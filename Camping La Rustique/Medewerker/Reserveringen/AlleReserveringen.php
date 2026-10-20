<?php

require_once "../../Classes/Database.php";
require_once "../../Classes/Boeking.php";

$boekingen = Boeking::getAllWithDetails();

?>

<!DOCTYPE html>
<html lang="nl">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Alle Reserveringen</title>

    <link rel="stylesheet" href="../../css/Medewerker.css">

</head>

<body>

<div class="header">

    <div>

        <h1>Alle Reserveringen</h1>

        <p>
            Overzicht van alle reserveringen van Camping La Rustique
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


<div class="reserveringen-container">

    <h2>Reserveringen overzicht</h2>

    <p>
        Hier zie je alle reserveringen, de klantgegevens en de gekozen tarieven.
    </p>


    <div class="table-container">

        <table class="reserveringen-table">

            <tr>

                <th>Boeking</th>

                <th>Klant</th>

                <th>Plaats</th>

                <th>Aankomst</th>

                <th>Vertrek</th>

                <th>Volwassenen</th>

                <th>Kinderen</th>

                <th>Extra tarieven</th>

                <th>Status</th>

            </tr>


            <?php if (count($boekingen) > 0) { ?>

                <?php foreach ($boekingen as $boeking) { ?>

                    <tr>

                        <td>
                            #<?= $boeking->id ?>
                        </td>


                        <td>

                            <span class="klant-naam">

                                <?= htmlspecialchars($boeking->klantNaam) ?>

                            </span>

                        </td>


                        <td>
                            Plaats <?= $boeking->plaatsId ?>
                        </td>


                        <td>
                            <?= date("d-m-Y", strtotime($boeking->datumAankomst)) ?>
                        </td>


                        <td>
                            <?= date("d-m-Y", strtotime($boeking->datumVertrek)) ?>
                        </td>


                        <td>
                            <?= $boeking->volwassenen ?>
                        </td>


                        <td>
                            <?= $boeking->kinderen ?>
                        </td>


                        <td class="tarieven">

                            <?php if (!empty($boeking->tarieven)) { ?>

                                <?= htmlspecialchars($boeking->tarieven) ?>

                            <?php } else { ?>

                                <span class="geen-tarieven">
                                    Geen extra tarieven
                                </span>

                            <?php } ?>

                        </td>


                        <td>

                            <?php

                            if ($boeking->status == "gereserveerd") {
                                $statusClass = "status-gereserveerd";
                            } elseif ($boeking->status == "afgerond") {
                                $statusClass = "status-afgerond";
                            } else {
                                $statusClass = "status-geannuleerd";
                            }

                            ?>

                            <span class="status <?= $statusClass ?>">

                                <?= htmlspecialchars($boeking->status) ?>

                            </span>

                        </td>

                    </tr>

                <?php } ?>

            <?php } else { ?>

                <tr>

                    <td colspan="9" class="geen-reserveringen">

                        Er zijn nog geen reserveringen.

                    </td>

                </tr>

            <?php } ?>

        </table>

    </div>


    <a href="../Reserveringen.php" class="reserveringen-terug-knop">

        ← Terug naar Reserveringen

    </a>

</div>

</body>

</html>