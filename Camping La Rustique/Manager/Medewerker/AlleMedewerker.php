<?php

require_once "../../Classes/Database.php";
require_once "../../Classes/Gebruiker.php";

$gebruikers = Gebruiker::getAll();

?>

<!DOCTYPE html>
<html lang="nl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Alle medewerkers</title>

    <link rel="stylesheet" href="../../css/Manager.css">

</head>

<body>

<div class="header">

    <div>

        <h1>Alle medewerkers</h1>

        <p>
            Overzicht van alle medewerkers
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

    <a href="../Campingplekken.php">
        Campingplekken
    </a>

    <a href="../Medewerkers.php" class="active">
        Medewerkers
    </a>

    <a href="../Tarievenlijst.php">
        Tarievenlijst
    </a>

</nav>


<div class="medewerkers-overzicht">

    <h2>Medewerkers overzicht</h2>


    <table class="medewerkers-tabel">

        <tr>

            <th>Naam</th>

            <th>Gebruikersnaam</th>

            <th>Rol</th>

        </tr>


        <?php foreach ($gebruikers as $gebruiker) { ?>

            <tr>

                <td>
                    <?= htmlspecialchars($gebruiker->naam) ?>
                </td>

                <td>
                    <?= htmlspecialchars($gebruiker->username) ?>
                </td>

                <td>
                    <?= htmlspecialchars($gebruiker->rol) ?>
                </td>

            </tr>

        <?php } ?>

    </table>


    <a href="../Medewerkers.php" class="terug-knop">

        ← Terug naar medewerkers

    </a>

</div>

</body>

</html>