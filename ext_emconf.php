<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'AB Test Pages',
    'description' => 'This extension supports TYPO3 administrators in performing A/B tests. This is useful when a site owner want to measure whether a new version improves or reduces user interaction compared to the current version.',
    'category' => 'misc',
    'author' => 'IllusionFACTORY',
    'author_email' => 'info@illusion-factory.de',
    'state' => 'alpha',
    'internal' => '',
    'uploadfolder' => '0',
    'createDirs' => '',
    'clearCacheOnLoad' => 1,
    'version' => '1.0.2',
    'constraints' => [
        'depends' => [
            'typo3' => '7.6.0-8.7.99',
            'realurl' => '2.0.0-0.0.0'
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
    'comment' => '',
    'user' => 'timof'
];
