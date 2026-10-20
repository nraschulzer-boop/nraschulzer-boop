<?php
// We halen de klassen binnen die we nodig hebben
include "gebruiker.php";
include "sessie.php";

// Zet een lege foutmelding klaar
$error = "";

// Check of het formulier is ingevuld (dus of er op login is geklikt)
if (isset($_POST['username'])) {
    // Haal de gebruikersnaam en het wachtwoord uit het formulier
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Probeer de gebruiker op te zoeken in de database
    $gebruiker = Gebruiker::vindGebruiker($username, $password);

    // Als we een gebruiker hebben gevonden
    if ($gebruiker) {

        // Maak een unieke sleutel aan voor de sessie
        $key = md5(uniqid(rand(), true));

        // Nieuwe sessie maken met info van deze gebruiker
        $sessie = new Sessie();
        $sessie->userId = $gebruiker->user_id;
        $sessie->key = $key;
        $sessie->start = date("Y-m-d H:i:s");
        $sessie->end = date("Y-m-d H:i:s", strtotime("+1 month"));
        $sessie->insert();

        // Zet een cookie met de sessiekey, zodat je ingelogd blijft
        setcookie("steptember-session", $key, strtotime("+1 month"), "/");

        // Stuur de gebruiker naar de overzichtspagina (ze zijn ingelogd nu)
        header("Location: overview.php");
        exit();
    } else
        // Als er niks gevonden is, laat dan een foutmelding zien
        $error = "Gebruikersnaam of wachtwoord onjuist probeer opnieuw.";
}
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inloggen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="Steptember.css" rel="stylesheet">
</head>

<body id="body">

    <div class="d-flex align-items-center justify-content-end vh-100">
        <div class="d-flex flex-column align-items-center border p-4 rounded shadow" style=" padding-right: 200px;">
            <!-- Als er een foutmelding is, laat die zien -->
            <?php
            if (!empty($error)) {
                echo "<div class='error-box'>$error</div>";
            }
            ?>
            <h1 class="mb-3">Inloggen</h1>
            <form method="POST">
                <table>
                    <tr>
                        <td><label for="username">Username:</label></td>
                        <td><input type="text" name="username" class="form-control ms-2"></td>
                    </tr>
                    <tr>
                        <td><label for="password">Password:</label></td>
                        <td><input type="password" name="password" class="form-control ms-2"></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-center pt-3">
                            <input type="submit" name="O-O" value="Login" class="btn btn-primary">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

</body>



</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>