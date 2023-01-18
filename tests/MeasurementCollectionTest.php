<?php

use Lokeland\SVO\Measurement;
use Lokeland\SVO\MeasurementCollection;

it('can find the shortest measurement', function () {
    $collection = MeasurementCollection::make([
        Measurement::fromMillimeters(2),
        Measurement::fromMillimeters(1),
        Measurement::fromMillimeters(3),
    ]);

    expect($collection->findShortest()->valueInMillimeters)->toBe(1);

    $collection = MeasurementCollection::make([
        Measurement::fromMillimeters(2),
        Measurement::fromMillimeters(0),
        Measurement::fromMillimeters(3),
    ]);

    expect($collection->findShortest()->valueInMillimeters)->toBe(0);

    $collection = MeasurementCollection::make();

    expect($collection->findShortest())->toBeNull();
});

it('can find the longest measurement', function () {
    $collection = MeasurementCollection::make([
        Measurement::fromMillimeters(2),
        Measurement::fromMillimeters(1),
        Measurement::fromMillimeters(3),
    ]);

    expect($collection->findLongest()->valueInMillimeters)->toBe(3);

    $collection = MeasurementCollection::make([
        Measurement::fromMillimeters(2),
        Measurement::fromMillimeters(0),
        Measurement::fromMillimeters(3),
    ]);

    expect($collection->findLongest()->valueInMillimeters)->toBe(3);

    $collection = MeasurementCollection::make();

    expect($collection->findLongest())->toBeNull();
});

it('can order by long to short', function () {
    $collection = MeasurementCollection::make([
        Measurement::fromMillimeters(2),
        Measurement::fromMillimeters(1),
        Measurement::fromMillimeters(3),
    ])->orderByLongToShort();

    expect($collection[0]->valueInMillimeters)->toBe(3)
        ->and($collection[1]->valueInMillimeters)->toBe(2)
        ->and($collection[2]->valueInMillimeters)->toBe(1);

    $collection = MeasurementCollection::make([
        Measurement::fromMillimeters(2),
        Measurement::fromMillimeters(0),
        Measurement::fromMillimeters(3),
    ]);

    expect($collection->findLongest()->valueInMillimeters)->toBe(3);

    $collection = MeasurementCollection::make();

    expect($collection->findLongest())->toBeNull();
});

it('can order by short to long', function () {
    $collection = MeasurementCollection::make([
        Measurement::fromMillimeters(2),
        Measurement::fromMillimeters(1),
        Measurement::fromMillimeters(3),
    ])->orderByShortToLong();

    expect($collection[0]->valueInMillimeters)->toBe(1)
        ->and($collection[1]->valueInMillimeters)->toBe(2)
        ->and($collection[2]->valueInMillimeters)->toBe(3);

    $collection = MeasurementCollection::make([
        Measurement::fromMillimeters(2),
        Measurement::fromMillimeters(0),
        Measurement::fromMillimeters(3),
    ])->orderByShortToLong();

    expect($collection[0]->valueInMillimeters)->toBe(0)
        ->and($collection[1]->valueInMillimeters)->toBe(2)
        ->and($collection[2]->valueInMillimeters)->toBe(3);
});

it('can sum measurements', function () {
    $sum = MeasurementCollection::make([
        Measurement::fromMillimeters(2),
        Measurement::fromMillimeters(0),
        Measurement::fromMillimeters(3),
    ])->sumMeasurements();

    expect($sum->valueInMillimeters)->toBe(5);
});
