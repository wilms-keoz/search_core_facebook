<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Search Core: Facebook',
    'description' => 'Search core implementation for Facebook.',
    'category' => 'be',
    'clearCacheOnLoad' => 1,
    'constraints' => [
        'depends' => [
            'typo3' => '7.6.0-8.7.99',
            'php' => '7.0.0-7.2.99',
            'search_core' => '',
        ],
        'conflicts' => [],
    ],
    'autoload' => [
        'psr-4' => [
            'Codappix\\SearchCoreFacebook\\' => 'Classes',
        ],
    ],
    'state' => 'beta',
    'version' => '0.0.1',
    'author' => 'Daniel Siepmann',
    'author_email' => 'coding@daniel-siepmann.de',
];
