<?php

session_start();

require_once "../../Classes/Database.php";
require_once "../../Classes/Tarief.php";

$tarieven = Tarief::getAll();

?>

<!DOCTYPE html>
<html lang="nl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Alle tarieven</title>

    <link rel="stylesheet" href="../../css/Manager.css">

</head>

<body>

    <div class="header">

        <div>

            <h1>Alle tarieven</h1>

            <p>Overzicht van de tarieven van Camping La Rustique</p>

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

            <h2>Overzicht tarieven</h2>

            <p>
                Hieronder staan alle huidige tarieven van Camping La Rustique.
            </p>

        </div>


        <table class="tarief-tabel">

            <thead>

                <tr>

                    <th>Naam</th>

                    <th>Omschrijving</th>

                    <th>Prijs</th>

                </tr>

            </thead>


            <tbody>

                <?php foreach ($tarieven as $tarief) { ?>

                    <tr>

                        <td>
                            <?= htmlspecialchars($tarief->naam) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($tarief->omschrijving) ?>
                        </td>

                        <td class="tarief-prijs">
                            € <?= number_format($tarief->prijs, 2, ',', '.') ?>
                        </td>

                    </tr>

                <?php } ?>

            </tbody>

        </table>


        <a href="../Tarievenlijst.php" class="tarief-terug-knop">
            ← Terug naar tarievenlijst
        </a>

    </div>

</body>

</html>