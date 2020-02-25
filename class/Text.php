<?php if( !defined("BOT_START") ) die("Direct access is not allowed.");

/**
 * Command class
 */

 class Text extends TelegramBOT {

    public function index() {
        
        $view = $this->view("start");

        return response($view);
    }
 }