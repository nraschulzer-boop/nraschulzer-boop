<?php

require_once "../../Classes/Database.php";
require_once "../../Classes/Klanten.php";

$melding = "";

if (isset($_POST["opslaan"])) {

    $klant = new Klant();

    $klant->naam = $_POST["volledige_naam"];
    $klant->email = $_POST["emailadres"];
    $klant->telefoonnummer = $_POST["telefoonnummer"];
    $klant->straat = $_POST["straat"];
    $klant->postcode = $_POST["postcode"];
    $klant->woonplaats = $_POST["woonplaats"];

    $klant->insert();

    $melding = "Klant is succesvol toegevoegd.";
}

?>

<!DOCTYPE html>
<html lang="nl">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Nieuwe klant</title>

    <link rel="stylesheet" href="../../css/Medewerker.css">

</head>

<body>

<div class="header">

    <div>

        <h1>Nieuwe klant</h1>

        <p>Voeg een nieuwe klant toe</p>

    </div>

</div>


<nav class="navigation">

    <a href="../Dashboard.php">
        Dashboard
    </a>

    <a href="../Reserveringen.php">
        Reserveringen
    </a>

    <a href="../Klanten.php" class="active">
        Klanten
    </a>

    <a href="../Facturen.php">
        Facturen & Betaling
    </a>

    <a href="../Campingplekken.php">
        Campingplekken
    </a>

    <a href="../Medewerkers.php">
        Medewerkers
    </a>

    <a href="../Tarievenlijst.php">
        Tarievenlijst
    </a>

</nav>


<div class="medewerker-nieuwe-klant-formulier">

    <h2>Nieuwe klant toevoegen</h2>

    <?php if ($melding != "") { ?>

        <div class="medewerker-klant-melding">
            <?php echo $melding; ?>
        </div>

    <?php } ?>


    <form method="POST">

        <div class="medewerker-klant-formulier-groep">

            <label for="volledige_naam">
                Volledige naam
            </label>

            <input
                type="text"
                id="volledige_naam"
                name="volledige_naam"
                required
            >

        </div>


        <div class="medewerker-klant-formulier-groep">

            <label for="emailadres">
                E-mailadres
            </label>

            <input
                type="email"
                id="emailadres"
                name="emailadres"
                required
            >

        </div>


        <div class="medewerker-klant-formulier-groep">

            <label for="telefoonnummer">
                Telefoonnummer
            </label>

            <input
                type="text"
                id="telefoonnummer"
                name="telefoonnummer"
                required
            >

        </div>


        <div class="medewerker-klant-formulier-groep">

            <label for="straat">
                Straat
            </label>

            <input
                type="text"
                id="straat"
                name="straat"
                required
            >

        </div>


        <div class="medewerker-klant-formulier-groep">

            <label for="postcode">
                Postcode
            </label>

            <input
                type="text"
                id="postcode"
                name="postcode"
                required
            >

        </div>


        <div class="medewerker-klant-formulier-groep">

            <label for="woonplaats">
                Woonplaats
            </label>

            <input
                type="text"
                id="woonplaats"
                name="woonplaats"
                required
            >

        </div>


        <button
            type="submit"
            name="opslaan"
            class="medewerker-klant-opslaan-knop"
        >
            Klant toevoegen
        </button>

    </form>


    <a
        href="../Klanten.php"
        class="medewerker-klant-terug-knop"
    >
        ← Terug naar klanten
    </a>

</div>

</body>

</html>