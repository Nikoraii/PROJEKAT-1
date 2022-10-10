<?php

session_start();
if (!isset($_SESSION['korisnik_rukovodilac_id']) && !isset($_SESSION['korisnik_admin_id'])) {
    header('Location: index.php');
    die();
}

$grupa = $_POST['grupa'];

require_once __DIR__ . '/../tabele/Rukovodilac.php';

$grupa = Rukovodilac::napraviGrupu($grupa);
header('Location: ../rukovodilac.php');
