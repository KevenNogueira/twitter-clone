<?php

namespace App\Models;

use MF\Model\Model;

class Tweet extends Model
{
    private $id;
    private $id_usuario;
    private $tweet;
    private $data_insercao;

    public function __get($attr)
    {
        return $this->$attr;
    }

    public function __set($attr, $value)
    {
        $this->$attr = $value;
    }

    public function salvar()
    {
        $query = "
            INSERT INTO
                tweets (
                    id_usuario,
                    tweet
                )
            VALUES (
                ?,
                ?
            )                
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(1, $this->__get('id_usuario'));
        $stmt->bindValue(2, $this->__get('tweet'));
        $stmt->execute();
    }

    public function getAll()
    {
        $query = "
            SELECT 
                t.id,
                t.id_usuario,
                u.nome,
                t.tweet,
                DATE_FORMAT(t.data_insercao, '%d/%m/%Y %H:%i') as data
            FROM 
                tweets as t
            LEFT JOIN
                usuarios as u
            ON 
                (t.id_usuario = u.id)
            WHERE
                t.id_usuario = ?
            ORDER BY
                data DESC
            
            
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(1, $this->__get('id_usuario'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
