<?php

use Lokeland\SVO\Weight;
use Lokeland\SVO\WeightCollection;

it('can find the shortest Weight', function () {
    $collection = WeightCollection::make([
        Weight::fromGrams(2),
        Weight::fromGrams(1),
        Weight::fromGrams(3),
    ]);

    expect($collection->findLightest()->valueInGrams)->toBe(1);

    $collection = WeightCollection::make([
        Weight::fromGrams(2),
        Weight::fromGrams(0),
        Weight::fromGrams(3),
    ]);

    expect($collection->findLightest()->valueInGrams)->toBe(0);

    $collection = WeightCollection::make();

    expect($collection->findLightest())->toBeNull();
});

it('can find the longest Weight', function () {
    $collection = WeightCollection::make([
        Weight::fromGrams(2),
        Weight::fromGrams(1),
        Weight::fromGrams(3),
    ]);

    expect($collection->findHeaviest()->valueInGrams)->toBe(3);

    $collection = WeightCollection::make([
        Weight::fromGrams(2),
        Weight::fromGrams(0),
        Weight::fromGrams(3),
    ]);

    expect($collection->findHeaviest()->valueInGrams)->toBe(3);

    $collection = WeightCollection::make();

    expect($collection->findHeaviest())->toBeNull();
});

it('can order by long to short', function () {
    $collection = WeightCollection::make([
        Weight::fromGrams(2),
        Weight::fromGrams(1),
        Weight::fromGrams(3),
    ]);

    $ordered = $collection->orderByHeavyToLight();

    expect($ordered[0]->valueInGrams)->toBe(3)
        ->and($ordered[1]->valueInGrams)->toBe(2)
        ->and($ordered[2]->valueInGrams)->toBe(1);

    $collection = WeightCollection::make([
        Weight::fromGrams(2),
        Weight::fromGrams(0),
        Weight::fromGrams(3),
    ]);

    expect($collection->findHeaviest()->valueInGrams)->toBe(3);

    $collection = WeightCollection::make();

    expect($collection->findHeaviest())->toBeNull();
});

it('can order by short to long', function () {
    $collection = WeightCollection::make([
        Weight::fromGrams(2),
        Weight::fromGrams(1),
        Weight::fromGrams(3),
    ])->orderByLightToHeavy();

    expect($collection[0]->valueInGrams)->toBe(1)
        ->and($collection[1]->valueInGrams)->toBe(2)
        ->and($collection[2]->valueInGrams)->toBe(3);

    $collection = WeightCollection::make([
        Weight::fromGrams(2),
        Weight::fromGrams(0),
        Weight::fromGrams(3),
    ])->orderByLightToHeavy();

    expect($collection[0]->valueInGrams)->toBe(0)
        ->and($collection[1]->valueInGrams)->toBe(2)
        ->and($collection[2]->valueInGrams)->toBe(3);
});

it('can sum weights', function () {
    $sum = WeightCollection::make([
        Weight::fromGrams(2),
        Weight::fromGrams(0),
        Weight::fromGrams(3),
    ])->sumWeight();

    expect($sum->valueInGrams)->toBe(5);
});
