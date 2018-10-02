<?php

namespace Dewsign\NovaRepeaterBlocks\Support;

class RenderEngine
{
    /**
     * Renders the repeater fields passed in to the $repeaters parameter
     *
     * @param Array|Illuminate\Support\Collection $repeaters
     * @return string
     */
    public static function renderRepeaters($model)
    {
        return $model->repeaters->map(function ($repeater) {
            $repeaterType = new \ReflectionClass($repeater->type);
            $repeaterKey = str_replace('\\', '.', $repeaterType->name);
            $repeaterContent = $repeater->type;

            return view()->first([
                $repeaterType->hasMethod('getBlockViewTemplate')
                    ? $repeaterType->getMethod('getBlockViewTemplate')->invoke(null)
                    : null,
                "repeaters.{$repeaterKey}",
                "nova-repeater-blocks::{$repeaterKey}",
                'repeaters.default',
                'nova-repeater-blocks::default'
                ])->with([
                    'repeaterKey' => $repeaterKey,
                    'repeaterContent' => $repeaterContent,
                ])->with($repeaterContent->toArray())
                ->render();
        })->implode('');
    }
}
