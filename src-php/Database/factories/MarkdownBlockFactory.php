<?php

use Faker\Generator as Faker;
use Dewsign\NovaRepeaterBlocks\Repeaters\Common\Models\MarkdownBlock;

$factory->define(MarkdownBlock::class, function (Faker $faker) {
    return [
        'content' => $faker->realText($nbMax = rand(70, 254)),
    ];
});
