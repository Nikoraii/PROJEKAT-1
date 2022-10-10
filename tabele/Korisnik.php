<?php

// namespace Tabele;

require_once __DIR__ . '/Tabela.php';

class Korisnik extends Tabela
{
    public $id;
    public $username;
    public $password;
    public $email;

    public static function getKorisnik($id) {
        $db = Database::getInstance();

        $query = 'SELECT * FROM korisnici ' . 'WHERE id = :id';

        $params = [
            ':id' => $id
        ];

        return $db->select('Korisnik', $query, $params);
    }

    public static function register($username, $password, $email, $tip_id = 3)
    {
        $db = Database::getInstance();

        $query = 'INSERT INTO korisnici (username, password, tip_id, email) '
        . 'VALUES(:u, :p, :tid, :e)';
        $params = [
            ':u' => $username,
            ':p' => $password,
            ':tid' => $tip_id,
            ':e' => $email
        ];

        try {
            $db->insert('Korisnik', $query, $params);
        } catch (Exception $ex) {
            return false;
        }

        return $db->lastInsertId();
    }

    public static function login($username, $password)
    {
        $db = Database::getInstance();

        $query = 'SELECT * FROM korisnici ' . 'WHERE username = :u AND password = :p';
        $params = [
            ':u' => $username,
            ':p' => $password
        ];

        $korisnici = $db->select('Korisnik', $query, $params);

        foreach ($korisnici as $korisnik) {
            return $korisnik;
        }
        return null;
    }

    public static function getKorisnikIzvrsilac() {
        $db = Database::getInstance();
        $tip_id = 3;

        $query = 'SELECT * FROM korisnici ' . 'WHERE tip_id = :tid';

        $params = [
            ':tid' => $tip_id
        ];

        return $db->select('Korisnik', $query, $params);
    }

    public static function getKorisnikRukovodilac() {
        $db = Database::getInstance();
        $tip_id = 2;

        $query = 'SELECT * FROM korisnici ' . 'WHERE tip_id = :tid';

        $params = [
            ':tid' => $tip_id
        ];

        return $db->select('Korisnik', $query, $params);
    }

}
