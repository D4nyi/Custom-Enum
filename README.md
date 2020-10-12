# Custom-Enum
A custom enum implementation for PHP.

## Installation
```bash
$ composer require danyi/custom-enum
```

## Usage tip
- It is good to declare an enum member 'None' with a value of 0, this way faulty behaviors can be detected.
 
## Conventions for EnumFlag
1. The first value __MUST be__ 'None' with the value of 0.
2. From that each enum's value should be the power of 2 in ascending order
The class coded with these conventions would work with this package.

## Define enums
```php
use CustomEnum\Enum;
use CustomEnum\EnumFlag;

final class Color extends Enum
{
    public const None  = 0;
    public const Red   = 1;
    public const Green = 2;
    public const Blue  = 3;

    /**
     * @inheritDoc
     */
    protected static function getConstants(): array
    {
        return [
            'None'  => 0,
            'Red'   => 1,
            'Green' => 2,
            'Blue'  => 3,
        ];
    }
}

final class Days extends EnumFlag
{
    public const None      = 0;
    public const Monday    = 1;
    public const Tuesday   = 2;
    public const Wednesday = 4;
    public const Thursday  = 8;
    public const Friday    = 16;
    public const Saturday  = 32;
    public const Sunday    = 64;

    protected static function getConstants(): array
    {
        return [
            'None'      => 0,
            'Monday'    => 1,
            'Tuesday'   => 2,
            'Wednesday' => 4,
            'Thursday'  => 8,
            'Friday'    => 16,
            'Saturday'  => 32,
            'Sunday'    => 64,
            'WeekDay'   => 128,
            'Weekend'   => 256,
        ];
    }
}
```

## Usage
```php
use Example\Color;
use Example\Days;

$red = Color::Red;
echo Color::isValidValue($red);
echo Color::nameOf($red);
echo Color::isValidName($red);

$weekend = Days::valuesToFlag([
    Days::Saturday,
    Days::Sunday,
]);

echo Days::contains($weekend, Days::Saturday);
echo Days::flagToEnumNames($weekend);
echo Days::flagToValues($weekend);
```