<?php

namespace Lokeland\SVO;

use Illuminate\Support\Collection;

class WeightCollection extends Collection
{
    public function findHeaviest(): ?Weight
    {
        return $this->orderByHeavyToLight()->first();
    }

    public function findLightest(): ?Weight
    {
        return $this->orderByLightToHeavy()->first();
    }

    public function orderByHeavyToLight(): self
    {
        return $this->sortByDesc(function (Weight $weight) {
            return $weight->valueInGrams;
        })->values();
    }

    public function orderByLightToHeavy(): self
    {
        return $this->sortBy(function (Weight $weight) {
            return $weight->valueInGrams;
        })->values();
    }

    public function sumWeight(): Weight
    {
        if ($this->isEmpty()) {
            return Weight::ofZero();
        }

        return $this->reduce(function (Weight $carry, Weight $weight) {
            return $carry->add($weight);
        }, Weight::ofZero());
    }
}
