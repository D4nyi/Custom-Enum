<?php
/**
 * Copyright © Dániel Szöllősi 2020 - 2020
 * All rights reserved.
 * Created at 2020. 10. 23. 16:00
 */

declare(strict_types=1);

namespace CustomEnum\Exceptions;

use InvalidArgumentException;
use Throwable;

class InvalidFlagException extends InvalidArgumentException
{
    /**
     * @inheritDoc
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}