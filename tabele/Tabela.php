<?php

// namespace Tabele;

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/Database.php';

class Tabela
{
    public static function getById($id, $table, $ime_klase)
    {
        $db = Database::getInstance();

        $query = "SELECT * FROM $table WHERE id = :id";

        $params = [
            ':id' => $id
        ];

        $zapisi = $db->select($ime_klase, $query, $params);
        foreach ($zapisi as $zapis) {
            return $zapis;
        }
        return null;
    }
}
