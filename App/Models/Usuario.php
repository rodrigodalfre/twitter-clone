<?php 

namespace App\Models;

use MF\Model\Model;

class Usuario extends Model{

    private $id;
    private $nome;
    private $email;
    private $senha;

    //GET E SET
    public function __get($attr){
        return $this->$attr;
    }

    public function __set($attr, $value){
        $this->$attr = $value;
    }

    //registrar
    public function salvar(){
        $query = "INSERT INTO usuarios(nome, email, senha) VALUES (:nome, :email, :senha)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->bindValue(':senha', $this->__get('senha')); //md5 = (32)
        $stmt->execute();

        return $this;
    }

    //validar cadastro
    public function validarCadastro() {
        $valido = true; 

        if(strlen($this->__get('nome')) < 3){
            $valido = false;
        }
        if(strlen($this->__get('email')) < 3){
            $valido = false;
        }
        if(strlen($this->__get('senha')) < 3){
            $valido = false;
        }

        return $valido;
    }

    //comparar usuário
    public function getUsuarioEmail() {
        $query = "SELECT nome, email from usuarios where email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    //autenticar
    public function autenticar(){
        $query = "select id, nome, email from usuarios where email = :email and senha = :senha";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->bindValue(':senha', $this->__get('senha'));
        $stmt->execute();

        $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);

        if($usuario['id'] != '' && $usuario['nome'] != ''){
            $this->__set('id', $usuario['id']);
            $this->__set('nome', $usuario['nome']); 
        }

        return $this;

    }



}

?>