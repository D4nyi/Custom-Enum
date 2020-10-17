<?php
/**
 * Copyright © Dániel Szöllősi 2020 - 2020
 * All rights reserved.
 * Created at 2020. 10. 10. 18:04
 */

declare(strict_types=1);

namespace CustomEnum;

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
     */
    public function __construct(int $value)
    {
        parent::__construct(0);
        $this->isFlag = self::isValidValue($value) === false;
        $this->value = $value;
        $this->valueName = $this->isFlag ? strval($this->value) : self::nameOf($this->value);
        //$this->builtFrom =
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
        foreach ($filtered as $value) {
            if ($value < $temp) {
                $temp -= $value;
                $results[] = $value;
            } elseif ($value === $temp) {
                $results[] = $value;
            }
        }

        $sum = array_reduce($filtered, fn ($acc, $item) => $acc + $item, 0);
        return ($sum === $flag) ?
            $results :
            null;
    }

    public function instanceContains()
    {

    }
}