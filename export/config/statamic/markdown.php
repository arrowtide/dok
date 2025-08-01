<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Markdown Parser Configurations
    |--------------------------------------------------------------------------
    |
    | Here you may define the configuration arrays for each markdown parser.
    | You may use the base CommonMark options as well as any extensions'
    | options here. The available options are in the CommonMark docs.
    |
    | https://statamic.dev/extending/markdown#configuration
    |
    */

    'configs' => [

        'default' => [
            'heading_permalink' => [
                'symbol' => '#',
                'min_heading_level' => 2,
                'max_heading_level' => 4,
                'fragment_prefix' => '',
                'id_prefix' => '',
                'aria_hidden' => false,
            ],
            'table_of_contents' => [
                'position' => 'placeholder',
                'placeholder' => '[TOC]',
                'html_class' => 'table-of-contents not-prose',
                'min_heading_level' => 2,
                'max_heading_level' => 4,
            ],
        ],

    ],

];
