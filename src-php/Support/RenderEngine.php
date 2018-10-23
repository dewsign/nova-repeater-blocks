<?php

namespace Dewsign\NovaRepeaterBlocks\Support;

class RenderEngine
{
    /**
     * Renders the repeater fields passed in to the $model parameter
     *
     * @param $model
     * @return string
     */
    public static function renderRepeaters($model)
    {
        if(!array_get($model, 'repeaters')) {
            return null;
        }

        return optional($model->repeaters)->map(function ($repeater) {
            $repeaterType = new \ReflectionClass($repeater->type);
            $repeaterKey = str_replace('\\', '.', $repeaterType->name);
            $repeaterShortKey = $repeaterType->getShortName();
            $repeaterContent = $repeater->type;
            $repeater = $repeater;

            return view()->first([
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
        })->implode('');
    }
}
