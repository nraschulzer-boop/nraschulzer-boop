<?php

// Klasse die een product representeert
class Product
{
    // Eigenschappen van een product
    public string $id;
    public string $name;
    public string $category;
    public string $price;
    public string $instock;

    // Haalt één product op op basis van het opgegeven product-ID
    public static function vindProductOpId($productId)
    {
        // Start een databaseverbinding
        $conn = Database::start();

        // Maakt het ID veilig voor gebruik in SQL
        $productId = mysqli_real_escape_string($conn, $productId);

        // Query om het product met het opgegeven ID op te halen
        $query = "SELECT * FROM products WHERE product_id = '$productId'";
        $resultaat = $conn->query($query);

        $product = null;

        // Als er een resultaat is, zet het om in een Product-object
        if ($resultaat->num_rows > 0) {
            $row = $resultaat->fetch_assoc();

            $product = new Product();
            $product->id = $row['product_id'];
            $product->name = $row['product_name'];
            $product->category = $row['product_category'];
            $product->price = $row['product_price'];
            $product->instock = $row['product_instock'];
        }

        // Sluit de databaseverbinding
        $conn->close();

        // Retourneer het product (of null als niet gevonden)
        return $product;
    }

    // Haalt alle producten op
    public static function haalAlleProductenOp()
{
    // Start een databaseverbinding
    $conn = Database::start();

    $producten = [];

    // Query om alle producten op te halen
    $query = "SELECT * FROM products";

    // Voer de query uit
    $resultaat = $conn->query($query);

    // Zet de resultaten om in Product-objecten
    if ($resultaat->num_rows > 0) {
        while ($row = $resultaat->fetch_assoc()) {
            $product = new Product();
            $product->id = $row['product_id'];
            $product->name = $row['product_name'];
            $product->category = $row['product_category'];
            $product->price = $row['product_price'];
            $product->instock = $row['product_instock'];
            $producten[] = $product;
        }
    }

    return $producten;
}

    // Verwijdert het product uit de database
    public function delete()
    {
        $conn = Database::start(); // Maak verbinding

        // Maak het product_id veilig
        $product_id = mysqli_real_escape_string($conn, $this->id);

        // SQL-query om het product te verwijderen op basis van ID
        $query = "
            DELETE FROM
                products
            WHERE
                product_id = '" . $product_id . "'  -- product met dit ID verwijderen
        ";

        // Voer de query uit
        $conn->query($query);

        // Sluit de verbinding
        $conn->close();
    }

    // Voeg dit product toe aan de database
    public function Toevoegen()
    {
        $conn = Database::start(); // Maak verbinding met de database

        // Maak alle eigenschappen veilig
        $productName = mysqli_real_escape_string($conn, $this->name);
        $productCategory = mysqli_real_escape_string($conn, $this->category);
        $productPrice = mysqli_real_escape_string($conn, $this->price);
        $productInstock = mysqli_real_escape_string($conn, $this->instock);

        // SQL-query om een nieuw product toe te voegen
        $sql = "INSERT INTO products (
            product_name,
            product_category,
            product_price,
            product_instock
        ) VALUES (
            '" . $productName . "',
            '" . $productCategory . "',
            '" . $productPrice . "',
            '" . $productInstock . "'
        )";

        // Voer de query uit
        $conn->query($sql);

        // Sluit de databaseverbinding
        $conn->close();
    }

    // Past het bestaande product aan in de database
    public function Aanpassen()
    {
        $conn = Database::start(); // Start databaseverbinding

        // Maak de waarden veilig
        $productId = mysqli_real_escape_string($conn, $this->id);
        $productName = mysqli_real_escape_string($conn, $this->name);
        $productCategory = mysqli_real_escape_string($conn, $this->category);
        $productPrice = mysqli_real_escape_string($conn, $this->price);
        $productInstock = mysqli_real_escape_string($conn, $this->instock);

        // SQL-query om het product te updaten
        $sql = "
            UPDATE 
                products
            SET
                product_id = '" . $productId . "',  -- Niet per se nodig, ID verandert zelden
                product_name = '" . $productName . "',
                product_category = '" . $productCategory . "',
                product_price = '" . $productPrice . "',
                product_instock = '" . $productInstock . "'
            WHERE
                product_id = " . $productId . "  -- Alleen dit specifieke product updaten
        ";

        // Voer de update-query uit
        $conn->query($sql);

        // Sluit de databaseverbinding
        $conn->close();
    }
}
