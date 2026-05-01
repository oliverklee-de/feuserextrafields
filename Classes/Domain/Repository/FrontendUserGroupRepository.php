<?php

declare(strict_types=1);

namespace OliverKlee\FeUserExtraFields\Domain\Repository;

use OliverKlee\FeUserExtraFields\Domain\Model\FrontendUserGroup;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * @extends Repository<FrontendUserGroup>
 */
class FrontendUserGroupRepository extends Repository implements DirectPersistInterface
{
    use DirectPersistTrait;

    /**
     * @param array<int> $uids
     *
     * @return QueryResultInterface<FrontendUserGroup>
     */
    public function findByUids(array $uids): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);

        return $query->matching($query->in('uid', $uids))->execute();
    }
}
