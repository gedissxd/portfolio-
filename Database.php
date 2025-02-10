<?php

class Database
{
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli(
            'localhost',
            'u161806173_gediminas',
            'iBfaWW56',
            'u161806173_komentarai'
        );

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }
}