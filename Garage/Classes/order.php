<?php

// Klasse die een bestelling (order) representeert en functies bevat om bestellingen op te halen uit de database
class Order
{
    // Eigenschappen van een bestelling
    public string $id;
    public string $customerId;
    public string $date;
    public string $paid;

    // Zoek een specifieke order op basis van het order-ID
    public static function vindOrderOpId($orderId)
    {
        // Start een databaseverbinding
        $conn = Database::start();

        // Maak het order-ID veilig voor gebruik in een SQL-query
        $orderId = mysqli_real_escape_string($conn, $orderId);

        // SQL-query om de order op te halen
        $query = "SELECT * FROM orders WHERE order_id = '$orderId'";
        $resultaat = $conn->query($query);

        $order = null;

        // Als er een resultaat is, maak een orderobject aan en vul de eigenschappen
        if ($resultaat->num_rows > 0) {
            $row = $resultaat->fetch_assoc();

            $order = new Order();
            $order->id = $row['order_id'];
            $order->customerId = $row['order_customer_id'];
            $order->date = $row['order_date'];
            $order->paid = $row['order_paid'];
        }

        // Sluit de databaseverbinding
        $conn->close();

        // Retourneer het orderobject of null als er geen resultaat is
        return $order;
    }

    // Haal alle orders op die bij een specifieke klant horen
    public static function vindOrdersVanKlant($customerId)
    {
        // Start een databaseverbinding
        $conn = Database::start();

        // Maak het klant-ID veilig voor gebruik in een SQL-query
        $customerId = mysqli_real_escape_string($conn, $customerId);

        // SQL-query om alle orders van de klant op te halen, gesorteerd op datum (nieuwste eerst)
        $query = "SELECT * FROM orders WHERE order_customer_id = '$customerId' ORDER BY order_date DESC";
        $resultaat = $conn->query($query);

        $orders = [];

        // Loop door de resultaten en maak voor elke rij een orderobject aan
        if ($resultaat->num_rows > 0) {
            while ($row = $resultaat->fetch_assoc()) {
                $order = new Order();
                $order->id = $row['order_id'];
                $order->customerId = $row['order_customer_id'];
                $order->date = $row['order_date'];
                $order->paid = $row['order_paid'];
                $orders[] = $order;
            }
        }

        // Sluit de databaseverbinding
        $conn->close();

        // Retourneer een lijst met orders van de klant
        return $orders;
    }

    // Haal alle bestellingen op uit de database
    public static function alleOrders()
    {
        // Start een databaseverbinding
        $conn = Database::start();

        // SQL-query om alle orders op te halen
        $query = "SELECT * FROM orders";
        $resultaat = $conn->query($query);

        $orders = [];

        // Loop door de resultaten en maak een lijst van orderobjecten
        if ($resultaat->num_rows > 0) {
            while ($row = $resultaat->fetch_assoc()) {
                $order = new Order();
                $order->id = $row['order_id'];
                $order->customerId = $row['order_customer_id'];
                $order->date = $row['order_date'];
                $order->paid = $row['order_paid'];
                $orders[] = $order;
            }
        }

        // Sluit de databaseverbinding
        $conn->close();

        // Retourneer de lijst met alle orders
        return $orders;
    }
}
