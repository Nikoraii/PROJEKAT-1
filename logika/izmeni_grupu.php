<?php

session_start();
if (!isset($_SESSION['korisnik_rukovodilac_id']) && !isset($_SESSION['korisnik_admin_id'])) {
    header('Location: index.php');
    die();
}

$grupa = $_POST['naslov_grupe'];
$id = $_POST['grupa_id'];

require_once __DIR__ . '/../tabele/Grupa.php';

$grupa = Grupa::izmeniGrupu($id, $grupa);
header('Location: ../rukovodilac.php');
