# Value objects for working with shipping attributes

[![Latest Version on Packagist](https://img.shields.io/packagist/v/lokeland/shipping-value-objects.svg?style=flat-square)](https://packagist.org/packages/lokeland/shipping-value-objects)
[![Tests](https://img.shields.io/github/actions/workflow/status/lokeland/shipping-value-objects/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/lokeland/shipping-value-objects/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/lokeland/shipping-value-objects.svg?style=flat-square)](https://packagist.org/packages/lokeland/shipping-value-objects)

This library contains a set of value objects regularly used when working with products and shipping.
In addition to that it also comes with a couple of custom collections extended from `Illuminate\Collections` (from Laravel).

Things to note:
* All operations on value objects are immutable.
* Only the most relevant (metric) units is added, but you're welcome to submit a pull request.

## Installation

You can install the package via composer:

```bash
composer require lokeland/shipping-value-objects
```

## Usage

### Value objects

#### Weight
```php
use Lokeland\SVO\Weight;

$weight = Weight::fromGrams(100);
$weight = Weight::fromKilos(100);
$weight = Weight::ofZero();

$weight->toGrams();
$weight->toKilos();

$weight->add(Weight::fromGrams(50));
$weight->subtract(Weight::fromGrams(50));
$weight->multiply(2);

$weight->isZero();
$weight->equal(Weight::fromGrams(50));
$weight->equalOrGreaterThan(Weight::fromGrams(50));
$weight->equalOrLessThan(Weight::fromGrams(50));
$weight->greaterThan(Weight::fromGrams(50));
$weight->lessThan(Weight::fromGrams(50));
$weight->isBetween(
    Weight::fromGrams(10),
    Weight::fromGrams(70)
);
```
> **Note**
> Values are stored as grams internally

#### Measurement
```php
use Lokeland\SVO\Measurement;

$measurement = Measurement::fromMillimeters(100);
$measurement = Measurement::fromCentimeters(100);
$measurement = Measurement::fromDecimeter(100);
$measurement = Measurement::fromMeters(100);

$measurement->toMillimeters();
$measurement->toCentimeters();
$measurement->toDecimeter();
$measurement->toMeters();

$measurement->isZero();
$measurement->add(Measurement::fromCentimeters(50));
$measurement->subtract(Measurement::fromCentimeters(50));
$measurement->equal(Measurement::fromCentimeters(50));
$measurement->equalOrGreaterThan(Measurement::fromCentimeters(50));
$measurement->equalOrLessThan(Measurement::fromCentimeters(50));
$measurement->greaterThan(Measurement::fromCentimeters(50));
$measurement->lessThan(Measurement::fromCentimeters(50));
$measurement->multiply(2);
$measurement->isBetween(
    Measurement::fromCentimeters(10),
    Measurement::fromCentimeters(70)
);
```
> **Note**
> Values are stored as millimeters internally

#### Dimensions
```php
use Lokeland\SVO\Dimensions;
use Lokeland\SVO\Measurement;

$dimensions = Dimensions::make(
    height: Measurement::fromMillimeters(100),
    width: Measurement::fromMillimeters(100),
    length: Measurement::fromMillimeters(100),
);
$dimensions = Dimensions::ofZero();

$dimensions->height;
$dimensions->width;
$dimensions->length;

$dimensions->isZero();

$dimensions->longest();
$dimensions->shortest();

$dimensions->toVolume();
$dimensions->toArray();
```

#### Shipping attributes
```php
use Lokeland\SVO\ShippingAttributes;
use Lokeland\SVO\Weight;
use Lokeland\SVO\Dimensions;
use Lokeland\SVO\Measurement;

$shippingAttributes = ShippingAttributes::make(
    weight: Weight::fromKilos(),
    dimensions: Dimensions::make(
        height: Measurement::fromMillimeters(100),
        width: Measurement::fromMillimeters(100),
        length: Measurement::fromMillimeters(100),
    )
);

$shippingAttributes->weight;
$shippingAttributes->dimensions;

$shippingAttributes->toArray();
```

#### Volume
```php
use Lokeland\SVO\Volume;

$volume = Volume::fromCubicMillimeters(10);
$volume = Volume::fromCubicCentimeters(10);
$volume = Volume::fromCubicDecimeters(10);
$volume = Volume::fromCubicMeters(10);

$volume->toCubicMillimeters();
$volume->toCubicCentimeters();
$volume->toCubicDecimeter();
$volume->toCubicMeters();

$volume->isZero();
$volume->add(Volume::fromCubicCentimeters(50));
$volume->subtract(Volume::fromCubicCentimeters(50));
$volume->equal(Volume::fromCubicCentimeters(50));
$volume->equalOrGreaterThan(Volume::fromCubicCentimeters(50));
$volume->equalOrLessThan(Volume::fromCubicCentimeters(50));
$volume->greaterThan(Volume::fromCubicCentimeters(50));
$volume->lessThan(Volume::fromCubicDecimeters(50));
$volume->multiply(2);
$volume->isBetween(
    Volume::fromCubicCentimeters(10),
    Volume::fromCubicCentimeters(70)
);
```
> **Note**
> Values are stored as cubic millimeters internally

### Collections

#### Measurement collection
```php
use Lokeland\SVO\Measurement;
use Lokeland\SVO\MeasurementCollection;

$collection = MeasurementCollection::make([
    Measurement::fromDecimeter(10),
    Measurement::fromDecimeter(20),
    Measurement::fromDecimeter(30),
]);

$collection->findLongest();
$collection->findShortest();
$collection->orderByLongToShort();
$collection->orderByShortToLong();
$collection->sumMeasurements();
```

#### Weight collection
```php
use Lokeland\SVO\Weight;
use Lokeland\SVO\WeightCollection;

$collection = WeightCollection::make([
    Weight::fromKilos(1),
    Weight::fromKilos(2),
    Weight::fromKilos(3),
]);

$collection->findHeaviest();
$collection->findLightest();
$collection->orderByHeavyToLight();
$collection->orderByLightToHeavy();
$collection->sumWeight();
```

### Min and max
When adding or subtracting a value, you can provide min/max as the second arguments, like this:
```php
use Lokeland\SVO\Measurement;

$measurement = Measurement::fromMeters(1);
$measurement->add(
    measurement: Measurement::fromMeters(5),
    max: Measurement::fromMeters(2),
);
$measurement->toMeters(); // 2

$measurement = Measurement::fromMeters(5);
$measurement->subtract(
    measurement: Measurement::fromMeters(4),
    min: Measurement::fromMeters(3)
);
$measurement->toMeters(); // 3
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Jarand](https://github.com/lokeland)
- [All Contributors](../../contributors)

Made using [package skeleton from Spatie](https://github.com/spatie/package-skeleton-php).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
