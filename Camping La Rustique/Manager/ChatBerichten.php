<?php

session_start();

require_once "../Classes/Database.php";
require_once "../Classes/Chat.php";
require_once "../Classes/Gebruiker.php";

header("Content-Type: application/json");


// Controleert of de gebruiker is ingelogd.
if (!isset($_SESSION["account_id"])) {

    echo json_encode([
        "success" => false,
        "message" => "Je bent niet ingelogd."
    ]);

    exit;
}


$accountId = (int)$_SESSION["account_id"];


// Controleert de ingelogde gebruiker.
$gebruiker = Gebruiker::findById($accountId);

if ($gebruiker == null) {

    echo json_encode([
        "success" => false,
        "message" => "Gebruiker bestaat niet."
    ]);

    exit;
}


// Alleen een beheerder mag berichten verwijderen.
$isBeheerder = ($gebruiker->rol === "beheerder");


// Bericht verwijderen.
if ($_SERVER["REQUEST_METHOD"] === "POST"
    && isset($_POST["actie"])
    && $_POST["actie"] === "verwijderen") {

    // Extra controle op de server.
    if (!$isBeheerder) {

        echo json_encode([
            "success" => false,
            "message" => "Je hebt geen toestemming om berichten te verwijderen."
        ]);

        exit;
    }


    $chatId = (int)($_POST["chat_id"] ?? 0);


    if ($chatId <= 0) {

        echo json_encode([
            "success" => false,
            "message" => "Ongeldig bericht."
        ]);

        exit;
    }


    Chat::deleteById($chatId);


    echo json_encode([
        "success" => true
    ]);

    exit;
}


// Bericht versturen.
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $bericht = trim($_POST["bericht"] ?? "");


    if ($bericht === "") {

        echo json_encode([
            "success" => false,
            "message" => "Het bericht mag niet leeg zijn."
        ]);

        exit;
    }


    $chat = new Chat();

    $chat->accountId = $accountId;
    $chat->bericht = $bericht;

    $chat->insert();


    echo json_encode([
        "success" => true
    ]);

    exit;
}


// Berichten ophalen.
$berichten = Chat::getAll();

$data = [];

foreach ($berichten as $bericht) {

    $data[] = [
        "id" => $bericht->id,
        "accountId" => $bericht->accountId,
        "naam" => $bericht->naam,
        "rol" => $bericht->rol,
        "bericht" => $bericht->bericht,
        "verstuurdOp" => $bericht->verstuurdOp
    ];
}


echo json_encode([
    "success" => true,
    "isBeheerder" => $isBeheerder,
    "berichten" => $data
]);