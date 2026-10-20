<?php

require_once "../../Classes/Database.php";
require_once "../../Classes/Klanten.php";

$melding = "";

if (isset($_POST["opslaan"])) {

    $klant = Klant::findById($_POST["klant_id"]);

    if ($klant != null) {

        $klant->naam = $_POST["volledige_naam"];
        $klant->email = $_POST["emailadres"];
        $klant->telefoonnummer = $_POST["telefoonnummer"];
        $klant->straat = $_POST["straat"];
        $klant->postcode = $_POST["postcode"];
        $klant->woonplaats = $_POST["woonplaats"];

        $klant->update();

        $melding = "Klant is succesvol aangepast.";
    }
}


if (isset($_GET["verwijder"])) {

    $klant = Klant::findById($_GET["verwijder"]);

    if ($klant != null) {

        $klant->delete();

        $melding = "Klant is succesvol verwijderd.";
    }
}


$klanten = Klant::getAll();

?>

<!DOCTYPE html>
<html lang="nl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Klanten beheren</title>

    <link rel="stylesheet" href="../../css/Manager.css">

    <script>

        function bevestigVerwijderen() {

            return confirm(
                "Weet je zeker dat je deze klant wilt verwijderen?"
            );

        }

    </script>

</head>

<body>


<div class="header">

    <div>

        <h1>Klanten beheren</h1>

        <p>
            Klanten aanpassen of verwijderen
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


<div class="overzicht">

    <h2>Klanten beheren</h2>


    <?php if ($melding != "") { ?>

        <div class="melding">

            <?= htmlspecialchars($melding) ?>

        </div>

    <?php } ?>


    <table class="klanten-tabel">

        <tr>

            <th>Naam</th>

            <th>E-mailadres</th>

            <th>Telefoonnummer</th>

            <th>Straat</th>

            <th>Postcode</th>

            <th>Woonplaats</th>

            <th>Acties</th>

        </tr>


        <?php foreach ($klanten as $klant) { ?>

            <tr>

                <form method="POST">


                    <td>

                        <input
                            type="text"
                            name="volledige_naam"
                            value="<?= htmlspecialchars($klant->naam) ?>"
                            required
                        >

                    </td>


                    <td>

                        <input
                            type="email"
                            name="emailadres"
                            value="<?= htmlspecialchars($klant->email) ?>"
                            required
                        >

                    </td>


                    <td>

                        <input
                            type="text"
                            name="telefoonnummer"
                            value="<?= htmlspecialchars($klant->telefoonnummer) ?>"
                            required
                        >

                    </td>


                    <td>

                        <input
                            type="text"
                            name="straat"
                            value="<?= htmlspecialchars($klant->straat) ?>"
                            required
                        >

                    </td>


                    <td>

                        <input
                            type="text"
                            name="postcode"
                            value="<?= htmlspecialchars($klant->postcode) ?>"
                            required
                        >

                    </td>


                    <td>

                        <input
                            type="text"
                            name="woonplaats"
                            value="<?= htmlspecialchars($klant->woonplaats) ?>"
                            required
                        >

                    </td>


                    <td>

                        <input
                            type="hidden"
                            name="klant_id"
                            value="<?= $klant->id ?>"
                        >


                        <button
                            type="submit"
                            name="opslaan"
                            class="opslaan-knop"
                        >
                            Opslaan
                        </button>


                        <a
                            href="KlantenBeheer.php?verwijder=<?= $klant->id ?>"
                            class="verwijder-knop"
                            onclick="return bevestigVerwijderen();"
                        >
                            Verwijderen
                        </a>

                    </td>


                </form>

            </tr>

        <?php } ?>

    </table>


    <a href="../Klanten.php" class="terug-knop">
        ← Terug naar klanten
    </a>

</div>


</body>

</html>