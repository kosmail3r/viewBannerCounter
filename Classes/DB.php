<?php

namespace Classes;

class DB
{
    private $connection;
    private static $_instance;
    private $opt = [
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        \PDO::ATTR_EMULATE_PREPARES => false,
    ];
    //vars need to be changed fit your db-server
    private $host = "localhost";
    private $username = "roottest";
    private $password = "rootroot";
    private $database = "test_task";

    private function __construct()
    {
        $dsn = "mysql:host=$this->host;dbname=$this->database;";
        $pdo = new \PDO($dsn, $this->username, $this->password);
        $pdo->setAttribute($this->opt);
        $this->connection = $pdo;
    }

    private function __clone()
    {
    }

    /**
     * Create or return DB instance
     * @return DB
     */
    public static function getInstance()
    {
        if (!self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * @param $sqlString
     * Method try to process any query string
     * @return \PDOStatement
     */
    public function query($sqlString)
    {
        static::getInstance();
        $query = $this->connection->query($sqlString);
        return $query;
    }

    /**
     * @param $sqlString
     * Method return array with row data, if entery exist
     * @return \PDOStatement
     */
    public function getRowIfExist($sqlString)
    {
        static::getInstance();
        $result = $this->connection->query($sqlString);
        foreach ($result as $row) {
            $result = $row;
        }
        return $result;
    }
}