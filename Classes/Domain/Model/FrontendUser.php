<?php

declare(strict_types=1);

namespace OliverKlee\FeUserExtraFields\Domain\Model;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Model for a front-end user.
 */
class FrontendUser extends AbstractEntity
{
    use CreationDateTrait;
    use ModificationDateTrait;

    /**
     * @deprecated #599 will be removed in version 7.0, use the `Gender` class instead
     */
    public const GENDER_MALE = 0;

    /**
     * @deprecated #599 will be removed in version 7.0, use the `Gender` class instead
     */
    public const GENDER_FEMALE = 1;

    /**
     * @deprecated #599 will be removed in version 7.0, use the `Gender` class instead
     */
    public const GENDER_DIVERSE = 2;

    /**
     * @deprecated #599 will be removed in version 7.0, use the `Gender` class instead
     */
    public const GENDER_NOT_PROVIDED = 99;

    /**
     * @deprecated #599 will be removed in version 7.0, use the `Gender` class instead
     *
     * @internal
     */
    public const VALID_GENDERS = [
        self::GENDER_MALE,
        self::GENDER_FEMALE,
        self::GENDER_DIVERSE,
        self::GENDER_NOT_PROVIDED,
    ];

    public const STATUS_NONE = 0;
    public const STATUS_STUDENT = 1;
    public const STATUS_JOB_SEEKING_FULL_TIME = 2;
    public const STATUS_WORKING = 3;
    public const STATUS_RETIRED = 4;
    public const STATUS_JOB_SEEKING_PART_TIME = 5;

    /**
     * @internal
     */
    public const VALID_STATUSES = [
        self::STATUS_NONE,
        self::STATUS_STUDENT,
        self::STATUS_JOB_SEEKING_FULL_TIME,
        self::STATUS_WORKING,
        self::STATUS_RETIRED,
        self::STATUS_JOB_SEEKING_PART_TIME,
    ];

    /**
     * @Extbase\Validate("StringLength", options={"maximum": 255})
     */
    protected string $username = '';

    /**
     * the password hash
     *
     * @Extbase\Validate("StringLength", options={"maximum": 100})
     */
    protected string $password = '';

    /**
     * @var ObjectStorage<FrontendUserGroup>
     */
    protected ObjectStorage $userGroup;

    /**
     * @Extbase\Validate("StringLength", options={"maximum": 160})
     */
    protected string $name = '';

    /**
     * @Extbase\Validate("StringLength", options={"maximum": 50})
     */
    protected string $firstName = '';

    /**
     * @Extbase\Validate("StringLength", options={"maximum": 50})
     */
    protected string $middleName = '';

    /**
     * @Extbase\Validate("StringLength", options={"maximum": 50})
     */
    protected string $lastName = '';

    /**
     * @Extbase\Validate("StringLength", options={"maximum": 255})
     */
    protected string $address = '';

    /**
     * @Extbase\Validate("StringLength", options={"maximum": 30})
     */
    protected string $telephone = '';

    /**
     * @Extbase\Validate("StringLength", options={"maximum": 255})
     */
    protected string $email = '';

    /**
     * @Extbase\Validate("StringLength", options={"maximum": 40})
     */
    protected string $title = '';

    /**
     * @Extbase\Validate("StringLength", options={"maximum": 10})
     */
    protected string $zip = '';

    /**
     * @Extbase\Validate("StringLength", options={"maximum": 50})
     */
    protected string $city = '';

    /**
     * @Extbase\Validate("StringLength", options={"maximum": 40})
     */
    protected string $country = '';

    /**
     * @Extbase\Validate("StringLength", options={"maximum": 80})
     */
    protected string $www = '';

    /**
     * @Extbase\Validate("StringLength", options={"maximum": 80})
     */
    protected string $company = '';

    /**
     * @Extbase\Validate("StringLength", options={"maximum": 128})
     */
    protected string $department = '';

    /**
     * VAT identification number (VATIN)
     *
     * @Extbase\Validate("StringLength", options={"maximum": 15})
     */
    protected string $vatIn = '';

    /**
     * @var ObjectStorage<FileReference>
     */
    protected ObjectStorage $image;

    protected ?\DateTime $lastLogin = null;

    /**
     * salutation (possibly including a name), e.g., "Hello" or "Good day, Mr. Smith"
     *
     * @Extbase\Validate("StringLength", options={"maximum": 255})
     */
    protected string $fullSalutation = '';

    /**
     * @phpstan-var int<0, max>
     */
    protected int $gender = self::GENDER_NOT_PROVIDED;

    /**
     * @Extbase\Validate("StringLength", options={"maximum": 45})
     */
    protected string $zone = '';

    /**
     * "privacy agreement accepted" flag
     */
    protected bool $privacy = false;

    protected ?\DateTime $privacyDateOfAcceptance = null;

    /**
     * the "terms and conditions" have been acknowledged
     */
    protected bool $termsAcknowledged = false;

    protected ?\DateTime $termsDateOfAcceptance = null;

    protected ?\DateTime $dateOfBirth = null;

    /**
     * @var self::STATUS_*
     */
    protected int $status = self::STATUS_NONE;

    /**
     * @Extbase\Validate("StringLength", options={"maximum": 65535})
     */
    protected string $comments = '';

    /**
     * @Extbase\Validate("StringLength", options={"maximum": 8})
     */
    protected string $membershipNumber = '';

    public function __construct()
    {
        $this->initializeObject();
    }

    /**
     * Properly initializes all associations (as fetching an entity from the DB does not use the constructor).
     */
    public function initializeObject(): void
    {
        $this->userGroup = new ObjectStorage();
        $this->image = new ObjectStorage();
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * Returns the password hash (or an empty string).
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Sets the password hash.
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * Returns the user groups. Keep in mind that the property is called "usergroup"
     * although it can hold several user groups.
     *
     * @return ObjectStorage<FrontendUserGroup>
     */
    public function getUserGroup(): ObjectStorage
    {
        return $this->userGroup;
    }

    /**
     * Sets the user groups. Keep in mind that the property is called "usergroup"
     * although it can hold several user groups.
     *
     * @param ObjectStorage<FrontendUserGroup> $groups
     */
    public function setUserGroup(ObjectStorage $groups): void
    {
        $this->userGroup = $groups;
    }

    public function addUserGroup(FrontendUserGroup $group): void
    {
        $this->userGroup->attach($group);
    }

    public function removeUserGroup(FrontendUserGroup $group): void
    {
        $this->userGroup->detach($group);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getMiddleName(): string
    {
        return $this->middleName;
    }

    public function setMiddleName(string $middleName): void
    {
        $this->middleName = $middleName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    public function getTelephone(): string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): void
    {
        $this->telephone = $telephone;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return non-empty-string the email address (if it is non-empty and valid)
     *
     * @throws \UnexpectedValueException if the email address is empty or invalid
     */
    public function getValidEmail(): string
    {
        $email = $this->getEmail();
        if ($email === '') {
            throw new \UnexpectedValueException('The email address is empty.', 1735245325);
        }
        if (!GeneralUtility::validEmail($email)) {
            throw new \UnexpectedValueException('The email address is invalid.', 1735245456);
        }

        return $email;
    }

    /**
     * Returns a name to display for the user.
     *
     * The name is constructed from these parts (if these exist):
     *
     * 1. full name
     * 2. last name, first name
     * 3. last name
     * 4. first name
     * 5. email address
     *
     * If all of these are empty, `null` is returned.
     */
    public function getDisplayName(): ?string
    {
        switch (true) {
            case $this->getName() !== '':
                $displayName = $this->getName();
                break;
            case $this->getLastName() !== '' && $this->getFirstName() !== '':
                $displayName = $this->getLastName() . ', ' . $this->getFirstName();
                break;
            case $this->getLastName() !== '':
                $displayName = $this->getLastName();
                break;
            case $this->getFirstName() !== '':
                $displayName = $this->getFirstName();
                break;
            case $this->getEmail() !== '':
                $displayName = $this->getEmail();
                break;
            default:
                $displayName = null;
        }

        return $displayName;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getZip(): string
    {
        return $this->zip;
    }

    public function setZip(string $zip): void
    {
        $this->zip = $zip;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    public function getWww(): string
    {
        return $this->www;
    }

    public function setWww(string $www): void
    {
        $this->www = $www;
    }

    public function getCompany(): string
    {
        return $this->company;
    }

    public function setCompany(string $company): void
    {
        $this->company = $company;
    }

    public function getDepartment(): string
    {
        return $this->department;
    }

    public function setDepartment(string $department): void
    {
        $this->department = $department;
    }

    public function getVatIn(): string
    {
        return $this->vatIn;
    }

    public function setVatIn(string $vatIn): void
    {
        $this->vatIn = $vatIn;
    }

    /**
     * Gets the image. (This is a storage with 0 or 1 elements.)
     *
     * @return ObjectStorage<FileReference>
     */
    public function getImage(): ObjectStorage
    {
        return $this->image;
    }

    /**
     * Sets the image. (This is a storage with 0 or 1 elements.)
     *
     * @param ObjectStorage<FileReference> $images
     */
    public function setImage(ObjectStorage $images): void
    {
        $this->image = $images;
    }

    public function getLastLogin(): ?\DateTime
    {
        return $this->lastLogin;
    }

    public function setLastLogin(\DateTime $lastLogin): void
    {
        $this->lastLogin = $lastLogin;
    }

    public function getZone(): string
    {
        return $this->zone;
    }

    public function setZone(string $zone): void
    {
        $this->zone = $zone;
    }

    public function getPrivacy(): bool
    {
        return $this->privacy;
    }

    public function setPrivacy(bool $privacy): void
    {
        $this->privacy = $privacy;
    }

    public function getPrivacyDateOfAcceptance(): ?\DateTime
    {
        return $this->privacyDateOfAcceptance;
    }

    public function setPrivacyDateOfAcceptance(?\DateTime $date): void
    {
        $this->privacyDateOfAcceptance = $date;
    }

    public function hasTermsAcknowledged(): bool
    {
        return $this->termsAcknowledged;
    }

    public function setTermsAcknowledged(bool $termsAcknowledged): void
    {
        $this->termsAcknowledged = $termsAcknowledged;
    }

    public function getTermsDateOfAcceptance(): ?\DateTime
    {
        return $this->termsDateOfAcceptance;
    }

    public function setTermsDateOfAcceptance(?\DateTime $date): void
    {
        $this->termsDateOfAcceptance = $date;
    }

    public function getFullSalutation(): string
    {
        return $this->fullSalutation;
    }

    public function setFullSalutation(string $fullSalutation): void
    {
        $this->fullSalutation = $fullSalutation;
    }

    /**
     * @deprecated #599 will be removed in version 7.0, use the `Gender` class instead
     *
     * @phpstan-assert-if-true 0|1|2|99 $gender
     */
    public static function isValidGender(int $gender): bool
    {
        return \in_array($gender, self::VALID_GENDERS, true);
    }

    /**
     * @return int<0, max>
     */
    public function getGender(): int
    {
        return $this->gender;
    }

    /**
     * @param int<0, max> $gender
     */
    public function setGender(int $gender): void
    {
        $this->gender = $gender;
    }

    public function getDateOfBirth(): ?\DateTime
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(?\DateTime $dateOfBirth): void
    {
        $this->dateOfBirth = $dateOfBirth;
    }

    public static function isValidStatus(int $gender): bool
    {
        return \in_array($gender, self::VALID_STATUSES, true);
    }

    /**
     * @return self::STATUS_*
     */
    public function getStatus(): int
    {
        $status = $this->status;
        \assert(\in_array($status, self::VALID_STATUSES, true));

        return $status;
    }

    /**
     * @param self::STATUS_* $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    public function getComments(): string
    {
        return $this->comments;
    }

    public function setComments(string $comments): void
    {
        $this->comments = $comments;
    }

    public function getMembershipNumber(): string
    {
        return $this->membershipNumber;
    }

    public function setMembershipNumber(string $membershipNumber): void
    {
        $this->membershipNumber = $membershipNumber;
    }
}
