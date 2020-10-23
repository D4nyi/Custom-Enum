<?php
/**
 * Copyright © Dániel Szöllősi 2020 - 2020
 * All rights reserved.
 * Created at 2020. 10. 10. 18:04
 */

declare(strict_types=1);

namespace CustomEnum;

use CustomEnum\Exceptions\InvalidFlagException;
use CustomEnum\Interfaces\EnumFlag as Flag;

/**
 * Trait EnumFlag
 *
 * For creating a similar functionality as C# has with enums.
 *
 * It is created to be applied on enum-like classes.
 *
 * @package CustomEnum
 */
abstract class EnumFlag extends Enum implements Flag
{
    /**
     * @inheritDoc
     */
    protected static array $cache;
    private bool           $isFlag;
    private array          $builtFrom;

    /**
     * EnumFlag constructor.
     *
     * @param int $value the current flag instance's value
     * @throws InvalidFlagException
     */
    public function __construct(int $value)
    {
        parent::__construct(1);
        $this->isFlag = self::isValidValue($value) === false;
        $this->value = $value;
        $this->valueName = $this->isFlag ? strval($this->value) : self::nameOf($this->value);

        $temp = self::flagToValues($this->value);
        if (is_null($temp)) {
            throw new InvalidFlagException("Flag ($value) cannot be decomposed!");
        }
        $this->builtFrom = $temp;
    }

    /**
     * @inheritDoc
     */
    public static function contains(int $flag, int $enum): bool
    {
        if (!self::isValidValue($enum)) {
            return false;
        }

        if ($flag === $enum) {
            return true;
        }

        return in_array($enum, self::flagToValues($flag));
    }

    /**
     * @inheritDoc
     */
    public static function valuesToFlag(array $values): int
    {
        return array_reduce(
            array_unique($values, SORT_NUMERIC),
            fn ($acc, $curr) => self::isValidValue($curr) ? $acc + $curr : 0,
            0);
    }

    /**
     * @inheritDoc
     */
    public static function flagToEnumNames(int $flag): ?array
    {
        $results = self::flagToValues($flag);
        return is_null($results) ?
            null :
            array_flip($results);
    }

    /**
     * @inheritDoc
     */
    public static function flagToValues(int $flag): ?array
    {
        if (self::isValidValue($flag)) {
            return [$flag];
        }

        $filtered = array_filter(
            static::$cache,
            fn ($value) => $value < $flag && $value !== 0);

        // nested ifs to save some performance if count != 2
        if (count($filtered) === 2) {
            $sum = array_reduce($filtered, fn ($acc, $item) => $acc + $item, 0);
            if ($sum === $flag) {
                return $filtered;
            }
        }

        $temp = $flag;
        $results = [];
        foreach (array_reverse($filtered) as $key => $value) {
            if ($value < $temp) {
                $temp -= $value;
                $results[$key] = $value;
            } elseif ($value === $temp) {
                $results[$key] = $value;
                break;
            }
        }

        $sum = array_reduce($results, fn ($acc, $item) => $acc + $item, 0);
        return ($sum === $flag) ?
            $results :
            null;
    }

    /**
     * Gets the key-value pairs (enums) which the current flag is built from
     *
     * @return array|int[]
     */
    public function getBuiltFrom(): array
    {
        return $this->builtFrom;
    }

    /**
     * Indices whether the current instance holds a flag or an enum value
     *
     * @return bool
     */
    public function isFlag(): bool
    {
        return $this->isFlag;
    }

    /**
     * Checks if the given enum is contained by the current flag
     * @param int $enum
     * @return bool
     */
    public function hasEnum(int $enum): bool
    {
        if (!self::isValidValue($enum)) {
            return false;
        }

        if ($this->value === $enum) {
            return true;
        }

        return in_array($enum, $this->builtFrom);
    }

    /**
     * Gets the names of the enums that contained by the current flag
     * @return array
     */
    public function names(): array
    {
        return array_flip($this->builtFrom);
    }
}