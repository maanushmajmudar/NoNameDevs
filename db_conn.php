
<?php

class dbConnect
{
    protected $hostname;
    protected $userName;
    protected $password;
    protected $dataBaseName;

    function __construct()
    {
        $this->hostname = "localhost";
        $this->userName = "root";
        $this->password = "";
        $this->dataBaseName = "laptops";
    }

    function dbConnect()
    {
        $connection = new PDO("mysql:host=$this->hostname", $this->userName, $this->password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "CREATE DATABASE IF NOT EXISTS laptops";
        $connection->exec($sql);
        $sql = "use " . $this->dataBaseName;
        $connection->exec($sql);
        return $connection;
    }
}

?>