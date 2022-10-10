<?php

session_start();
if (!isset($_SESSION['korisnik_rukovodilac_id']) && !isset($_SESSION['korisnik_admin_id'])) {
    header('Location: index.php');
    die();
}

require_once __DIR__ . '/../tabele/Zadatak.php';
$id = $_POST['zadatak_id'];
$naslov = $_POST['naslov'];
$opis = $_POST['opis_zadatka'];
$rukovodilac_id = $_POST['izaberi_rukovodilaca'];
$rok = $_POST['rok'];

if (empty($_POST['rok'])) {
    $rok = null;
}

$prioritet = $_POST['prioritet'];
$grupa = $_POST['izaberi_grupu'];

$zadatak = Zadatak::izmeniZadatak($id, $naslov, $opis, $rukovodilac_id, $rok, $prioritet, $grupa);

if (!empty($_FILES['fajl']['name'])) {
    require_once __DIR__ . '/../includes/Upload.php';

    $upload = Upload::factory('/../fajlovi');
	$upload->file($_FILES['fajl']);
	$upload->set_allowed_mime_types(['jpg/jpeg', 'image/png', 'image/gif']);
	$upload->set_max_file_size(2);
	$upload->set_filename($_FILES['fajl']['name']);
	$upload->save();
	$fajl = 'fajlovi/' . $_FILES['fajl']['name'];

    Zadatak::ubaciFajl($zadatak->id, $fajl);
}


header('Location: ../rukovodilac.php');
