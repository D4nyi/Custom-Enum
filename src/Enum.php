<?php
/**
 * Copyright © Dániel Szöllősi 2020 - 2020
 * All rights reserved.
 * Created at 2020. 10. 10. 17:13
 */

declare(strict_types=1);

namespace CustomEnum;

/**
 * Class Enum
 *
 * Basic enum-like functionality
 *
 * @package CustomEnum
 */
abstract class Enum
{
    /**
     * Holds the key-value pairs of the enum constants
     * Int the following way:
     * <code>
     * $cache = [
     * 'None => 0,
     * 'One' => 1,
     * etc...
     * ];
     * </code>
     *
     * @var array|int[]
     */
    protected static array $cache;

    /**
     * Enum constructor.
     * Forces the implementer to hide its ctor, and prevent initializations
     */
    protected function __construct()
    {
    }

    /**
     * Gets the name of the provided enum value
     *
     * @param int  $value   enum value whose name are looked for
     * @param bool $toLower indicates whether to convert the enums name to lower case or not
     * @param bool $strict  type check also applied not just value check
     * @return string the found name by the value, default is 'None' that provided if an error occurs
     */
    public static final function nameOf(int $value, bool $toLower = false, bool $strict = true): string
    {
        $result =
            self::isValidValue($value, $strict) ?
                array_search($value, static::$cache, $strict) :
                'None';

        return $toLower ?
            strtolower($result) :
            $result;
    }

    /**
     * Checks if the provided enum value is in the current enum type
     *
     * @param int  $value  enum value which are looked for
     * @param bool $strict true type check is applied and 0 (zero) values are treated as non-valid
     * @return bool true if the value is found, otherwise false
     */
    public static final function isValidValue(int $value, bool $strict = true): bool
    {
        return !($strict && $value === 0) && // if strict true and the value is 0 than its not a valid value
               in_array($value,
                   static::$cache,
                   $strict); // if the value is found in the constants (strict -> type check is applied or not)
    }

    /**
     * Checks if the provided enum name is in the current enum type
     *
     * @param string $name   enum name whose name are looked for
     * @param bool   $strict case sensitive comparison
     * @return bool true if the value is found, otherwise false
     */
    public static final function isValidName(string $name, $strict = false): bool
    {
        $constants = static::$cache;
        return
            $strict ?
                array_key_exists($name, $constants) :
                in_array(strtolower($name), array_map('strtolower', array_keys($constants)));
    }
}
