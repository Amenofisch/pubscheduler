<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'pubscheduler',
    'description' => 'This plugin allows rescheduling the visibility of content elements and pages in Typo3.',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.0-12.4.99',
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'Amenofisch\\Pubscheduler\\' => 'Classes/',
        ],
    ],
];
