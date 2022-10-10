<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registracija</title>
</head>
<body>
    <form action="logika/registruj_se.php" method="post">
        <input type="text" name="username" id="username" placeholder="Korisnicko ime" require>
        <input type="password" name="password" id="password" placeholder="Lozinka" require>
        <input type="password" name="ponovo_password" placeholder="Ponovite lozinku" require>
        <input type="text" name="ime_prezime" placeholder="Ime i prezime" require>
        <input type="number" name="broj_telefona" id="broj_telefona">
        <input type="email" name="email" placeholder="E-mail" require>
        <input type="date" name="datum_rodjenja" id="datum_rodjenja">
        <input type="submit" value="Registruj se">
        <?php if (isset($_GET['error'])) { ?>
        <p id="error">Vec postoji korisnik sa tim korisnikom imenom ili e-mailom</p>
        <?php } ?>
    </form>
</body>
</html>