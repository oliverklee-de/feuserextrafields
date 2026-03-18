<?php

declare(strict_types=1);

namespace OliverKlee\FeUserExtraFields\Tests\Unit\Domain\Model;

use OliverKlee\FeUserExtraFields\Domain\Model\Gender;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * @covers OliverKlee\FeUserExtraFields\Domain\Model\Gender
 */
final class GenderTest extends UnitTestCase
{
    #[Test]
    public function maleReturnsValueForMale(): void
    {
        self::assertSame(0, Gender::male());
    }

    #[Test]
    public function femaleReturnsValueForFemale(): void
    {
        self::assertSame(1, Gender::female());
    }

    #[Test]
    public function diverseReturnsValueForDiverse(): void
    {
        self::assertSame(2, Gender::diverse());
    }

    #[Test]
    public function notProvidedReturnsValueForNotProvided(): void
    {
        self::assertSame(99, Gender::notProvided());
    }

    /**
     * @return array<non-empty-string, array{0: int|null}>
     */
    public static function validGenderDataProvider(): array
    {
        return [
            'not provided' => [Gender::notProvided()],
            'diverse' => [Gender::diverse()],
            'female' => [Gender::female()],
            'male' => [Gender::male()],
        ];
    }

    #[DataProvider('validGenderDataProvider')]
    #[Test]
    public function allExistingGendersAreValid(?int $gender): void
    {
        self::assertTrue(Gender::isValidGender($gender));
    }

    /**
     * @return array<non-empty-string, array{0: int}>
     */
    public static function invalidGenderDataProvider(): array
    {
        return [
            'negative' => [-1],
            'too large' => [100],
            'unassigned in the middle' => [50],
        ];
    }

    #[DataProvider('invalidGenderDataProvider')]
    #[Test]
    public function invalidGenderValuesAreInvalid(int $gender): void
    {
        self::assertFalse(Gender::isValidGender($gender));
    }
}
