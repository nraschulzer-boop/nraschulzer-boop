<?php 

// Klasse die categorieën representeert en ophaalt uit de database
class Categories
{
    // Eigenschap voor het unieke ID van een categorie
    public string $id;

    // Eigenschap voor de naam van een categorie
    public string $name;

    // Haalt alle categorieën op uit de database
    public static function findAll()
    {
        // Start databaseverbinding
        $conn = database::start();

        // SQL-query om alle categorieën op te halen
        $sql = "SELECT * FROM categories";

        // Query uitvoeren
        $result = $conn->query($sql);

        // Lege array voor categorie-objecten
        $categories = [];

        // Controleert of er resultaten zijn
        if ($result->num_rows > 0) {

            // Loopt door alle rijen uit de database
            while ($row = $result->fetch_assoc()) {

                // Nieuw Categories-object aanmaken
                $category = new Categories();

                // Databasewaarde toewijzen aan ID
                $category->id = $row["category_id"];

                // Databasewaarde toewijzen aan naam
                $category->name = $row["category_name"];

                // Object toevoegen aan de resultatenlijst
                $categories[] = $category;
            }
        }

        // Databaseverbinding sluiten
        $conn->close();

        // Resultaten teruggeven
        return $categories;
    }
}