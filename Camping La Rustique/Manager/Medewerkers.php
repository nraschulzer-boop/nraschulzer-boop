<?php

session_start();

?>

<!DOCTYPE html>
<html lang="nl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Medewerkers</title>

    <link rel="stylesheet" href="../css/Manager.css">

</head>

<body>

    <div class="header">

        <div>

            <h1>Medewerkers</h1>

            <p>Beheer de medewerkers van Camping La Rustique</p>

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

        <a href="Medewerkers.php" class="active">
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

            <h2>Medewerkers beheren</h2>

            <p>
                Vanuit deze pagina kun je de medewerkers
                van Camping La Rustique bekijken en beheren.
            </p>

        </div>


        <div class="cards">

            <div class="card">

                <h3>Alle medewerkers</h3>

                <p>
                    Bekijk alle medewerkers die in het systeem staan.
                </p>

                <a href="Medewerker/Allemedewerker.php" class="button">
                    Bekijken
                </a>

            </div>


            <div class="card">

                <h3>Nieuwe medewerker</h3>

                <p>
                    Voeg een nieuwe medewerker toe aan het systeem.
                </p>

                <a href="Medewerker/NieuweMedewerker.php" class="button">
                    Toevoegen
                </a>

            </div>


            <div class="card">

                <h3>Medewerkers beheren</h3>

                <p>
                    Pas bestaande medewerkers aan of verwijder een medewerker.
                </p>

                <a href="Medewerker/MedewerkerBeheer.php" class="button">
                    Beheren
                </a>

            </div>

        </div>

    </div>

</body>

</html>