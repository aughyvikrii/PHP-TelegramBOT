<?php

/**
 * PHP-TelegramBOT
 * 
 * Version      : V.1.0
 * Dev By       : aughyvikrii < aughyvikrii@gmail.com >
 * status       : BETA
 * last update  : 2020-02-26 09:22 PM
 */

header("Content-Type: application/json");

## time bot start
define("BOT_START",microtime(true));

define("BASE_PATH",__DIR__);

## Autoload system
require_once BASE_PATH."/system/autoload.php";

## Defines the Routing class
$routing = new Routing;

## run the function
$routing->run();
