<?php

declare(strict_types=1);

namespace OliverKlee\FeUserExtraFields\Tests\Functional\Domain\Repository;

use OliverKlee\FeUserExtraFields\Domain\Model\FrontendUser;
use OliverKlee\FeUserExtraFields\Domain\Model\FrontendUserGroup;
use OliverKlee\FeUserExtraFields\Domain\Model\Gender;
use OliverKlee\FeUserExtraFields\Domain\Repository\DirectPersistInterface;
use OliverKlee\FeUserExtraFields\Domain\Repository\DirectPersistTrait;
use OliverKlee\FeUserExtraFields\Domain\Repository\FrontendUserRepository;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Persistence\RepositoryInterface;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

#[CoversClass(FrontendUserRepository::class)]
#[CoversClass(DirectPersistTrait::class)]
final class FrontendUserRepositoryTest extends FunctionalTestCase
{
    protected array $testExtensionsToLoad = ['oliverklee/feuserextrafields'];

    private PersistenceManagerInterface $persistenceManager;

    private FrontendUserRepository $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->persistenceManager = $this->get(PersistenceManagerInterface::class);

        $this->subject = $this->get(FrontendUserRepository::class);
    }

    #[Test]
    public function implementsRepositoryInterface(): void
    {
        self::assertInstanceOf(RepositoryInterface::class, $this->subject);
    }

    #[Test]
    public function isRepository(): void
    {
        self::assertInstanceOf(Repository::class, $this->subject);
    }

    #[Test]
    public function implementsDirectPersistInterface(): void
    {
        self::assertInstanceOf(DirectPersistInterface::class, $this->subject);
    }

    #[Test]
    public function findAllForNoRecordsReturnsEmptyContainer(): void
    {
        $container = $this->subject->findAll();

        self::assertCount(0, $container);
    }

    #[Test]
    public function findByUidForExistingRecordReturnsModelWithAllScalarData(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/UserWithAllScalarData.csv');

        $model = $this->subject->findByUid(1);

        self::assertInstanceOf(FrontendUser::class, $model);
        self::assertEquals(new \DateTime('2019-01-01 00:00:00'), $model->getCreationDate());
        self::assertEquals(new \DateTime('2023-01-01 00:00:00'), $model->getModificationDate());
        self::assertSame('max', $model->getUsername());
        self::assertSame('luif3ui4t12', $model->getPassword());
        self::assertSame('Max M. Minimau', $model->getName());
        self::assertSame('Max', $model->getFirstName());
        self::assertSame('Murri', $model->getMiddleName());
        self::assertSame('Minimau', $model->getLastName());
        self::assertSame('Near the heating 4', $model->getAddress());
        self::assertSame('+49 1111 1233456-78', $model->getTelephone());
        self::assertSame('max@example.com', $model->getEmail());
        self::assertSame('Head of fur', $model->getTitle());
        self::assertSame('01234', $model->getZip());
        self::assertSame('Kattingen', $model->getCity());
        self::assertSame('United States of CAT', $model->getCountry());
        self::assertSame('www.example.com', $model->getWww());
        self::assertSame('Cat Scans Inc.', $model->getCompany());
        self::assertSame('Mammalians Nurturable', $model->getDepartment());
        self::assertSame('DE123456789', $model->getVatIn());
        self::assertEquals(new \DateTime('2022-04-02T18:00'), $model->getLastLogin());
        self::assertTrue($model->getPrivacy());
        self::assertEquals(new \DateTime('2024-04-13T09:20'), $model->getPrivacyDateOfAcceptance());
        self::assertTrue($model->hasTermsAcknowledged());
        self::assertEquals(new \DateTime('2024-05-18T02:40'), $model->getTermsDateOfAcceptance());
        self::assertSame('NRW', $model->getZone());
        self::assertSame('Welcome, Max MM!', $model->getFullSalutation());
        self::assertSame(Gender::diverse(), $model->getGender());
        self::assertEquals(new \DateTime('2022-04-02T00:00'), $model->getDateOfBirth());
        self::assertSame(FrontendUser::STATUS_JOB_SEEKING_FULL_TIME, $model->getStatus());
        self::assertSame('Here we go!', $model->getComments());
        self::assertSame('TB-303', $model->getMembershipNumber());
    }

    #[Test]
    public function initializesUserGroupsWithEmptyStorage(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/UserWithAllScalarData.csv');

        $model = $this->subject->findByUid(1);
        self::assertInstanceOf(FrontendUser::class, $model);

        $groups = $model->getUserGroup();
        self::assertInstanceOf(ObjectStorage::class, $groups);
        self::assertCount(0, $groups);
    }

    #[Test]
    public function mapsUserGroupsAssociation(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/UserWithTwoGroups.csv');

        $model = $this->subject->findByUid(1);
        self::assertInstanceOf(FrontendUser::class, $model);

        $groups = $model->getUserGroup();
        self::assertInstanceOf(ObjectStorage::class, $groups);
        self::assertCount(2, $groups);
        $groupsAsArray = $groups->toArray();
        self::assertInstanceOf(FrontendUserGroup::class, $groupsAsArray[0]);
        self::assertInstanceOf(FrontendUserGroup::class, $groupsAsArray[1]);
    }

    #[Test]
    public function initializesImageWithEmptyStorage(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/UserWithAllScalarData.csv');

        $model = $this->subject->findByUid(1);
        self::assertInstanceOf(FrontendUser::class, $model);

        $image = $model->getImage();
        self::assertInstanceOf(ObjectStorage::class, $image);
        self::assertCount(0, $image);
    }

    #[Test]
    public function mapsImageAssociation(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/UserWithImage.csv');

        $model = $this->subject->findByUid(1);
        self::assertInstanceOf(FrontendUser::class, $model);

        $images = $model->getImage();
        self::assertInstanceOf(ObjectStorage::class, $images);
        self::assertCount(1, $images);
        $imagesAsArray = $images->toArray();
        $firstImage = $imagesAsArray[0];
        self::assertInstanceOf(FileReference::class, $firstImage);
        self::assertSame(1, $firstImage->getUid());
    }

    #[Test]
    public function persistAllPersistsAddedModels(): void
    {
        $user = new FrontendUser();

        $this->subject->add($user);
        $this->subject->persistAll();

        $this->assertCSVDataSet(__DIR__ . '/Assertions/CreatedUser.csv');
    }

    #[Test]
    public function findOneByUsernameWithoutMatchReturnsNull(): void
    {
        $result = $this->subject->findOneByUsername('not-existing-username');

        self::assertNull($result);
    }

    #[Test]
    public function findOneByUsernameWithMatchReturnsUserWithTheProvidedUsername(): void
    {
        $username = 'max';
        $this->importCSVDataSet(__DIR__ . '/Fixtures/UserWithAllScalarData.csv');

        $result = $this->subject->findOneByUsername($username);

        self::assertInstanceOf(FrontendUser::class, $result);
        self::assertSame($username, $result->getUsername());
    }

    #[Test]
    public function findOneByUsernameWithEmptyUsernameReturnsNullEvenForUserWithEmptyUsername(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/UserWithEmptyUsername.csv');

        $result = $this->subject->findOneByUsername('');

        self::assertNull($result);
    }

    #[Test]
    public function existsWithUsernameWithoutMatchReturnsFalse(): void
    {
        $result = $this->subject->existsWithUsername('not-existing-username');

        self::assertFalse($result);
    }

    #[Test]
    public function existsWithUsernameWithMatchReturnsTrue(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/UserWithAllScalarData.csv');

        $result = $this->subject->existsWithUsername('max');

        self::assertTrue($result);
    }

    #[Test]
    public function existsWithUsernameWithEmptyUsernameReturnsFalseEvenForUserWithEmptyUsername(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/UserWithEmptyUsername.csv');

        $result = $this->subject->existsWithUsername('');

        self::assertFalse($result);
    }

    #[Test]
    public function willSaveNewUserWithExplicitPidOnTheGivenPage(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/Pages.csv');
        $pageUid = 1;

        $user = new FrontendUser();
        $user->setPid($pageUid);

        $this->subject->add($user);
        $this->persistenceManager->persistAll();

        $this->assertCSVDataSet(__DIR__ . '/Assertions/CreatedUserOnPage.csv');
    }

    #[Test]
    public function findBySearchTermInBackendModeReturnsQueryResult(): void
    {
        $result = $this->subject->findBySearchTermInBackendMode('1234');

        self::assertInstanceOf(QueryResultInterface::class, $result);
    }

    #[Test]
    public function findBySearchTermInBackendModeReturnsResultWithFrontendUser(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/User/findBySearchTermInBackendMode/VisibleUser.csv');

        $result = $this->subject->findBySearchTermInBackendMode('1234');

        $model = $result->getFirst();
        self::assertInstanceOf(FrontendUser::class, $model);
    }

    #[Test]
    public function findBySearchTermInBackendModeFindsVisibleUserWithExactMatchingUid(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/User/findBySearchTermInBackendMode/VisibleUser.csv');

        $result = $this->subject->findBySearchTermInBackendMode('1234');

        $model = $result->getFirst();
        self::assertInstanceOf(FrontendUser::class, $model);
    }

    #[Test]
    public function findBySearchTermInBackendModeFindsHiddenUserWithExactMatchingUid(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/User/findBySearchTermInBackendMode/HiddenUser.csv');

        $result = $this->subject->findBySearchTermInBackendMode('1234');

        $model = $result->getFirst();
        self::assertInstanceOf(FrontendUser::class, $model);
    }

    #[Test]
    public function findBySearchTermInBackendModeIgnoresDeletedUserWithExactMatchingUid(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/User/findBySearchTermInBackendMode/DeletedUser.csv');

        $result = $this->subject->findBySearchTermInBackendMode('1234');

        self::assertInstanceOf(QueryResultInterface::class, $result);
        self::assertCount(0, $result);
    }

    #[Test]
    public function findBySearchTermInBackendModeFindsUserOnAnyPage(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/User/findBySearchTermInBackendMode/UserOnPage.csv');

        $result = $this->subject->findBySearchTermInBackendMode('1234');

        $model = $result->getFirst();
        self::assertInstanceOf(FrontendUser::class, $model);
    }

    #[Test]
    public function findBySearchTermInBackendModeIgnoresUserWithCompletelyDifferentUid(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/User/findBySearchTermInBackendMode/VisibleUser.csv');

        $result = $this->subject->findBySearchTermInBackendMode('4567');

        self::assertCount(0, $result);
    }

    #[Test]
    public function findBySearchTermInBackendModeIgnoresUserSubstringMatchInUid(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/User/findBySearchTermInBackendMode/VisibleUser.csv');

        $result = $this->subject->findBySearchTermInBackendMode('23');

        self::assertCount(0, $result);
    }

    #[Test]
    public function findBySearchTermInBackendModeFindsUserWithCaseInsensitiveSubstringMatchOnUserName(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/User/findBySearchTermInBackendMode/VisibleUser.csv');

        $result = $this->subject->findBySearchTermInBackendMode('ainbo');

        $model = $result->getFirst();
        self::assertInstanceOf(FrontendUser::class, $model);
    }

    #[Test]
    public function findBySearchTermInBackendModeFindsUserWithCaseInsensitiveSubstringMatchOnFullName(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/User/findBySearchTermInBackendMode/VisibleUser.csv');

        $result = $this->subject->findBySearchTermInBackendMode('AX');

        $model = $result->getFirst();
        self::assertInstanceOf(FrontendUser::class, $model);
    }

    #[Test]
    public function findBySearchTermInBackendModeFindsUserWithCaseInsensitiveSubstringMatchOnFirstName(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/User/findBySearchTermInBackendMode/VisibleUser.csv');

        $result = $this->subject->findBySearchTermInBackendMode('schm');

        $model = $result->getFirst();
        self::assertInstanceOf(FrontendUser::class, $model);
    }

    #[Test]
    public function findBySearchTermInBackendModeFindsUserWithCaseInsensitiveSubstringMatchOnEmail(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/User/findBySearchTermInBackendMode/VisibleUser.csv');

        $result = $this->subject->findBySearchTermInBackendMode('zm');

        $model = $result->getFirst();
        self::assertInstanceOf(FrontendUser::class, $model);
    }

    #[Test]
    public function findBySearchTermInBackendModeFindsUserWithCaseInsensitiveSubstringMatchOnCompany(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/User/findBySearchTermInBackendMode/VisibleUser.csv');

        $result = $this->subject->findBySearchTermInBackendMode('UME');

        $model = $result->getFirst();
        self::assertInstanceOf(FrontendUser::class, $model);
    }
}
