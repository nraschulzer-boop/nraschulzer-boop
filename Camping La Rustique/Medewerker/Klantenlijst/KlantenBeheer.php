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

    <link rel="stylesheet" href="../../css/Medewerker.css">

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

        <p>Klanten aanpassen of verwijderen</p>

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


<div class="medewerker-klanten-beheer-overzicht">

    <h2>Klanten beheren</h2>


    <?php if ($melding != "") { ?>

        <div class="medewerker-klanten-beheer-melding">

            <?php echo $melding; ?>

        </div>

    <?php } ?>


    <table class="medewerker-klanten-beheer-tabel">

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
                            value="<?php echo $klant->naam; ?>"
                            required
                        >

                    </td>


                    <td>

                        <input
                            type="email"
                            name="emailadres"
                            value="<?php echo $klant->email; ?>"
                            required
                        >

                    </td>


                    <td>

                        <input
                            type="text"
                            name="telefoonnummer"
                            value="<?php echo $klant->telefoonnummer; ?>"
                            required
                        >

                    </td>


                    <td>

                        <input
                            type="text"
                            name="straat"
                            value="<?php echo $klant->straat; ?>"
                            required
                        >

                    </td>


                    <td>

                        <input
                            type="text"
                            name="postcode"
                            value="<?php echo $klant->postcode; ?>"
                            required
                        >

                    </td>


                    <td>

                        <input
                            type="text"
                            name="woonplaats"
                            value="<?php echo $klant->woonplaats; ?>"
                            required
                        >

                    </td>


                    <td>

                        <input
                            type="hidden"
                            name="klant_id"
                            value="<?php echo $klant->id; ?>"
                        >


                        <button
                            type="submit"
                            name="opslaan"
                            class="medewerker-klanten-opslaan-knop"
                        >
                            Opslaan
                        </button>


                        <a
                            href="KlantenBeheer.php?verwijder=<?php echo $klant->id; ?>"
                            class="medewerker-klanten-verwijder-knop"
                            onclick="return bevestigVerwijderen();"
                        >
                            Verwijderen
                        </a>

                    </td>


                </form>

            </tr>

        <?php } ?>

    </table>


    <a
        href="../Klanten.php"
        class="medewerker-klanten-beheer-terug-knop"
    >
        ← Terug naar klanten
    </a>

</div>


</body>

</html>