<?php 
class Auteurs
{
    // Eigenschap die het ID van een auteur opslaat
    public int $id;

    // Eigenschap die de naam van een auteur opslaat
    public string $name;

    // Statische functie om auteurs op te halen uit de database met optionele filters
    public static function getAuthors(string $titel = "", array $categorie = [])
    {
        // Start databaseverbinding
        $conn = database::start();

        // SQL-query om unieke auteurs op te halen die gekoppeld zijn aan boeken
        // en waarbij de boektitel overeenkomt met de zoekterm
        $sql = "SELECT DISTINCT a.author_id, a.author_name
                FROM authors a
                JOIN books b ON a.author_id = b.book_author_id
                WHERE b.book_title LIKE '%$titel%'";

        // Controleert of er categorieën zijn meegegeven als filter
        if (!empty($categorie)) {
            // Zet alle categorie-ID's om naar integers voor veiligheid
            $ids = array_map('intval', $categorie);

            // Voegt categorie-filter toe aan de SQL-query
            $sql .= " AND book_category_id IN (" . implode(',', $ids) . ")";
        }

        // Voert de SQL-query uit
        $result = $conn->query($sql);

        // Lege array om auteurs in op te slaan
        $authors = [];

        // Controleert of er resultaten zijn
        if ($result->num_rows > 0) {

            // Loopt door alle rijen uit de database
            while ($row = $result->fetch_assoc()) {

                // Maakt een nieuw Auteurs-object aan
                $author = new Auteurs();

                // Zet databasewaarde om naar object property ID
                $author->id = $row["author_id"];

                // Zet databasewaarde om naar object property naam
                $author->name = $row["author_name"];

                // Voegt het object toe aan de resultatenlijst
                $authors[] = $author;
            }
        }

        // Sluit de databaseverbinding
        $conn->close();

        // Geeft de lijst met auteurs terug
        return $authors;
    }
}