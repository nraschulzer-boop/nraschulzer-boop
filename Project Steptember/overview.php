<?php
include "sessie.php";
include "stap.php";
include "connectie.php";
include "gebruiker.php";

// Check of er een actieve sessie is
$sessie = Sessie::vindActieveSessie();

// Controle of sessie bestaat (extra veilig)
if (!$sessie) {
    die("Geen actieve sessie gevonden. Log eerst in.");
}

// Haal de gebruiker op die hoort bij de sessie
$gebruiker = Gebruiker::vindAdmin($sessie->session_user_id);

// Haal stappen op: alles als admin, of alleen eigen stappen
if ($gebruiker && $gebruiker->userAdmin == "1") {
    $stappen = Stap::vindAlleStappen();
} else {
    $stappen = Stap::vindStappen($sessie->session_user_id);
}

// Totale en gemiddelde stappen berekenen
$totaalStappen = 0;
$gemiddeldeStappen = 0;
$aantalStappen = count($stappen);

if ($stappen) {
    foreach ($stappen as $stap) {
        $totaalStappen += (int)$stap->stepTotal;
    }
    $gemiddeldeStappen = $aantalStappen > 0 ? round($totaalStappen / $aantalStappen, 2) : 0;
}
?>

<!doctype html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Overzicht</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="Steptember.css" rel="stylesheet">
</head>
<body id="body">
    <div class="container">
        <div class="row">
            <div class="col-4 text-center" id="welkom" style="margin-top: 250px; border: 2px solid black;">
                <h1>Welkom <?= htmlspecialchars($gebruiker->userFirstname) ?>!</h1>
            </div>
            <div class="col-8 d-flex justify-content-end"></div>
        </div>

        <div class="row">
            <div class="col">
                <div class="row justify-content-center" style="margin-top: -300px; margin-left: 650px;">
                    <div class="col-6">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">Datum</th>
                                        <th scope="col">Stappen per dag</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($stappen as $stap): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($stap->stepDate) ?></td>
                                            <td><?= htmlspecialchars($stap->stepTotal) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Totaal & gemiddelde -->
                    <div class="col-6">
                        <div class="table-responsive mt-3">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">Gemiddelde stappen</th>
                                        <th scope="col">Totaal aantal stappen</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?= $gemiddeldeStappen ?></td>
                                        <td><?= $totaalStappen ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
