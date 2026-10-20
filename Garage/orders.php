<?php
// Laad de vereiste klassen voor databaseverbinding en orderfunctionaliteit
include "Classes/database.php";
include "Classes/order.php";

// Haal alle bestellingen op uit de database via de Order-klasse
$orders = Order::alleOrders();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="CSS/style.css" rel="stylesheet">
</head>

<body>

    <!-- Navigatiebalk met links naar de overzichten -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary py-4 px-4">
        <div class="container-fluid">
            <!-- Link naar klantenoverzicht -->
            <a class="navbar-brand fs-3 fw-semibold" href="index.php">Overzicht van klanten</a>
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

    <!-- Hoofdcontainer met het overzicht van bestellingen -->
    <div class="container mt-4">
        <h1 class="text-center mb-4">Overzicht van bestellingen</h1>

        <!-- Tabel met bestelinformatie -->
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Order klant ID</th>
                    <th>Besteldatum</th>
                    <th>Betaald</th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop door elke order heen en toon de gegevens -->
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= htmlspecialchars($order->id) ?></td>
                        <td><?= htmlspecialchars($order->customerId) ?></td>
                        <td><?= htmlspecialchars($order->date) ?></td>
                        <td><?= htmlspecialchars($order->paid) ?></td>
                        <td>
                            <!-- Actieknop om factuur te bekijken -->
                            <div style="display: flex; gap: 10px;">
                                <a href="invoice.php?order_id=<?= $order->id ?>" class="btn btn-success">Factuur</a>
                            </div>
                        </td>
                    </tr>
                    <!-- Visuele ruimte tussen rijen -->
                    <tr>
                        <td colspan="5" style="height: 10px;"></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
        crossorigin="anonymous"></script>
</body>

</html>
