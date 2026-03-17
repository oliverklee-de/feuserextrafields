<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') || die();

call_user_func(static function (): void {
    $languageFile = 'LLL:EXT:feuserextrafields/Resources/Private/Language/locallang.xlf:';

    $temporaryColumns = [
        'crdate' => [
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

    ExtensionManagementUtility::addTCAcolumns('fe_groups', $temporaryColumns);
});
