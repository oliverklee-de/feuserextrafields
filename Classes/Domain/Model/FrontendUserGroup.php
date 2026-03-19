<?php

declare(strict_types=1);

namespace OliverKlee\FeUserExtraFields\Domain\Model;

use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Model for a front-end user group.
 */
class FrontendUserGroup extends AbstractEntity
{
    use CreationDateTrait;
    use ModificationDateTrait;

    #[Extbase\Validate(['validator' => 'StringLength', 'options' => ['maximum' => 50]])]
    protected string $title = '';

    #[Extbase\Validate(['validator' => 'StringLength', 'options' => ['maximum' => 65535]])]
    protected string $description = '';

    /**
     * @var ObjectStorage<FrontendUserGroup>
     */
    protected ObjectStorage $subgroup;

    public function __construct(string $title = '')
    {
        $this->setTitle($title);
        $this->initializeObject();
    }

    /**
     * Properly initializes all associations (as fetching an entity from the DB does not use the constructor).
     */
    public function initializeObject(): void
    {
        $this->subgroup = new ObjectStorage();
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * Returns the subgroups. Keep in mind that the property is called "subgroup"
     * although it can hold several user groups.
     *
     * @return ObjectStorage<FrontendUserGroup>
     */
    public function getSubgroup(): ObjectStorage
    {
        return $this->subgroup;
    }

    /**
     * Sets the subgroups. Keep in mind that the property is called "subgroup"
     * although it can hold several user groups.
     *
     * @param ObjectStorage<FrontendUserGroup> $groups
     */
    public function setSubgroup(ObjectStorage $groups): void
    {
        $this->subgroup = $groups;
    }

    public function addSubgroup(FrontendUserGroup $group): void
    {
        $this->subgroup->attach($group);
    }

    public function removeSubgroup(FrontendUserGroup $group): void
    {
        $this->subgroup->detach($group);
    }
}
