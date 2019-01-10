<?php

use Faker\Generator as Faker;
use Dewsign\NovaRepeaterBlocks\Repeaters\Common\Models\ContainerBlock;

$factory->define(ContainerBlock::class, function (Faker $faker) {
    return [
        'template' => $faker->word,
    ];
});
