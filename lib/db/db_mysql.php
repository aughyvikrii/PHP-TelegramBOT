<?php if( !defined("BOT_START") ) die("Direct access is not allowed.");


class db_mysql {

    public $host;

    public $user;

    public $pass;

    public $database;

    public $config;

    function __construct($config) {

        $this->config   = $config;
        $this->host     = $config['host'];
        $this->user     = $config['user'];
        $this->pass     = $config['pass'];
        $this->db       = $config['db'];
        return $this->connect();
    }

    public function connect() {

        $db = new mysqli(
            $this->host,
            $this->user,
            $this->pass,
            $this->db
        );

        if( @$db->connect_errno ) {
            $error = $db->connect_error;

            die("~ERROR DB: {$error}");
        }

        return $db;
    }
}