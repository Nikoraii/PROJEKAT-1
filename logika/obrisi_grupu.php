<?php

session_start();
if (!isset($_SESSION['korisnik_rukovodilac_id']) && !isset($_SESSION['korisnik_admin_id'])) {
    header('Location: index.php');
    die();
}

$id = $_POST['grupa_id_obrisi'];

require_once __DIR__ . '/../tabele/Grupa.php';

try {
    Grupa::obrisiGrupu($id);
    header('Location: ../rukovodilac.php');
} catch (Exception $ex) {
    echo "Ne mozete obrisati grupu ukoliko postoje zadacu u toj grupi.
    <br>\n status: " . $ex->getMessage();
}
