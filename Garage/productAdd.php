<?php
// Laad de database- en productklasse
include "Classes/database.php";
include "Classes/product.php";

// Verwerk het formulier als het verzonden is via POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Maak een nieuw Product-object aan en vul de gegevens vanuit het formulier
    $nieuwProduct = new Product();
    $nieuwProduct->name = $_POST["product_name"];
    $nieuwProduct->category = $_POST["product_category"];
    $nieuwProduct->price = $_POST["product_price"];
    $nieuwProduct->instock = $_POST["product_instock"];

    // Voeg het product toe aan de database
    $nieuwProduct->Toevoegen();

    // Redirect naar de productenpagina met een succesbericht
    header("Location: products.php?message=product+is+toegevoegd");
    exit;
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="CSS/style.css" rel="stylesheet">

    <title>Product toevoegen</title>
</head>

<body>

    <!-- Navigatiebalk bovenin -->
    <nav class="navbar navbar-expand-lg py-4 px-4">
        <div class="container-fluid">
            <!-- Navigatielinks naar andere overzichtspagina's -->
            <a class="navbar-brand fs-3 fw-semibold" href="index.php">Overzicht van klanten</a>
            <a class="navbar-brand fs-3 fw-semibold" href="orders.php">Overzicht van bestellingen</a>
            <a class="navbar-brand fs-3 fw-semibold" href="products.php">Overzicht van producten</a>
          
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <!-- Hoofdcontainer met formulier -->
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Nieuw product toevoegen</h1>

        <!-- Formulier voor productgegevens -->
        <form method="POST" action="">
            <!-- Productnaam invoerveld -->
            <div class="mb-3">
                <label for="product_name" class="form-label">Productnaam</label>
                <input type="text" class="form-control" id="product_name" name="product_name" required>
            </div>

            <!-- Categorie invoerveld -->
            <div class="mb-3">
                <label for="product_category" class="form-label">Categorie</label>
                <input type="text" class="form-control" id="product_category" name="product_category" required>
            </div>

            <!-- Prijs invoerveld -->
            <div class="mb-3">
                <label for="product_price" class="form-label">Prijs</label>
                <input type="number" step="0.01" class="form-control" id="product_price" name="product_price" required>
            </div>

            <!-- Voorraad invoerveld -->
            <div class="mb-3">
                <label for="product_instock" class="form-label">Aantal op voorraad</label>
                <input type="number" class="form-control" id="product_instock" name="product_instock" required>
            </div>

            <!-- Knoppen: toevoegen of annuleren -->
            <button type="submit" class="btn btn-success">Toevoegen</button>
            <a href="products.php" class="btn btn-secondary">Annuleren</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
