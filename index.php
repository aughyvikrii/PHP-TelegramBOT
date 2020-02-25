<?php

/**
 * PHP-TelegramBOT
 * 
 * Version      : V.1.0
 * Dev By       : aughyvikrii < aughyvikrii@gmail.com >
 * status       : BETA
 * last update  : 2020-02-25 11:18 PM
 */

header("Content-Type: application/json");

## time bot start
define("BOT_START",microtime(true));

define("BASE_PATH",__DIR__);

define("DEBUG",true);

define("BOT_TOKEN","");

define('API_URL', 'https://api.telegram.org/bot'.BOT_TOKEN.'/');

## Load Route config
require_once BASE_PATH."/app/route.php";

## Load Main config
require_once BASE_PATH."/app/config.php";

## Load function
require_once BASE_PATH."/lib/function.php";

## Load TelegramBOT class
require_once BASE_PATH."/class/TelegramBOT.php";

if( !DEBUG ) error_reporting(0);

## use Class TelegramBOT
$bot = new TelegramBOT;

## Run TelegramBOT
$bot->run();