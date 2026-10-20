<?php

session_start();

?>

<!DOCTYPE html>
<html lang="nl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Klanten</title>

    <link rel="stylesheet" href="../css/Manager.css">

</head>

<body>

    <div class="header">

        <div>

            <h1>Klanten</h1>

            <p>Beheer de klanten van Camping La Rustique</p>

        </div>

    </div>


    <nav class="navigation">

        <a href="Dashboard.php">
            Dashboard
        </a>

        <a href="Reserveringen.php">
            Reserveringen
        </a>

        <a href="Klanten.php" class="active">
            Klanten
        </a>

        <a href="Facturen.php">
            Facturen & Betaling
        </a>

        <a href="Campingplekken.php">
            Campingplekken
        </a>

        <a href="Tarievenlijst.php">
            Tarievenlijst
        </a>

        <a href="../Uitloggen.php" class="uitloggen">
             Uitloggen
        </a>

    </nav>


    <div class="container">

        <div class="welcome">

            <h2>Klanten beheren</h2>

            <p>
                Vanuit deze pagina kun je de klanten van
                Camping La Rustique bekijken en beheren.
            </p>

        </div>


        <div class="cards">

            <div class="card">

                <h3>Alle klanten</h3>

                <p>
                    Bekijk alle geregistreerde klanten.
                </p>

                <a href="Klantenlijst/AlleKlanten.php" class="button">
                    Bekijken
                </a>

            </div>


            <div class="card">

                <h3>Nieuwe klant</h3>

                <p>
                    Voeg een nieuwe klant toe aan het systeem.
                </p>

                <a href="Klantenlijst/NieuweKlanten.php" class="button">
                    Toevoegen
                </a>

            </div>


            <div class="card">

                <h3>Klanten beheren</h3>

                <p>
                    Pas bestaande klantgegevens aan of verwijder een klant.
                </p>

                <a href="Klantenlijst/KlantenBeheer.php" class="button">
                    Beheren
                </a>

            </div>

        </div>

    </div>

</body>

</html>