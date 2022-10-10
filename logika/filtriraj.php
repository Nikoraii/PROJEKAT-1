<?php

session_start();
if (!isset($_SESSION['korisnik_rukovodilac_id']) && !isset($_SESSION['korisnik_admin_id'])) {
    header('Location: index.php');
    die();
}

// include_once __DIR__ . '/../rukovodilac.php';
$datum_od = $_POST['d_od'];
$datum_do = $_POST['d_do'];
$prioritet = $_POST['prioritet'];
$naslov = $_POST['naslov'];
$filtrirani_zadaci = [];

require_once __DIR__ . '/../tabele/Zadatak.php';
// $filtrirani_zadaci = Zadatak::getAll();

if (!empty($_POST['d_od'] && $_POST['d_do'])) {
    $filtrirani_zadaci = Zadatak::sviZaDatum($datum_od, $datum_do);
}

if (!empty($_POST['prioritet'])) {
    $filtrirani_zadaci = Zadatak::sviZaPrioritet($prioritet);
}

if (!empty($_POST['naslov'])) {
    $filtrirani_zadaci = Zadatak::sviZaNaslov($naslov);
}

$zadaci = $filtrirani_zadaci;
header('Location: ../rukovodilac.php');
