<?php

class Database
{
    public $connection;

    public function __construct($host, $username, $password, $database, $port = 3306)
    {
        $this->connection = mysqli_connect($host, $username, $password, $database, $port);
        if (!$this->connection) {
            die("Error de conexión: " . mysqli_connect_error());
        }
    }

    public function query($sql)
    {
        $result = mysqli_query($this->connection, $sql);
        if (!$result) {
            die("Error en la consulta: " . mysqli_error($this->connection));
        }
        return $result;
    }

    public function fetch($result)
    {
        return mysqli_fetch_assoc($result);
    }

    public function close()
    {
        mysqli_close($this->connection);
    }
}
