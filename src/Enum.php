<?php
/**
 * Copyright © Dániel Szöllősi 2020 - 2021
 * All rights reserved.
 * Created at 2020. 10. 10. 17:13
 */

declare(strict_types=1);

namespace CustomEnum;

use CustomEnum\Exceptions\InvalidValueException;
use JetBrains\PhpStorm\Pure;

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
    protected static array   $cache;
    protected int            $value;
    protected string         $valueName;

    /**
     * Enum constructor.
     *
     * @param int $value the current enum instance's value
     * @throws InvalidValueException
     */
    public function __construct(int $value)
    {
        if (static::isValidValue($value) === false) {
            throw new InvalidValueException("The value ($value) which is provided is not an enum value");
        }
        $this->value = $value;
        $this->valueName = self::nameOf($this->value);
    }

    /**
     * Gets the name of the provided enum value
     *
     * @param int  $value   enum value whose name are looked for
     * @param bool $toLower indicates whether to convert the enums name to lower case or not
     * @param bool $strict  type check also applied not just value check
     * @return string the found name by the value, default is 'None' that provided if an error occurs
     */
    #[Pure] public static final function nameOf(int $value, bool $toLower = false, bool $strict = true): string
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
     * Tries to get the value of the provided enum name, if nothing is found -1 is returned
     *
     * @param string $name
     * @param bool   $caseSensitive
     * @return int the value of the enum name, if not found -1
     */
    public static final function valueOf(string $name, bool $caseSensitive = false): int
    {
        if (static::isValidName($name, $caseSensitive) === false) {
            return -1;
        }

        if ($caseSensitive) {
            return static::$cache[$name];
        }

        $keys = array_keys(static::$cache);
        $index = array_search(
            strtolower($name),
            array_map('strtolower', $keys)
        );

        return static::$cache[$keys[$index]];
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
     * @param string $name          enum name whose name are looked for
     * @param bool   $caseSensitive case sensitive comparison
     * @return bool true if the value is found, otherwise false
     */
    public static final function isValidName(string $name, bool $caseSensitive = false): bool
    {
        $constants = static::$cache;
        return
            $caseSensitive ?
                array_key_exists($name, $constants) :
                in_array(strtolower($name), array_map('strtolower', array_keys($constants)), true);
    }

    /**
     * Creates a new instance from an enum name
     *
     * @param string $name from which a new instance is initialized
     * @param bool   $caseSensitive
     * @return self
     * @throws InvalidValueException if an invalid name is provided
     */
    public static abstract function byName(string $name, bool $caseSensitive = true): self;

    /**
     * Gets the name of the instance's value
     *
     * @return string name of the instance's value
     */
    public final function getName(): string
    {
        return $this->valueName;
    }

    /**
     * Gets the current enum value or the flag value
     *
     * @return int
     */
    public final function getValue(): int
    {
        return $this->value;
    }

    /**
     * Gets the current enum as a key-value pair
     *
     * @return int[]
     */
    #[Pure] public final function getAsKeyValue(): array
    {
        return [$this->getName() => $this->value];
    }
}
