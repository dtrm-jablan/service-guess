<?php

return [
    /*------------------------------------------------------------------------------*/
    /* App Info
    /*------------------------------------------------------------------------------*/
    'display-name'      => 'Global Unified ElasticSearch Service',
    'display-version'   => 'v1.0.x-dev',
    'display-copyright' => '(c) ' . date('Y') . ' Determine, Inc. All Rights Reserved',
    'display-brand'     => 'GUESS',
    /*------------------------------------------------------------------------------*/
    /* ES Instance Info
    /*------------------------------------------------------------------------------*/
    'elastic'           => [
        'hosts' => [
            'http://localhost:9200',
        ],
    ],
];
