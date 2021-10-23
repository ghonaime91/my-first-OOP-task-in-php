<?php

class DataBase {

    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $db_name = "oop";
    private $conn = null;


    public function __construct()
    {
        # code...
        $this->conn = mysqli_connect($this->host,$this->user,$this->pass,$this->db_name);
        if(!$this->conn)
        {
            echo mysqli_error_connect();
        } 
    }

    public function query($sql)
    {
        # code...
        $result = mysqli_query($this->conn,$sql);
        return $result;
    }

    public function __destruct()
    {
        # code...
        mysqli_close($this->conn);
    }
}
























?>