<?php

use Faker\Generator as Faker;
use Dewsign\NovaRepeaterBlocks\Repeaters\Common\Models\TextareaBlock;

$factory->define(TextareaBlock::class, function (Faker $faker) {
    return [
        'content' => $faker->realText($nbMax = rand(70, 254)),
    ];
});
