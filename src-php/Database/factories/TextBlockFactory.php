<?php

use Faker\Generator as Faker;
use Dewsign\NovaRepeaterBlocks\Repeaters\Common\Models\TextBlock;

$factory->define(TextBlock::class, function (Faker $faker) {
    return [
        'format' => $faker->randomElement([
            'p',
            'h2',
            'h3',
        ]),
        'content' => $faker->realText($nbMax = rand(70, 254)),
    ];
});
