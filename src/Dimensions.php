<?php

namespace Lokeland\SVO;

class Dimensions
{
    public function __construct(
        public readonly Measurement $height,
        public readonly Measurement $width,
        public readonly Measurement $length,
    ) {
    }

    public static function make(
        Measurement $height,
        Measurement $width,
        Measurement $length,
    ): self {
        return new self(
            height: $height,
            width: $width,
            length: $length,
        );
    }

    public function toVolume(): Volume
    {
        return Volume::fromCubicMillimeters(
            $this->height->getValue() * $this->width->getValue() * $this->length->getValue(),
        );
    }

    public static function ofZero(): self
    {
        return new self(
            height: Measurement::ofZero(),
            width: Measurement::ofZero(),
            length: Measurement::ofZero(),
        );
    }

    public function longest(): Measurement
    {
        return $this->toCollection()->findLongest();
    }

    public function shortest(): Measurement
    {
        return $this->toCollection()->findShortest();
    }

    public function isZero(): bool
    {
        return $this->height->isZero()
            && $this->width->isZero()
            && $this->length->isZero();
    }

    public function toCollection(): MeasurementCollection
    {
        return MeasurementCollection::make([
            $this->height,
            $this->width,
            $this->length,
        ]);
    }

    /**
     * @return array{
     *     height: \Lokeland\SVO\Measurement,
     *     width: \Lokeland\SVO\Measurement,
     *     length: \Lokeland\SVO\Measurement
     * }
     */
    public function toArray(): array
    {
        return [
            'height' => $this->height,
            'width' => $this->width,
            'length' => $this->length,
        ];
    }
}
