<?php

namespace Core;

use PDO;

class Database
{


    private $username = null;
    private $password = null;
    /**
     * @var string
     */
    private $dsn = null;
    private static $instance = null;
    private $errors;
    /**
     * @var PDO
     */
    public $database;

    private function __construct()
    {
        $this->username = Config::get('database.username');
        $this->password = Config::get('database.password');
        $this->dsn = "pgsql:host=" . Config::get('database.host') . ";dbname=" . Config::get('database.name') . ";port=" . Config::get('database.port');
        try {
            $this->database = new PDO($this->dsn, $this->username, $this->password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        } catch (\PDOException $exception) {
            $this->errors = $exception;
        }
    }


    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }









}