<?php

session_start();

?>

<!DOCTYPE html>
<html lang="nl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Facturen & Betalingen</title>

    <link rel="stylesheet" href="../css/Manager.css">

</head>

<body>

    <div class="header">

        <div>

            <h1>Facturen & Betalingen</h1>

            <p>Beheer de facturen en betalingen van Camping La Rustique</p>

        </div>

    </div>


    <nav class="navigation">

        <a href="Dashboard.php">
            Dashboard
        </a>

        <a href="Reserveringen.php">
            Reserveringen
        </a>

        <a href="Klanten.php">
            Klanten
        </a>

        <a href="Facturen.php" class="active">
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

            <h2>Facturen & Betalingen beheren</h2>

            <p>
                Vanuit deze pagina kun je facturen bekijken,
                betalingen controleren en de financiële gegevens
                van Camping La Rustique beheren.
            </p>

        </div>


        <div class="cards">

            <div class="card">

                <h3>Alle facturen</h3>

                <p>
                    Bekijk alle gemaakte facturen.
                </p>

                <a href="Facturen/AlleFacturen.php" class="button">
                    Bekijken
                </a>

            </div>


            <div class="card">

                <h3>Openstaande betalingen</h3>

                <p>
                    Bekijk welke facturen nog niet betaald zijn.
                </p>

                <a href="Facturen/OpenstaandeFacturen.php" class="button">
                    Bekijken
                </a>

            </div>


            <div class="card">

                <h3>Betalingen beheren</h3>

                <p>
                    Bekijk en beheer de betalingen van klanten.
                </p>

                <a href="Facturen/FacturenBeheer.php" class="button">
                    Beheren
                </a>

            </div>

        </div>

    </div>

</body>

</html>