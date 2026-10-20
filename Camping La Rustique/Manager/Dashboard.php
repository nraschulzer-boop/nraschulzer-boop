<?php

session_start();

require_once "../Classes/Database.php";
require_once "../Classes/Gebruiker.php";
require_once "../Classes/DashboardStatistieken.php";

$gebruiker = null;

if (isset($_SESSION["account_id"])) {
    $gebruiker = Gebruiker::findById($_SESSION["account_id"]);
}

$statistieken = DashboardStatistieken::getOverzicht();

?>

<!DOCTYPE html>
<html lang="nl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manager Dashboard</title>

    <link rel="stylesheet" href="../css/Manager.css">

</head>

<body>

    <div class="header">

        <div>

            <h1>Manager Dashboard</h1>

            <p>Beheer Camping La Rustique</p>

        </div>

        <div class="welkom-gebruiker">

            Welkom

            <?php if ($gebruiker != null): ?>

                <?= htmlspecialchars($gebruiker->naam) ?>

            <?php endif; ?>

        </div>

    </div>


    <nav class="navigation">

        <a href="Dashboard.php" class="active">
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


    <!-- Statistieken -->

    <div class="statistieken">

        <div class="statistiek-kaart">

            <h3>Totale inkomsten</h3>

            <div class="statistiek-waarde">

                € <?= number_format(
                    $statistieken["totale_inkomsten"],
                    2,
                    ",",
                    "."
                ) ?>

            </div>

            <div class="statistiek-omschrijving">
                Betaalde facturen
            </div>

        </div>


        <div class="statistiek-kaart">

            <h3>Totale reserveringen</h3>

            <div class="statistiek-waarde">

                <?= $statistieken["totale_reserveringen"] ?>

            </div>

            <div class="statistiek-omschrijving">
                Alle reserveringen
            </div>

        </div>


        <div class="statistiek-kaart">

            <h3>Totale klanten</h3>

            <div class="statistiek-waarde">

                <?= $statistieken["totale_klanten"] ?>

            </div>

            <div class="statistiek-omschrijving">
                Geregistreerde klanten
            </div>

        </div>

    </div>


    <!-- Dashboard en algemene chat -->

    <div class="dashboard-container">

        <div class="welcome">

            <h2>Welkom bij het dashboard</h2>

            <p>
                Vanuit dit dashboard kun je de reserveringen,
                klanten, facturen, campingplekken, medewerkers
                en tarieven beheren.
            </p>

        </div>


        <div class="chat-container">

            <h2>Algemene chat</h2>

            <p>
                Chat met medewerkers en beheerders van Camping La Rustique.
            </p>


            <div
                id="chatBerichten"
                class="chat-berichten"
            >
            </div>


            <form
                id="chatFormulier"
                class="chat-formulier"
                data-chat-url="ChatBerichten.php"
            >

                <input
                    type="text"
                    id="bericht"
                    name="bericht"
                    placeholder="Typ een bericht..."
                    autocomplete="off"
                    required
                >

                <button type="submit">
                    Versturen
                </button>

            </form>


            <div
                id="chatFout"
                class="chat-fout"
            >
            </div>

        </div>

    </div>

    <script src="../js/Chat.js"></script>

</body>

</html>