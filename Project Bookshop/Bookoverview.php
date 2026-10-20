<?php

// Inclusie van benodigde classes voor databaseverbinding, boeken en auteurs
include "Classes/Database.php";
include "Classes/Book.php";
include "Classes/Auteurs.php";

// Ophalen van POST-gegevens met standaardwaarden
$zoek = $_POST['zoek'] ?? '';
$categorie = $_POST['categorie'] ?? [];
$auteurs = $_POST['auteur'] ?? [];

// Controleert of categorie een array is, anders omzetten naar array
if (!is_array($categorie)) $categorie = [$categorie];

// Controleert of auteurs een array is, anders omzetten naar array
if (!is_array($auteurs)) $auteurs = [$auteurs];

// Haalt boeken op op basis van zoekterm, categorie en auteursfilters
$books = Book::findByTitleAndCat($zoek, $categorie, $auteurs);

// Haalt alle auteurs op om een mapping te maken van ID naar naam
$authorsList = Auteurs::getAuthors();

// Lege array om auteurs-ID's te koppelen aan namen
$auteursMap = [];

// Bouwt een associative array: [author_id => author_name]
foreach ($authorsList as $aut) {
    $auteursMap[$aut->id] = $aut->name;
}

?>

<!-- Grid layout voor het weergeven van boeken -->
<div class="grid">

<?php foreach ($books as $book): ?>

    <!-- Eén boekkaart -->
    <div class="book">

        <!-- Afbeelding van het boek met fallback als bestand ontbreekt -->
        <img src="images/<?= htmlspecialchars($book->image) ?>"
             onerror="this.src='images/no-image.png'">

        <!-- Titel van het boek -->
        <h3><?= htmlspecialchars($book->titel) ?></h3>

        <!-- Naam van de auteur via mapping, fallback indien niet gevonden -->
        <p>
            <?= htmlspecialchars($auteursMap[$book->bookauthor] ?? "Onbekend") ?>
        </p>

        <!-- Aantal pagina's van het boek -->
        <p><?= $book->page ?> pages</p>

        <!-- Prijs van het boek met Europese formatting -->
        <p>€<?= number_format($book->price, 2, ',', '.') ?></p>

    </div>

<?php endforeach; ?>

</div>