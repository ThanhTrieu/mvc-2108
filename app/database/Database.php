<?php

namespace app\database;

use PDO;
use PDOException;

// class connection PDO MySQL
class Database
{
    protected $db;

    public function __construct()
    {
        $this->db = $this->connection();
    }

    protected function connection()
    {
        try {
            $dbh = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8', DB_USER, DB_PASSWORD);
            return $dbh;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    protected function disconnection()
    {
        $this->db = null;
    }

    public function __destruct()
    {
        $this->disconnection();
    }
}