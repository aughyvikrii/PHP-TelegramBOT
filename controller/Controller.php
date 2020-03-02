<?php if( !defined("BOT_START") ) die("Direct access is not allowed."); // This is important

/**
 * Example Controller
 */

class Controller extends Main_Controller {


    public function text() {
        $text = "Handler text isn't set yet";

        $this->response($text);
    }

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


    public function command_start() {
        $view = $this->view("start");

        $this->response($view);
    }

    public function command_button() {
        $keyboard = array(
            "inline_keyboard" => array(
                array(
                    array(
                        "text" => "Button B Type 1",
                        "callback_data" => "button.b.1"
                    ),
                    array(
                        "text" => "Button B Type 2",
                        "callback_data" => "button.b.2"
                    )
                )
            )
        );
    }
}