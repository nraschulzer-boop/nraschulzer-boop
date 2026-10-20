<?php

session_start();

require_once "../../Classes/Database.php";
require_once "../../Classes/Tarief.php";

$melding = "";


/*
 * Tarief verwijderen
 */
if (isset($_GET["verwijder"])) {

    $tarief = Tarief::findById($_GET["verwijder"]);

    if ($tarief != null) {

        $tarief->delete();

        $melding = "Het tarief is verwijderd.";

    } else {

        $melding = "Het tarief kan niet worden verwijderd.";

    }
}


/*
 * Tarief aanpassen
 */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $tarief = Tarief::findById($_POST["dienst_id"]);

    if ($tarief != null) {

        $tarief->naam = $_POST["naam"];
        $tarief->omschrijving = $_POST["omschrijving"];
        $tarief->prijs = $_POST["prijs"];

        $tarief->update();

        $melding = "Het tarief is succesvol aangepast.";

    } else {

        $melding = "Er is iets misgegaan bij het aanpassen.";

    }
}


/*
 * Tarieven ophalen
 */
$tarieven = Tarief::getAll();

?>

<!DOCTYPE html>
<html lang="nl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tarieven beheren</title>

    <link rel="stylesheet" href="../../css/Manager.css">

</head>

<body>

    <div class="header">

        <div>

            <h1>Tarieven beheren</h1>

            <p>Beheer de tarieven van Camping La Rustique</p>

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

            <h2>Tarieven beheren</h2>

            <p>
                Pas hieronder bestaande tarieven aan of verwijder een tarief.
            </p>

        </div>


        <?php if (!empty($melding)) { ?>

            <div class="tarief-melding">
                <?= htmlspecialchars($melding) ?>
            </div>

        <?php } ?>


        <table class="tarief-beheer-tabel">

            <thead>

                <tr>

                    <th>Naam</th>

                    <th>Omschrijving</th>

                    <th>Prijs</th>

                    <th>Actie</th>

                </tr>

            </thead>


            <tbody>

                <?php foreach ($tarieven as $tarief) { ?>

                    <tr>

                        <form method="POST">

                            <td>

                                <input
                                    type="text"
                                    name="naam"
                                    value="<?= htmlspecialchars($tarief->naam) ?>"
                                    required
                                >

                            </td>


                            <td>

                                <textarea name="omschrijving"><?= htmlspecialchars($tarief->omschrijving ?? '') ?></textarea>

                            </td>


                            <td>

                                <input
                                    type="number"
                                    name="prijs"
                                    value="<?= htmlspecialchars($tarief->prijs) ?>"
                                    step="0.01"
                                    min="0"
                                    required
                                >

                            </td>


                            <td>

                                <input
                                    type="hidden"
                                    name="dienst_id"
                                    value="<?= $tarief->id ?>"
                                >

                                <button
                                    type="submit"
                                    class="tarief-opslaan-knop"
                                >
                                    Opslaan
                                </button>

                                <br>

                                <a
                                    href="?verwijder=<?= $tarief->id ?>"
                                    class="tarief-verwijder-knop"
                                    onclick="return confirm('Weet je zeker dat je dit tarief wilt verwijderen?');"
                                >
                                    Verwijderen
                                </a>

                            </td>

                        </form>

                    </tr>

                <?php } ?>

            </tbody>

        </table>


        <a
            href="../Tarievenlijst.php"
            class="tarief-terug-knop"
        >
            ← Terug naar tarievenlijst
        </a>

    </div>

</body>

</html>