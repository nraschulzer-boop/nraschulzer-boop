<?php

require_once "../../Classes/Database.php";
require_once "../../Classes/Klanten.php";

$klanten = Klant::getAll();

?>

<!DOCTYPE html>
<html lang="nl">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Alle klanten</title>

    <link rel="stylesheet" href="../../css/Medewerker.css">

</head>

<body>

<div class="header">

    <div>

        <h1>Alle klanten</h1>

        <p>Overzicht van alle klanten van Camping La Rustique</p>

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


<div class="medewerker-klanten-overzicht">

    <h2>Klantenoverzicht</h2>


    <table class="medewerker-klanten-tabel">

        <tr>

            <th>Naam</th>
            <th>E-mailadres</th>
            <th>Telefoonnummer</th>
            <th>Straat</th>
            <th>Postcode</th>
            <th>Woonplaats</th>

        </tr>


        <?php foreach ($klanten as $klant) { ?>

            <tr>

                <td>
                    <?php echo $klant->naam; ?>
                </td>

                <td>
                    <?php echo $klant->email; ?>
                </td>

                <td>
                    <?php echo $klant->telefoonnummer; ?>
                </td>

                <td>
                    <?php echo $klant->straat; ?>
                </td>

                <td>
                    <?php echo $klant->postcode; ?>
                </td>

                <td>
                    <?php echo $klant->woonplaats; ?>
                </td>

            </tr>

        <?php } ?>

    </table>


    <a
        href="../Klanten.php"
        class="medewerker-klanten-terug-knop"
    >
        ← Terug naar klanten
    </a>

</div>

</body>

</html>