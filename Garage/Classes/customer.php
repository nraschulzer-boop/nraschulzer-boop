<?php

// Klasse die een klant representeert en functies bevat om klantgegevens uit de database op te halen
class Klant
{
    // Eigenschappen van de klant
    public string $id;
    public string $firstname;
    public string $lastname;
    public string $address;
    public string $zipcode;
    public string $city;
    public string $email;

    // Zoek een klant op basis van het e-mailadres
    public static function vindKlantOpEmail($email)
    {
        // Start een databaseverbinding
        $conn = Database::start();

        // Maak het e-mailadres veilig voor gebruik in een SQL-query
        $email = mysqli_real_escape_string($conn, $email);

        // SQL-query om de klant met het opgegeven e-mailadres op te zoeken
        $query = "SELECT * FROM customers WHERE customer_email = '$email'";
        $resultaat = $conn->query($query);

        $klant = null;

        // Controleer of er resultaten zijn en maak een klantobject aan
        if ($resultaat->num_rows > 0) {
            $row = $resultaat->fetch_assoc();

            $klant = new Klant();
            $klant->id = $row['customer_id'];
            $klant->firstname = $row['customer_firstname'];
            $klant->lastname = $row['customer_lastname'];
            $klant->address = $row['customer_address'];
            $klant->zipcode = $row['customer_zipcode'];
            $klant->city = $row['customer_city'];
            $klant->email = $row['customer_email'];
        }

        // Sluit de databaseverbinding
        $conn->close();

        // Retourneer het gevonden klantobject of null als er niets is gevonden
        return $klant;
    }

    // Zoek een klant op basis van het klant-ID
    public static function vindKlantOpId($customerId)
    {
        // Start een databaseverbinding
        $conn = Database::start();

        // Maak het klant-ID veilig voor gebruik in een SQL-query
        $customerId = mysqli_real_escape_string($conn, $customerId);

        // SQL-query om de klant met het opgegeven ID op te zoeken
        $query = "SELECT * FROM customers WHERE customer_id = '$customerId'";
        $resultaat = $conn->query($query);

        $klant = null;

        // Controleer of er een resultaat is en maak een klantobject aan
        if ($resultaat->num_rows > 0) {
            $row = $resultaat->fetch_assoc();

            $klant = new Klant();
            $klant->id = $row['customer_id'];
            $klant->firstname = $row['customer_firstname'];
            $klant->lastname = $row['customer_lastname'];
            $klant->address = $row['customer_address'];
            $klant->zipcode = $row['customer_zipcode'];
            $klant->city = $row['customer_city'];
            $klant->email = $row['customer_email'];
        }

        // Sluit de databaseverbinding
        $conn->close();

        // Retourneer het gevonden klantobject of null als er niets is gevonden
        return $klant;
    }

    // Haal alle klanten op uit de database
    public static function alleKlanten()
    {
        // Start een databaseverbinding
        $conn = Database::start();

        // SQL-query om alle klanten op te halen
        $query = "SELECT * FROM customers";
        $resultaat = $conn->query($query);

        // Array om alle klantobjecten in op te slaan
        $klanten = [];

        // Loop door de resultaten en maak voor elke rij een klantobject aan
        if ($resultaat->num_rows > 0) {
            while ($row = $resultaat->fetch_assoc()) {
                $klant = new Klant();
                $klant->id = $row['customer_id'];
                $klant->firstname = $row['customer_firstname'];
                $klant->lastname = $row['customer_lastname'];
                $klant->address = $row['customer_address'];
                $klant->zipcode = $row['customer_zipcode'];
                $klant->city = $row['customer_city'];
                $klant->email = $row['customer_email'];
                // Voeg de klant toe aan de lijst
                $klanten[] = $klant;
            }
        }

        // Sluit de databaseverbinding
        $conn->close();

        // Retourneer de lijst met alle klanten
        return $klanten;
    }
}
