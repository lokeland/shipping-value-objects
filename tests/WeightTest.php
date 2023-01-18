<?php

use Lokeland\SVO\Weight;

it('can be created from grams', function () {
    $weight = Weight::fromGrams(1);

    expect($weight->valueInGrams)->toBe(1);
});

it('can be created from kilos', function () {
    $weight = Weight::fromKilos(1);

    expect($weight->valueInGrams)->toBe(1000);

    $weight = Weight::fromKilos(1.5);

    expect($weight->valueInGrams)->toBe(1500);

    $weight = Weight::fromKilos(0.5);

    expect($weight->valueInGrams)->toBe(500);
});

it('can be created from zero', function () {
    $weight = Weight::ofZero();

    expect($weight->valueInGrams)->toBe(0);
});

it('can be cast to grams', function () {
    $weight = Weight::fromGrams(1500);

    expect($weight->toGrams())->toBe(1500);
});

it('can be cast to kilos', function () {
    $weight = Weight::fromKilos(1);

    expect($weight->toKilos())->toBe(1);

    $weight = Weight::fromKilos(1.5);

    expect($weight->toKilos())->toBe(1.5);
});

it('can tell if the value is zero', function () {
    $weight = Weight::fromGrams(1);

    expect($weight->isZero())->toBeFalse();

    $weight = Weight::ofZero();

    expect($weight->isZero())->toBeTrue();
});

it('can add a value to another', function () {
    $first = Weight::fromKilos(1);
    $second = Weight::fromKilos(2.5);

    expect($first->add($second)->valueInGrams)->toBe(3500);

    $first = Weight::ofZero();
    $second = Weight::ofZero();

    expect($first->add($second)->valueInGrams)->toBe(0);
});

it('can add a value to another while never going above a set value', function () {
    $first = Weight::fromKilos(1);
    $second = Weight::fromKilos(3);
    $max = Weight::fromKilos(2);

    expect($first->add($second, $max)->valueInGrams)->toBe(2000);
});

it('can subtract a value from another', function () {
    $first = Weight::fromKilos(5);
    $second = Weight::fromKilos(2.5);

    expect($first->subtract($second)->valueInGrams)->toBe(2500);

    $first = Weight::ofZero();
    $second = Weight::ofZero();

    expect($first->subtract($second)->valueInGrams)->toBe(0);
});

it('can subtract a value from another while never going beneath a set value', function () {
    $first = Weight::fromKilos(5);
    $second = Weight::fromKilos(2.5);
    $min = Weight::fromKilos(4);

    expect($first->subtract($second, $min)->valueInGrams)->toBe(4000);
});

it('can be multiplied', function () {
    $weight = Weight::fromKilos(2);

    expect($weight->multiply(1.5)->valueInGrams)->toBe(3000);
});

it('can tell if it is equal than another value', function () {
    expect(Weight::fromGrams(1)->equal(Weight::fromGrams(1)))->toBeTrue()
        ->and(Weight::fromGrams(1)->equal(Weight::fromGrams(2)))->toBeFalse();
});

it('can tell if it is equal or greater than another value', function () {
    expect(Weight::fromGrams(1)->equalOrGreaterThan(Weight::fromGrams(1)))->toBeTrue()
        ->and(Weight::fromGrams(1)->equalOrGreaterThan(Weight::fromGrams(2)))->toBeFalse()
        ->and(Weight::fromGrams(2)->equalOrGreaterThan(Weight::fromGrams(1)))->toBeTrue();
});

it('can tell if it is greater than another value', function () {
    expect(Weight::fromGrams(1)->greaterThan(Weight::fromGrams(1)))->toBeFalse()
        ->and(Weight::fromGrams(1)->greaterThan(Weight::fromGrams(2)))->toBeFalse()
        ->and(Weight::fromGrams(2)->greaterThan(Weight::fromGrams(1)))->toBeTrue();
});

it('can tell if it is equal or less than another value', function () {
    expect(Weight::fromGrams(1)->equalOrLessThan(Weight::fromGrams(1)))->toBeTrue()
        ->and(Weight::fromGrams(1)->equalOrLessThan(Weight::fromGrams(2)))->toBeTrue()
        ->and(Weight::fromGrams(2)->equalOrLessThan(Weight::fromGrams(1)))->toBeFalse();
});

it('can tell if it is less than another value', function () {
    expect(Weight::fromGrams(1)->lessThan(Weight::fromGrams(1)))->toBeFalse()
        ->and(Weight::fromGrams(1)->lessThan(Weight::fromGrams(2)))->toBeTrue()
        ->and(Weight::fromGrams(2)->lessThan(Weight::fromGrams(1)))->toBeFalse();
});

it('can tell if it is inbetween two other value', function () {
    expect(Weight::fromGrams(1)->isBetween(Weight::fromGrams(1), Weight::fromGrams(1)))->toBeTrue()
        ->and(Weight::fromGrams(1)->isBetween(Weight::fromGrams(1), Weight::fromGrams(2)))->toBeTrue()
        ->and(Weight::fromGrams(2)->isBetween(Weight::fromGrams(1), Weight::fromGrams(2)))->toBeTrue()
        ->and(Weight::fromGrams(5)->isBetween(Weight::fromGrams(1), Weight::fromGrams(4)))->toBeFalse()
        ->and(Weight::fromGrams(5)->isBetween(Weight::fromGrams(6), Weight::fromGrams(7)))->toBeFalse();
});

it('can be cast to a weight collection', function () {
    $weight = Weight::fromGrams(20)->toCollection();

    expect($weight->count())->toBe(1)
        ->and($weight[0]->valueInGrams)->toBe(20);
});

it('can be cast to a string', function () {
    $weight = Weight::fromGrams(123);

    expect($weight)->toBeInstanceOf(Stringable::class)
        ->and($weight->__toString())->toBe('123');
});
