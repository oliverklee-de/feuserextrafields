<?php

use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') || die();

call_user_func(static function (): void {
    $languageFile = 'LLL:EXT:feuserextrafields/Resources/Private/Language/locallang.xlf:';

    $temporaryColumns = [
        'crdate' => [
            'exclude' => true,
            'label' => $languageFile . 'crdate',
            'config' => [
                'type' => 'input',
                'renderType' => 'datetime',
                'format' => 'datetime',
                'eval' => 'int',
                'readOnly' => true,
            ],
        ],
        'tstamp' => [
            'exclude' => true,
            'label' => $languageFile . 'tstamp',
            'config' => [
                'type' => 'input',
                'renderType' => 'datetime',
                'format' => 'datetime',
                'eval' => 'int',
                'readOnly' => true,
            ],
        ],
    ];

    $typo3Version = new Typo3Version();
    if ($typo3Version->getMajorVersion() < 12) {
        $temporaryColumns = array_replace_recursive(
            $temporaryColumns,
            [
                'crdate' => [
                    'config' => [
                        'renderType' => 'inputDateTime',
                        'eval' => 'datetime,int',
                    ],
                ],
                'tstamp' => [
                    'config' => [
                        'renderType' => 'inputDateTime',
                        'eval' => 'datetime,int',
                    ],
                ],
            ],
        );
    }

    ExtensionManagementUtility::addTCAcolumns('fe_groups', $temporaryColumns);
});
