<?php
define('DRIVE','mysql');
define('HOST','localhost');
define('DBNAME','Bank');
define('USER','root');
define('PASSWORD','');

class Database{

    public function connection(){
        $dsn = DRIVE.":host=".HOST.";dbname=".DBNAME;
        $conn = new PDO($dsn,USER,PASSWORD);
        return $conn;
    }
    
}


?>