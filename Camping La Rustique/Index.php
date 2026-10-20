<?php

session_start();

require_once "Classes/Database.php";
require_once "Classes/Gebruiker.php";
require_once "Classes/Sessie.php";

$fout = "";

// Controleert of het inlogformulier is verstuurd.
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $gebruikersnaam = $_POST["gebruikersnaam"];
    $wachtwoord = $_POST["wachtwoord"];

    // Controleert de gebruikersnaam en het wachtwoord.
    $gebruiker = Gebruiker::Login($gebruikersnaam, $wachtwoord);

    if ($gebruiker !== null) {

        // Maakt een unieke session key.
        $sessionKey = bin2hex(random_bytes(32));

        // Maakt de starttijd en eindtijd van de sessie.
        $sessionStart = date("Y-m-d H:i:s");
        $sessionEnd = date("Y-m-d H:i:s", strtotime("+1 hour"));

        // Maakt een nieuw Sessie object.
        $sessie = new Sessie();

        $sessie->userId = $gebruiker->id;
        $sessie->sessionKey = $sessionKey;
        $sessie->sessionStart = $sessionStart;
        $sessie->sessionEnd = $sessionEnd;

        // Slaat de sessie op in de database.
        $sessie->insert();

        // Slaat de session key op in de PHP sessie.
        $_SESSION["session_key"] = $sessionKey;

        // Slaat het account ID op in de PHP sessie.
        $_SESSION["account_id"] = $gebruiker->id;

        // Stuurt de gebruiker door naar de hoofdpagina.
        if ($gebruiker->rol === "medewerker") {

            header("Location: Medewerker/Dashboard.php");
            exit;

        } elseif ($gebruiker->rol === "beheerder") {

            header("Location: Manager/Dashboard.php");
            exit;
        }

    } else {

        // Geeft een foutmelding als de gegevens niet kloppen.
        $fout = "Gebruikersnaam of wachtwoord is onjuist.";
    }
}

?>

<!DOCTYPE html>
<html lang="nl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Inloggen</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;

            display: flex;
            justify-content: center;
            align-items: center;

            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .login-container {
            width: 400px;
            padding: 35px;

            background-color: white;
            border-radius: 10px;

            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 5px;
        }

        input {
            width: 100%;
            padding: 12px;

            border: 1px solid #ccc;
            border-radius: 5px;

            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 12px;
            margin-top: 25px;

            border: none;
            border-radius: 5px;

            background-color: #333;
            color: white;

            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #555;
        }

        .fout {
            padding: 10px;
            margin-bottom: 15px;

            color: #b00020;
            background-color: #ffe5e5;

            border-radius: 5px;
        }

    </style>

</head>

<body>

    <div class="login-container">

        <h1>Inloggen</h1>

        <?php if ($fout !== "") { ?>

            <div class="fout">
                <?= $fout ?>
            </div>

        <?php } ?>

        <form method="POST">

            <label for="gebruikersnaam">
                Gebruikersnaam
            </label>

            <input
                type="text"
                id="gebruikersnaam"
                name="gebruikersnaam"
                required
            >

            <label for="wachtwoord">
                Wachtwoord
            </label>

            <input
                type="password"
                id="wachtwoord"
                name="wachtwoord"
                required
            >

            <button type="submit">
                Inloggen
            </button>

        </form>

    </div>

</body>

</html>