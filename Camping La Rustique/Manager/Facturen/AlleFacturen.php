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

    <link rel="stylesheet" href="../../css/Manager.css">

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


<div class="facturen-container">

    <h2>Facturen overzicht</h2>

    <p>
        Hier zie je alle facturen, bedragen en betaalstatussen.
    </p>


    <div class="table-container">

        <table class="facturen-table">

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

                            <span class="factuur-nummer">
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

                            <span class="bedrag">

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

                                $statusClass = "betaald";

                            } elseif ($rekening->betaalstatus == "openstaand") {

                                $statusClass = "openstaand";

                            } else {

                                $statusClass = "geannuleerd";

                            }

                            ?>

                            <span class="betaalstatus <?= $statusClass ?>">

                                <?= htmlspecialchars($rekening->betaalstatus) ?>

                            </span>

                        </td>

                    </tr>

                <?php } ?>

            <?php } else { ?>

                <tr>

                    <td colspan="5" class="geen-facturen">

                        Er zijn nog geen facturen.

                    </td>

                </tr>

            <?php } ?>

        </table>

    </div>


    <a
        href="../Facturen.php"
        class="terug-knop"
    >
        ← Terug naar Facturen
    </a>

</div>

</body>

</html>