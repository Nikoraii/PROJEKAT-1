<?php

if (!isset($_POST['username'])) {
    header('Location: ../index.php');
    die();
}

$username = $_POST['username'];
$password = $_POST['password'];
$password = hash('sha512', $password);
require_once __DIR__ . '/../tabele/Korisnik.php';
$korisnik = Korisnik::login($username, $password);
require_once __DIR__ . '/../tabele/Uloga.php';
$uloga_admin = Uloga::getByName('admin');
$uloga_rukovodilac = Uloga::getByName('rukovodilac');

// if ($korisnik !== null) {
//     session_start();
//     $_SESSION['korisnik_id'] = $korisnik->id;
//     header('Location: ../index.php?error=good');
// } else {
//     header('Location: ../index.php?error=login');
// }

if ($korisnik !== null) {
    if ($korisnik->tip_id === $uloga_admin->id) {
        session_start();
        $_SESSION['korisnik_admin_id'] = $korisnik->id;
        $_SESSION['korisnik_id'] = $korisnik->id;
        header('Location: ../admin.php');
    } else if ($korisnik->tip_id === $uloga_rukovodilac->id) {
        session_start();
        $_SESSION['korisnik_rukovodilac_id'] = $korisnik->id;
        $_SESSION['korisnik_id'] = $korisnik->id;
        header('Location: ../rukovodilac.php');
    } else {
        session_start();
        $_SESSION['korisnik_id'] = $korisnik->id;
        header('Location: ../izvrsilac.php');
    }
} else {
    header('Location: ../index.php?error=login');
}
