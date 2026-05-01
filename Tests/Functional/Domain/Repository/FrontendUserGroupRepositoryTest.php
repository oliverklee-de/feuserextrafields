<?php

declare(strict_types=1);

namespace OliverKlee\FeUserExtraFields\Tests\Functional\Domain\Repository;

use OliverKlee\FeUserExtraFields\Domain\Model\FrontendUserGroup;
use OliverKlee\FeUserExtraFields\Domain\Repository\DirectPersistInterface;
use OliverKlee\FeUserExtraFields\Domain\Repository\DirectPersistTrait;
use OliverKlee\FeUserExtraFields\Domain\Repository\FrontendUserGroupRepository;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Persistence\RepositoryInterface;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

#[CoversClass(FrontendUserGroupRepository::class)]
#[CoversClass(DirectPersistTrait::class)]
final class FrontendUserGroupRepositoryTest extends FunctionalTestCase
{
    protected array $testExtensionsToLoad = ['oliverklee/feuserextrafields'];

    private FrontendUserGroupRepository $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->get(FrontendUserGroupRepository::class);
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
        $this->importCSVDataSet(__DIR__ . '/Fixtures/UserGroupWithAllScalarData.csv');

        $model = $this->subject->findByUid(1);

        self::assertInstanceOf(FrontendUserGroup::class, $model);
        self::assertEquals(new \DateTime('2019-01-01 00:00:00'), $model->getCreationDate());
        self::assertEquals(new \DateTime('2023-01-01 00:00:00'), $model->getModificationDate());
        self::assertSame('editors', $model->getTitle());
        self::assertSame('We build websites!', $model->getDescription());
    }

    #[Test]
    public function findByUidsWithoutMatchesReturnsEmptyArray(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/UserGroupWithAllScalarData.csv');

        $models = $this->subject->findByUids([2]);

        self::assertCount(0, $models);
    }

    #[Test]
    public function findByUidsForExistingRecordReturnsMatchingModel(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/UserGroupWithAllScalarData.csv');

        $models = $this->subject->findByUids([1]);

        self::assertCount(1, $models);
        $firstModel = $models->current();
        self::assertInstanceOf(FrontendUserGroup::class, $firstModel);
        self::assertSame(1, $firstModel->getUid());
    }

    #[Test]
    public function findByUidsFindsRecordsOnAnyPage(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/UserGroupOnPage.csv');

        $models = $this->subject->findByUids([1]);

        self::assertCount(1, $models);
        $firstModel = $models->current();
        self::assertInstanceOf(FrontendUserGroup::class, $firstModel);
        self::assertSame(1, $firstModel->getUid());
    }

    #[Test]
    public function findByUidsForForPartialMatchesReturnsOnlyTheMatches(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/UserGroupWithAllScalarData.csv');

        $models = $this->subject->findByUids([1, 2]);

        self::assertCount(1, $models);
        $firstModel = $models->current();
        self::assertInstanceOf(FrontendUserGroup::class, $firstModel);
        self::assertSame(1, $firstModel->getUid());
    }

    #[Test]
    public function initializesSubGroupsWithEmptyStorage(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/UserGroupWithAllScalarData.csv');

        $model = $this->subject->findByUid(1);
        self::assertInstanceOf(FrontendUserGroup::class, $model);

        $groups = $model->getSubgroup();
        self::assertInstanceOf(ObjectStorage::class, $groups);
        self::assertCount(0, $groups);
    }

    #[Test]
    public function mapsSubgroupAssociation(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/UserGroupWithTwoSubgroups.csv');

        $model = $this->subject->findByUid(1);
        self::assertInstanceOf(FrontendUserGroup::class, $model);

        $groups = $model->getSubgroup();
        self::assertInstanceOf(ObjectStorage::class, $groups);
        self::assertCount(2, $groups);
        $groupsAsArray = $groups->toArray();
        self::assertInstanceOf(FrontendUserGroup::class, $groupsAsArray[0]);
        self::assertInstanceOf(FrontendUserGroup::class, $groupsAsArray[1]);
    }

    #[Test]
    public function persistAllPersistsAddedModels(): void
    {
        $group = new FrontendUserGroup();

        $this->subject->add($group);
        $this->subject->persistAll();

        $this->assertCSVDataSet(__DIR__ . '/Assertions/CreatedUserGroup.csv');
    }
}
