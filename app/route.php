<?php if( !defined("BOT_START") ) die("Direct access is not allowed.");

$route = [
    // Route By Feature Telegram
    "photo"     => "Controller@photo",
    "animation" => "Controller@animation",
    "document"  => "Controller@document",
    "voice"     => "Controller@voice",
    "sticker"   => "Controller@sticker",

    /**
     * Text Route
     * Delimiter use ' ' (space)
     * ex: "price *"    => "Controller@price"
     * so when text is "price book", it will use "Controller@price"
     */
    "text"      => [
        "*" => "Controller@text",
    ],

    // Route Command
    "command"   => [
        "start"     => "Controller@command_start",
        "button"    => "Controller@command_button",
        "*"         => "Controller@not_set"
    ],

    /**
     * Button Route
     * Delimiter use '.' (space)
     * ex: "deposit.*"    => "Controller@deposit"
     * so when text is "deposit.fund", it will use "Controller@deposit"
     */
    "button"    => [
        "lorem"          => "Controller@button_lorem",
        "lorem.*"        => "Controller@button_handler_lorem"
    ]
];