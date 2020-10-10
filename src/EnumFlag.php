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
    public static final function contains(int $flag, int $enum): bool
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
    public static final function valuesToFlag(array $values): int
    {
        return array_reduce(
            array_unique($values, SORT_NUMERIC),
            fn ($acc, $curr) => self::isValidValue($curr) ? $acc + $curr : 0,
            0);
    }

    /**
     * @inheritDoc
     */
    public static final function flagToEnumNames(int $flag): ?array
    {
        $results = self::flagToValues($flag);
        foreach ($results as $key => $category) {
            $results[$key] = self::nameOf($category);
        }
        return $results;
    }

    /**
     * @inheritDoc
     */
    public static final function flagToValues(int $flag): ?array
    {
        if (self::isValidValue($flag)) {
            return [$flag];
        }

        $filtered = array_reverse(
            array_filter(
                static::getConstants(),
                fn ($value) => $value < $flag && $value !== 0),
            true);

        $sum = array_reduce($filtered, fn ($acc, $item) => $acc + $item, 0);
        if ($sum === $flag || count($filtered) === 2) {
            return $filtered;
        }

        $results = [];
        foreach ($filtered as $api) {
            if ($api < $flag) {
                $flag -= $api;
                $results[] = $api;
            } elseif ($api === $flag) {
                $results[] = $api;
            }
        }

        return $results;
    }

    /**
     * @inheritDoc
     */
    protected abstract static function getConstants(): array;
}