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
}