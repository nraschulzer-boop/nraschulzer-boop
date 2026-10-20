<?php

require_once "../../Classes/Database.php";
require_once "../../Classes/Rekening.php";

$rekeningen = Rekening::getAll();

?>

<!DOCTYPE html>
<html lang="nl">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Openstaande Facturen</title>

    <link rel="stylesheet" href="../../css/Medewerker.css">

</head>

<body>


<div class="header">

    <div>

        <h1>Openstaande Facturen</h1>

        <p>
            Overzicht van alle facturen die nog niet zijn betaald
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


<div class="medewerker-openstaande-facturen-container">

    <h2>Openstaande facturen</h2>

    <p>
        Hier zie je alle facturen waarvan de betaling nog openstaat.
    </p>


    <div class="medewerker-openstaande-facturen-tabel-container">

        <table class="medewerker-openstaande-facturen-table">

            <tr>

                <th>Factuur</th>

                <th>Boeking</th>

                <th>Aangemaakt op</th>

                <th>Totaalbedrag</th>

                <th>Betaalstatus</th>

            </tr>


            <?php

            $aantalOpenstaand = 0;

            foreach ($rekeningen as $rekening) {

                if ($rekening->betaalstatus != "openstaand") {
                    continue;
                }

                $aantalOpenstaand++;

            ?>

                <tr>

                    <td>

                        <span class="medewerker-openstaande-factuur-nummer">
                            #<?= $rekening->id ?>
                        </span>

                    </td>


                    <td>
                        Boeking #<?= $rekening->boekingId ?>
                    </td>


                    <td>

                        <?= date(
                            "d-m-Y H:i",
                            strtotime($rekening->aangemaaktOp)
                        ) ?>

                    </td>


                    <td>

                        <span class="medewerker-openstaande-factuur-bedrag">

                            € <?= number_format(
                                $rekening->totaalbedrag,
                                2,
                                ",",
                                "."
                            ) ?>

                        </span>

                    </td>


                    <td>

                        <span class="medewerker-openstaande-status">
                            Openstaand
                        </span>

                    </td>

                </tr>

            <?php } ?>


            <?php if ($aantalOpenstaand == 0) { ?>

                <tr>

                    <td
                        colspan="5"
                        class="medewerker-openstaande-geen-facturen"
                    >

                        Er zijn momenteel geen openstaande facturen.

                    </td>

                </tr>

            <?php } ?>

        </table>

    </div>


    <a
        href="../Facturen.php"
        class="medewerker-openstaande-terug-knop"
    >
        ← Terug naar Facturen
    </a>

</div>

</body>

</html>