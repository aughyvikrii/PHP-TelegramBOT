<?php if( !defined("BOT_START") ) die("Direct access is not allowed.");

$route = [

    //  
    "text"      => "HandlerClass@text",
    "photo"     => "HandlerClass@photo",
    "animation" => "HandlerClass@animation",
    "document"  => "HandlerClass@document",
    "voice"     => "HandlerClass@voice",
    "sticker"   => "HandlerClass@sticker",

    // Jika data yang di post berasal dari command
    "command"   => [
        "start"     => "Command@start",
        "button"  => "Command@generate_button"
    ],

    // Jika data yang di post berasal dari button
    "button"    => [
        "tombol.*"          => "Button@index",
        "button.b.*"        => "Button@button_b"
    ]
];