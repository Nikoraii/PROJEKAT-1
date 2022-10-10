<?php

require_once __DIR__ . '/Tabela.php';
require_once __DIR__ . '/Korisnik.php';
require_once __DIR__ . '/Zadatak.php';

class Zaduzen extends Tabela {
    public $id;
    public $korisnik_id;

    public function getKorisnik() {
        return Korisnik::getById($this->korisnik_id, 'korisnici', 'Korisnik');
    }

    public function getZadatak() {
        return Zadatak::getById($this->zadatak_id, 'zadaci', 'Zadatak');
    }

    public static function getZaduzeni($korisnik_id) {
        $db = Database::getInstance();

        $query = 'SELECT * FROM zaduzeni ' . 'WHERE izvrsilac_id = :iid';

        $params = [
            ':iid' => $korisnik_id
        ];

        return $db->select('Zaduzen', $query, $params);
    }

}
