<?php

namespace Lokeland\SVO;

class ShippingAttributes
{
    public function __construct(
        public readonly Weight $weight,
        public readonly Dimensions $dimensions,
    ) {
    }

    public static function make(Weight $weight, Dimensions $dimensions): self
    {
        return new self(weight: $weight, dimensions: $dimensions);
    }

    public function toWeightCollection(): WeightCollection
    {
        return WeightCollection::make([$this->weight]);
    }

    /**
     * @return array{
     *     weight: \Lokeland\SVO\Weight,
     *     dimensions: array{
     *         height: \Lokeland\SVO\Measurement,
     *         width: \Lokeland\SVO\Measurement,
     *         length: \Lokeland\SVO\Measurement
     *     }
     * }
     */
    public function toArray(): array
    {
        return [
            'weight' => $this->weight,
            'dimensions' => $this->dimensions->toArray(),
        ];
    }
}
