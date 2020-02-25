<?php if( !defined("BOT_START") ) die("Direct access is not allowed.");

$route = [

    // 
    "text"  => "Text@index",

    // Jika data yang di post berasal dari command
    "command"   => [
        "start" => "Command@start"
    ],

    // Jika data yang di post berasal dari button
    "button"    => []
];