<?php

declare(strict_types=1);

namespace OliverKlee\FeUserExtraFields\Tests\Functional\Domain\Model;

use OliverKlee\FeUserExtraFields\Domain\Model\FrontendUserGroup;
use OliverKlee\FeUserExtraFields\Tests\Functional\Domain\Model\Fixtures\XclassFrontendUserGroup;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

#[CoversClass(FrontendUserGroup::class)]
final class FrontendUserGroupTest extends FunctionalTestCase
{
    protected bool $initializeDatabase = false;

    protected array $testExtensionsToLoad = ['oliverklee/feuserextrafields'];

    #[Test]
    public function canBeSubclassed(): void
    {
        // @phpstan-ignore offsetAccess.nonOffsetAccessible, offsetAccess.nonOffsetAccessible
        $xclassConfiguration = &$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'];
        self::assertIsArray($xclassConfiguration);
        $xclassConfiguration[FrontendUserGroup::class] = ['className' => XclassFrontendUserGroup::class];

        $instance = GeneralUtility::makeInstance(FrontendUserGroup::class);

        self::assertInstanceOf(XclassFrontendUserGroup::class, $instance);
    }
}
