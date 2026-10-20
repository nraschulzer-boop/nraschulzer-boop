<?php
// Laad de vereiste klassen in
include 'Classes/database.php';
include 'Classes/order.php';
include 'Classes/customer.php';
include 'Classes/orderLine.php';
include 'Classes/product.php';

// Controleer of een order_id is meegegeven via de URL
if (!isset($_GET['order_id'])) {
    http_response_code(400); // Foutmelding: Bad Request
    die("Fout: Geen order ID opgegeven.");
}

$orderId = $_GET['order_id'];

// Haal de order, bijbehorende klant en orderregels op
$order = Order::vindOrderOpId($orderId);
$klant = $order ? Klant::vindKlantOpId($order->customerId) : null;
$orderregels = $order ? OrderLine::vindOrderRegelsBijOrderId($order->id) : null;

// Controleer of alles succesvol is opgehaald
if (!$order || !$klant || !$orderregels) {
    if (!$order) {
        http_response_code(404); // Foutmelding: Order niet gevonden
        die("Fout: Order niet gevonden.");
    } elseif (!$klant) {
        http_response_code(404); // Foutmelding: Klant niet gevonden
        die("Fout: Klant niet gevonden.");
    } elseif (!$orderregels || count($orderregels) === 0) {
        http_response_code(404); // Foutmelding: Geen orderregels gevonden
        die("Fout: Geen orderregels gevonden voor deze bestelling.");
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Factuur #<?= htmlspecialchars($order->id) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS en fonts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="CSS/style.css" rel="stylesheet">

    <!-- Interne CSS voor de factuur-layout -->
    <style>
        .container {
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
            padding: 20px;
            margin-top: 70px;
        }
    </style>
</head>

<body>

    <!-- Navigatiebalk -->
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary py-4 px-4">
            <div class="container-fluid">
                <a class="navbar-brand fs-3 fw-semibold" href="index.php">Overzicht van klanten</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                    aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand fs-3 fw-semibold" href="orders.php">Overzicht van bestellingen</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                    aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand fs-3 fw-semibold" href="products.php">Overzicht van producten</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                    aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>
    </header>

    <!-- Extra stijl voor factuurbox -->
    <style>
        .factuur-border {
            border: 2px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
            background-color: #f9f9f9;
        }
    </style>

    <!-- Hoofdinhoud: Factuur -->
    <div class="container">
        <div class="factuur-border">
            <!-- Ordergegevens -->
            <h1>Factuur #<?= htmlspecialchars($order->id) ?></h1>
            <p><strong>Datum:</strong> <?= htmlspecialchars($order->date) ?></p>
            <p><strong>Status:</strong> <?= $order->paid ? "Betaald" : "Niet betaald" ?></p>

            <hr>

            <!-- Klantinformatie -->
            <h3>Klantinformatie</h3>
            <p><strong>Naam:</strong> <?= htmlspecialchars($klant->firstname . ' ' . $klant->lastname) ?></p>
            <p><strong>Adres:</strong> <?= htmlspecialchars($klant->address) ?>, <?= htmlspecialchars($klant->zipcode) ?> <?= htmlspecialchars($klant->city) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($klant->email) ?></p>

            <hr>

            <!-- Tabel met bestelde producten -->
            <h3>Bestelde Producten</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Productnaam</th>
                        <th>Categorie</th>
                        <th>Prijs per stuk</th>
                        <th>Aantal</th>
                        <th>Totaal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Totaalprijs initiëren
                    $totaalPrijs = 0;
                    foreach ($orderregels as $regel):
                        // Haal het product op bij elke regel
                        $product = Product::vindProductOpId($regel->productId);
                        if ($product):
                            $subtotaal = $regel->quantity * $product->price;
                            $totaalPrijs += $subtotaal;
                    ?>
                            <!-- Toon productregel -->
                            <tr>
                                <td><?= htmlspecialchars($product->name) ?></td>
                                <td><?= htmlspecialchars($product->category) ?></td>
                                <td>€ <?= number_format($product->price, 2, ',', '.') ?></td>
                                <td><?= htmlspecialchars($regel->quantity) ?></td>
                                <td>€ <?= number_format($subtotaal, 2, ',', '.') ?></td>
                            </tr>
                    <?php endif;
                    endforeach; ?>
                </tbody>
                <!-- Totaal van de bestelling -->
                <tfoot>
                    <tr>
                        <th colspan="4" class="text-end">Totaal:</th>
                        <th>€ <?= number_format($totaalPrijs, 2, ',', '.') ?></th>
                    </tr>
                </tfoot>
            </table>

            <!-- Terugknop -->
            <a href="orders.php" class="btn btn-primary">Ga terug</a>
        </div>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>