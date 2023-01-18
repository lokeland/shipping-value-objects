<?php

namespace Lokeland\SVO;

use Stringable;

class Measurement implements Stringable
{
    public function __construct(public readonly int $valueInMillimeters)
    {
    }

    public static function fromMillimeters(int $milimeters): self
    {
        return new self($milimeters);
    }

    public static function fromCentimeters(int|float $centimeters): self
    {
        return new self($centimeters * 10);
    }

    public static function fromDecimeter(int|float $decimeter): self
    {
        return new self($decimeter * 100);
    }

    public static function fromMeters(int|float $meters): self
    {
        return new self($meters * 1000);
    }

    public static function ofZero(): self
    {
        return new self(0);
    }

    public function toMillimeters(): int
    {
        return $this->valueInMillimeters;
    }

    public function toCentimeters(): float|int
    {
        return $this->valueInMillimeters / 10;
    }

    public function toDecimeter(): float|int
    {
        return $this->valueInMillimeters / 100;
    }

    public function toMeters(): float|int
    {
        return $this->valueInMillimeters / 1000;
    }

    public function add(Measurement $measurement, ?Measurement $max = null): self
    {
        $newMeasurement = $measurement->valueInMillimeters + $this->valueInMillimeters;

        if ($max && $newMeasurement > $max->valueInMillimeters) {
            $newMeasurement = $max->valueInMillimeters;
        }

        return new self(valueInMillimeters: $newMeasurement);
    }

    public function subtract(Measurement $measurement, ?Measurement $min = null): self
    {
        $newMeasurement = $this->valueInMillimeters - $measurement->valueInMillimeters;

        if ($newMeasurement <= 0) {
            return static::ofZero();
        }

        if ($min && $newMeasurement < $min->valueInMillimeters) {
            $newMeasurement = $min->valueInMillimeters;
        }

        return new self(valueInMillimeters: $newMeasurement);
    }

    public function multiply(int|float $times): self
    {
        if ($times === 0) {
            return self::ofZero();
        }

        return new self(valueInMillimeters: $this->valueInMillimeters * $times);
    }

    public function isZero(): bool
    {
        return $this->valueInMillimeters === 0;
    }

    public function isBetween(Measurement $first, Measurement $second): bool
    {
        return $this->valueInMillimeters >= $first->valueInMillimeters
            && $this->valueInMillimeters <= $second->valueInMillimeters;
    }

    public function equalOrGreaterThan(Measurement $measurement): bool
    {
        return $this->valueInMillimeters >= $measurement->valueInMillimeters;
    }

    public function equalOrLessThan(Measurement $measurement): bool
    {
        return $this->valueInMillimeters <= $measurement->valueInMillimeters;
    }

    public function equal(Measurement $measurement): bool
    {
        return $this->valueInMillimeters === $measurement->valueInMillimeters;
    }

    public function lessThan(Measurement $measurement): bool
    {
        return $this->valueInMillimeters < $measurement->valueInMillimeters;
    }

    public function greaterThan(Measurement $measurement): bool
    {
        return $this->valueInMillimeters > $measurement->valueInMillimeters;
    }

    public function __toString(): string
    {
        return $this->valueInMillimeters;
    }
}
