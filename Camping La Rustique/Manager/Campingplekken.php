<?php

session_start();

?>

<!DOCTYPE html>
<html lang="nl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Campingplekken</title>

    <link rel="stylesheet" href="../css/Manager.css">

</head>

<body>

    <div class="header">

        <div>

            <h1>Campingplekken</h1>

            <p>Beheer de campingplekken van Camping La Rustique</p>

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

        <a href="Facturen.php">
            Facturen & Betaling
        </a>

        <a href="Campingplekken.php" class="active">
            Campingplekken
        </a>

        <a href="Medewerkers.php">
            Medewerkers
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

            <h2>Campingplekken beheren</h2>

            <p>
                Vanuit deze pagina kun je de campingplekken
                van Camping La Rustique bekijken en beheren.
            </p>

        </div>


        <div class="cards">

            <div class="card">

                <h3>Alle campingplekken</h3>

                <p>
                    Bekijk alle beschikbare en bezette campingplekken.
                </p>

                <a href="Campingplekken/AlleCampingplekken.php" class="button">
                    Bekijken
                </a>

            </div>


            <div class="card">

                <h3>Nieuwe campingplek</h3>

                <p>
                    Voeg een nieuwe campingplek toe aan het systeem.
                </p>

                <a href="Campingplekken/NieuweCampingplekken.php" class="button">
                    Toevoegen
                </a>

            </div>


            <div class="card">

                <h3>Campingplekken beheren</h3>

                <p>
                    Pas bestaande campingplekken aan of verwijder een plek.
                </p>

                <a href="Campingplekken/Campingplekkenbeheer.php" class="button">
                    Beheren
                </a>

            </div>

        </div>

    </div>

</body>

</html>