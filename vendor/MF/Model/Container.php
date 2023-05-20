<?php

namespace MF\Model;

use App\Connection;

class Container
{
    public static function getModel($model)
    {
        $class = "\\App\\Models\\" . ucfirst($model);

        // instância de conexão
        $conn = Connection::getDb();

        // instância de modelo
        return new $class($conn);
    }
}