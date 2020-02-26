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
        "start" => "Command@start"
    ],

    // Jika data yang di post berasal dari button
    "button"    => []
];