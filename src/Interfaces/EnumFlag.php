<?php
/**
 * Copyright © Dániel Szöllősi 2020 - 2021
 * All rights reserved.
 * Created at 2020. 10. 10. 18:06
 */

namespace CustomEnum\Interfaces;

/**
 * Interface EnumFlag
 *
 * For creating a similar functionality as C# has with enums.
 *
 * It is created to let you implement your own flag mechanism.
 *
 * @package CustomEnum\Interfaces
 */
interface EnumFlag
{
    /**
     * Checks if the current flag contains the provided enum value
     *
     * @param int $flag
     * @param int $enum
     *
     * @return bool
     */
    public static function contains(int $flag, int $enum): bool;

    /**
     * Creates a flag from the provided $values array.
     *
     * Duplicated values are removed!
     *
     * @param int[] $values contains only the implementer's Enum values
     *
     * @return int the created flag from $values
     */
    public static function valuesToFlag(array $values): int;

    /**
     * Converts the provided flag to those enum names from which it was composed
     *
     * @param int $flag that will be decomposed
     *
     * @return array containing enum names that are used to compose the flag
     */
    public static function flagToEnumNames(int $flag): ?array;

    /**
     * Converts the provided flag to those enum values from which it was composed
     *
     * @param int $flag that will be decomposed
     *
     * @return array|null array if containing enum values that are used to compose the flag,
     *                    null if the flag cannot be decomposed
     */
    public static function flagToValues(int $flag): ?array;
}