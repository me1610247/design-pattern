<?php
class Database
{
    private static $instance = null;
    private $conn;

    private function __construct($host, $username, $password, $dbName)
    {
        $this->conn = new mysqli($host, $username, $password, $dbName);
        if ($this->conn->connect_error) {
            die("Connection Failed" . $this->conn->connect_error);
        }
    }

    public static function getInstance($host, $username, $password, $dbName)
    {
        if (self::$instance === null) {
            self::$instance = new self($host, $username, $password, $dbName);
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->conn;
    }

    public function close()
    {
        $this->conn->close();
    }
}
