<?php

namespace Dewsign\NovaRepeaterBlocks\Fields;

use Laravel\Nova\Nova;
use Illuminate\Http\Request;
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
        parent::resolveForDisplay($model, $this->attribute.'_type');
 
        foreach ($this->meta['types'] as $index => $type) {
            $this->meta['types'][$index]['active'] =
                $this->mapToKey($type['value']) == $model->{$this->attribute . '_type'};

            foreach ($type['fields'] as $field) {
                $field->resolveForDisplay($model->{$this->attribute});

                try {
                    $field->resolveForDisplay($model->{$this->attribute});
                } catch (\Exception $e) {
                    //
                }
            }
        }
    }
}
