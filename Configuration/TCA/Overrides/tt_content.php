<?php declare(strict_types=1);

use Amenofisch\Pubscheduler\Constants\iPublicationTypes;
use Amenofisch\Pubscheduler\Utils\TcaTranslationUtil;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die();

$publicationTypes = [
  [TcaTranslationUtil::buildLanguageString('pubscheduler.publication.type.default'), iPublicationTypes::DEFAULT],
  [TcaTranslationUtil::buildLanguageString('pubscheduler.publication.type.daily'), iPublicationTypes::DAILY],
  [TcaTranslationUtil::buildLanguageString('pubscheduler.publication.type.weekly'), iPublicationTypes::WEEKLY],
  [TcaTranslationUtil::buildLanguageString('pubscheduler.publication.type.monthly'), iPublicationTypes::MONTHLY],
  [TcaTranslationUtil::buildLanguageString('pubscheduler.publication.type.yearly'), iPublicationTypes::YEARLY],
];

ExtensionManagementUtility::addTCAcolumns('tt_content',
  [
    'pubscheduler_publication_type' => [
      'exclude' => 0,
      'label' => TcaTranslationUtil::buildLanguageString('pubscheduler.publication.type'),
      'config' => [
        'type' => 'select',
        'renderType' => 'selectSingle',
        'items' => $publicationTypes,
        'size' => 1,
        'maxitems' => 1
      ],
    ],
  ]
);

ExtensionManagementUtility::addFieldsToPalette(
  'tt_content',
  'access',
  'pubscheduler_publication_type',
  'before:editlock'
);