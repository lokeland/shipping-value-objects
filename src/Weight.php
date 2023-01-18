<?php

namespace Lokeland\SVO;

use Stringable;

class Weight implements Stringable
{
    public function __construct(public readonly int $valueInGrams)
    {
    }

    public static function fromGrams(int $grams): self
    {
        return new self(valueInGrams: $grams);
    }

    public static function fromKilos(int|float $kilos): self
    {
        return new self(valueInGrams: $kilos * 1000);
    }

    public static function ofZero(): self
    {
        return new self(valueInGrams: 0);
    }

    public function toGrams(): int
    {
        return $this->valueInGrams;
    }

    public function toKilos(): int|float
    {
        return $this->valueInGrams / 1000;
    }

    public function isZero(): bool
    {
        return $this->valueInGrams === 0;
    }

    public function isBetween(Weight $first, Weight $second): bool
    {
        return $this->valueInGrams >= $first->valueInGrams
            && $this->valueInGrams <= $second->valueInGrams;
    }

    public function add(Weight $weight, ?Weight $max = null): self
    {
        $newWeight = $this->valueInGrams + $weight->valueInGrams;

        if ($max && $newWeight > $max->valueInGrams) {
            $newWeight = $max->valueInGrams;
        }

        return new self(valueInGrams: $newWeight);
    }

    public function subtract(Weight $weight, ?Weight $min = null): self
    {
        $newWeight = $this->valueInGrams - $weight->valueInGrams;

        if ($newWeight <= 0) {
            return static::ofZero();
        }

        if ($min && $newWeight < $min->valueInGrams) {
            $newWeight = $min->valueInGrams;
        }

        return new self(valueInGrams: $newWeight);
    }

    public function multiply(int|float $times): self
    {
        if ($times === 0) {
            return self::ofZero();
        }

        return new self(valueInGrams: $this->valueInGrams * $times);
    }

    public function equalOrGreaterThan(Weight $weight): bool
    {
        return $this->valueInGrams >= $weight->valueInGrams;
    }

    public function equalOrLessThan(Weight $weight): bool
    {
        return $this->valueInGrams <= $weight->valueInGrams;
    }

    public function equal(Weight $weight): bool
    {
        return $this->valueInGrams === $weight->valueInGrams;
    }

    public function lessThan(Weight $weight): bool
    {
        return $this->valueInGrams < $weight->valueInGrams;
    }

    public function greaterThan(Weight $weight): bool
    {
        return $this->valueInGrams > $weight->valueInGrams;
    }

    public function toCollection(): WeightCollection
    {
        return WeightCollection::make([$this]);
    }

    public function __toString(): string
    {
        return $this->valueInGrams;
    }
}
