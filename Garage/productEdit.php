<?php
include "Classes/database.php";
include "Classes/product.php";

// Controleer of er een product-ID is opgegeven via de URL
if (!isset($_GET['id'])) {
    header("Location: products.php?error=Geen+product+ID+opgegeven");
    exit;
}

$id = $_GET['id'];

// Zoek het product op aan de hand van het ID
$product = Product::vindProductOpId($id);

if (!$product) {
    header("Location: products.php?error=Product+niet+gevonden");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Vul de nieuwe waarden in het product-object
    $product->name = $_POST["product_name"];
    $product->category = $_POST["product_category"];
    $product->price = $_POST["product_price"];
    $product->instock = $_POST["product_instock"];

    // Werk product bij via methode in de Product klasse
    $product->Aanpassen();

    // Redirect met succesmelding
    header("Location: products.php?message=Product+bijgewerkt");
    exit;
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Product bewerken</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="CSS/style.css" rel="stylesheet">
</head>

<body>

    <!-- Navigatiebalk -->
    <nav class="navbar navbar-expand-lg py-4 px-4">
        <div class="container-fluid">
            <a class="navbar-brand fs-3 fw-semibold" href="index.php">Overzicht van klanten</a>
            <a class="navbar-brand fs-3 fw-semibold" href="orders.php">Overzicht van bestellingen</a>
            <a class="navbar-brand fs-3 fw-semibold" href="products.php">Overzicht van producten</a>
        </div>
    </nav>

    <!-- Formulier voor het bewerken van een product -->
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Product bewerken</h1>

        <form method="POST">
            <div class="mb-3">
                <label for="product_name" class="form-label">Productnaam</label>
                <input type="text" class="form-control" id="product_name" name="product_name" value="<?= htmlspecialchars($product->name) ?>" required>
            </div>

            <div class="mb-3">
                <label for="product_category" class="form-label">Categorie</label>
                <input type="text" class="form-control" id="product_category" name="product_category" value="<?= htmlspecialchars($product->category) ?>" required>
            </div>

            <div class="mb-3">
                <label for="product_price" class="form-label">Prijs</label>
                <input type="number" step="0.01" class="form-control" id="product_price" name="product_price" value="<?= htmlspecialchars($product->price) ?>" required>
            </div>

            <div class="mb-3">
                <label for="product_instock" class="form-label">Aantal op voorraad</label>
                <input type="number" class="form-control" id="product_instock" name="product_instock" value="<?= htmlspecialchars($product->instock) ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Opslaan</button>
            <a href="products.php" class="btn btn-secondary">Annuleren</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
