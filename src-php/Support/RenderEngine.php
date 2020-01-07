<?php

namespace Dewsign\NovaRepeaterBlocks\Support;

use Illuminate\Support\Arr;

class RenderEngine
{
    /**
     * Renders the repeater fields passed in to the $model parameter. Optionally wraps each repeater
     * inside the before and after code.
     *
     * @param $model
     * @param string $before
     * @param string $after
     * @return string
     */
    public static function renderRepeaters($model, string $before = null, string $after = null)
    {
        if (!Arr::get($model, 'repeaters')) {
            return null;
        }

        return optional($model->repeaters)->map(function ($repeater) use ($before, $after) {
            $repeaterType = new \ReflectionClass($repeater->type);
            $repeaterKey = str_replace('\\', '.', $repeaterType->name);
            $repeaterShortKey = $repeaterType->getShortName();
            $repeaterContent = $repeater->type;
            $repeater = $repeater;

            $view = view()->first([
                $repeaterType->hasMethod('getBlockViewTemplate')
                    ? $repeaterType->getMethod('getBlockViewTemplate')->invoke(null)
                    : null,
                "repeaters.{$repeaterKey}",
                "nova-repeater-blocks::{$repeaterKey}",
                'repeaters.default',
                'nova-repeater-blocks::default'
                ])->with([
                    'repeater' => $repeater,
                    'repeaterKey' => $repeaterKey,
                    'repeaterShortKey' => $repeaterShortKey,
                    'repeaterContent' => $repeaterContent,
                ])->with($repeaterContent->toArray())
                ->render();

            return "{$before}{$view}{$after}";
        })->implode('');
    }

    /**
     * Renders the repeater fields passed in to the $model parameter as json (Ideal for JavaScript front ends.)
     *
     * @param $model
     * @return array
     */
    public static function renderRepeatersJson($model)
    {
        return optional($model->repeaters)->map(function ($repeater) {
            $repeaterContent = $repeater->type;

            return [
                $repeaterContent,
            ];
        });
    }
}
