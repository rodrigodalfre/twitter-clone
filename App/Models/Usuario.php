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

    //GET ALL
    //Sub-consulta utilizando()
    public function getAll(){
        $query = "SELECT
            u.id, u.nome, u.email, 
            (   select count(*)
                from usuarios_seguidores as us
                where us.id_usuario = :id_usuario and us.id_usuario_seguindo = u.id
            ) as seguindo_sn
        FROM
            usuarios as u
        WHERE
            u.nome like :nome AND u.id != :id_usuario
        ";
        $stmt = $this->db->prepare($query);
        //O like espera o caractere coringa (%) para ter uma pesquisa mais ampla
        $stmt->bindValue(':nome', '%'.$this->__get('nome').'%');
        $stmt->bindValue(':id_usuario', $this->__get('id'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function follow($id){
        $query = "INSERT INTO usuarios_seguidores(id_usuario, id_usuario_seguindo) 
            VALUES(:id_usuario, :id_usuario_seguindo)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id'));
        $stmt->bindValue('id_usuario_seguindo', $id);
        $stmt->execute();

        return true;
    }

    public function unfollow($id){
        $query = "DELETE FROM usuarios_seguidores
        WHERE
            id_usuario = :id_usuario 
        AND 
            id_usuario_seguindo = :id_usuario_seguindo";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id'));
        $stmt->bindValue('id_usuario_seguindo', $id);
        $stmt->execute();
    }




}

?>