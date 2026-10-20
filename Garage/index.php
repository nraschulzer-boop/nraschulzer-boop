<?php
// Importeer de benodigde klassen
include "Classes/database.php";
include "Classes/customer.php";

// Haal alle klanten op via de statische methode van de Klant-klasse
$klanten = Klant::alleKlanten();
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Instellingen voor tekencodering en mobiele weergave -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS-stijlen en iconen -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="CSS/style.css" rel="stylesheet">
</head>

<body>
    <!-- Navigatiebalk -->
    <nav class="navbar navbar-expand-lg py-4 px-4">
        <div class="container-fluid">
            <!-- Link naar klantenoverzicht -->
            <a class="navbar-brand fs-3 fw-semibold" href="index.php">Overzicht van klanten</a>
            <!-- Toggle-knop voor mobiele weergave -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Link naar bestellingen -->
            <a class="navbar-brand fs-3 fw-semibold" href="orders.php">Overzicht van bestellingen</a>
            <!-- Opnieuw een toggle-knop voor navigatie -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Link naar producten -->
            <a class="navbar-brand fs-3 fw-semibold" href="products.php">Overzicht van producten</a>
            <!-- Wederom toggle voor mobiel menu -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <!-- Container voor klantenoverzicht -->
    <div class="container mt-4">
        <h1 class="text-center mb-4">Overzicht van klanten</h1>

        <!-- Tabel om klantgegevens weer te geven -->
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Voornaam</th>
                    <th>Achternaam</th>
                    <th>Adres</th>
                    <th>Postcode</th>
                    <th>Woonplaats</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop door alle klanten en toon ze in rijen -->
                <?php foreach ($klanten as $klant): ?>
                    <tr>
                        <!-- Gebruik htmlspecialchars om XSS-aanvallen te voorkomen -->
                        <td><?= htmlspecialchars($klant->id) ?></td>
                        <td><?= htmlspecialchars($klant->firstname) ?></td>
                        <td><?= htmlspecialchars($klant->lastname) ?></td>
                        <td><?= htmlspecialchars($klant->address) ?></td>
                        <td><?= htmlspecialchars($klant->zipcode) ?></td>
                        <td><?= htmlspecialchars($klant->city) ?></td>
                        <td><?= htmlspecialchars($klant->email) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- JavaScript-bestanden voor Bootstrap-functionaliteit -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
        crossorigin="anonymous"></script>
</body>

</html>