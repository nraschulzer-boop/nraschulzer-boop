<?php

session_start();

require_once "../../Classes/Database.php";
require_once "../../Classes/Gebruiker.php";

$melding = "";

if (isset($_POST["opslaan"])) {

    $gebruiker = Gebruiker::findById($_POST["account_id"]);

    if ($gebruiker != null) {

        $gebruiker->naam = $_POST["volledige_naam"];
        $gebruiker->username = $_POST["gebruikersnaam"];
        $gebruiker->password = $_POST["wachtwoord"];
        $gebruiker->rol = $_POST["rol"];

        $gebruiker->update();

        $melding = "Medewerker is succesvol aangepast.";
    }
}

if (isset($_GET["verwijder"])) {

    $id = (int) $_GET["verwijder"];

    // Controleert of de gebruiker zichzelf probeert te verwijderen.
    if (isset($_SESSION["account_id"]) && $id === (int) $_SESSION["account_id"]) {

        $melding = "Je kunt jezelf niet verwijderen.";

    } else {

        $gebruiker = Gebruiker::findById($id);

        if ($gebruiker != null) {

            $gebruiker->delete();

            $melding = "Medewerker is succesvol verwijderd.";
        }
    }
}

$gebruikers = Gebruiker::getAll();

?>

<!DOCTYPE html>
<html lang="nl">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Medewerkers beheren</title>

    <link rel="stylesheet" href="../../css/Manager.css">

    <script>

        function bevestigVerwijderen() {

            return confirm(
                "Weet je zeker dat je deze medewerker wilt verwijderen?"
            );
        }

    </script>

</head>

<body>

<div class="header">

    <div>

        <h1>Medewerkers beheren</h1>

        <p>Medewerkers aanpassen of verwijderen</p>

    </div>

</div>

<nav class="navigation">

    <a href="../Dashboard.php">Dashboard</a>

    <a href="../Reserveringen.php">Reserveringen</a>

    <a href="../Klanten.php">Klanten</a>

    <a href="../Facturen.php">Facturen & Betaling</a>

    <a href="../Campingplekken.php">Campingplekken</a>

    <a href="../Medewerkers.php" class="active">Medewerkers</a>

    <a href="../Tarievenlijst.php">Tarievenlijst</a>

</nav>

<div class="medewerker-overzicht">

    <h2>Medewerkers beheren</h2>

    <?php if ($melding != "") { ?>

        <div class="medewerker-melding">

            <?php echo $melding; ?>

        </div>

    <?php } ?>

    <table class="medewerkers-tabel">

        <tr>

            <th>Naam</th>

            <th>Gebruikersnaam</th>

            <th>Wachtwoord</th>

            <th>Rol</th>

            <th>Acties</th>

        </tr>

        <?php foreach ($gebruikers as $gebruiker) { ?>

            <tr>

                <form method="POST">

                    <td>

                        <input
                            type="text"
                            name="volledige_naam"
                            value="<?php echo htmlspecialchars($gebruiker->naam); ?>"
                            required
                        >

                    </td>

                    <td>

                        <input
                            type="text"
                            name="gebruikersnaam"
                            value="<?php echo htmlspecialchars($gebruiker->username); ?>"
                            required
                        >

                    </td>

                    <td>

                        <input
                            type="text"
                            name="wachtwoord"
                            value="<?php echo htmlspecialchars($gebruiker->password); ?>"
                            required
                        >

                    </td>

                    <td>

                        <select name="rol" required>

                            <option
                                value="medewerker"
                                <?php
                                if ($gebruiker->rol == "medewerker") {
                                    echo "selected";
                                }
                                ?>
                            >
                                Medewerker
                            </option>

                            <option
                                value="beheerder"
                                <?php
                                if ($gebruiker->rol == "beheerder") {
                                    echo "selected";
                                }
                                ?>
                            >
                                Beheerder
                            </option>

                        </select>

                    </td>

                    <td>

                        <input
                            type="hidden"
                            name="account_id"
                            value="<?php echo $gebruiker->id; ?>"
                        >

                        <button
                            type="submit"
                            name="opslaan"
                            class="medewerker-opslaan-knop"
                        >
                            Opslaan
                        </button>

                        <?php

                        if (
                            !isset($_SESSION["account_id"]) ||
                            (int) $gebruiker->id !== (int) $_SESSION["account_id"]
                        ) {

                        ?>

                            <a
                                href="MedewerkerBeheer.php?verwijder=<?php echo $gebruiker->id; ?>"
                                class="medewerker-verwijder-knop"
                                onclick="return bevestigVerwijderen();"
                            >
                                Verwijderen
                            </a>

                        <?php

                        } else {

                        ?>

                            <span>Ingelogd</span>

                        <?php

                        }

                        ?>

                    </td>

                </form>

            </tr>

        <?php } ?>

    </table>

    <a href="../Medewerkers.php" class="medewerker-terug-knop">
        ← Terug naar medewerkers
    </a>

</div>

</body>

</html>