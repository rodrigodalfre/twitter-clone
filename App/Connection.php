<?php

namespace App;

class Conexao {

    private $host = 'localhost';
    private $dbname = "mvc";
    private $user = 'root';
    private $pass = '';

    //Metodos static não é necessário criar uma classe, basta usar a referencia. Connection::getDb()
    public static function getDb() {
        try {
            $conexao = new PDO(
                "mysql:host=$this->host;dbname=$this->dbname",
                "$this->user",
                "$this->pass"
            );   
        
            return $conexao;
        } catch (\PDOException $e) {
            echo $e->getMessege();
        }
    }

}

?>