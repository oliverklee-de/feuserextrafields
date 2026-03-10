<?php

declare(strict_types=1);

namespace OliverKlee\FeUserExtraFields\Tests\Unit\Domain\Model;

use OliverKlee\FeUserExtraFields\Domain\Model\FrontendUser;
use OliverKlee\FeUserExtraFields\Domain\Model\FrontendUserGroup;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * @covers \OliverKlee\FeUserExtraFields\Domain\Model\FrontendUser
 */
final class FrontendUserTest extends UnitTestCase
{
    private FrontendUser $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new FrontendUser();
    }

    /**
     * @test
     */
    public function isAbstractEntity(): void
    {
        self::assertInstanceOf(AbstractEntity::class, $this->subject);
    }

    /**
     * @test
     */
    public function getPidInitiallyReturnsNull(): void
    {
        self::assertNull($this->subject->getPid());
    }

    /**
     * @test
     */
    public function setPidSetsPid(): void
    {
        $value = 123456;
        $this->subject->setPid($value);

        self::assertSame($value, $this->subject->getPid());
    }

    /**
     * @test
     */
    public function getCreationDateInitiallyReturnsNull(): void
    {
        self::assertNull($this->subject->getCreationDate());
    }

    /**
     * @test
     */
    public function setCreationDateSetsCreationDate(): void
    {
        $date = new \DateTime();

        $this->subject->setCreationDate($date);

        self::assertSame($date, $this->subject->getCreationDate());
    }

    /**
     * @test
     */
    public function getModificationDateInitiallyReturnsNull(): void
    {
        self::assertNull($this->subject->getModificationDate());
    }

    /**
     * @test
     */
    public function setModificationDateSetsModificationDate(): void
    {
        $date = new \DateTime();

        $this->subject->setModificationDate($date);

        self::assertSame($date, $this->subject->getModificationDate());
    }

    /**
     * @test
     */
    public function getUsernameInitiallyReturnsEmptyString(): void
    {
        $result = $this->subject->getUsername();

        self::assertSame('', $result);
    }

    /**
     * @test
     */
    public function setUsernameSetsUsername(): void
    {
        $username = 'don.juan';

        $this->subject->setUsername($username);

        self::assertSame($username, $this->subject->getUsername());
    }

    /**
     * @test
     */
    public function getPasswordInitiallyReturnsEmptyString(): void
    {
        $result = $this->subject->getPassword();

        self::assertSame('', $result);
    }

    /**
     * @test
     */
    public function setPasswordSetsPassword(): void
    {
        $password = 'f00Bar';

        $this->subject->setPassword($password);

        self::assertSame($password, $this->subject->getPassword());
    }

    /**
     * @test
     */
    public function getUserGroupInitiallyReturnsEmptyStorage(): void
    {
        $result = $this->subject->getUserGroup();

        self::assertInstanceOf(ObjectStorage::class, $result);
        self::assertCount(0, $result);
    }

    /**
     * @test
     */
    public function setUserGroupSetsUserGroups(): void
    {
        /** @var ObjectStorage<FrontendUserGroup> $groups */
        $groups = new ObjectStorage();
        $groups->attach(new FrontendUserGroup('foo'));

        $this->subject->setUserGroup($groups);

        self::assertSame($groups, $this->subject->getUserGroup());
    }

    /**
     * @test
     */
    public function addUserGroupAddsUserGroup(): void
    {
        $group = new FrontendUserGroup('foo');

        $this->subject->addUserGroup($group);

        self::assertTrue($this->subject->getUserGroup()->contains($group));
    }

    /**
     * @test
     */
    public function removeUserGroupRemovesUserGroup(): void
    {
        $group = new FrontendUserGroup('foo');
        $this->subject->addUserGroup($group);
        self::assertTrue($this->subject->getUserGroup()->contains($group));

        $this->subject->removeUserGroup($group);

        self::assertFalse($this->subject->getUserGroup()->contains($group));
    }

    /**
     * @test
     */
    public function getNameInitiallyReturnsEmptyString(): void
    {
        $result = $this->subject->getName();

        self::assertSame('', $result);
    }

    /**
     * @test
     */
    public function setNameSetsName(): void
    {
        $name = 'don juan';

        $this->subject->setName($name);

        self::assertSame($name, $this->subject->getName());
    }

    /**
     * @test
     */
    public function getFirstNameInitiallyReturnsEmptyString(): void
    {
        $result = $this->subject->getFirstName();

        self::assertSame('', $result);
    }

    /**
     * @test
     */
    public function setFirstNameSetsFirstName(): void
    {
        $firstName = 'don';

        $this->subject->setFirstName($firstName);

        self::assertSame($firstName, $this->subject->getFirstName());
    }

    /**
     * @test
     */
    public function getMiddleNameInitiallyReturnsEmptyString(): void
    {
        $result = $this->subject->getMiddleName();

        self::assertSame('', $result);
    }

    /**
     * @test
     */
    public function setMiddleNameSetsMiddleName(): void
    {
        $middleName = 'miguel';

        $this->subject->setMiddleName($middleName);

        self::assertSame($middleName, $this->subject->getMiddleName());
    }

    /**
     * @test
     */
    public function getLastNameInitiallyReturnsEmptyString(): void
    {
        $result = $this->subject->getLastName();

        self::assertSame('', $result);
    }

    /**
     * @test
     */
    public function setLastNameSetsLastName(): void
    {
        $lastName = 'juan';

        $this->subject->setLastName($lastName);

        self::assertSame($lastName, $this->subject->getLastName());
    }

    /**
     * @test
     */
    public function getAddressInitiallyReturnsEmptyString(): void
    {
        $result = $this->subject->getAddress();

        self::assertSame('', $result);
    }

    /**
     * @test
     */
    public function setAddressSetsAddress(): void
    {
        $address = 'foobar 42, foo';

        $this->subject->setAddress($address);

        self::assertSame($address, $this->subject->getAddress());
    }

    /**
     * @test
     */
    public function getTelephoneInitiallyReturnsEmptyString(): void
    {
        $result = $this->subject->getTelephone();

        self::assertSame('', $result);
    }

    /**
     * @test
     */
    public function setTelephoneSetsTelephone(): void
    {
        $telephone = '42';

        $this->subject->setTelephone($telephone);

        self::assertSame($telephone, $this->subject->getTelephone());
    }

    /**
     * @test
     */
    public function getEmailInitiallyReturnsEmptyString(): void
    {
        $result = $this->subject->getEmail();

        self::assertSame('', $result);
    }

    /**
     * @test
     */
    public function setEmailSetsEmail(): void
    {
        $email = 'don.juan@example.com';

        $this->subject->setEmail($email);

        self::assertSame($email, $this->subject->getEmail());
    }

    /**
     * @test
     */
    public function getValidEmailForEmptyEmailThrowsException(): void
    {
        $this->subject->setEmail('');

        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessage('The email address is empty.');
        $this->expectExceptionCode(1735245325);

        $this->subject->getValidEmail();
    }

    /**
     * @test
     */
    public function getValidEmailForInvalidEmailThrowsException(): void
    {
        $this->subject->setEmail('Better caul Saul.');

        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessage('The email address is invalid.');
        $this->expectExceptionCode(1735245456);

        $this->subject->getValidEmail();
    }

    /**
     * @test
     */
    public function getValidEmailForValidEmailReturnsEmail(): void
    {
        $email = 'oli@example.com';
        $this->subject->setEmail($email);

        $result = $this->subject->getValidEmail();

        self::assertSame($email, $result);
    }

    /**
     * @test
     */
    public function getTitleInitiallyReturnsEmptyString(): void
    {
        $result = $this->subject->getTitle();

        self::assertSame('', $result);
    }

    /**
     * @test
     */
    public function setTitleSetsTitle(): void
    {
        $title = 'foobar';

        $this->subject->setTitle($title);

        self::assertSame($title, $this->subject->getTitle());
    }

    /**
     * @test
     */
    public function getZipInitiallyReturnsEmptyString(): void
    {
        $result = $this->subject->getZip();

        self::assertSame('', $result);
    }

    /**
     * @test
     */
    public function setZipSetsZip(): void
    {
        $zip = '42123';

        $this->subject->setZip($zip);

        self::assertSame($zip, $this->subject->getZip());
    }

    /**
     * @test
     */
    public function getCityInitiallyReturnsEmptyString(): void
    {
        $result = $this->subject->getCity();

        self::assertSame('', $result);
    }

    /**
     * @test
     */
    public function setCitySetsCity(): void
    {
        $city = 'foo';

        $this->subject->setCity($city);

        self::assertSame($city, $this->subject->getCity());
    }

    /**
     * @test
     */
    public function getCountryInitiallyReturnsEmptyString(): void
    {
        $result = $this->subject->getCountry();

        self::assertSame('', $result);
    }

    /**
     * @test
     */
    public function setCountrySetsCountry(): void
    {
        $country = 'foo';

        $this->subject->setCountry($country);

        self::assertSame($country, $this->subject->getCountry());
    }

    /**
     * @test
     */
    public function getWwwInitiallyReturnsEmptyString(): void
    {
        $result = $this->subject->getWww();

        self::assertSame('', $result);
    }

    /**
     * @test
     */
    public function setWwwSetsWww(): void
    {
        $www = 'foo.bar';

        $this->subject->setWww($www);

        self::assertSame($www, $this->subject->getWww());
    }

    /**
     * @test
     */
    public function getCompanyInitiallyReturnsEmptyString(): void
    {
        $result = $this->subject->getCompany();

        self::assertSame('', $result);
    }

    /**
     * @test
     */
    public function setCompanySetsCompany(): void
    {
        $company = 'foo bar';

        $this->subject->setCompany($company);

        self::assertSame($company, $this->subject->getCompany());
    }

    /**
     * @test
     */
    public function getDepartmentInitiallyReturnsEmptyString(): void
    {
        self::assertSame('', $this->subject->getDepartment());
    }

    /**
     * @test
     */
    public function setDepartmentSetsDepartment(): void
    {
        $value = 'Macrodata refinement';
        $this->subject->setDepartment($value);

        self::assertSame($value, $this->subject->getDepartment());
    }

    /**
     * @test
     */
    public function getVatInInitiallyReturnsEmptyString(): void
    {
        self::assertSame('', $this->subject->getVatIn());
    }

    /**
     * @test
     */
    public function setVatInSetsVatIn(): void
    {
        $value = 'DE987654321';
        $this->subject->setVatIn($value);

        self::assertSame($value, $this->subject->getVatIn());
    }

    /**
     * @test
     */
    public function getImageInitiallyReturnsEmptyCollection(): void
    {
        $result = $this->subject->getImage();

        self::assertInstanceOf(ObjectStorage::class, $result);
        self::assertCount(0, $result);
    }

    /**
     * @test
     */
    public function setImageSetsImage(): void
    {
        /** @var ObjectStorage<FileReference> $images */
        $images = new ObjectStorage();

        $this->subject->setImage($images);

        self::assertSame($images, $this->subject->getImage());
    }

    /**
     * @test
     */
    public function getLastLoginInitiallyReturnsNull(): void
    {
        $result = $this->subject->getLastLogin();

        self::assertNull($result);
    }

    /**
     * @test
     */
    public function setLastLoginSetsLastLogin(): void
    {
        $date = new \DateTime();

        $this->subject->setLastLogin($date);

        self::assertSame($date, $this->subject->getLastLogin());
    }

    /**
     * @return array<non-empty-string, array{0: FrontendUser::GENDER_*}>
     */
    public static function validGenderDataProvider(): array
    {
        return [
            'male' => [FrontendUser::GENDER_MALE],
            'female' => [FrontendUser::GENDER_FEMALE],
            'diverse' => [FrontendUser::GENDER_DIVERSE],
            'unknown' => [FrontendUser::GENDER_NOT_PROVIDED],
        ];
    }

    /**
     * @test
     *
     * @param FrontendUser::GENDER_* $gender
     *
     * @dataProvider validGenderDataProvider
     */
    public function allGenderConstantsAreValid(int $gender): void
    {
        // @phpstan-ignore staticMethod.alreadyNarrowedType
        self::assertTrue(FrontendUser::isValidGender($gender));
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

    /**
     * @test
     *
     * @dataProvider invalidGenderDataProvider
     */
    public function invalidGenderValuesAreInvalid(int $gender): void
    {
        self::assertFalse(FrontendUser::isValidGender($gender));
    }

    /**
     * @test
     */
    public function getFullSalutationInitiallyReturnsEmptyString(): void
    {
        self::assertSame('', $this->subject->getFullSalutation());
    }

    /**
     * @test
     */
    public function setFullSalutationSetsFullSalutation(): void
    {
        $value = 'Bonjour, my friend!';

        $this->subject->setFullSalutation($value);

        self::assertSame($value, $this->subject->getFullSalutation());
    }

    /**
     * @test
     */
    public function getGenderInitiallyReturnsNotProvided(): void
    {
        self::assertSame(FrontendUser::GENDER_NOT_PROVIDED, $this->subject->getGender());
    }

    /**
     * @test
     */
    public function setGenderSetsGender(): void
    {
        $value = FrontendUser::GENDER_DIVERSE;

        $this->subject->setGender($value);

        self::assertSame($value, $this->subject->getGender());
    }

    /**
     * @test
     */
    public function getZoneInitiallyReturnsEmptyString(): void
    {
        self::assertSame('', $this->subject->getZone());
    }

    /**
     * @test
     */
    public function setZoneSetsZone(): void
    {
        $value = 'Club-Mate';

        $this->subject->setZone($value);

        self::assertSame($value, $this->subject->getZone());
    }

    /**
     * @test
     */
    public function isPrivacyInitiallyReturnsFalse(): void
    {
        self::assertFalse($this->subject->getPrivacy());
    }

    /**
     * @test
     */
    public function setPrivacySetsPrivacy(): void
    {
        $this->subject->setPrivacy(true);

        self::assertTrue($this->subject->getPrivacy());
    }

    /**
     * @test
     */
    public function getPrivacyDateOfAcceptanceInitiallyReturnsNull(): void
    {
        self::assertNull($this->subject->getPrivacyDateOfAcceptance());
    }

    /**
     * @test
     */
    public function setPrivacyDateOfAcceptanceSetsPrivacyDateOfAcceptance(): void
    {
        $model = new \DateTime();
        $this->subject->setPrivacyDateOfAcceptance($model);

        self::assertSame($model, $this->subject->getPrivacyDateOfAcceptance());
    }

    /**
     * @test
     */
    public function hasTermsAcknowledgedInitiallyReturnsFalse(): void
    {
        self::assertFalse($this->subject->hasTermsAcknowledged());
    }

    /**
     * @test
     */
    public function setTermsAcknowledgedSetsTermsAcknowledged(): void
    {
        $this->subject->setTermsAcknowledged(true);

        self::assertTrue($this->subject->hasTermsAcknowledged());
    }

    /**
     * @test
     */
    public function getDateOfBirthInitiallyReturnsNull(): void
    {
        $result = $this->subject->getDateOfBirth();

        self::assertNull($result);
    }

    /**
     * @test
     */
    public function setDateOfBirthSetsDateOfBirth(): void
    {
        $date = new \DateTime();

        $this->subject->setDateOfBirth($date);

        self::assertSame($date, $this->subject->getDateOfBirth());
    }

    /**
     * @test
     */
    public function setDateOfBirthCanSetDateOfBirthToNull(): void
    {
        $this->subject->setDateOfBirth(null);

        self::assertNull($this->subject->getDateOfBirth());
    }

    /**
     * @return array<non-empty-string, array{0: FrontendUser::STATUS_*}>
     */
    public function validStatusDataProvider(): array
    {
        return [
            'unknown' => [FrontendUser::STATUS_NONE],
            'student' => [FrontendUser::STATUS_STUDENT],
            'job seeking (full time)' => [FrontendUser::STATUS_JOB_SEEKING_FULL_TIME],
            'working' => [FrontendUser::STATUS_WORKING],
            'retired' => [FrontendUser::STATUS_RETIRED],
            'job seeking (part time)' => [FrontendUser::STATUS_JOB_SEEKING_PART_TIME],
        ];
    }

    /**
     * @test
     *
     * @param FrontendUser::STATUS_* $status
     *
     * @dataProvider validStatusDataProvider
     */
    public function allStatusConstantsAreValid(int $status): void
    {
        self::assertTrue(FrontendUser::isValidStatus($status));
    }

    /**
     * @return array<non-empty-string, array{0: int}>
     */
    public function invalidStatusDataProvider(): array
    {
        return [
            'negative' => [-1],
            'too large' => [6],
        ];
    }

    /**
     * @test
     *
     * @dataProvider invalidStatusDataProvider
     */
    public function invalidStatusValuesAreInvalid(int $gender): void
    {
        self::assertFalse(FrontendUser::isValidStatus($gender));
    }

    /**
     * @test
     */
    public function getStatusInitiallyReturnsNone(): void
    {
        self::assertSame(FrontendUser::STATUS_NONE, $this->subject->getStatus());
    }

    /**
     * @test
     */
    public function setStatusSetsStatus(): void
    {
        $value = FrontendUser::STATUS_RETIRED;

        $this->subject->setStatus($value);

        self::assertSame($value, $this->subject->getStatus());
    }

    /**
     * @test
     */
    public function getCommentsInitiallyReturnsEmptyString(): void
    {
        self::assertSame('', $this->subject->getComments());
    }

    /**
     * @test
     */
    public function setCommentsSetsComments(): void
    {
        $value = 'Club-Mate';

        $this->subject->setComments($value);

        self::assertSame($value, $this->subject->getComments());
    }

    /**
     * @test
     */
    public function getTermsDateOfAcceptanceInitiallyReturnsNull(): void
    {
        self::assertNull($this->subject->getTermsDateOfAcceptance());
    }

    /**
     * @test
     */
    public function setTermsDateOfAcceptanceSetsTermsDateOfAcceptance(): void
    {
        $model = new \DateTime();
        $this->subject->setTermsDateOfAcceptance($model);

        self::assertSame($model, $this->subject->getTermsDateOfAcceptance());
    }

    /**
     * @test
     */
    public function getDisplayNameForEmptyModelReturnsNull(): void
    {
        self::assertNull($this->subject->getDisplayName());
    }

    /**
     * @return array<non-empty-string, array{0: string, 1: string, 2: string, 3: string, 4: string}>
     */
    public static function displayNameDataProvider(): array
    {
        return [
            'full name only' => ['Don Juan', '', '', '', 'Don Juan'],
            'first name only' => ['', 'Don', '', '', 'Don'],
            'last name only' => ['', '', 'Juan', '', 'Juan'],
            'full and first and last name' => ['Don Juan', 'Don', 'Juan', '', 'Don Juan'],
            'first and last name' => ['', 'Don', 'Juan', '', 'Juan, Don'],
            'email only' => ['', '', '', 'don@example.com', 'don@example.com'],
            'full name and email' => ['Don Juan', '', '', 'don@example.com', 'Don Juan'],
        ];
    }

    /**
     * @test
     * @dataProvider displayNameDataProvider
     */
    public function getDisplayNameForNonEmptyDataReturnsDisplayName(
        string $fullName,
        string $firstName,
        string $lastName,
        string $email,
        string $expected
    ): void {
        $this->subject->setName($fullName);
        $this->subject->setFirstName($firstName);
        $this->subject->setLastName($lastName);
        $this->subject->setEmail($email);

        self::assertSame($expected, $this->subject->getDisplayName());
    }

    /**
     * @test
     */
    public function getMembershipNumberInitiallyReturnsEmptyString(): void
    {
        self::assertSame('', $this->subject->getMembershipNumber());
    }

    /**
     * @test
     */
    public function setMembershipNumberSetsMembershipNumber(): void
    {
        $value = 'TR-808';
        $this->subject->setMembershipNumber($value);

        self::assertSame($value, $this->subject->getMembershipNumber());
    }
}
