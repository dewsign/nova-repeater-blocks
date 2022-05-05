<?php

namespace Dewsign\NovaRepeaterBlocks\Fields;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Laravel\Nova\Nova;
use MichielKempen\NovaPolymorphicField\PolymorphicField;

class Polymorphic extends PolymorphicField
{
    /**
     * Register multiple fields for a Polymorphic relationship
     *
     * @param Request $request
     * @param array $types Array of Nova fields
     * @return self
     */
    public function types(Request $request, array $types)
    {
        foreach ($types as $type) {
            $field = new $type($request);
            $this->type($field->singularLabel(), $type::$model, $field->fields($request));
        }

        return $this;
    }

    /**
     * Extending the default method in order to add a try-catch statement. This has been PR'd to the package
     * but it has not yet been merged. Ideally we remove this overload when a fix has been implemented.
     */
    public function resolveForDisplay($model, $attribute = null)
    {
        try {
            parent::resolveForDisplay($model, $this->attribute.'_type');
        } catch (\Throwable $e) {
            //
        }
 
        foreach ($this->meta['types'] as $index => $type) {
            $this->meta['types'][$index]['active'] =
                $this->mapToKey($type['value']) == $model->{$this->attribute . '_type'};

            foreach ($type['fields'] as $field) {
                try {
                    $field->resolveForDisplay($model->{$this->attribute});
                } catch (\Throwable $e) {
                    $field->readonly(true);
                }
            }
        }
    }

    /**
     * Retrieve values of dependency fields
     *
     * @param mixed $model
     * @param string $attribute
     * @return array|mixed
     */
    protected function resolveAttribute($model, $attribute)
    {
        try {
            return parent::resolveAttribute($model, $attribute);
        } catch (ModelNotFoundException $e) {
            $this->logMorphTableIssue($model, $e);
            $this->updateMorphTable($model);
        } catch (\Throwable $e) {
            logger($e->getMessage());
        }
    }

    /**
     * Add debug messaging to the log to allow further investigation
     *
     * @param  Model      $model
     * @param  \Exception $exception
     * @return void
     */
    public function logMorphTableIssue(Model $model, \Exception $exception)
    {
        logger(sprintf(
            "An issue has occured with ID: %d, Type: %s. This record has been disabled",
            $model->id,
            $model->{$this->attribute . '_type'}
        ), ['error' => $exception->getMessage()]);
    }

    /**
     * In the event there is a morph relation issue we check to see if we can
     * update the morph table with disable column updates, this in return
     * allows for graceful notification/failure.
     *
     * @param  Model  $model
     * @return void
     */
    private function updateMorphTable(Model $model)
    {
        $tableName = $model->getTable();
        $columns = config("repeater-blocks.morph_tables.{$tableName}.disable_columns");

        if (is_array($columns) && count($columns)) {
            collect($model->getAttributes())
            ->keys()
            ->filter(function ($attribute) use ($columns) {
                return isset($columns[$attribute]);
            })
            ->each(function ($attribute, $index) use ($model, $columns) {
                $model->{$attribute} = $columns[$attribute];
            })
            ->whenNotEmpty(function () use ($model) {
                $model->save();
            });
        }
    }
}
