<?php
// Inclusie van database en product klassen
include "Classes/database.php";
include "Classes/product.php";

// Ophalen van alle producten via de Product klasse
$producten = Product::haalAlleProductenOp();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap icons en CSS toevoegen -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="CSS/style.css" rel="stylesheet">
</head>

<body>
    <!-- Navigatiebalk bovenaan de pagina -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary py-4 px-4">
        <div class="container-fluid">
            <!-- Link naar klantenoverzicht -->
            <a class="navbar-brand fs-3 fw-semibold" href="index.php">Overzicht van klanten</a>
            <!-- Responsive toggler knop -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Link naar bestellingenoverzicht -->
            <a class="navbar-brand fs-3 fw-semibold" href="orders.php">Overzicht van bestellingen</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Link naar productenoverzicht -->
            <a class="navbar-brand fs-3 fw-semibold" href="products.php">Overzicht van producten</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-10">
                <!-- Titel en knop om een nieuw product toe te voegen -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="text-center flex-grow-1 mb-0">Overzicht van producten</h1>
                    <a href="productAdd.php" class="btn btn-dark ms-3">Toevoegen</a>
                </div>

                <!-- Tabel met alle producten -->
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <!-- Kolomkoppen -->
                            <th>ID</th>
                            <th>Product name</th>
                            <th>Product category</th>
                            <th>Product price</th>
                            <th>Product in stock</th>
                            <th>Acties</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Loop door alle producten en toon ze in de tabel -->
                        <?php foreach ($producten as $product): ?>
                            <tr>
                                <td><?= htmlspecialchars($product->id) ?></td> <!-- Product ID -->
                                <td><?= htmlspecialchars($product->name) ?></td> <!-- Naam product -->
                                <td><?= htmlspecialchars($product->category) ?></td> <!-- Categorie -->
                                <td><?= htmlspecialchars($product->price) ?></td> <!-- Prijs -->
                                <td><?= htmlspecialchars($product->instock) ?></td> <!-- Voorraad -->
                                <td>
                                    <!-- Actieknoppen: aanpassen en verwijderen -->
                                    <div style="display: flex; gap: 10px;">
                                        <a href="productEdit.php?id=<?= $product->id ?>" class="btn btn-dark">Aanpassen</a>
                                        <a href="productDelete.php?id=<?= $product->id ?>" class="btn btn-dark" onclick="return confirm('Weet je zeker dat je dit product wilt verwijderen?')">Verwijderen</a>
                                    </div>
                                </td>
                            </tr>
                            <!-- Ruimte tussen rijen -->
                            <tr>
                                <td colspan="6" style="height: 10px;"></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="col">
                <!-- Berichtweergave: foutmeldingen of succesberichten tonen -->
                <?php if (isset($_GET["message"]) || isset($_GET["error"])): ?>
                    <div class="error-message">
                        <?php if (isset($_GET["message"])): ?>
                            <?= htmlspecialchars($_GET["message"]) ?>
                        <?php endif; ?>

                        <?php if (isset($_GET["error"])): ?>
                            <div class="error-message">
                                <?= htmlspecialchars($_GET["error"]) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap JavaScript toevoegen -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
        crossorigin="anonymous"></script>
</body>

</html>