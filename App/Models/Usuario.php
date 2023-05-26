<?php

namespace App\Models;

use MF\Model\Model;

class Usuario extends Model
{
    private $id;
    private $nome;
    private $email;
    private $senha;
    private $facebook;
    private $instagram;
    private $linkedin;
    private $tiktok;
    private $outrosLinks;

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
                u.id,
                u.nome,
                u.email,
                (
                    SELECT 
                        count(*)
                    FROM
                        usuarios_seguidores AS us 
                    WHERE 
                        us.id_usuario = :id_usuario
                    AND
                        us.id_usuario_seguindo = u.id
                ) AS bool_seguindo                    
            FROM
                usuarios as U
            WHERE
                u.nome LIKE :nome
            AND 
                u.id != :id_usuario
        ";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nome', '%' . $this->__get('nome') . '%');
        $stmt->bindValue(':id_usuario', $this->__get('id'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function seguirUsuario($id_usuario_seguindo)
    {
        $query = "
            INSERT INTO
                usuarios_seguidores (
                    id_usuario,
                    id_usuario_seguindo
                )
            VALUES (
                ?,
                ?
            )
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(1, $this->__get('id'));
        $stmt->bindValue(2, $id_usuario_seguindo);
        $stmt->execute();
    }

    public function deixarSeguirUsuario($id_usuario_seguindo)
    {
        $query = "
            DELETE FROM
                usuarios_seguidores
            WHERE
                id_usuario = ?
            AND
                id_usuario_seguindo = ?
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(1, $this->__get('id'));
        $stmt->bindValue(2, $id_usuario_seguindo);
        $stmt->execute();
    }

    public function getInfoUsuario()
    {
        $query = "
            SELECT
                nome,
                biografia,
                facebook,
                instagram,
                linkedin,
                tiktok,
                outros_links
            FROM
                usuarios
            WHERE
                id = ?
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(1, $this->__get('id'));
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getTotalTweets()
    {
        $query = "
            SELECT
                count(*) AS total_tweet
            FROM
                tweets
            WHERE
                id_usuario = ?
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(1, $this->__get('id'));
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getTotalSeguindo()
    {
        $query = "
            SELECT
                count(*) AS total_seguindo
            FROM
                usuarios_seguidores
            WHERE
                id_usuario = ?
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(1, $this->__get('id'));
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getTotalSeguidores()
    {
        $query = "
            SELECT
                count(*) AS total_seguidores
            FROM
                usuarios_seguidores
            WHERE
                id_usuario_seguindo = ?
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(1, $this->__get('id'));
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getSeguidores()
    {
        $query = "
            SELECT 
                u.id,
                u.nome,
                us.id_usuario_seguindo,
                u2.nome AS seguidor,
                u2.biografia AS biografia 
            FROM
                usuarios u 
            LEFT JOIN
                usuarios_seguidores us 
            ON	
                (u.id = us.id_usuario)
            INNER JOIN 
                usuarios u2 
            ON
                (us.id_usuario_seguindo = u2.id)
            WHERE 
                u.id = ?
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(1, $this->__get('id'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


    public function salvarBiografia()
    {
        $query = "
            UPDATE 
                usuarios 
            SET 
                biografia = ?
            WHERE 
                id = ?
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(1, $this->__get('biografia'));
        $stmt->bindValue(2, $this->__get('id'));
        $stmt->execute();
    }

    public function salvarRedesSociais()
    {
        $query = "
            UPDATE
                usuarios
            SET
                facebook = ?,
                instagram = ?,
                linkedin = ?,
                tiktok = ?,
                outros_links = ?
            WHERE
                id = ?
        ";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(1, $this->__get('facebook'));
        $stmt->bindValue(2, $this->__get('instagram'));
        $stmt->bindValue(3, $this->__get('linkedin'));
        $stmt->bindValue(4, $this->__get('tiktok'));
        $stmt->bindValue(5, $this->__get('outrosLinks'));
        $stmt->bindValue(6, $this->__get('id'));
        $stmt->execute();
    }

    public function pesquisaSeguidores()
    {
        $query = "
            SELECT 
                u.id,
                u.nome,
                us.id_usuario_seguindo,
                u2.nome AS seguidor,
                u2.biografia AS biografia 
            FROM
                usuarios u 
            LEFT JOIN
                usuarios_seguidores us 
            ON	
                (u.id = us.id_usuario)
            INNER JOIN 
                usuarios u2 
            ON
                (us.id_usuario_seguindo = u2.id)
            WHERE 
                u.id = ?
            AND 	
                u2.nome LIKE ?
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(1, $this->__get('id'));
        $stmt->bindValue(2, '%' . $this->__get('nome') . '%');
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
