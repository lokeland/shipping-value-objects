<?php

use Lokeland\SVO\Dimensions;
use Lokeland\SVO\Measurement;
use Lokeland\SVO\ShippingAttributes;
use Lokeland\SVO\Weight;
use Lokeland\SVO\WeightCollection;

it('can be created', function () {
    $shippingAttributes = ShippingAttributes::make(
        Weight::fromKilos(1),
        Dimensions::make(
            Measurement::fromCentimeters(1),
            Measurement::fromCentimeters(2),
            Measurement::fromCentimeters(3),
        )
    );

    expect($shippingAttributes->weight)->toBeInstanceOf(Weight::class)
        ->and($shippingAttributes->dimensions)->toBeInstanceOf(Dimensions::class)
        ->and($shippingAttributes->weight->valueInGrams)->toBe(1000)
        ->and($shippingAttributes->dimensions->height->valueInMillimeters)->toBe(10)
        ->and($shippingAttributes->dimensions->width->valueInMillimeters)->toBe(20)
        ->and($shippingAttributes->dimensions->length->valueInMillimeters)->toBe(30);
});

it('can be cast to a weight collection', function () {
    $shippingAttributes = ShippingAttributes::make(
        Weight::fromGrams(10),
        Dimensions::make(
            Measurement::fromCentimeters(1),
            Measurement::fromCentimeters(1),
            Measurement::fromCentimeters(1),
        )
    );

    $weightCollection = $shippingAttributes->toWeightCollection();

    expect($weightCollection)->toBeInstanceOf(WeightCollection::class)
        ->and($weightCollection[0]->valueInGrams)->toBe(10);
});

it('can be cast to an array', function () {
    $shippingAttributes = ShippingAttributes::make(
        Weight::fromGrams(10),
        Dimensions::make(
            Measurement::fromCentimeters(1),
            Measurement::fromCentimeters(2),
            Measurement::fromCentimeters(3),
        )
    );

    $asAnArray = $shippingAttributes->toArray();

    expect($asAnArray['weight'])->toBeInstanceOf(Weight::class)
        ->and($asAnArray['weight']->valueInGrams)->toBe(10)
        ->and($asAnArray['dimensions']['height'])->toBeInstanceOf(Measurement::class)
        ->and($asAnArray['dimensions']['height']->valueInMillimeters)->toBe(10)
        ->and($asAnArray['dimensions']['width'])->toBeInstanceOf(Measurement::class)
        ->and($asAnArray['dimensions']['width']->valueInMillimeters)->toBe(20)
        ->and($asAnArray['dimensions']['length'])->toBeInstanceOf(Measurement::class)
        ->and($asAnArray['dimensions']['length']->valueInMillimeters)->toBe(30);
});
