<?php

use Faker\Generator as Faker;
use Dewsign\NovaRepeaterBlocks\Repeaters\Common\Models\CustomViewBlock;

$factory->define(CustomViewBlock::class, function (Faker $faker) {
    return [
        'template_name' => $faker->word,
    ];
});
