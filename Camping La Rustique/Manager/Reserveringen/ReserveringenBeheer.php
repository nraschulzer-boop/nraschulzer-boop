<?php

session_start();

require_once "../../Classes/Database.php";
require_once "../../Classes/Boeking.php";
require_once "../../Classes/Klanten.php";
require_once "../../Classes/Kampeerplaats.php";

$melding = "";

// Reservering verwijderen.
if (isset($_GET["verwijderen"])) {

    $id = (int)$_GET["verwijderen"];

    $boeking = Boeking::findById($id);

    if ($boeking != null) {
        $boeking->delete();

        $melding = "Reservering is verwijderd.";
    }
}

// Reservering bijwerken.
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id = (int)$_POST["boeking_id"];

    $boeking = Boeking::findById($id);

    if ($boeking != null) {

        $boeking->klantId = (int)$_POST["klant_id"];
        $boeking->plaatsId = (int)$_POST["plaats_id"];
        $boeking->datumAankomst = $_POST["datum_aankomst"];
        $boeking->datumVertrek = $_POST["datum_vertrek"];
        $boeking->volwassenen = (int)$_POST["volwassenen"];
        $boeking->kinderen = (int)$_POST["kinderen"];
        $boeking->status = $_POST["status"];

        $boeking->update();

        $melding = "Reservering is bijgewerkt.";
    }
}

// Alle reserveringen ophalen.
$boekingen = Boeking::getAll();

// Alle klanten ophalen.
$klanten = Klant::getAll();

// Alle campingplaatsen ophalen.
$campingplaatsen = Kampeerplaats::getAll();


// Klanten koppelen aan hun ID.
$klantenLijst = [];

foreach ($klanten as $klant) {
    $klantenLijst[$klant->id] = $klant;
}

// Campingplaatsen koppelen aan hun ID.
$plaatsenLijst = [];

foreach ($campingplaatsen as $plaats) {
    $plaatsenLijst[$plaats->id] = $plaats;
}

?>

<!DOCTYPE html>
<html lang="nl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reserveringen beheren</title>

    <link rel="stylesheet" href="../../css/Manager.css">

</head>

<body>

<div class="header">

    <div>

        <h1>Reserveringen beheren</h1>

        <p>
            Reserveringen van Camping La Rustique beheren
        </p>

    </div>

</div>


<nav class="navigation">

    <a href="../Dashboard.php">
        Dashboard
    </a>

    <a href="../Reserveringen.php" class="active">
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

    <a href="../Tarievenlijst.php">
        Tarievenlijst
    </a>

</nav>


<div class="beheer-container">

    <?php if ($melding != ""): ?>

        <div class="melding">

            <?= htmlspecialchars($melding) ?>

        </div>

    <?php endif; ?>


    <a href="../Reserveringen.php" class="knop terug">
        ← Terug naar reserveringen
    </a>


    <h2>Alle reserveringen</h2>


    <?php if (count($boekingen) == 0): ?>

        <p>
            Er zijn nog geen reserveringen.
        </p>

    <?php else: ?>


        <?php foreach ($boekingen as $boeking): ?>

            <div class="reservering">

                <h2>
                    Reservering #<?= $boeking->id ?>
                </h2>


                <form method="POST">

                    <input
                        type="hidden"
                        name="boeking_id"
                        value="<?= $boeking->id ?>"
                    >


                    <div class="formulier">


                        <div>

                            <label>Klant</label>

                            <select name="klant_id" required>

                                <?php foreach ($klanten as $klant): ?>

                                    <option
                                        value="<?= $klant->id ?>"
                                        <?= $klant->id == $boeking->klantId ? "selected" : "" ?>
                                    >

                                        <?= htmlspecialchars($klant->naam) ?>

                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>


                        <div>

                            <label>Campingplaats</label>

                            <select name="plaats_id" required>

                                <?php foreach ($campingplaatsen as $plaats): ?>

                                    <option
                                        value="<?= $plaats->id ?>"
                                        <?= $plaats->id == $boeking->plaatsId ? "selected" : "" ?>
                                    >

                                        Plaats
                                        <?= htmlspecialchars($plaats->plaatsNummer) ?>

                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>


                        <div>

                            <label>Aankomst</label>

                            <input
                                type="datetime-local"
                                name="datum_aankomst"
                                value="<?= date("Y-m-d\TH:i", strtotime($boeking->datumAankomst)) ?>"
                                required
                            >

                        </div>


                        <div>

                            <label>Vertrek</label>

                            <input
                                type="datetime-local"
                                name="datum_vertrek"
                                value="<?= date("Y-m-d\TH:i", strtotime($boeking->datumVertrek)) ?>"
                                required
                            >

                        </div>


                        <div>

                            <label>Volwassenen</label>

                            <input
                                type="number"
                                name="volwassenen"
                                min="1"
                                value="<?= $boeking->volwassenen ?>"
                                required
                            >

                        </div>


                        <div>

                            <label>Kinderen</label>

                            <input
                                type="number"
                                name="kinderen"
                                min="0"
                                value="<?= $boeking->kinderen ?>"
                                required
                            >

                        </div>


                        <div>

                            <label>Status</label>

                            <select name="status" required>

                                <option
                                    value="gereserveerd"
                                    <?= $boeking->status == "gereserveerd" ? "selected" : "" ?>
                                >
                                    Gereserveerd
                                </option>

                                <option
                                    value="afgerond"
                                    <?= $boeking->status == "afgerond" ? "selected" : "" ?>
                                >
                                    Afgerond
                                </option>

                                <option
                                    value="geannuleerd"
                                    <?= $boeking->status == "geannuleerd" ? "selected" : "" ?>
                                >
                                    Geannuleerd
                                </option>

                            </select>

                        </div>


                    </div>


                    <div class="knoppen">

                        <button
                            type="submit"
                            class="knop opslaan"
                        >
                            Reservering opslaan
                        </button>


                        <a
                            href="?verwijderen=<?= $boeking->id ?>"
                            class="knop verwijderen"
                            onclick="return confirm('Weet je zeker dat je deze reservering wilt verwijderen?');"
                        >
                            Verwijderen
                        </a>

                    </div>


                </form>

            </div>

        <?php endforeach; ?>


    <?php endif; ?>

</div>

</body>

</html>