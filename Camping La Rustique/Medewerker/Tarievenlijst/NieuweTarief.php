<?php

session_start();

require_once "../../Classes/Database.php";
require_once "../../Classes/Tarief.php";

$melding = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $tarief = new Tarief();

    $tarief->naam = $_POST["naam"];
    $tarief->omschrijving = $_POST["omschrijving"];
    $tarief->prijs = $_POST["prijs"];

    $tarief->insert();

    $melding = "Het tarief is succesvol toegevoegd.";
}

?>

<!DOCTYPE html>
<html lang="nl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Nieuw tarief</title>

    <link rel="stylesheet" href="../../css/Medewerker.css">

</head>

<body>

    <div class="header">

        <div>

            <h1>Nieuw tarief</h1>

            <p>Voeg een nieuw tarief toe aan Camping La Rustique</p>

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

        <a href="../Medewerkers.php">
            Medewerkers
        </a>

        <a href="../Tarievenlijst.php" class="active">
            Tarievenlijst
        </a>

    </nav>


    <div class="container">

        <div class="welcome">

            <h2>Nieuw tarief toevoegen</h2>

            <p>
                Vul hieronder de gegevens van het nieuwe tarief in.
            </p>

        </div>


        <?php if (!empty($melding)) { ?>

            <div class="medewerker-nieuw-tarief-melding">
                <?= htmlspecialchars($melding) ?>
            </div>

        <?php } ?>


        <form method="POST" class="medewerker-nieuw-tarief-formulier">

            <div class="medewerker-nieuw-tarief-groep">

                <label for="naam">
                    Naam
                </label>

                <input
                    type="text"
                    id="naam"
                    name="naam"
                    required
                >

            </div>


            <div class="medewerker-nieuw-tarief-groep">

                <label for="omschrijving">
                    Omschrijving
                </label>

                <textarea
                    id="omschrijving"
                    name="omschrijving"
                ></textarea>

            </div>


            <div class="medewerker-nieuw-tarief-groep">

                <label for="prijs">
                    Prijs
                </label>

                <input
                    type="number"
                    id="prijs"
                    name="prijs"
                    step="0.01"
                    min="0"
                    required
                >

            </div>


            <div class="medewerker-nieuw-tarief-knoppen">

                <button
                    type="submit"
                    class="medewerker-nieuw-tarief-opslaan-knop"
                >
                    Tarief opslaan
                </button>

                <a
                    href="../Tarievenlijst.php"
                    class="medewerker-nieuw-tarief-terug-knop"
                >
                    ← Terug
                </a>

            </div>

        </form>

    </div>

</body>

</html>