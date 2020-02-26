<?php if( !defined("BOT_START") ) die("Direct access is not allowed.");

/**
 * Command class
 */

 class HandlerClass extends TelegramBOT {

    public function document() {

        $text = "Handler document isn't set yet";

        $this->response($text);
    }

    public function photo() {
        $text = "Handler photo isn't set yet";

        $this->response($text);
    }

    public function voice() {
        $text = "Handler voice isn't set yet";

        $this->response($text);
    }

    public function sticker() {
        $text = "Handler sticker isn't set yet";

        $this->response($text);
    }

    public function animation() {
        $text = "Handler animation isn't set yet";

        $this->response($text);
    }
 }