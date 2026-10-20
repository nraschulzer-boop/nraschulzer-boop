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

    <title>Alle Facturen</title>

    <link rel="stylesheet" href="../../css/Medewerker.css">

</head>

<body>


<div class="header">

    <div>

        <h1>Alle Facturen</h1>

        <p>
            Overzicht van alle facturen van Camping La Rustique
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


<div class="medewerker-facturen-container">

    <h2>Facturen overzicht</h2>

    <p>
        Hier zie je alle facturen, bedragen en betaalstatussen.
    </p>


    <div class="medewerker-facturen-tabel-container">

        <table class="medewerker-facturen-table">

            <tr>

                <th>Factuur</th>

                <th>Boeking</th>

                <th>Aangemaakt op</th>

                <th>Totaalbedrag</th>

                <th>Betaalstatus</th>

            </tr>


            <?php if (count($rekeningen) > 0) { ?>

                <?php foreach ($rekeningen as $rekening) { ?>

                    <tr>

                        <td>

                            <span class="medewerker-factuur-nummer">
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

                            <span class="medewerker-factuur-bedrag">

                                € <?= number_format(
                                    $rekening->totaalbedrag,
                                    2,
                                    ",",
                                    "."
                                ) ?>

                            </span>

                        </td>


                        <td>

                            <?php

                            if ($rekening->betaalstatus == "betaald") {

                                $statusClass = "medewerker-betaald";

                            } elseif ($rekening->betaalstatus == "openstaand") {

                                $statusClass = "medewerker-openstaand";

                            } else {

                                $statusClass = "medewerker-geannuleerd";

                            }

                            ?>

                            <span class="medewerker-betaalstatus <?= $statusClass ?>">

                                <?= htmlspecialchars($rekening->betaalstatus) ?>

                            </span>

                        </td>

                    </tr>

                <?php } ?>

            <?php } else { ?>

                <tr>

                    <td
                        colspan="5"
                        class="medewerker-geen-facturen"
                    >

                        Er zijn nog geen facturen.

                    </td>

                </tr>

            <?php } ?>

        </table>

    </div>


    <a
        href="../Facturen.php"
        class="medewerker-facturen-terug-knop"
    >
        ← Terug naar Facturen
    </a>

</div>

</body>

</html>