<?php

require_once __DIR__ . '/Tabela.php';
// require_once __DIR__ . '/Korisnik.php';

class Komentar extends Tabela {
    public $id;
    public $komentar_id;

    // public function getKorisnik() {
    //     return Korisnik::getById($this->korisnik_id, 'korisnici', 'Korisnik');
    // }

    public function getKomentar() {
        return Komentar::getById($this->id, 'komentari', 'Komentar');
    }

    public function sviKomentari() {
        $db = Database::getInstance();

        $query = 'SELECT * from komentari';

        $params = [];

        $komentari = $db->select('Komentar', $query);
        return $komentari;
    }

    public static function upisiKomentar($naslov, $komentar, $korisnik_id, $zadatak_id) {
        $db = Database::getInstance();

        $query = 'INSERT INTO komentari (naslov, komentar, korisnik_id, zadatak_id) '
        . 'VALUES (:n, :k, :kid, :zid)';

        $params = [
            ':n' => $naslov,
            ':k' => $komentar,
            ':kid' => $korisnik_id,
            ':zid' => $zadatak_id
        ];

        $db->insert('Komentar', $query, $params);
    }

    public static function komentariZaZadatak($zadatak_id) {
        $db = Database::getInstance();

        $query = 'SELECT * FROM komentari ' . 'WHERE zadatak_id = :id';

        $params = [
            ':id' => $zadatak_id
        ];

        return $db->select('Komentar', $query, $params);
    }
}