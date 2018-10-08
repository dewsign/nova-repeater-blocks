<?php

use Faker\Generator as Faker;
use Dewsign\NovaRepeaterBlocks\Models\Repeater;
use Dewsign\NovaRepeaterBlocks\Repeaters\Common\Models\TextBlock;

$factory->define(Repeater::class, function (Faker $faker) {
    $blockNumber = $faker->randomNumber;

    return [
        'name' => "Repeater Block {$blockNumber}",
    ];
});
