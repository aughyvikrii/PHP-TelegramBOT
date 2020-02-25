<?php if( !defined("BOT_START") ) die("Direct access is not allowed.");

/**
 * Command class
 */

 class Command extends TelegramBOT {

    public function start() {
        $view = $this->view("start");
        $this->response($view);
    }
 }