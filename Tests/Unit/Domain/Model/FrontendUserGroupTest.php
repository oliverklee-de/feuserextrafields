<?php

declare(strict_types=1);

namespace OliverKlee\FeUserExtraFields\Tests\Unit\Domain\Model;

use OliverKlee\FeUserExtraFields\Domain\Model\FrontendUserGroup;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

#[CoversClass(FrontendUserGroup::class)]
final class FrontendUserGroupTest extends UnitTestCase
{
    private FrontendUserGroup $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new FrontendUserGroup();
    }

    #[Test]
    public function isAbstractEntity(): void
    {
        self::assertInstanceOf(AbstractEntity::class, $this->subject);
    }

    #[Test]
    public function getCreationDateInitiallyReturnsNull(): void
    {
        self::assertNull($this->subject->getCreationDate());
    }

    #[Test]
    public function setCreationDateSetsCreationDate(): void
    {
        $date = new \DateTime();

        $this->subject->setCreationDate($date);

        self::assertSame($date, $this->subject->getCreationDate());
    }

    #[Test]
    public function getModificationDateInitiallyReturnsNull(): void
    {
        self::assertNull($this->subject->getModificationDate());
    }

    #[Test]
    public function setModificationDateSetsModificationDate(): void
    {
        $date = new \DateTime();

        $this->subject->setModificationDate($date);

        self::assertSame($date, $this->subject->getModificationDate());
    }

    #[Test]
    public function getTitleInitiallyReturnsEmptyString(): void
    {
        $result = $this->subject->getTitle();

        self::assertSame('', $result);
    }

    #[Test]
    public function setTitleSetsTitle(): void
    {
        $title = 'foo bar';

        $this->subject->setTitle($title);

        self::assertSame($title, $this->subject->getTitle());
    }

    #[Test]
    public function getSubgroupInitiallyReturnsEmptyStorage(): void
    {
        $result = $this->subject->getSubgroup();

        self::assertInstanceOf(ObjectStorage::class, $result);
        self::assertCount(0, $result);
    }

    #[Test]
    public function setSubgroupSetsUserGroups(): void
    {
        /** @var ObjectStorage<FrontendUserGroup> $groups */
        $groups = new ObjectStorage();
        $groups->attach(new FrontendUserGroup());

        $this->subject->setSubgroup($groups);

        self::assertSame($groups, $this->subject->getSubgroup());
    }

    #[Test]
    public function getDescriptionInitiallyReturnsEmptyString(): void
    {
        $result = $this->subject->getDescription();

        self::assertSame('', $result);
    }

    #[Test]
    public function setDescriptionSetsDescription(): void
    {
        $description = 'foo bar';

        $this->subject->setDescription($description);

        self::assertSame($description, $this->subject->getDescription());
    }

    #[Test]
    public function addSubgroupAddsUserGroup(): void
    {
        $group = new FrontendUserGroup();

        $this->subject->addSubgroup($group);

        self::assertTrue($this->subject->getSubgroup()->contains($group));
    }

    #[Test]
    public function removeSubgroupRemovesUserGroup(): void
    {
        $group = new FrontendUserGroup();
        $this->subject->addSubgroup($group);
        self::assertTrue($this->subject->getSubgroup()->contains($group));

        $this->subject->removeSubgroup($group);

        self::assertFalse($this->subject->getSubgroup()->contains($group));
    }
}
