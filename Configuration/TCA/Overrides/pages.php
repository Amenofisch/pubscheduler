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

ExtensionManagementUtility::addTCAcolumns('pages',
  [
    'pubscheduler_publication_type' => [
      'exclude' => 0,
      'label' => TcaTranslationUtil::buildLanguageString('pubscheduler.publication.type'),
      'config' => [
        'type' => 'select',
        'renderType' => 'selectSingle',
        'items' => $publicationTypes,
        'size' => 1,
        'maxitems' => 1,
        "default" => iPublicationTypes::DEFAULT,
      ],
    ],
  ]
);

ExtensionManagementUtility::addFieldsToPalette(
  'pages',
  'access',
  'pubscheduler_publication_type',
  'before:editlock'
);