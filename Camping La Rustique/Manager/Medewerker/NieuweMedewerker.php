<?php

require_once "../../Classes/Database.php";
require_once "../../Classes/Gebruiker.php";

$melding = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $medewerker = new Gebruiker();

    $medewerker->naam = $_POST["volledige_naam"];
    $medewerker->username = $_POST["gebruikersnaam"];
    $medewerker->password = $_POST["wachtwoord"];
    $medewerker->rol = $_POST["rol"];

    $medewerker->insert();

    $melding = "Medewerker is succesvol toegevoegd.";
}

?>

<!DOCTYPE html>
<html lang="nl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Nieuwe medewerker</title>

    <link rel="stylesheet" href="../../css/Manager.css">

</head>

<body>

<div class="header">

    <div>

        <h1>Nieuwe medewerker</h1>

        <p>
            Voeg een nieuwe medewerker toe
        </p>

    </div>

</div>


<nav class="navigation">

    <a href="../Dashboard.php">
        Dashboard
    </a>

    <a href="../Reserveringen.php">
        Reserveringen
    </a>

    <a href="../Klanten.php">
        Klanten
    </a>

    <a href="../Facturen.php">
        Facturen & Betaling
    </a>

    <a href="../Campingplekken.php">
        Campingplekken
    </a>

    <a href="../Medewerkers.php" class="active">
        Medewerkers
    </a>

    <a href="../Tarievenlijst.php">
        Tarievenlijst
    </a>

</nav>


<div class="medewerker-formulier">

    <h2>Nieuwe medewerker toevoegen</h2>


    <?php if ($melding != "") { ?>

        <div class="medewerker-melding">

            <?= htmlspecialchars($melding) ?>

        </div>

    <?php } ?>


    <form method="POST">

        <label for="volledige_naam">
            Volledige naam
        </label>

        <input
            type="text"
            id="volledige_naam"
            name="volledige_naam"
            required
        >


        <label for="gebruikersnaam">
            Gebruikersnaam
        </label>

        <input
            type="text"
            id="gebruikersnaam"
            name="gebruikersnaam"
            required
        >


        <label for="wachtwoord">
            Wachtwoord
        </label>

        <input
            type="password"
            id="wachtwoord"
            name="wachtwoord"
            required
        >


        <label for="rol">
            Rol
        </label>

        <select
            id="rol"
            name="rol"
            required
        >

            <option value="medewerker">
                Medewerker
            </option>

            <option value="beheerder">
                Beheerder
            </option>

        </select>


        <button
            type="submit"
            class="medewerker-opslaan-knop"
        >
            Medewerker toevoegen
        </button>

    </form>


    <a
        href="../Medewerkers.php"
        class="medewerker-terug-knop"
    >
        ← Terug naar medewerkers
    </a>

</div>

</body>

</html>