<?php

use OliverKlee\FeUserExtraFields\Domain\Model\FrontendUser;
use OliverKlee\FeUserExtraFields\Domain\Model\Gender;
use TYPO3\CMS\Core\Information\Typo3Version;
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
                'eval' => 'datetime,int',
                'readOnly' => true,
            ],
        ],
        'tstamp' => [
            'label' => $languageFile . 'tstamp',
            'config' => [
                'type' => 'input',
                'format' => 'datetime',
                'renderType' => 'datetime',
                'eval' => 'datetime,int',
                'readOnly' => true,
            ],
        ],
        'full_salutation' => [
            'label' => $languageFile . 'full_salutation',
            'config' => [
                'type' => 'input',
                'size' => '20',
                'max' => '255',
                'eval' => '',
                'default' => '',
            ],
        ],
        'gender' => [
            'label' => $languageFile . 'gender',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    [
                        'label' => $languageFile . 'gender.99',
                        'value' => Gender::notProvided(),
                    ],
                    [
                        'label' => $languageFile . 'gender.0',
                        'value' => Gender::male(),
                    ],
                    [
                        'label' => $languageFile . 'gender.1',
                        'value' => Gender::female(),
                    ],
                    [
                        'label' => $languageFile . 'gender.2',
                        'value' => Gender::diverse(),
                    ],
                ],
                'default' => Gender::notProvided(),
            ],
        ],
        'date_of_birth' => [
            'label' => $languageFile . 'dateOfBirth',
            'config' => [
                'type' => 'input',
                'renderType' => 'datetime',
                'format' => 'date',
                'size' => 10,
                'eval' => 'int',
                'default' => 0,
            ],
        ],
        'zone' => [
            'label' => $languageFile . 'zone',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'max' => 40,
                'eval' => 'trim',
                'default' => '',
            ],
        ],
        'department' => [
            'exclude' => true,
            'label' => $languageFile . 'department',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'max' => 128,
                'eval' => 'trim',
                'default' => '',
            ],
        ],
        'vat_in' => [
            'exclude' => true,
            'label' => $languageFile . 'vatIn',
            'config' => [
                'type' => 'input',
                'size' => 10,
                'max' => 15,
                'eval' => 'trim',
                'default' => '',
            ],
        ],
        'membership_number' => [
            'exclude' => true,
            'label' => $languageFile . 'membership_number',
            'config' => [
                'type' => 'input',
                'size' => 8,
                'max' => 8,
                'eval' => 'trim',
                'default' => '',
            ],
        ],
        'privacy' => [
            'exclude' => true,
            'label' => $languageFile . 'privacy',
            'config' => [
                'type' => 'check',
            ],
        ],
        'privacy_date_of_acceptance' => [
            'exclude' => true,
            'label' => $languageFile . 'privacyDateOfAcceptance',
            'config' => [
                'type' => 'input',
                'renderType' => 'datetime',
                'format' => 'datetime',
                'eval' => 'datetime,int',
                'readOnly' => true,
            ],
        ],
        'terms_acknowledged' => [
            'exclude' => true,
            'label' => $languageFile . 'terms_acknowledged',
            'config' => [
                'type' => 'check',
            ],
        ],
        'terms_date_of_acceptance' => [
            'exclude' => true,
            'label' => $languageFile . 'termsDateOfAcceptance',
            'config' => [
                'type' => 'input',
                'renderType' => 'datetime',
                'format' => 'datetime',
                'eval' => 'datetime,int',
                'readOnly' => true,
            ],
        ],
        'status' => [
            'label' => $languageFile . 'status',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    [
                        'label' => $languageFile . 'status.0',
                        'value' => FrontendUser::STATUS_NONE,
                    ],
                    [
                        'label' => $languageFile . 'status.1',
                        'value' => FrontendUser::STATUS_STUDENT,
                    ],
                    [
                        'label' => $languageFile . 'status.2',
                        'value' => FrontendUser::STATUS_JOB_SEEKING_FULL_TIME,
                    ],
                    [
                        'label' => $languageFile . 'status.3',
                        'value' => FrontendUser::STATUS_WORKING,
                    ],
                    [
                        'label' => $languageFile . 'status.4',
                        'value' => FrontendUser::STATUS_RETIRED,
                    ],
                    [
                        'label' => $languageFile . 'status.5',
                        'value' => FrontendUser::STATUS_JOB_SEEKING_PART_TIME,
                    ],
                ],
                'default' => FrontendUser::STATUS_NONE,
            ],
        ],
        'comments' => [
            'label' => $languageFile . 'comments',
            'config' => [
                'type' => 'text',
                'rows' => 5,
                'cols' => 48,
                'default' => '',
                'eval' => 'trim',
            ],
        ],
    ];

    $typo3Version = new Typo3Version();
    if ($typo3Version->getMajorVersion() < 12) {
        unset($temporaryColumns['gender']['config']['items'], $temporaryColumns['status']['config']['items']);
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
                'date_of_birth' => [
                    'config' => [
                        'renderType' => 'inputDateTime',
                        'eval' => 'datetime,int',
                    ],
                ],
                'gender' => [
                    'config' => [
                        'items' => [
                            [
                                $languageFile . 'gender.99',
                                Gender::notProvided(),
                            ],
                            [
                                $languageFile . 'gender.0',
                                Gender::male(),
                            ],
                            [
                                $languageFile . 'gender.1',
                                Gender::female(),
                            ],
                            [
                                $languageFile . 'gender.2',
                                Gender::diverse(),
                            ],
                        ],
                    ],
                ],
                'privacy_date_of_acceptance' => [
                    'config' => [
                        'renderType' => 'inputDateTime',
                        'eval' => 'datetime,int',
                    ],
                ],
                'terms_date_of_acceptance' => [
                    'config' => [
                        'renderType' => 'inputDateTime',
                        'eval' => 'datetime,int',
                    ],
                ],
                'status' => [
                    'config' => [
                        'items' => [
                            [
                                $languageFile . 'status.0',
                                FrontendUser::STATUS_NONE,
                            ],
                            [
                                $languageFile . 'status.1',
                                FrontendUser::STATUS_STUDENT,
                            ],
                            [
                                $languageFile . 'status.2',
                                FrontendUser::STATUS_JOB_SEEKING_FULL_TIME,
                            ],
                            [
                                $languageFile . 'status.3',
                                FrontendUser::STATUS_WORKING,
                            ],
                            [
                                $languageFile . 'status.4',
                                FrontendUser::STATUS_RETIRED,
                            ],
                            [
                                $languageFile . 'status.5',
                                FrontendUser::STATUS_JOB_SEEKING_PART_TIME,
                            ],
                        ],
                    ],
                ],
            ],
        );
    }

    ExtensionManagementUtility::addTCAcolumns('fe_users', $temporaryColumns);
    ExtensionManagementUtility::addToAllTCAtypes(
        'fe_users',
        'full_salutation, gender',
        '',
        'before:name',
    );
    ExtensionManagementUtility::addToAllTCAtypes(
        'fe_users',
        'date_of_birth, status',
        '',
        'after:name',
    );
    ExtensionManagementUtility::addToAllTCAtypes(
        'fe_users',
        'zone',
        '',
        'after:city',
    );
    ExtensionManagementUtility::addToAllTCAtypes(
        'fe_users',
        'department, vat_in, membership_number',
        '',
        'after:company',
    );
    ExtensionManagementUtility::addToAllTCAtypes(
        'fe_users',
        'privacy, privacy_date_of_acceptance, terms_acknowledged, terms_date_of_acceptance, comments',
    );
});
