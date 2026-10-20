<?php

require_once "../../Classes/Database.php";
require_once "../../Classes/Kampeerplaats.php";

$campingplekken = Kampeerplaats::getAll();

?>

<!DOCTYPE html>
<html lang="nl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Alle Campingplekken</title>

    <link rel="stylesheet" href="../../css/Manager.css">

</head>

<body>

<div class="header">

    <div>

        <h1>Alle Campingplekken</h1>

        <p>
            Overzicht van alle campingplekken van Camping La Rustique
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


<div class="camping-container">

    <h2>Campingplekken overzicht</h2>

    <p>
        Hier zie je alle campingplekken, de categorie, nachtprijs en beschikbaarheid.
    </p>


    <div class="table-container">

        <table class="camping-table">

            <tr>

                <th>Plaatsnummer</th>

                <th>Categorie</th>

                <th>Nachtprijs</th>

                <th>Beschikbaarheid</th>

            </tr>


            <?php if (count($campingplekken) > 0) { ?>

                <?php foreach ($campingplekken as $campingplek) { ?>

                    <tr>

                        <td>

                            <span class="plaatsnummer">

                                Plaats
                                <?= htmlspecialchars($campingplek->plaatsNummer) ?>

                            </span>

                        </td>


                        <td>

                            <?php

                            if ($campingplek->categorie == "basis") {

                                $categorieClass = "categorie-basis";

                            } elseif ($campingplek->categorie == "comfort") {

                                $categorieClass = "categorie-comfort";

                            } else {

                                $categorieClass = "categorie-luxe";

                            }

                            ?>

                            <span class="categorie <?= $categorieClass ?>">

                                <?= htmlspecialchars($campingplek->categorie) ?>

                            </span>

                        </td>


                        <td>

                            <span class="prijs">

                                €
                                <?= number_format(
                                    $campingplek->nachtprijs,
                                    2,
                                    ",",
                                    "."
                                ) ?>

                            </span>

                        </td>


                        <td>

                            <?php if ($campingplek->beschikbaar) { ?>

                                <span class="beschikbaar beschikbaar-ja">

                                    Beschikbaar

                                </span>

                            <?php } else { ?>

                                <span class="beschikbaar beschikbaar-nee">

                                    Niet beschikbaar

                                </span>

                            <?php } ?>

                        </td>

                    </tr>

                <?php } ?>

            <?php } else { ?>

                <tr>

                    <td colspan="4" class="geen-plekken">

                        Er zijn nog geen campingplekken.

                    </td>

                </tr>

            <?php } ?>

        </table>

    </div>


    <a href="../Campingplekken.php" class="terug-knop">

        ← Terug naar Campingplekken

    </a>

</div>

</body>

</html>