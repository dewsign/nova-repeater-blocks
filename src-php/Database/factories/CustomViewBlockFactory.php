<?php

use Faker\Generator as Faker;
use Dewsign\NovaRepeaterBlocks\Repeaters\Common\Models\CustomViewBlock;

$factory->define(CustomViewBlock::class, function (Faker $faker) {
    return [
        'template-name' => $faker->word,
    ];
});
