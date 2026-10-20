<?php

session_start();

?>

<!DOCTYPE html>
<html lang="nl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reserveringen</title>

    <link rel="stylesheet" href="../css/Manager.css">

</head>

<body>

    <div class="header">

        <div>

            <h1>Reserveringen</h1>

            <p>Beheer de reserveringen van Camping La Rustique</p>

        </div>

    </div>


    <nav class="navigation">

        <a href="Dashboard.php">
            Dashboard
        </a>

        <a href="Reserveringen.php" class="active">
            Reserveringen
        </a>

        <a href="Klanten.php">
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

            <h2>Reserveringen beheren</h2>

            <p>
                Vanuit deze pagina kun je de reserveringen
                van Camping La Rustique bekijken en beheren.
            </p>

        </div>


        <div class="cards">

            <div class="card">

                <h3>Alle reserveringen</h3>

                <p>
                    Bekijk alle gemaakte reserveringen.
                </p>

                <a href="Reserveringen/AlleReserveringen.php" class="button">
                    Bekijken
                </a>

            </div>


            <div class="card">

                <h3>Nieuwe reservering</h3>

                <p>
                    Maak een nieuwe reservering aan.
                </p>

                <a href="Reserveringen/NieuweReservering.php" class="button">
                    Toevoegen
                </a>

            </div>


            <div class="card">

                <h3>Reserveringen beheren</h3>

                <p>
                    Pas bestaande reserveringen aan of verwijder deze.
                </p>

                <a href="Reserveringen/ReserveringenBeheer.php" class="button">
                    Beheren
                </a>

            </div>

        </div>

    </div>

</body>

</html>