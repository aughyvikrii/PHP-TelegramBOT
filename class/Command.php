<?php if( !defined("BOT_START") ) die("Direct access is not allowed.");

/**
 * Command class
 */

 class Command extends TelegramBOT {

    public function start() {
        $view = $this->view("start");
        $this->response($view);
    }

    public function generate_button() {

        $keyboard = array(
            "inline_keyboard" => array(
                array(
                    array(
                        "text" => "Tombol A",
                        "callback_data" => "tombol.a"
                    ),
                    array(
                        "text" => "Tombol B",
                        "callback_data" => "tombol.b"
                    )
                )
            )
        );

        $this->response("Percobaan",$keyboard);
    }
 }