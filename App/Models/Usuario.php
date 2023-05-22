<?php

namespace App\Models;

use MF\Model\Model;

class Usuario extends Model
{
    private $id;
    private $nome;
    private $email;
    private $senha;

    public function __get($attr)
    {
        return $this->$attr;
    }

    public function __set($attr, $value)
    {
        $this->$attr = $value;
    }

    public function insereUsuario()
    {
        $query = "
            INSERT INTO 
                usuarios (
                    nome,
                    email,
                    senha
                )
            VALUES (
                ?,
                ?,
                ?
            )
        ";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(1, $this->__get('nome'));
        $stmt->bindValue(2, $this->__get('email'));
        $stmt->bindValue(3, $this->__get('senha'));
        $stmt->execute();

        return $this;
    }

    public function validarCadastro()
    {
        if (strlen($this->__get('nome')) < 3 || strlen($this->__get('email')) < 3 || strlen($this->__get('senha')) < 3) {
            $valido = false;
        } else {
            $valido = true;
        }
        return $valido;
    }

    public function getUsuaruioPorEmail()
    {
        $query = "
            SELECT 
                email
            FROM
                usuarios
            WHERE
                email = ?
        ";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(1, $this->__get('email'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function validaLogin()
    {
        $query = "
            SELECT
                id,
                nome,
                email
            FROM
                usuarios
            WHERE
                email = ?
            AND
                senha = ?
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(1, $this->__get('email'));
        $stmt->bindValue(2, $this->__get('senha'));
        $stmt->execute();

        $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!empty($usuario['id']) && !empty($usuario['nome'])) {
            $this->__set('id', $usuario['id']);
            $this->__set('nome', $usuario['nome']);
        }
    }

    public function getAll()
    {
        $query = "
            SELECT 
                id,
                nome,
                email
            FROM
                usuarios
            WHERE
                nome LIKE ?
        ";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(1, '%' . $this->__get('nome') . '%');
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
