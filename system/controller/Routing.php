<?php if( !defined("BOT_START") ) die("Direct access is not allowed.");

/**
 * System Class Route
 */

 class Routing extends TelegramBOT {

    /**
     * Final exec route
     */
    private $exec_route;

    public function __construct() {
        parent::__construct();
    }

    public function run() {
        
        ## Validasi Route
        $this->routing();

        ## eksekusi class berdasarkan route
        $this->exec();
    }

    private function routing() {

        $route_set  = '';
        $dataType   = $this->dataType();
        $routeList  = $this->route[$dataType];

        /** 
         * If Type data is [ "photo", "animation", "document", "voice", "stricker" ]
         */
        if( in_array($dataType,["photo","animation","document","voice","sticker"]) ) {
            $route_set = @$routeList;
        }
        
        /**
         * If type data is text
         */

        else if( $dataType == 'text' ){
            $text       = @$this->data("message")["text"];
            $route_set  = @$routeList[$text];

            if( !$route_set ) {
                $split = explode(" ", $text);
                $query = $split[0];

                $search = preg_grep("/{$query} /", array_keys($routeList));
                
                $found = false;
                if( !empty($search) ) foreach($search as $key) {

                    $x = explode(" ",$key);
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
                else { $found = "*"; }
            }

            $route_set = @$routeList[$found];
        }
        
        /**
         * If type data is button
         */
        else if( $dataType == 'button' ) {
            $text       = @$this->data("callback_query")["data"];
            $route_set  = @$routeList[$text];

            if( empty($route_set) && preg_match("/./",$text)==true ) {
                $split = explode(".", $text);
                $query = $split[0];

                $search = preg_grep("/{$query}./", array_keys($routeList));
                
                $found = false;
                if( !empty($search) )foreach($search as $key) {

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
                } else { $found = "*"; }
            }

            $route_set = @$routeList[$found];
        }
        
        /**
         * If type data is command
         */
        else if ( $dataType == 'command' ) {
            $text       = @$this->data("message")["text"];

            // pisahkan antara /command dengan text lainnya
            $text = explode(" ",$text);

            // remove / from text
            $text = ltrim($text[0], "/");

            $route_set = @$routeList[ strtolower($text) ];
            if( !$route_set ) $route_set = @$routeList['*'];

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

        if( !file_exists(BASE_PATH."/controller/{$file}.php") ) {
            die("Class {$file} doesn't exists");
        }

        require_once BASE_PATH."/controller/{$file}.php";

        $class = new $file;

        if( !method_exists($class,$func) ) {
            die("Function {$func} doesn't exists in {$file}");
        }

        $class->$func();
    }
 }