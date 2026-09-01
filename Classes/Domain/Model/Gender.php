<?php

declare(strict_types=1);

namespace OliverKlee\FeUserExtraFields\Domain\Model;

/**
 * Adapter to allow for TYPO3-version-independent gender values.
 */
final class Gender
{
    /**
     * @return int<0, max>
     */
    public static function notProvided(): int
    {
        return 99;
    }

    /**
     * @return int<0, max>
     */
    public static function diverse(): int
    {
        return 2;
    }

    /**
     * @return int<0, max>
     */
    public static function female(): int
    {
        return 1;
    }

    /**
     * @return int<0, max>
     */
    public static function male(): int
    {
        return 0;
    }

    /**
     * @return list<int<0, max>|null>
     */
    private static function definedGenders(): array
    {
        return [
            self::notProvided(),
            self::diverse(),
            self::female(),
            self::male(),
        ];
    }

    public static function isValidGender(?int $gender): bool
    {
        return in_array($gender, self::definedGenders(), true);
    }
}
