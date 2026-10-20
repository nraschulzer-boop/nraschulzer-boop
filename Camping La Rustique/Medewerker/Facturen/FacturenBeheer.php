<?php

require_once "../../Classes/Database.php";
require_once "../../Classes/Rekening.php";

$fout = "";
$gelukt = "";


// Factuur verwijderen.
if (isset($_GET["verwijder"])) {

    $id = $_GET["verwijder"];

    $rekening = Rekening::findById($id);

    if ($rekening != null) {

        $rekening->delete();

        $gelukt = "De factuur is succesvol verwijderd.";

    } else {

        $fout = "De factuur kon niet worden gevonden.";

    }
}


// Factuur aanpassen.
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id = $_POST["rekening_id"];
    $boekingId = $_POST["boeking_id"];
    $aangemaaktOp = $_POST["aangemaakt_op"];
    $totaalbedrag = $_POST["totaalbedrag"];
    $betaalstatus = $_POST["betaalstatus"];


    if (
        empty($boekingId) ||
        empty($aangemaaktOp) ||
        $totaalbedrag === "" ||
        empty($betaalstatus)
    ) {

        $fout = "Vul alle verplichte velden in.";

    } else {

        $rekening = Rekening::findById($id);

        if ($rekening != null) {

            $rekening->boekingId = $boekingId;
            $rekening->aangemaaktOp = $aangemaaktOp;
            $rekening->totaalbedrag = $totaalbedrag;
            $rekening->betaalstatus = $betaalstatus;

            $rekening->update();

            $gelukt = "De factuur is succesvol aangepast.";

        } else {

            $fout = "De factuur kon niet worden gevonden.";

        }
    }
}


$rekeningen = Rekening::getAll();

?>

<!DOCTYPE html>
<html lang="nl">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Facturen Beheren</title>

    <link rel="stylesheet" href="../../css/Medewerker.css">

</head>

<body>


<div class="header">

    <div>

        <h1>Facturen Beheren</h1>

        <p>
            Facturen bekijken en aanpassen
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

    <a href="../Facturen.php" class="active">
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


<div class="medewerker-factuur-beheer-container">

    <h2>Facturen beheren</h2>

    <p>
        Pas hieronder de gegevens van een factuur aan of verwijder een factuur.
    </p>


    <?php if (!empty($fout)) { ?>

        <div class="medewerker-factuur-melding medewerker-factuur-fout">
            <?= htmlspecialchars($fout) ?>
        </div>

    <?php } ?>


    <?php if (!empty($gelukt)) { ?>

        <div class="medewerker-factuur-melding medewerker-factuur-gelukt">
            <?= htmlspecialchars($gelukt) ?>
        </div>

    <?php } ?>


    <?php if (count($rekeningen) > 0) { ?>

        <div class="medewerker-facturen-container">


            <?php foreach ($rekeningen as $rekening) { ?>


                <div class="medewerker-factuur-card">

                    <h3>
                        Factuur #<?= $rekening->id ?>
                    </h3>


                    <form method="POST">

                        <input
                            type="hidden"
                            name="rekening_id"
                            value="<?= $rekening->id ?>"
                        >


                        <div class="medewerker-factuur-form-group">

                            <label>
                                Boeking ID
                            </label>

                            <input
                                type="number"
                                name="boeking_id"
                                value="<?= htmlspecialchars($rekening->boekingId) ?>"
                                required
                            >

                        </div>


                        <div class="medewerker-factuur-form-group">

                            <label>
                                Aangemaakt op
                            </label>

                            <input
                                type="datetime-local"
                                name="aangemaakt_op"
                                value="<?= date(
                                    "Y-m-d\TH:i",
                                    strtotime($rekening->aangemaaktOp)
                                ) ?>"
                                required
                            >

                        </div>


                        <div class="medewerker-factuur-form-group">

                            <label>
                                Totaalbedrag
                            </label>

                            <input
                                type="number"
                                name="totaalbedrag"
                                value="<?= htmlspecialchars($rekening->totaalbedrag) ?>"
                                step="0.01"
                                min="0"
                                required
                            >

                        </div>


                        <div class="medewerker-factuur-form-group">

                            <label>
                                Betaalstatus
                            </label>

                            <select
                                name="betaalstatus"
                                required
                            >

                                <option
                                    value="openstaand"
                                    <?= $rekening->betaalstatus == "openstaand" ? "selected" : "" ?>
                                >
                                    Openstaand
                                </option>

                                <option
                                    value="betaald"
                                    <?= $rekening->betaalstatus == "betaald" ? "selected" : "" ?>
                                >
                                    Betaald
                                </option>

                            </select>

                        </div>


                        <button
                            type="submit"
                            class="medewerker-factuur-opslaan-knop"
                        >
                            Opslaan
                        </button>


                        <a
                            href="?verwijder=<?= $rekening->id ?>"
                            class="medewerker-factuur-verwijder-knop"
                            onclick="return confirm('Weet je zeker dat je deze factuur wilt verwijderen?');"
                        >
                            Verwijderen
                        </a>

                    </form>

                </div>


            <?php } ?>


        </div>


    <?php } else { ?>

        <div class="medewerker-geen-facturen">
            Er zijn nog geen facturen.
        </div>

    <?php } ?>


    <a
        href="../Facturen.php"
        class="medewerker-factuur-terug-knop"
    >
        ← Terug naar Facturen
    </a>

</div>

</body>

</html>