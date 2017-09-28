<?php
namespace io\db;

class DbConnector{
    public $mysql;
    public $username;
    public $password;
    public $pdo;

    public function connect(){
        $this->pdo = new \PDO('mysql:host='.$this->mysql['host'].';dbname=' . $this->mysql['dbname'], $this->username, $this->password);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }
}
?>
