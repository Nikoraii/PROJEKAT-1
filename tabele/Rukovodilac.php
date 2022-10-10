<?php

require_once __DIR__ . '/Tabela.php';
require_once __DIR__ . '/Zadatak.php';
require_once __DIR__ . '/Zaduzen.php';

class Rukovodilac extends Tabela {
    public $id;
    public $zaduzen_id;

    public static function napraviGrupu($grupa) {
        $db = Database::getInstance();

        $query = 'INSERT INTO grupe_zadataka (grupa) ' . 'VALUES (:g)';

        $params = [
            ':g' => $grupa
        ];

        $db->insert('Rukovodilac', $query, $params);

        $id = $db->lastInsertId();
        $grupa = self::getById($id, 'grupe_zadataka', 'Rukovodilac');
        return $grupa;
    }

    // public function getRukovodilac() {
    //     return Korisnik::getById($this->korisnik_id, 'korisnici', 'Korisnik');
    // }
}
