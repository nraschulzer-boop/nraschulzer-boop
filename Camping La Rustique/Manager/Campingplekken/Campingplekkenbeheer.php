<?php

require_once "../../Classes/Database.php";
require_once "../../Classes/Kampeerplaats.php";

$fout = "";
$gelukt = "";


// Campingplek verwijderen.
if (isset($_GET["verwijder"])) {

    $id = $_GET["verwijder"];

    $campingplek = Kampeerplaats::findById($id);

    if ($campingplek != null) {

        $campingplek->delete();

        $gelukt = "De campingplek is succesvol verwijderd.";

    } else {

        $fout = "De campingplek kon niet worden gevonden.";

    }
}


// Campingplek aanpassen.
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id = $_POST["plaats_id"];
    $plaatsNummer = $_POST["plaats_nummer"];
    $categorie = $_POST["categorie"];
    $nachtprijs = $_POST["nachtprijs"];
    $beschikbaar = $_POST["beschikbaar"];

    if (
        empty($plaatsNummer) ||
        empty($categorie) ||
        $nachtprijs === ""
    ) {

        $fout = "Vul alle verplichte velden in.";

    } else {

        $campingplek = Kampeerplaats::findById($id);

        if ($campingplek != null) {

            $campingplek->plaatsNummer = $plaatsNummer;
            $campingplek->categorie = $categorie;
            $campingplek->nachtprijs = $nachtprijs;
            $campingplek->beschikbaar = $beschikbaar;

            $campingplek->update();

            $gelukt = "De campingplek is succesvol aangepast.";

        } else {

            $fout = "De campingplek kon niet worden gevonden.";

        }
    }
}


$campingplekken = Kampeerplaats::getAll();

?>

<!DOCTYPE html>
<html lang="nl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Campingplekken Beheren</title>

    <link rel="stylesheet" href="../../css/Manager.css">

</head>

<body>


<div class="header">

    <div>

        <h1>Campingplekken Beheren</h1>

        <p>
            Campingplekken bekijken en aanpassen
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


<div class="camping-beheer-container">

    <h2>Campingplekken beheren</h2>

    <p>
        Pas hieronder de gegevens van een campingplek aan of verwijder een campingplek.
    </p>


    <?php if (!empty($fout)) { ?>

        <div class="camping-melding camping-fout">

            <?= htmlspecialchars($fout) ?>

        </div>

    <?php } ?>


    <?php if (!empty($gelukt)) { ?>

        <div class="camping-melding camping-gelukt">

            <?= htmlspecialchars($gelukt) ?>

        </div>

    <?php } ?>


    <?php if (count($campingplekken) > 0) { ?>

        <div class="plekken-container">


            <?php foreach ($campingplekken as $campingplek) { ?>


                <div class="plek-card">

                    <h3>
                        Campingplek
                        <?= htmlspecialchars($campingplek->plaatsNummer) ?>
                    </h3>


                    <form method="POST">

                        <input
                            type="hidden"
                            name="plaats_id"
                            value="<?= $campingplek->id ?>"
                        >


                        <div class="plek-form-group">

                            <label>
                                Plaatsnummer
                            </label>

                            <input
                                type="number"
                                name="plaats_nummer"
                                value="<?= htmlspecialchars($campingplek->plaatsNummer) ?>"
                                required
                            >

                        </div>


                        <div class="plek-form-group">

                            <label>
                                Categorie
                            </label>

                            <select
                                name="categorie"
                                required
                            >

                                <option
                                    value="basis"
                                    <?= $campingplek->categorie == "basis" ? "selected" : "" ?>
                                >
                                    Basis
                                </option>

                                <option
                                    value="comfort"
                                    <?= $campingplek->categorie == "comfort" ? "selected" : "" ?>
                                >
                                    Comfort
                                </option>

                                <option
                                    value="luxe"
                                    <?= $campingplek->categorie == "luxe" ? "selected" : "" ?>
                                >
                                    Luxe
                                </option>

                            </select>

                        </div>


                        <div class="plek-form-group">

                            <label>
                                Nachtprijs
                            </label>

                            <input
                                type="number"
                                name="nachtprijs"
                                value="<?= htmlspecialchars($campingplek->nachtprijs) ?>"
                                step="0.01"
                                min="0"
                                required
                            >

                        </div>


                        <div class="plek-form-group">

                            <label>
                                Beschikbaarheid
                            </label>

                            <select
                                name="beschikbaar"
                                required
                            >

                                <option
                                    value="1"
                                    <?= $campingplek->beschikbaar ? "selected" : "" ?>
                                >
                                    Beschikbaar
                                </option>

                                <option
                                    value="0"
                                    <?= !$campingplek->beschikbaar ? "selected" : "" ?>
                                >
                                    Niet beschikbaar
                                </option>

                            </select>

                        </div>


                        <button
                            type="submit"
                            class="plek-opslaan-knop"
                        >
                            Opslaan
                        </button>


                        <a
                            href="?verwijder=<?= $campingplek->id ?>"
                            class="plek-verwijder-knop"
                            onclick="return confirm('Weet je zeker dat je deze campingplek wilt verwijderen?');"
                        >
                            Verwijderen
                        </a>

                    </form>

                </div>


            <?php } ?>


        </div>


    <?php } else { ?>

        <div class="geen-plekken">

            Er zijn nog geen campingplekken.

        </div>

    <?php } ?>


    <a
        href="../Campingplekken.php"
        class="plek-terug-knop"
    >
        ← Terug naar Campingplekken
    </a>

</div>

</body>

</html>