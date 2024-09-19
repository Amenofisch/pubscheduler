<?php

$EM_CONF[$_EXTKEY] = [
  'title' => 'pubscheduler',
  'description' => 'This plugin allows rescheduling the visibility of content elements and pages in Typo3.',
  'version' => '1.0.0',
  'category' => 'misc',
  'state' => 'stable',
  'author' => 'amenofisch',
  'author_email' => 'me@amenofisch.dev',
  'constraints' => [
    'depends' => [
      'typo3' => '12.4.0-12.4.99',
    ],
    'conflicts' => [],
    'suggests' => [],
  ],
  'autoload' => [
    'psr-4' => [
      'Amenofisch\\Pubscheduler\\' => 'Classes/',
    ],
  ],
];

