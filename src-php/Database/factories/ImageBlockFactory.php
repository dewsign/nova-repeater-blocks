<?php

use Faker\Generator as Faker;
use Dewsign\NovaRepeaterBlocks\Repeaters\Common\Models\ImageBlock;

$factory->define(ImageBlock::class, function (Faker $faker) {
    return [
        'image' => $faker->word,
        'alt_content' => $faker->word,
    ];
});
