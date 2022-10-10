<?php

session_start();
if (!isset($_SESSION['korisnik_rukovodilac_id']) && !isset($_SESSION['korisnik_admin_id'])) {
    header('Location: index.php');
    die();
}

require_once __DIR__ . '/tabele/Zadatak.php';
require_once __DIR__ . '/tabele/Korisnik.php';
require_once __DIR__ . '/tabele/Grupa.php';
require_once __DIR__ . '/tabele/Komentar.php';

$zadaci = Zadatak::getAll();
$zaduzeni = Korisnik::getKorisnikIzvrsilac();
$rukovodioci = Korisnik::getKorisnikRukovodilac();
$grupe = Grupa::sveGrupe();
// require_once __DIR__ . '/tabele/Zaduzen.php';
// $rukovodilac = Rukovodilac::getRukovodilac($_SESSION['korisnik_rukovodilac_id']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Izvrsilac</title>
</head>
<body>
    <a href="logika/logout.php" id="odjava">Odjavi se</a>

    <h1>Kreiraj grupu zadataka</h1>
    <form action="logika/napravi_grupu.php" method="post" id="grupa_forma">
        <input type="text" name="grupa" id="grupa" placeholder="Ime grupe">
        <input type="submit" value="Napravi grupu">
    </form>

    <h1>Kreiraj zadatak</h1>
    <form action="logika/napravi_zadatak.php" method="post" enctype="multipart/form-data">
        <input type="text" name="naslov" id="naslov" placeholder="Unesite naslov" maxlength="191">
        <textarea name="opis_zadatka" id="opis_zadatka" cols="30" rows="10" placeholder="Unesite opis"></textarea>
        <select name="izaberi_zaduzenog" id="izaberi_zaduzenog">
            <?php foreach ($zaduzeni as $zaduzen) { ?>
                <option value="<?= $zaduzen->id?>"><?= $zaduzen->username?></option>
            <?php } ?>
        </select>
        <select name="izaberi_rukovodilaca" id="izaberi_rukovodilaca">
            <?php foreach ($rukovodioci as $rukovodilac) { ?>
                <option value="<?= $rukovodilac->id?>"><?= $rukovodilac->username?></option>
            <?php } ?>
        </select>
        <input type="datetime-local" name="rok" id="rok">
        <select name="prioritet" id="prioritet">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
        </select>
        <select name="izaberi_grupu" id="izaberi_grupu">
            <?php foreach ($grupe as $grupa) { ?>
                <option value="<?= $grupa->id?>"><?= $grupa->grupa?></option>
            <?php } ?>
        </select>
        <input type="file" name="fajl" id="fajl">
        <input type="submit" value="Napravi zadatak">
    </form>

    <section>
        <h2>Grupe</h2>
        <form action="logika/izmeni_grupu.php" method="post">
            <input type="text" name="naslov_grupe" id="naslov_grupe" placeholder="Naslov grupe">
            <select name="grupa_id" id="grupa_id">
                <?php foreach ($grupe as $grupa) { ?>
                    <option value="<?= $grupa->id?>"><?= $grupa->grupa?></option>
                <?php } ?>
            </select>
            <input type="submit" value="Izmeni grupu">
        </form>
        
        <h3>Obrisi grupu</h3>
        <form action="logika/obrisi_grupu.php" method="post">
            <select name="grupa_id_obrisi" id="grupa_id_obrisi">
                <?php foreach ($grupe as $grupa) { ?>
                    <option value="<?= $grupa->id?>"><?= $grupa->grupa?></option>
                <?php } ?>
            </select>
            <input type="submit" value="Obrisi grupu">
        </form>
        <h2>Zadaci</h2>
        <p>Filtriraj zadatke: </p>
        <form method="post">
            <input type="datetime-local" name="d_od" id="d_od">
            <input type="datetime-local" name="d_do" id="d_do">
            <select name="prioritet" id="prioritet">
                <option value="" selected></option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
            </select>
            <input type="text" name="naslov" id="naslov">
            <input type="submit" name="filter" value="Filtriraj">
            <?php if (isset($_POST['filter'])) {
                $datum_od = $_POST['d_od'];
                $datum_do = $_POST['d_do'];
                $prioritet = $_POST['prioritet'];
                $naslov = $_POST['naslov'];
                $filtrirani_zadaci = [];
                
                if (!empty($_POST['d_od'] && $_POST['d_do'])) {
                    $filtrirani_zadaci_d = Zadatak::sviZaDatum($datum_od, $datum_do);
                }
                
                if (!empty($_POST['prioritet'])) {
                    $filtrirani_zadaci_p = Zadatak::sviZaPrioritet($prioritet);
                    // $filtrirani_zadaci = array_intersect($filtrirani_zadaci_d, $filtrirani_zadaci_p);
                }
                
                if (!empty($_POST['naslov'])) {
                    $filtrirani_zadaci_n = Zadatak::sviZaNaslov($naslov);
                    $filtrirani_zadaci = array_intersect($filtrirani_zadaci_p, $filtrirani_zadaci_n);
                }
                
                $zadaci = $filtrirani_zadaci;
            } ?>
            <input type="submit" value="Resetuj" name="resetuj">
            <?php if (isset($_POST['resetuj'])) {
                $zadaci = Zadatak::getAll();
            } ?>
        </form>

        <div class="svi_zadaci">
            <?php foreach ($zadaci as $zadatak) { ?>
                <div class="zadatak">
                    <p><?= $zadatak->grupa_id?></p>
                    <p><?= $zadatak->naslov?></p>
                    <?php
                    if ($zadatak->otkazan == 'ne') {
                        if ($zadatak->zavrsen == 'ne') {
                            echo "<p>Zadatak nije zavrsen</p>";
                            echo "<a href='logika/zavrsi_zadatak.php?id=<?= $zadatak->id?>'>Oznaci zadatak kao zavrsen.</a>";
                        } else {
                            echo "<p>Zadatak je zavrsen!</p>";
                        }
                    } else {
                        echo "<p>Zadatak je otkazan</p>";
                    } ?> 
                    <p><?= $zadatak->opis_zadatka?></p>
                    <p>Prioritet: <?= $zadatak->prioritet?></p>
                    <?php $zaduzeniZaZadatak = $zadatak->zaduzeniZaZadatak($zadatak->id);
                    foreach ($zaduzeniZaZadatak as $zaduzenZaZadatak) { ?>
                        <p><?= $zaduzenZaZadatak->izvrsilac_id ?>
                        - <?= Korisnik::getKorisnik($zaduzenZaZadatak->izvrsilac_id)[0]->username ?>
                        | ZAVRSIO: <?= $zaduzenZaZadatak->zavrsio ?></p>
                    <?php } ?>
                    <?php if ($zadatak->otkazan == 'ne') { ?>
                        <a href="logika/otkazi_zadatak.php">Otkazi zadatak</a>
                    <?php } ?>
                    <a href="logika/obrisi_zadatak.php?id=<?=$zadatak->id?>">Obrisi</a>
                    <form action="logika/izmeni_zadatak.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="zadatak_id" value="<?= $zadatak->id?>">
                        <input type="text" name="naslov" id="naslov" placeholder="Unesite naslov" maxlength="191" value="<?= $zadatak->naslov?>">
                        <textarea name="opis_zadatka" id="opis_zadatka" cols="30" rows="10" placeholder="Unesite opis"><?= $zadatak->opis_zadatka?></textarea>
                        <select name="izaberi_zaduzenog" id="izaberi_zaduzenog">
                            <?php foreach ($zaduzeni as $zaduzen) { ?>
                                <option value="<?= $zaduzen->id?>"><?= $zaduzen->username?></option>
                            <?php } ?>
                        </select>
                        <select name="izaberi_rukovodilaca" id="izaberi_rukovodilaca">
                            <?php foreach ($rukovodioci as $rukovodilac) { ?>
                                <option value="<?= $rukovodilac->id?>"><?= $rukovodilac->username?></option>
                            <?php } ?>
                        </select>
                        <input type="datetime-local" name="rok" id="rok">
                        <select name="prioritet" id="prioritet">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                        </select>
                        <select name="izaberi_grupu" id="izaberi_grupu">
                            <?php foreach ($grupe as $grupa) { ?>
                                <option value="<?= $grupa->id?>"><?= $grupa->grupa?></option>
                            <?php } ?>
                        </select>
                        <input type="file" name="fajl" id="fajl">
                        <input type="submit" value="Izmeni zadatak">
                    </form>
                    <?php $komentari = Komentar::komentariZaZadatak($zadatak->id);
                    foreach ($komentari as $komentar) { ?>
                        <h4><?= $komentar->naslov ?> - <?= Korisnik::getKorisnik($komentar->korisnik_id)[0]->username ?></h4>
                        <p><?= $komentar->komentar ?></p>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </section>
</body>
</html>
