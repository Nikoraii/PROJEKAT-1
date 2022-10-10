<?php

require_once __DIR__ . '/Tabela.php';
require_once __DIR__ . '/Korisnik.php';

class Zadatak extends Tabela {
    public $id;
    public $zadatak;
    public $rukovodilac_id;

    public static function getAll()
    {
        $db = Database::getInstance();

        $query = 'SELECT * FROM zadaci';

        return $db->select('Zadatak', $query);
    }

    public static function filtriraj($naslov = null, $datum_od = 0, $datum_do = 0, $prioritet = 0)
    {
        $db = Database::getInstance();

        $query = 'SELECT * FROM zadaci WHERE naslov = IFNULL(:n, naslov), prioritet = IFNULL(:p, prioritet), rok_izvrsenja = IFNULL(BETWEEN datum_od = :dod AND datum_do = :ddo, rok_izvrsenja)';

        $paramas = [
            ':n' => $naslov,
            ':p' => $prioritet,
            ':dod' => $datum_od,
            ':ddo' => $datum_do
        ];

        return $db->select('Zadatak', $query, $paramas);
    }

    public static function sviZaDatum($datum_od, $datum_do)
    {
        $db = Database::getInstance();

        $query = 'SELECT * FROM zadaci WHERE rok_izvrsenja BETWEEN :dod AND :ddo';

        $params = [
            ':dod' => $datum_od,
            ':ddo' => $datum_do
        ];

        return $db->select('Zadatak', $query, $params);
    }

    public static function sviZaPrioritet($prioritet)
    {
        $db = Database::getInstance();

        $query = 'SELECT * FROM zadaci WHERE prioritet = :p';

        $params = [
            ':p' => $prioritet
        ];

        return $db->select('Zadatak', $query, $params);
    }

    public static function sviZaNaslov($naslov)
    {
        $db = Database::getInstance();

        $query = "SELECT * FROM zadaci WHERE naslov LIKE :n";

        $params = [
            ':n' => $naslov
        ];

        return $db->select('Zadatak', $query, $params);
    }

    public static function upisiZadatak($naslov, $opis, $rukovodilac_id, $rok, $prioritet, $grupa_id)
    {
        $db = Database::getInstance();

        $query = 'INSERT INTO zadaci (naslov, opis_zadatka, rukovodilac_id, rok_izvrsenja, prioritet, grupa_id) '
        . 'VALUES (:n, :oz, :rid, :r, :p, :gid)';

        $params = [
            ':n' => $naslov,
            ':oz' => $opis,
            ':rid' => $rukovodilac_id,
            ':r' => $rok,
            ':p' => $prioritet,
            ':gid' => $grupa_id
        ];

        $db->insert('Zadatak', $query, $params);

        $id = $db->lastInsertId();
        $zadatak = self::getById($id, 'zadaci', 'Zadatak');
        return $zadatak;
    }

    public static function ubaciFajl($zadatak_id, $fajl) {
        $db = Database::getInstance();

        $query = 'INSERT INTO propratni_fajlovi (zadatak_id, propratni_fajl) '
        . 'VALUES (:zid, :pf)';

        $params = [
            ':zid' => $zadatak_id,
            ':pf' => $fajl
        ];

        return $db->insert('Zadatak', $query, $params);
    }

    public static function izmeniZadatak($id, $naslov, $opis, $rukovodilac_id, $rok, $prioritet, $grupa) {
        $db = Database::getInstance();

        $query = 'UPDATE zadaci '
        . 'SET naslov = :n, opis_zadatka = :oz, rukovodilac_id = :rid, rok_izvrsenja = :r, prioritet = :p, grupa_id = :gid '
        . 'WHERE id = :id';

        $params = [
            ':id' => $id,
            ':n' => $naslov,
            ':oz' => $opis,
            ':rid' => $rukovodilac_id,
            ':r' => $rok,
            ':p' => $prioritet,
            ':gid' => $grupa
        ];

        $db->update('Zadatak', $query, $params);

        $id = $db->lastInsertId();
        $zadatak = self::getById($id, 'zadaci', 'Zadatak');
        return $zadatak;
    }

    public static function obrisiZadatak($id) {
        $db = Database::getInstance();

        $query = 'DELETE FROM zadaci WHERE id = :id';

        $params = [
            ':id' => $id
        ];

        $db->delete($query, $params);
    }

    public static function zaduzeniZaZadatak($zadatak_id) {
        $db = Database::getInstance();

        $query = 'SELECT * FROM zaduzeni WHERE zadatak_id = :id';

        $params = [
            ':id' => $zadatak_id
        ];

        return $db->select('Zadatak', $query, $params);
    }

    public static function zavrsiZadatak($id) {
        $zavrsi = 'da';

        $db = Database::getInstance();

        $query = 'UPDATE zadaci ' . 'SET zavrsen = :z ' . 'WHERE id = :id';

        $params = [
            ':z' => $zavrsi,
            ':id' => $id
        ];

        $db->update('Zadatak', $query, $params);
    }
}
