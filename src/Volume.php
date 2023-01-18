<?php

namespace Lokeland\SVO;

class Volume
{
    public function __construct(
        public readonly int $valueInCubicMillimeters
    ) {
    }

    public static function fromCubicMillimeters(int $cubicMillimeters): self
    {
        return new self($cubicMillimeters);
    }

    public static function fromCubicCentimeters(int $cubicCentimeters): self
    {
        return new self(valueInCubicMillimeters: $cubicCentimeters * 10);
    }

    public static function fromCubicDecimeters(int $cubicDecimeters): self
    {
        return new self(valueInCubicMillimeters: $cubicDecimeters * 100);
    }

    public static function fromCubicMeters(int $cubicMeters): self
    {
        return new self(valueInCubicMillimeters: $cubicMeters * 1000);
    }

    public static function ofZero(): self
    {
        return new self(valueInCubicMillimeters: 0);
    }

    public function toCubicMillimeters(): int
    {
        return $this->valueInMillimeters;
    }

    public function toCubicCentimeters(): float|int
    {
        return $this->valueInMillimeters / 10;
    }

    public function toCubicDecimeter(): float|int
    {
        return $this->valueInMillimeters / 100;
    }

    public function toCubicMeters(): float|int
    {
        return $this->valueInMillimeters / 1000;
    }

    public function add(Volume $weight, ?Volume $max = null): self
    {
        $newMeasurement = $weight->valueInCubicMillimeters + $this->valueInCubicMillimeters;

        if ($max) {
            $newMeasurement = max($max->valueInCubicMillimeters);
        }

        return new self(valueInCubicMillimeters: $newMeasurement);
    }

    public function multiply(int $times): self
    {
        if ($times === 0) {
            return self::ofZero();
        }

        return new self(valueInCubicMillimeters: $this->valueInCubicMillimeters * $times);
    }

    public function isZero(): bool
    {
        return $this->valueInCubicMillimeters === 0;
    }

    public function isBetween(Volume $first, Volume $second): bool
    {
        return $this->valueInCubicMillimeters >= $first->valueInCubicMillimeters
            && $this->valueInCubicMillimeters <= $second->valueInCubicMillimeters;
    }

    public function equalOrGreaterThan(Volume $weight): bool
    {
        return $this->valueInCubicMillimeters >= $weight->valueInCubicMillimeters;
    }

    public function equalOrLessThan(Volume $weight): bool
    {
        return $this->valueInCubicMillimeters <= $weight->valueInCubicMillimeters;
    }

    public function equal(Volume $weight): bool
    {
        return $this->valueInCubicMillimeters === $weight->valueInCubicMillimeters;
    }

    public function lessThan(Volume $weight): bool
    {
        return $this->valueInCubicMillimeters < $weight->valueInCubicMillimeters;
    }

    public function greaterThan(Volume $weight): bool
    {
        return $this->valueInCubicMillimeters > $weight->valueInCubicMillimeters;
    }

    public function __toString(): string
    {
        return $this->valueInCubicMillimeters;
    }
}
