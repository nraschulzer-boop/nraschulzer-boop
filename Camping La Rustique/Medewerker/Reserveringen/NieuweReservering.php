<?php

require_once "../../Classes/Database.php";
require_once "../../Classes/Klanten.php";
require_once "../../Classes/Kampeerplaats.php";
require_once "../../Classes/Boeking.php";
require_once "../../Classes/Tarief.php";
require_once "../../Classes/BoekingExtra.php";
require_once "../../Classes/Rekening.php";
require_once "../../Classes/RekeningRegel.php";

$fout = "";
$gelukt = false;
$factuurId = null;

// Alle klanten ophalen.
$klanten = Klant::getAll();

// Alle tarieven ophalen.
$tarieven = Tarief::getAll();

// Alle campingplekken ophalen.
$campingplekken = Kampeerplaats::getAll();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $klantKeuze = $_POST["klant_keuze"];
    $start = $_POST["datum_aankomst"];
    $einde = $_POST["datum_vertrek"];
    $plaatsId = $_POST["plaats_id"];
    $volwassenen = (int) $_POST["volwassenen"];
    $kinderen = (int) $_POST["kinderen"];
    $betaalstatus = $_POST["betaalstatus"];

    /*
     * Controleert of de einddatum na de startdatum ligt.
     */
    if (strtotime($einde) <= strtotime($start)) {

        $fout = "De einddatum en tijd moeten na de startdatum en tijd liggen.";

    } else {

        /*
         * Bestaande klant gebruiken.
         */
        if ($klantKeuze === "bestaand") {

            $klantId = (int) $_POST["klant_id"];

            $klant = Klant::findById($klantId);

            if ($klant == null) {
                $fout = "De gekozen klant bestaat niet.";
            }
        }

        /*
         * Nieuwe klant aanmaken.
         */
        if ($klantKeuze === "nieuw" && empty($fout)) {

            $klant = new Klant();

            $klant->naam = $_POST["naam"];
            $klant->email = $_POST["email"];
            $klant->telefoonnummer = $_POST["telefoonnummer"];
            $klant->straat = $_POST["straat"];
            $klant->postcode = $_POST["postcode"];
            $klant->woonplaats = $_POST["woonplaats"];

            $klant->insert();

            /*
             * Na insert halen we de nieuw aangemaakte klant
             * opnieuw op met de laatst aangemaakte ID.
             */
            $conn = Database::start();

            $result = $conn->query(
                "SELECT klant_id
                 FROM klanten
                 ORDER BY klant_id DESC
                 LIMIT 1"
            );

            $row = $result->fetch_assoc();

            $klantId = $row["klant_id"];

            $conn->close();
        }

        /*
         * Controleert of de campingplek bestaat.
         */
        if (empty($fout)) {

            $campingplek = Kampeerplaats::findById($plaatsId);

            if ($campingplek == null) {
                $fout = "De gekozen campingplek bestaat niet.";
            }
        }

        /*
         * Controleert of de campingplek beschikbaar is
         * voor de gekozen periode.
         */
        if (empty($fout)) {

            if (!Kampeerplaats::isBeschikbaarVoorPeriode(
                $plaatsId,
                $start,
                $einde
            )) {

                $fout = "Deze campingplek is in de gekozen periode al gereserveerd.";
            }
        }

        if (empty($fout)) {

            /*
             * Berekenen hoeveel nachten de reservering duurt.
             */
            $startTijd = new DateTime($start);
            $eindTijd = new DateTime($einde);

            $verschil = $startTijd->diff($eindTijd);
            $nachten = $verschil->days;

            if ($nachten < 1) {
                $nachten = 1;
            }

            /*
             * Prijs van de campingplek.
             */
            $totaal = $nachten * $campingplek->nachtprijs;

            /*
             * Nieuwe boeking maken.
             */
            $boeking = new Boeking();

            $boeking->klantId = $klantId;
            $boeking->plaatsId = $plaatsId;
            $boeking->datumAankomst = $start;
            $boeking->datumVertrek = $einde;
            $boeking->volwassenen = $volwassenen;
            $boeking->kinderen = $kinderen;
            $boeking->status = "gereserveerd";

            $boekingId = $boeking->insert();

            /*
             * Volwassenen en kinderen als tarieven opslaan.
             */
            foreach ($tarieven as $tarief) {

                $aantal = 0;

                if ($tarief->naam == "Volwassene") {
                    $aantal = $volwassenen;
                }

                if (
                    $tarief->naam == "Kinderen van 4 tot 12 jaar"
                    || $tarief->naam == "Kinderen 4-12"
                ) {
                    $aantal = $kinderen;
                }

                if ($aantal > 0) {

                    $regel = new BoekingExtra();

                    $regel->boekingId = $boekingId;
                    $regel->dienstId = $tarief->id;
                    $regel->aantal = $aantal;

                    $regel->insert();

                    $totaal += $aantal * $tarief->prijs;
                }
            }

            /*
             * Geselecteerde extra tarieven verwerken.
             */
            if (isset($_POST["tarief"])) {

                foreach ($_POST["tarief"] as $dienstId => $aantal) {

                    $aantal = (int) $aantal;

                    if ($aantal > 0) {

                        $tarief = Tarief::findById($dienstId);

                        if ($tarief != null) {

                            $regel = new BoekingExtra();

                            $regel->boekingId = $boekingId;
                            $regel->dienstId = $dienstId;
                            $regel->aantal = $aantal;

                            $regel->insert();

                            $totaal += $aantal * $tarief->prijs;
                        }
                    }
                }
            }

            /*
             * Factuur maken.
             */
            $rekening = new Rekening();

            $rekening->boekingId = $boekingId;
            $rekening->aangemaaktOp = date("Y-m-d H:i:s");
            $rekening->totaalbedrag = $totaal;
            $rekening->betaalstatus = $betaalstatus;

            $factuurId = $rekening->insert();

            /*
             * Factuurregel voor de campingplek.
             */
            $regel = new RekeningRegel();

            $regel->rekeningId = $factuurId;
            $regel->omschrijving = "Campingplek per nacht";
            $regel->aantal = $nachten;
            $regel->prijsPerStuk = $campingplek->nachtprijs;
            $regel->regelTotaal = $nachten * $campingplek->nachtprijs;

            $regel->insert();

            /*
             * Factuurregels voor de volwassenen en kinderen.
             */
            foreach ($tarieven as $tarief) {

                $aantal = 0;

                if ($tarief->naam == "Volwassene") {
                    $aantal = $volwassenen;
                }

                if (
                    $tarief->naam == "Kinderen van 4 tot 12 jaar"
                    || $tarief->naam == "Kinderen 4-12"
                ) {
                    $aantal = $kinderen;
                }

                if ($aantal > 0) {

                    $regel = new RekeningRegel();

                    $regel->rekeningId = $factuurId;
                    $regel->omschrijving = $tarief->naam;
                    $regel->aantal = $aantal;
                    $regel->prijsPerStuk = $tarief->prijs;
                    $regel->regelTotaal = $aantal * $tarief->prijs;

                    $regel->insert();
                }
            }

            /*
             * Factuurregels voor extra tarieven.
             */
            if (isset($_POST["tarief"])) {

                foreach ($_POST["tarief"] as $dienstId => $aantal) {

                    $aantal = (int) $aantal;

                    if ($aantal > 0) {

                        $tarief = Tarief::findById($dienstId);

                        if ($tarief != null) {

                            $regel = new RekeningRegel();

                            $regel->rekeningId = $factuurId;
                            $regel->omschrijving = $tarief->naam;
                            $regel->aantal = $aantal;
                            $regel->prijsPerStuk = $tarief->prijs;
                            $regel->regelTotaal = $aantal * $tarief->prijs;

                            $regel->insert();
                        }
                    }
                }
            }

            /*
             * De campingplek wordt op niet beschikbaar gezet.
             */
            $campingplek->beschikbaar = 0;
            $campingplek->update();

            $gelukt = true;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="nl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Nieuwe Reservering</title>

    <link rel="stylesheet" href="../../css/Medewerker.css">

</head>

<body>

    <div class="header">

        <div>

            <h1>Nieuwe Reservering</h1>

            <p>
                Maak een nieuwe reservering voor Camping La Rustique
            </p>

        </div>

    </div>


    <nav class="navigation">

        <a href="../Dashboard.php">
            Dashboard
        </a>

        <a href="../Reserveringen.php" class="active">
            Reserveringen
        </a>

        <a href="../Klanten.php">
            Klanten
        </a>

        <a href="../Facturen.php">
            Facturen & Betaling
        </a>

        <a href="../Campingplekken.php">
            Campingplekken
        </a>

        <a href="../Medewerkers.php">
            Medewerkers
        </a>

        <a href="../Tarievenlijst.php">
            Tarievenlijst
        </a>

    </nav>


    <div class="medewerker-reservering-container">

        <?php if (!empty($fout)) { ?>

            <div class="medewerker-melding medewerker-fout">

                <?= htmlspecialchars($fout) ?>

            </div>

        <?php } ?>


        <?php if ($gelukt) { ?>

            <div class="medewerker-melding medewerker-gelukt">

                De reservering is succesvol aangemaakt.

                <div class="medewerker-knoppen">

                    <a
                        href="../../Facturen/Afdrukken.php?id=<?= $factuurId ?>"
                        class="medewerker-print-knop"
                        target="_blank"
                    >
                        Factuur afdrukken
                    </a>

                    <a
                        href="../Reserveringen.php"
                        class="medewerker-terug-knop"
                    >
                        Terug naar Reserveringen
                    </a>

                </div>

            </div>

        <?php } else { ?>

            <form method="POST">

                <div class="medewerker-form-card">

                    <h2>Klant</h2>

                    <div class="medewerker-keuze">

                        <button
                            type="button"
                            id="bestaandeKlantKnop"
                            class="active"
                        >
                            Bestaande klant
                        </button>

                        <button
                            type="button"
                            id="nieuweKlantKnop"
                        >
                            Nieuwe klant
                        </button>

                    </div>


                    <input
                        type="hidden"
                        name="klant_keuze"
                        id="klant_keuze"
                        value="bestaand"
                    >


                    <div
                        id="bestaandeKlant"
                        class="medewerker-klant-sectie active"
                    >

                        <div class="medewerker-form-group">

                            <label>
                                Kies een klant
                            </label>

                            <select name="klant_id">

                                <option value="">
                                    Kies een klant
                                </option>

                                <?php foreach ($klanten as $klant) { ?>

                                    <option value="<?= $klant->id ?>">

                                        <?= htmlspecialchars($klant->naam) ?>
                                        -
                                        <?= htmlspecialchars($klant->email) ?>

                                    </option>

                                <?php } ?>

                            </select>

                        </div>

                    </div>


                    <div
                        id="nieuweKlant"
                        class="medewerker-klant-sectie"
                    >

                        <div class="medewerker-form-grid">

                            <div class="medewerker-form-group">

                                <label>
                                    Volledige naam
                                </label>

                                <input
                                    type="text"
                                    name="naam"
                                >

                            </div>


                            <div class="medewerker-form-group">

                                <label>
                                    E-mailadres
                                </label>

                                <input
                                    type="email"
                                    name="email"
                                >

                            </div>


                            <div class="medewerker-form-group">

                                <label>
                                    Telefoonnummer
                                </label>

                                <input
                                    type="text"
                                    name="telefoonnummer"
                                >

                            </div>


                            <div class="medewerker-form-group">

                                <label>
                                    Straat
                                </label>

                                <input
                                    type="text"
                                    name="straat"
                                >

                            </div>


                            <div class="medewerker-form-group">

                                <label>
                                    Postcode
                                </label>

                                <input
                                    type="text"
                                    name="postcode"
                                >

                            </div>


                            <div class="medewerker-form-group">

                                <label>
                                    Woonplaats
                                </label>

                                <input
                                    type="text"
                                    name="woonplaats"
                                >

                            </div>

                        </div>

                    </div>

                </div>


                <div class="medewerker-form-card">

                    <h2>Periode</h2>

                    <div class="medewerker-form-grid">

                        <div class="medewerker-form-group">

                            <label>
                                Startdatum en tijd
                            </label>

                            <input
                                type="datetime-local"
                                name="datum_aankomst"
                                id="datum_aankomst"
                                required
                            >

                        </div>


                        <div class="medewerker-form-group">

                            <label>
                                Einddatum en tijd
                            </label>

                            <input
                                type="datetime-local"
                                name="datum_vertrek"
                                id="datum_vertrek"
                                required
                            >

                        </div>

                    </div>

                </div>


                <div class="medewerker-form-card">

                    <h2>Campingplek</h2>

                    <div class="medewerker-plek-filter">

                        <label>

                            <input
                                type="checkbox"
                                id="alleenBeschikbaar"
                                checked
                            >

                            Alleen beschikbare campingplekken tonen

                        </label>

                    </div>


                    <div class="medewerker-plek-overzicht">

                        <?php foreach ($campingplekken as $plek) { ?>

                            <label
                                class="medewerker-plek <?= !$plek->beschikbaar ? 'niet-beschikbaar' : '' ?>"
                                data-beschikbaar="<?= $plek->beschikbaar ?>"
                            >

                                <input
                                    type="radio"
                                    name="plaats_id"
                                    value="<?= $plek->id ?>"
                                    <?= !$plek->beschikbaar ? "disabled" : "" ?>
                                    required
                                >

                                <strong>
                                    Plaats <?= htmlspecialchars($plek->plaatsNummer) ?>
                                </strong>

                                <br>

                                Categorie:
                                <?= htmlspecialchars($plek->categorie) ?>

                                <br>

                                €
                                <?= number_format(
                                    $plek->nachtprijs,
                                    2,
                                    ",",
                                    "."
                                ) ?>
                                per nacht

                                <br>

                                <?php if ($plek->beschikbaar) { ?>

                                    <span class="medewerker-beschikbaar">
                                        Beschikbaar
                                    </span>

                                <?php } else { ?>

                                    <span class="medewerker-niet-beschikbaar">
                                        Niet beschikbaar
                                    </span>

                                <?php } ?>

                            </label>

                        <?php } ?>

                    </div>

                </div>


                <div class="medewerker-form-card">

                    <h2>Personen</h2>

                    <div class="medewerker-form-grid">

                        <div class="medewerker-form-group">

                            <label>
                                Volwassenen
                            </label>

                            <input
                                type="number"
                                name="volwassenen"
                                id="volwassenen"
                                value="1"
                                min="0"
                            >

                        </div>


                        <div class="medewerker-form-group">

                            <label>
                                Kinderen van 4 tot 12 jaar
                            </label>

                            <input
                                type="number"
                                name="kinderen"
                                id="kinderen"
                                value="0"
                                min="0"
                            >

                        </div>

                    </div>

                </div>


                <div class="medewerker-form-card">

                    <h2>Extra tarieven</h2>

                    <div class="medewerker-tarieven">

                        <?php foreach ($tarieven as $tarief) { ?>

                            <?php

                            /*
                             * Volwassenen en kinderen worden hierboven
                             * apart ingevuld.
                             */

                            if (
                                $tarief->naam == "Volwassene"
                                || $tarief->naam == "Kinderen van 4 tot 12 jaar"
                                || $tarief->naam == "Kinderen 4-12"
                            ) {
                                continue;
                            }

                            ?>

                            <div class="medewerker-tarief">

                                <div class="medewerker-tarief-links">

                                    <input
                                        type="checkbox"
                                        class="tarief-checkbox"
                                        data-prijs="<?= $tarief->prijs ?>"
                                    >

                                    <span>

                                        <?= htmlspecialchars($tarief->naam) ?>

                                        <br>

                                        <span class="medewerker-prijs">

                                            €

                                            <?= number_format(
                                                $tarief->prijs,
                                                2,
                                                ",",
                                                "."
                                            ) ?>

                                        </span>

                                    </span>

                                </div>


                                <input
                                    type="number"
                                    name="tarief[<?= $tarief->id ?>]"
                                    value="0"
                                    min="0"
                                    class="tarief-aantal"
                                    data-prijs="<?= $tarief->prijs ?>"
                                >

                            </div>

                        <?php } ?>

                    </div>

                </div>


                <div class="medewerker-form-card">

                    <h2>Betaling</h2>

                    <div class="medewerker-form-group">

                        <label>
                            Betaalstatus
                        </label>

                        <select name="betaalstatus">

                            <option value="openstaand">
                                Openstaand
                            </option>

                            <option value="betaald">
                                Betaald
                            </option>

                        </select>

                    </div>


                    <div class="medewerker-totaal-box">

                        <div>
                            Totaalbedrag
                        </div>

                        <div
                            class="medewerker-totaal"
                            id="totaalBedrag"
                        >
                            € 0,00
                        </div>

                    </div>


                    <div class="medewerker-knoppen">

                        <button
                            type="submit"
                            class="medewerker-reserveer-knop"
                        >
                            Reserveren
                        </button>

                        <a
                            href="../Reserveringen.php"
                            class="medewerker-terug-knop"
                        >
                            Annuleren
                        </a>

                    </div>

                </div>

            </form>

        <?php } ?>

    </div>


    <script src="../../js/NieuweReservering.js"></script>

</body>

</html>