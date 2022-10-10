<?php

session_start();
if (!isset($_SESSION['korisnik_id']) && !isset($_SESSION['korisnik_admin_id'])) {
    header('Location: index.php');
    die();
}

require_once __DIR__ . '/tabele/Zaduzen.php';
require_once __DIR__ . '/tabele/Komentar.php';
$zaduzeni = Zaduzen::getZaduzeni($_SESSION['korisnik_id']);

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

    <h1>Zadaci</h1>
    <div class="svi_zadaci">
        <?php foreach ($zaduzeni as $zaduzen) { ?>
            <div class="zadatak">
                <p><?= $zaduzen->getZadatak()->naslov?></p>
                <p><?= $zaduzen->getZadatak()->opis_zadatka?></p>
                <p>Prioritet: <?= $zaduzen->getZadatak()->prioritet?></p>
                <form action="logika/dodaj_komentar.php" method="post">
                    <input type="text" name="naslov" id="naslov" placeholder="Dodaj naslov">
                    <textarea name="komentar" id="komentar" cols="30" rows="10" placeholder="Dodaj komentar"></textarea>
                    <input type="hidden" name="zadatak_id" value="<?= $zaduzen->getZadatak()->id ?>">
                    <input type="submit" value="Posalji komentar">
                </form>
                <?php $komentari = Komentar::komentariZaZadatak($zaduzen->getZadatak()->id);
                foreach ($komentari as $komentar) { ?>
                <p><?= $komentar->getKomentar()->naslov?></p>
                <p><?= $komentar->getKomentar()->komentar?></p>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</body>
</html>
