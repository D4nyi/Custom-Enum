<?php
/**
 * Copyright © Dániel Szöllősi 2020 - 2020
 * All rights reserved.
 * Created at 2020. 10. 14. 15:40
 */

declare(strict_types=1);

namespace Example;

use CustomEnum\Enum;
use CustomEnum\Exceptions\InvalidValueException;

final class Color extends Enum
{
    public const None  = 0;
    public const Red   = 0xFF0000;
    public const Green = 0x00FF00;
    public const Blue  = 0x0000FF;

    /**
     * @inheritDoc
     */
    protected static array $cache = [
        'None'  => 0,
        'Red'   => 0xFF0000,
        'Green' => 0x00FF00,
        'Blue'  => 0x0000FF,
    ];

    /**
     * @inheritDoc
     */
    public function __construct($value)
    {
        parent::__construct($value);
    }

    /**
     * @inheritDoc
     * @return self
     */
    public static function byName(string $name, bool $caseSensitive = true): self
    {
        if (static::isValidName($name) === false) {
            throw new InvalidValueException("The value ('$name') which is provided is not an enum value");
        }
        $value = static::valueOf($name, $caseSensitive);
        return new self($value);
    }
}