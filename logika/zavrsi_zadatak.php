<?php

session_start();
if (!isset($_SESSION['korisnik_rukovodilac_id']) && !isset($_SESSION['korisnik_admin_id'])) {
    header('Location: index.php');
    die();
}

require_once __DIR__ . '/../tabele/Zadatak.php';

$id = $_GET['id'];

Zadatak::zavrsiZadatak($id);

header('Location: ../rukovodilac.php');
