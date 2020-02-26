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

        if( !$message && isset($this->data['callback_query']) ) {
            $type = 'bot_button';
        }

        if( $type == 'bot_command' ) return 'command';
        else if( $type == 'bot_button' ) return 'button';
        else if( isset($message['text']) ) return 'text';
        else if( isset($message['photo']) ) return 'photo';
        else if( isset($message['document']) && isset($message['animation']) ) return 'animation';
        else if( isset($message['document']) ) return 'document';
        else if( isset($message['voice']) ) return 'voice';
        else if( isset($message['sticker']) ) return 'sticker';
        else {
            if( DEBUG ) $this->response("~reply type not recognized");
            die("~ERROR");
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

        if( in_array($dataType,["text","photo","animation","document","voice","sticker"]) ) {
            $route_set = @$routeList;
        } else if ( $dataType == 'command' ) {
            $text       = @$this->data("message")["text"];

            // pisahkan antara /command dengan text lainnya
            $text = explode(" ",$text);

            // remove / from text
            $text = ltrim($text[0], "/");

            $route_set = @$routeList[ strtolower($text) ];
            
        } else if( $dataType == 'button' ) {
            $text       = @$this->data("callback_query")["data"];
            $route_set  = @$routeList[$text];

            if( empty($route_set) && preg_match("/./",$text)==true ) {
                $split = explode(".", $text);
                $query = $split[0];

                $search = preg_grep("/{$query}./", array_keys($routeList));
                
                $found = false;
                foreach($search as $key) {

                    $x = explode(".",$key);
                    if( count($x) == count($split) ){
                        foreach($x as $i => $v){
                            if( $v == $split[$i] || $v == '*' ) {
                                if( $i == ( count($x)-1 ) ) {
                                    $found = $key; break 2;
                                } else {
                                    continue;
                                }
                            }
                        }
                    }
                }
            }

            $route_set = @$routeList[$found];
        } else {
            if( DEBUG ) $this->response("~reply type not recognized");
            die("~ERROR");
        }

        if( !$route_set ) {
            if( DEBUG ) $this->response("~Route not set");
            die("~ERROR");
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
            if( DEBUG ) $this->response("~File {$file} doesn't exists.");
            die("~File {$file} doesn't exists.");
        }

        if( empty($this->assign) ) $this->assign = array();

        extract($this->assign);
        ob_start();
        include_once $path;
        return ob_get_clean();
    }

    public function response($text,$keyboard=array(),$chat_id=false) {
        
        if( !$chat_id ) $chat_id = @$this->data['message']['chat']['id'];

        if( !$chat_id ) $chat_id = @$this->data['callback_query']['message']['chat']['id'];

        if ( !$chat_id ) {
            // if( DEBUG ) $this->response("~Chat ID not define");
            die("~Chat ID not define");
        } else if( !empty($keyboard) ) {
            withKeyboard($chat_id,$text,$keyboard);
        } else {
            sendResponse($chat_id,$text);
        }

    }

    public function segment($index=null){
        $type = $this->dataType();

        if( $type == 'text' ){
            $split = explode(" ",$this->data['message']['text']);
            unset($split[0]);
        } else if ( $type == 'button' ) {
            $split = explode(".",$this->data['callback_query']['data']);
            unset($split[0]);    
        } else {
            return array();
        }

        $split = array_values($split);
        
        return ($index) === null ? $split : @$split[$index];
    }
 }