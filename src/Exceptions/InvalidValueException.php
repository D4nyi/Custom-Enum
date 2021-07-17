<?php
/**
 * Copyright © Dániel Szöllősi 2020 - 2021
 * All rights reserved.
 * Created at 2020. 10. 14. 14:28
 */

declare(strict_types=1);

namespace CustomEnum\Exceptions;

use InvalidArgumentException;
use JetBrains\PhpStorm\Pure;
use Throwable;

class InvalidValueException extends InvalidArgumentException
{
    /**
     * @inheritDoc
     */
    #[Pure] public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}