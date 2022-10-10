<?php

require_once __DIR__ . '/Tabela.php';

class Grupa extends Tabela {
    public $id;

    public static function sveGrupe() {
        $db = Database::getInstance();

        $query = 'SELECT * FROM grupe_zadataka ' . 'ORDER BY id ASC';

        $params = [];

        return $db->select('Grupa', $query);
    }

    public static function izmeniGrupu($id, $grupa) {
        $db = Database::getInstance();

        $query = 'UPDATE grupe_zadataka ' . 'SET grupa = :g ' . 'WHERE id = :id';

        $params = [
            ':g' => $grupa,
            'id' => $id
        ];

        $db->update('Grupa', $query, $params);
    }

    public static function obrisiGrupu($id) {
        $db = Database::getInstance();

        $query = 'DELETE FROM grupe_zadataka WHERE id = :id';

        $params = [
            ':id' => $id
        ];

        $db->delete($query, $params);
    }
}