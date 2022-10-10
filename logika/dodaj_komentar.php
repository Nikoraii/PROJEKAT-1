<?php

session_start();
if (!isset($_SESSION['korisnik_id']) && !isset($_SESSION['korisnik_admin_id'])) {
    header('Location: ../index.php');
    die();
}

require_once __DIR__ . '/../tabele/Komentar.php';

$naslov = $_POST['naslov'];
$komentar = $_POST['komentar'];
$korisnik_id = $_SESSION['korisnik_id'];
$zadatak_id = $_POST['zadatak_id'];

Komentar::upisiKomentar($naslov, $komentar, $korisnik_id, $zadatak_id);
header('Location: ../izvrsilac.php');
