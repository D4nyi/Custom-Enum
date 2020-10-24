<?php
/**
 * Copyright © Dániel Szöllősi 2020 - 2020
 * All rights reserved.
 * Created at 2020. 10. 14. 15:40
 */

declare(strict_types=1);

namespace Example;

use CustomEnum\EnumFlag;
use CustomEnum\Interfaces\EnumFlag as Flag;
use CustomEnum\Exceptions\InvalidValueException;

final class Days extends EnumFlag implements Flag
{
    public const None      = 0;
    public const Monday    = 1;
    public const Tuesday   = 2;
    public const Wednesday = 4;
    public const Thursday  = 8;
    public const Friday    = 16;
    public const Saturday  = 32;
    public const Sunday    = 64;

    /**
     * @inheritDoc
     */
    protected static array $cache = [
        'None'      => 0,
        'Monday'    => 1,
        'Tuesday'   => 2,
        'Wednesday' => 4,
        'Thursday'  => 8,
        'Friday'    => 16,
        'Saturday'  => 32,
        'Sunday'    => 64,
    ];

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