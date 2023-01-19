<?php

namespace Lokeland\SVO;

use Illuminate\Support\Collection;

class MeasurementCollection extends Collection
{
    public function findLongest(): ?Measurement
    {
        return $this->orderByLongToShort()->first();
    }

    public function findShortest(): ?Measurement
    {
        return $this->orderByShortToLong()->first();
    }

    public function orderByLongToShort(): self
    {
        return $this->sortByDesc(function (Measurement $measurement) {
            return $measurement->valueInMillimeters;
        })->values();
    }

    public function orderByShortToLong(): self
    {
        return $this->sortBy(function (Measurement $measurement) {
            return $measurement->valueInMillimeters;
        })->values();
    }

    public function sumMeasurements(): Measurement
    {
        if ($this->isEmpty()) {
            return Measurement::ofZero();
        }

        return $this->reduce(function (Measurement $carry, Measurement $measurement) {
            return $carry->add($measurement);
        }, Measurement::ofZero());
    }
}
