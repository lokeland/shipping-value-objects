<?php

use Lokeland\SVO\Measurement;

it('can be created from millimeters', function () {
    $measurement = Measurement::fromMillimeters(1);

    expect($measurement->valueInMillimeters)->toBe(1);
});

it('can be created from centimeters', function () {
    $measurement = Measurement::fromCentimeters(1);

    expect($measurement->valueInMillimeters)->toBe(10);

    $measurement = Measurement::fromCentimeters(1.5);

    expect($measurement->valueInMillimeters)->toBe(15);

    $measurement = Measurement::fromCentimeters(0.5);

    expect($measurement->valueInMillimeters)->toBe(5);
});

it('can be created from decimeters', function () {
    $measurement = Measurement::fromDecimeter(1);

    expect($measurement->valueInMillimeters)->toBe(100);

    $measurement = Measurement::fromDecimeter(1.5);

    expect($measurement->valueInMillimeters)->toBe(150);

    $measurement = Measurement::fromDecimeter(0.5);

    expect($measurement->valueInMillimeters)->toBe(50);
});

it('can be created from meters', function () {
    $measurement = Measurement::fromMeters(1);

    expect($measurement->valueInMillimeters)->toBe(1000);

    $measurement = Measurement::fromMeters(1.5);

    expect($measurement->valueInMillimeters)->toBe(1500);

    $measurement = Measurement::fromMeters(0.5);

    expect($measurement->valueInMillimeters)->toBe(500);
});

it('can be created from zero', function () {
    $measurement = Measurement::ofZero();

    expect($measurement->valueInMillimeters)->toBe(0);
});

it('can be cast to millimeters', function () {
    $measurement = Measurement::fromMillimeters(1500);

    expect($measurement->toMillimeters())->toBe(1500);
});

it('can be cast to centimeters', function () {
    $measurement = Measurement::fromCentimeters(1);

    expect($measurement->toCentimeters())->toBe(1);

    $measurement = Measurement::fromCentimeters(1.5);

    expect($measurement->toCentimeters())->toBe(1.5);

    $measurement = Measurement::fromCentimeters(0.5);

    expect($measurement->toCentimeters())->toBe(0.5);
});

it('can be cast to decimeters', function () {
    $measurement = Measurement::fromDecimeter(1);

    expect($measurement->toDecimeter())->toBe(1);

    $measurement = Measurement::fromDecimeter(1.5);

    expect($measurement->toDecimeter())->toBe(1.5);

    $measurement = Measurement::fromDecimeter(0.5);

    expect($measurement->toDecimeter())->toBe(0.5);
});

it('can be cast to meters', function () {
    $measurement = Measurement::fromMeters(1);

    expect($measurement->toMeters())->toBe(1);

    $measurement = Measurement::fromMeters(1.5);

    expect($measurement->toMeters())->toBe(1.5);

    $measurement = Measurement::fromMeters(0.5);

    expect($measurement->toMeters())->toBe(0.5);
});

it('can tell if the value is zero', function () {
    $measurement = Measurement::fromMillimeters(1);

    expect($measurement->isZero())->toBeFalse();

    $measurement = Measurement::ofZero();

    expect($measurement->isZero())->toBeTrue();
});

it('can add a value to another', function () {
    $first = Measurement::fromCentimeters(10);
    $second = Measurement::fromCentimeters(1.5);

    expect($first->add($second)->valueInMillimeters)->toBe(115);

    $first = Measurement::ofZero();
    $second = Measurement::ofZero();

    expect($first->add($second)->valueInMillimeters)->toBe(0);
});

it('can add a value to another while never going above a set value', function () {
    $first = Measurement::fromMeters(1);
    $second = Measurement::fromMeters(3);
    $max = Measurement::fromMeters(2);

    expect($first->add($second, $max)->valueInMillimeters)->toBe(2000);
});

it('can subtract a value from another', function () {
    $first = Measurement::fromMeters(5);
    $second = Measurement::fromMeters(2.5);

    expect($first->subtract($second)->valueInMillimeters)->toBe(2500);

    $first = Measurement::ofZero();
    $second = Measurement::ofZero();

    expect($first->subtract($second)->valueInMillimeters)->toBe(0);
});

it('can subtract a value from another while never going beneath a set value', function () {
    $first = Measurement::fromMeters(5);
    $second = Measurement::fromMeters(2.5);
    $min = Measurement::fromMeters(4);

    expect($first->subtract($second, $min)->valueInMillimeters)->toBe(4000);
});

it('can be multiplied', function () {
    $weight = Measurement::fromMeters(2);

    expect($weight->multiply(1.5)->valueInMillimeters)->toBe(3000);
});

it('can tell if it is equal than another value', function () {
    expect(Measurement::fromMillimeters(1)->equal(Measurement::fromMillimeters(1)))->toBeTrue()
        ->and(Measurement::fromMillimeters(1)->equal(Measurement::fromMillimeters(2)))->toBeFalse();
});

it('can tell if it is equal or greater than another value', function () {
    expect(Measurement::fromMillimeters(1)->equalOrGreaterThan(Measurement::fromMillimeters(1)))->toBeTrue()
        ->and(Measurement::fromMillimeters(1)->equalOrGreaterThan(Measurement::fromMillimeters(2)))->toBeFalse()
        ->and(Measurement::fromMillimeters(2)->equalOrGreaterThan(Measurement::fromMillimeters(1)))->toBeTrue();
});

it('can tell if it is greater than another value', function () {
    expect(Measurement::fromMillimeters(1)->greaterThan(Measurement::fromMillimeters(1)))->toBeFalse()
        ->and(Measurement::fromMillimeters(1)->greaterThan(Measurement::fromMillimeters(2)))->toBeFalse()
        ->and(Measurement::fromMillimeters(2)->greaterThan(Measurement::fromMillimeters(1)))->toBeTrue();
});

it('can tell if it is equal or less than another value', function () {
    expect(Measurement::fromMillimeters(1)->equalOrLessThan(Measurement::fromMillimeters(1)))->toBeTrue()
        ->and(Measurement::fromMillimeters(1)->equalOrLessThan(Measurement::fromMillimeters(2)))->toBeTrue()
        ->and(Measurement::fromMillimeters(2)->equalOrLessThan(Measurement::fromMillimeters(1)))->toBeFalse();
});

it('can tell if it is less than another value', function () {
    expect(Measurement::fromMillimeters(1)->lessThan(Measurement::fromMillimeters(1)))->toBeFalse()
        ->and(Measurement::fromMillimeters(1)->lessThan(Measurement::fromMillimeters(2)))->toBeTrue()
        ->and(Measurement::fromMillimeters(2)->lessThan(Measurement::fromMillimeters(1)))->toBeFalse();
});

it('can tell if it is inbetween two other value', function () {
    expect(Measurement::fromMillimeters(1)->isBetween(Measurement::fromMillimeters(1), Measurement::fromMillimeters(1)))->toBeTrue()
        ->and(Measurement::fromMillimeters(1)->isBetween(Measurement::fromMillimeters(1), Measurement::fromMillimeters(2)))->toBeTrue()
        ->and(Measurement::fromMillimeters(2)->isBetween(Measurement::fromMillimeters(1), Measurement::fromMillimeters(2)))->toBeTrue()
        ->and(Measurement::fromMillimeters(5)->isBetween(Measurement::fromMillimeters(1), Measurement::fromMillimeters(4)))->toBeFalse()
        ->and(Measurement::fromMillimeters(5)->isBetween(Measurement::fromMillimeters(6), Measurement::fromMillimeters(7)))->toBeFalse();
});

it('can be cast to a string', function () {
    $measurement = Measurement::fromMillimeters(123);

    expect($measurement)->toBeInstanceOf(Stringable::class)
        ->and($measurement->__toString())->toBe('123');
});
