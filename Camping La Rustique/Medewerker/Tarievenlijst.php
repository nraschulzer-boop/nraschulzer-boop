<?php

session_start();

?>

<!DOCTYPE html>
<html lang="nl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tarievenlijst</title>

    <link rel="stylesheet" href="../css/Manager.css">

</head>

<body>

    <div class="header">

        <div>

            <h1>Tarievenlijst</h1>

            <p>Beheer de tarieven van Camping La Rustique</p>

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

        <a href="Campingplekken.php">
            Campingplekken
        </a>

        <a href="Tarievenlijst.php" class="active">
            Tarievenlijst
        </a>

        <a href="../Uitloggen.php" class="uitloggen">
             Uitloggen
        </a>

    </nav>


    <div class="container">

        <div class="welcome">

            <h2>Tarieven beheren</h2>

            <p>
                Vanuit deze pagina kun je de tarieven van
                Camping La Rustique bekijken en beheren.
            </p>

        </div>


        <div class="cards">

            <div class="card">

                <h3>Alle tarieven</h3>

                <p>
                    Bekijk alle huidige tarieven van de camping.
                </p>

                <a href="Tarievenlijst/AlleTarieven.php" class="button">
                    Bekijken
                </a>

            </div>


            <div class="card">

                <h3>Nieuw tarief</h3>

                <p>
                    Voeg een nieuw tarief toe aan de tarievenlijst.
                </p>

                <a href="Tarievenlijst/NieuweTarief.php" class="button">
                    Toevoegen
                </a>

            </div>


            <div class="card">

                <h3>Tarieven beheren</h3>

                <p>
                    Pas bestaande tarieven aan of verwijder een tarief.
                </p>

                <a href="Tarievenlijst/TarievenBeheer.php" class="button">
                    Beheren
                </a>

            </div>

        </div>

    </div>

</body>

</html>