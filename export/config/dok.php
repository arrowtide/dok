<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Code Highlighting Enabled
    |--------------------------------------------------------------------------
    |
    | You may enable code highlighting for code blocks here. It's recommended
    | to do this inside your .env so you switch depending on your environment.
    |
    */
    'code_highlighting_enabled' => env('CODE_HIGHLIGHTER_ENABLED', false),

    /*
    |--------------------------------------------------------------------------
    | Code Highlighter
    |--------------------------------------------------------------------------
    |
    | The code highlighter to use for code blocks. This is used in the
    | AppServiceProvider to register the required extensions. You may
    | replace this with your own highlighter if you'd like.

    | If you'd like to change the highlighter to another supported by Dok,
    | you will need to install the required packages manually. Please
    | see the documentation for more information.
    |
    | Dok comes with two at installation: `torchlight-engine`, `shiki`.
    |
    */
    'code_highlighter' => 'PLACEHOLDER_CONFIG_CODE_HIGHLIGHTER',
];
