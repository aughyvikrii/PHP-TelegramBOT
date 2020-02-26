<?php if( !defined("BOT_START") ) die("Direct access is not allowed.");

/**
 * Button class
 */

 class Button extends TelegramBOT {

    public function tombol(){

        $button = $this->segment(0);

        if( $button == 'a' ) {
            $text = "You press the {$button} button";

            $this->response($text);
        } else {
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
    
            $this->response("Button Type B:",$keyboard);
        }
    }
 }