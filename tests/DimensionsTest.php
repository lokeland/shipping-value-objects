<?php

use Lokeland\SVO\Dimensions;
use Lokeland\SVO\Measurement;

it('can be created from a set of measurements', function () {
    $dimensions = Dimensions::make(
        Measurement::fromMillimeters(10),
        Measurement::fromMillimeters(20),
        Measurement::fromMillimeters(30),
    );

    expect($dimensions->height->valueInMillimeters)->toBe(10)
        ->and($dimensions->width->valueInMillimeters)->toBe(20)
        ->and($dimensions->length->valueInMillimeters)->toBe(30);
});

it('can be created from zero', function () {
    $dimensions = Dimensions::ofZero();

    expect($dimensions->height->valueInMillimeters)->toBe(0)
        ->and($dimensions->width->valueInMillimeters)->toBe(0)
        ->and($dimensions->length->valueInMillimeters)->toBe(0);
});

it('can find the longest measurement', function () {
    $dimensions = Dimensions::make(
        Measurement::fromMillimeters(10),
        Measurement::fromMillimeters(30),
        Measurement::fromMillimeters(20),
    );

    expect($dimensions->longest()->valueInMillimeters)->toBe(30);

    $dimensions = Dimensions::ofZero();

    expect($dimensions->longest()->valueInMillimeters)->toBe(0);
});

it('can find the shortest measurement', function () {
    $dimensions = Dimensions::make(
        Measurement::fromMillimeters(30),
        Measurement::fromMillimeters(10),
        Measurement::fromMillimeters(20),
    );

    expect($dimensions->shortest()->valueInMillimeters)->toBe(10);

    $dimensions = Dimensions::ofZero();

    expect($dimensions->shortest()->valueInMillimeters)->toBe(0);
});

it('can tell if all measurements are zero', function () {
    $dimensions = Dimensions::ofZero();

    expect($dimensions->isZero())->toBeTrue();

    $dimensions = Dimensions::make(
        Measurement::ofZero(),
        Measurement::ofZero(),
        Measurement::fromMillimeters(1),
    );

    expect($dimensions->isZero())->toBeFalse();
});

it('can be cast to a measurement collection', function () {
    $dimensions = Dimensions::make(
        Measurement::fromMillimeters(10),
        Measurement::fromMillimeters(20),
        Measurement::fromMillimeters(30),
    )->toCollection();

    expect($dimensions[0]->valueInMillimeters)->toBe(10)
        ->and($dimensions[1]->valueInMillimeters)->toBe(20)
        ->and($dimensions[2]->valueInMillimeters)->toBe(30);
});

it('can be cast to an array', function () {
    $dimensions = Dimensions::make(
        Measurement::fromMillimeters(10),
        Measurement::fromMillimeters(20),
        Measurement::fromMillimeters(30),
    )->toArray();

    expect($dimensions['height']->valueInMillimeters)->toBe(10)
        ->and($dimensions['width']->valueInMillimeters)->toBe(20)
        ->and($dimensions['length']->valueInMillimeters)->toBe(30);
});
