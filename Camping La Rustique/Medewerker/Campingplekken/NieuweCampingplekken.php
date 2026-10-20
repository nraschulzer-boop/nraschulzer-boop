<?php

require_once "../../Classes/Database.php";
require_once "../../Classes/Kampeerplaats.php";

$fout = "";
$gelukt = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $plaatsNummer = $_POST["plaats_nummer"];
    $categorie = $_POST["categorie"];
    $nachtprijs = $_POST["nachtprijs"];
    $beschikbaar = $_POST["beschikbaar"];

    if (
        empty($plaatsNummer) ||
        empty($categorie) ||
        empty($nachtprijs)
    ) {

        $fout = "Vul alle verplichte velden in.";

    } else {

        $campingplek = new Kampeerplaats();

        $campingplek->plaatsNummer = $plaatsNummer;
        $campingplek->categorie = $categorie;
        $campingplek->nachtprijs = $nachtprijs;
        $campingplek->beschikbaar = $beschikbaar;

        $campingplek->insert();

        $gelukt = "De campingplek is succesvol toegevoegd.";
    }
}

?>

<!DOCTYPE html>
<html lang="nl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Nieuwe Campingplek</title>

    <link rel="stylesheet" href="../../css/Manager.css">

</head>

<body>

<div class="header">

    <div>

        <h1>Nieuwe Campingplek</h1>

        <p>
            Voeg een nieuwe campingplek toe aan Camping La Rustique
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

    <a href="../Campingplekken.php" class="active">
        Campingplekken
    </a>

    <a href="../Medewerkers.php">
        Medewerkers
    </a>

    <a href="../Tarievenlijst.php">
        Tarievenlijst
    </a>

</nav>


<div class="form-container">

    <h2>Campingplek toevoegen</h2>

    <p>
        Vul hieronder de gegevens van de nieuwe campingplek in.
    </p>


    <?php if (!empty($fout)) { ?>

        <div class="fout">
            <?= htmlspecialchars($fout) ?>
        </div>

    <?php } ?>


    <?php if (!empty($gelukt)) { ?>

        <div class="gelukt">
            <?= htmlspecialchars($gelukt) ?>
        </div>

    <?php } ?>


    <form method="POST">

        <div class="form-group">

            <label for="plaats_nummer">
                Plaatsnummer
            </label>

            <input
                type="number"
                id="plaats_nummer"
                name="plaats_nummer"
                required
            >

        </div>


        <div class="form-group">

            <label for="categorie">
                Categorie
            </label>

            <select
                id="categorie"
                name="categorie"
                required
            >

                <option value="">
                    Kies een categorie
                </option>

                <option value="basis">
                    Basis
                </option>

                <option value="comfort">
                    Comfort
                </option>

                <option value="luxe">
                    Luxe
                </option>

            </select>

        </div>


        <div class="form-group">

            <label for="nachtprijs">
                Nachtprijs
            </label>

            <input
                type="number"
                id="nachtprijs"
                name="nachtprijs"
                step="0.01"
                min="0"
                placeholder="Bijvoorbeeld 25.00"
                required
            >

        </div>


        <div class="form-group">

            <label for="beschikbaar">
                Beschikbaarheid
            </label>

            <select
                id="beschikbaar"
                name="beschikbaar"
                required
            >

                <option value="1">
                    Beschikbaar
                </option>

                <option value="0">
                    Niet beschikbaar
                </option>

            </select>

        </div>


        <button
            type="submit"
            class="opslaan-knop"
        >
            Campingplek toevoegen
        </button>


        <a
            href="../Campingplekken.php"
            class="terug-knop"
        >
            Annuleren
        </a>

    </form>

</div>

</body>

</html>