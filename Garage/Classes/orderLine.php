<?php

// Klasse die een orderregel representeert (één regel in een bestelling met een specifiek product)
class OrderLine
{
    // Eigenschappen van een orderregel
    public string $id;
    public string $orderId;
    public string $productId;
    public string $quantity;

    // Haalt alle orderregels op die horen bij een specifieke bestelling (order ID)
    public static function vindOrderRegelsBijOrderId($orderId)
    {
        // Start een nieuwe databaseverbinding
        $conn = Database::start();

        // Maak het order ID veilig voor gebruik in de SQL-query
        $orderId = mysqli_real_escape_string($conn, $orderId);

        // SQL-query om alle regels op te halen die bij de opgegeven order horen
        $query = "SELECT * FROM order_lines WHERE order_line_order_id = '$orderId'";
        $resultaat = $conn->query($query);

        $orderRegels = [];

        // Als er resultaten zijn, maak voor elke rij een nieuw OrderLine-object aan
        if ($resultaat->num_rows > 0) {
            while ($row = $resultaat->fetch_assoc()) {
                $orderLine = new OrderLine();
                $orderLine->id = $row['order_line_id'];
                $orderLine->orderId = $row['order_line_order_id'];
                $orderLine->productId = $row['order_line_product_id'];
                $orderLine->quantity = $row['order_line_quantity'];
                $orderRegels[] = $orderLine; // Voeg toe aan de lijst met orderregels
            }
        }

        // Sluit de databaseverbinding
        $conn->close();

        // Retourneer de lijst met orderregels
        return $orderRegels;
    }

    // Haalt één specifieke orderregel op aan de hand van het orderregel-ID
    public static function vindOrderRegelOpId($orderLineId)
    {
        // Start een nieuwe databaseverbinding
        $conn = Database::start();

        // Maak het orderregel ID veilig voor gebruik in de SQL-query
        $orderLineId = mysqli_real_escape_string($conn, $orderLineId);

        // SQL-query om de specifieke orderregel op te halen
        $query = "SELECT * FROM order_lines WHERE order_line_id = '$orderLineId'";
        $resultaat = $conn->query($query);

        $orderLine = null;

        // Als er een resultaat is, maak een nieuw OrderLine-object aan en vul de eigenschappen
        if ($resultaat->num_rows > 0) {
            $row = $resultaat->fetch_assoc();

            $orderLine = new OrderLine();
            $orderLine->id = $row['order_line_id'];
            $orderLine->orderId = $row['order_line_order_id'];
            $orderLine->productId = $row['order_line_product_id'];
            $orderLine->quantity = $row['order_line_quantity'];
        }

        // Sluit de databaseverbinding
        $conn->close();

        // Retourneer het orderregel-object of null als niet gevonden
        return $orderLine;
    }
}
