<?php
/**
 * Copyright © Dániel Szöllősi 2020 - 2020
 * All rights reserved.
 * Created at 2020. 10. 10. 19:42
 */

declare(strict_types=1);

namespace Example;

use CustomEnum\Enum;

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