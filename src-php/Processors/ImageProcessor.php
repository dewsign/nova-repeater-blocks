<?php

namespace Dewsign\NovaRepeaterBlocks\Processors;

use Illuminate\Support\Facades\Storage;

class ImageProcessor
{
    public static function get(string $image, array $params = [])
    {
        return Storage::disk(config('repeater-blocks.images.disk'))->url($image);
    }

    public static function delete(string $image)
    {
        return Storage::disk(config('repeater-blocks.images.disk'))->delete($image);
    }
}
