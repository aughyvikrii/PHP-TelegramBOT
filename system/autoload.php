<?php if( !defined("BOT_START") ) die("Direct access is not allowed.");


## Load Route config
require_once BASE_PATH."/app/route.php";

## Load Main config
require_once BASE_PATH."/app/config.php";

## Load Function
require_once BASE_PATH."/system/lib/function.php";

## Load Class TelegramBOT
require_once BASE_PATH."/system/controller/TelegramBOT.php";

## Load Class Routing
require_once BASE_PATH."/system/controller/Routing.php";

define("DEBUG", @$config['debug'] );

define("BOT_TOKEN", @$config['bot_token']);

define('API_URL', 'https://api.telegram.org/bot'.BOT_TOKEN.'/');

## Load Custom Function
require_once BASE_PATH."/lib/function.php";

## Load Main_Controller
require_once BASE_PATH."/controller/Main_Controller.php";