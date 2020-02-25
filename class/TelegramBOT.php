<?php if( !defined("BOT_START") ) die("Direct access is not allowed.");

/**
 * Mainclass TelegramBOT
 */

 class TelegramBOT {

    /**
     * Config variable, all config should be here
     */

    public $config;

    /**
     * All Route from route file
     */

    public $route;

    /**
     * Data from telegram
     */

    public $data;

    /**
     * Final exec route
     */
    private $exec_route;


    /**
     * Assign Data
     */
    public $assign = array();

    public function __construct() {

        GLOBAL $route,$config;
        
        $this->config   = $config;
        $this->route    = $route;

        ## Ambil data yang di post
        $this->get_data();
    }

    public function run() {
        
        ## Validasi Route
        $this->routing();

        ## eksekusi class berdasarkan route
        $this->exec();
    }

    public function config($key=false){
        if( !$key ) return $this->config;
        return isset($this->config[$key]) ? $this->config[$key] : false;
    }

    public function data($key=false){
        if( !$key ) return $this->data;
        return isset($this->data[$key]) ? $this->data[$key] : false;
    }

    public function dataType(){

        $message    = $this->data('message');
        $type       = @$message['entities'][0]['type']; 
        
        switch($type) {

            case "":
                return "text";
                break;

            case "bot_command":
                return "command";
                break;

            case "bot_button":
                return "button";
                break;

            default:
                return 'text'; // return error
        }
    }

    private function get_data() {
        $data = file_get_contents('php://input');
        
        $this->data = isset($data) ? json_decode($data,true) : array();
    }

    private function routing() {

        $route_set  = '';
        $dataType   = $this->dataType();
        $routeList  = $this->route[$dataType];
        $text       = $this->data("message")["text"];

        if( $dataType == 'text' ) {
            $route_set = @$routeList;
        } else if ( $dataType == 'command' ) {

            $text = explode(" ",$text); // pisahkan antara /command dengan text lainnya
            $text = ltrim($text[0], "/"); // remove / from text

            $route_set = @$routeList[ strtolower($text) ];
        } else if( $dataType == 'button' ) {
            die("Route button belum di set");
        } else {
            die("ERROR~");
        }

        if( !$route_set ) {
            if( DEBUG ) $this->response("Route belum di set");
            die("ERROR~");
        }

        $this->exec_route = $route_set;
    }

    private function exec() {
        $split = explode("@",$this->exec_route);
        
        $file = $split[0];
        $func = $split[1];

        if( !file_exists(BASE_PATH."/class/{$file}.php") ) {
            die("Class {$file} doesn't exists");
        }

        require_once BASE_PATH."/class/{$file}.php";

        $class = new $file;

        if( !method_exists($class,$func) ) {
            die("Function {$func} doesn't exists in {$file}");
        }

        $class->$func();
    }
    
    public function assign($key,$value=false){

        if( is_array($key) ) {
            $merge = array_merge($this->assign,$key);
        } else if( is_array($key)==false  && $value ) {
            $merge = array_merge($this->assign,array(
                $key    => $value
            ));
        } else return;

        $this->assign = $merge;
    }

    public function view($file) {

        $path = BASE_PATH."/views/{$file}.php";

        if( !file_exists($path) ){
            die("File {$file} doesn't exists.");
        }

        if( empty($this->assign) ) $this->assign = array();

        extract($this->assign);
        ob_start();
        include_once $path;
        return ob_get_clean();
    }

    public function response($text,$chat_id=false,$keyboard=array()) {
        
        if( !$chat_id ) $chat_id = @$this->data['message']['chat']['id'];

        if ( !$chat_id ) {
            die("Chat ID not define~");
        } else if( !empty($keyboard) ) {
            withKeyboard($chat_id,$text,$keyboard);
        } else {
            sendResponse($chat_id,$text);
        }

    }
 }