<?php 

// Klasse die een Book-object representeert en database-operaties uitvoert voor boeken
class Book
{
    // Eigenschap voor het unieke ID van een boek
    public int $id;

    // Eigenschap voor de titel van het boek
    public string $titel;

    // Eigenschap voor het aantal pagina's
    public int $page;

    // Eigenschap voor de prijs van het boek
    public float $price;

    // Eigenschap voor de bestandsnaam van de afbeelding
    public string $image;

    // Eigenschap voor de categorie-ID (kan null zijn)
    public ?string $bookcategoryId;

    // Eigenschap voor de auteur-ID (kan null zijn)
    public ?int $bookauthor;

    // Eigenschap voor het publicatiejaar (kan null zijn)
    public ?string $bookyear;

    // Eigenschap voor de taal van het boek (kan null zijn)
    public ?string $booklanguage;

    // Zet een database-row om naar een Book-object
    private static function mapRowToBook($row): Book
    {
        // Nieuw Book-object aanmaken
        $book = new Book();

        // Databasewaarden mappen naar objecteigenschappen
        $book->id = $row["book_id"];
        $book->titel = $row["book_title"];
        $book->page = $row["book_pages"];
        $book->price = $row["book_price"];
        $book->image = $row["book_image"];
        $book->bookcategoryId = $row["book_category_id"] ?? null;
        $book->bookauthor = $row["book_author_id"] ?? null;
        $book->bookyear = $row["book_publication_year"] ?? null;
        $book->booklanguage = $row["book_language"] ?? null;

        // Geeft het ingevulde Book-object terug
        return $book;
    }

    // Haalt alle boeken op uit de database
    public static function findAll(): array
    {
        // Start databaseverbinding
        $conn = database::start();

        // SQL-query om alle boeken op te halen
        $sql = "SELECT * FROM books";

        // Query uitvoeren
        $result = $conn->query($sql);

        // Array voor Book-objecten
        $books = [];

        // Elke database-row omzetten naar een Book-object
        while ($row = $result->fetch_assoc()) {
            $books[] = self::mapRowToBook($row);
        }

        // Databaseverbinding sluiten
        $conn->close();

        // Resultaten teruggeven
        return $books;
    }

    // Zoekt boeken op basis van titel
    public static function search(string $search): array
    {
        // Start databaseverbinding
        $conn = database::start();

        // Prepared statement voor veilige zoekopdracht
        $stmt = $conn->prepare("SELECT * FROM books WHERE book_title LIKE ?");

        // Zoekterm met wildcards
        $like = "%" . $search . "%";

        // Parameter binden aan query
        $stmt->bind_param("s", $like);

        // Query uitvoeren
        $stmt->execute();

        // Resultaat ophalen
        $result = $stmt->get_result();

        // Array voor boeken
        $books = [];

        // Elke rij omzetten naar Book-object
        while ($row = $result->fetch_assoc()) {
            $books[] = self::mapRowToBook($row);
        }

        // Databaseverbinding sluiten
        $conn->close();

        // Resultaten teruggeven
        return $books;
    }

    // Haalt één boek op basis van ID
    public static function findById(int $id): ?Book
    {
        // Start databaseverbinding
        $conn = database::start();

        // Prepared statement om één boek op te halen
        $stmt = $conn->prepare("SELECT * FROM books WHERE book_id = ?");

        // ID binden aan query
        $stmt->bind_param("i", $id);

        // Query uitvoeren
        $stmt->execute();

        // Resultaat ophalen
        $result = $stmt->get_result();

        // Controle of er een resultaat is
        if ($row = $result->fetch_assoc()) {

            // Verbinding sluiten
            $conn->close();

            // Book-object teruggeven
            return self::mapRowToBook($row);
        }

        // Verbinding sluiten als niets gevonden is
        $conn->close();

        // Geen resultaat gevonden
        return null;
    }

    // Haalt boeken op met filters voor titel, categorie en auteurs
    public static function findByTitleAndCat(string $titel, array $categorie = [], array $auteurs = []): array
    {
        // Start databaseverbinding
        $conn = database::start();

        // Basisquery
        $sql = "SELECT * FROM books WHERE book_title LIKE ?";

        // Parameters en types voor prepared statement
        $params = ["%" . $titel . "%"];
        $types = "s";

        // Filter op categorieën indien aanwezig
        if (!empty($categorie)) {

            // Maak placeholders voor IN-clause
            $placeholders = implode(',', array_fill(0, count($categorie), '?'));

            // Voeg filter toe aan query
            $sql .= " AND book_category_id IN ($placeholders)";

            // Voeg types toe (integer per categorie)
            $types .= str_repeat("i", count($categorie));

            // Voeg waarden toe aan parameters
            $params = array_merge($params, $categorie);
        }

        // Filter op auteurs indien aanwezig
        if (!empty($auteurs)) {

            // Maak placeholders voor IN-clause
            $placeholders = implode(',', array_fill(0, count($auteurs), '?'));

            // Voeg filter toe aan query
            $sql .= " AND book_author_id IN ($placeholders)";

            // Voeg types toe (integer per auteur)
            $types .= str_repeat("i", count($auteurs));

            // Voeg waarden toe aan parameters
            $params = array_merge($params, $auteurs);
        }

        // Prepared statement maken
        $stmt = $conn->prepare($sql);

        // Parameters binden
        $stmt->bind_param($types, ...$params);

        // Query uitvoeren
        $stmt->execute();

        // Resultaat ophalen
        $result = $stmt->get_result();

        // Array voor boeken
        $books = [];

        // Elke rij omzetten naar Book-object
        while ($row = $result->fetch_assoc()) {
            $books[] = self::mapRowToBook($row);
        }

        // Databaseverbinding sluiten
        $conn->close();

        // Resultaten teruggeven
        return $books;
    }
}