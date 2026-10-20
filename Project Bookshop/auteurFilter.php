<?php

// Inclusie van benodigde classes voor databaseverbinding en auteursfunctionaliteit
include "Classes/Database.php";
include "Classes/Auteurs.php";

// Ophalen van POST-gegevens met fallback naar standaardwaarden
$zoek = $_POST["zoek"] ?? "";
$categorie = $_POST["categorie"] ?? [];
$gekozen = $_POST["auteur"] ?? [];

// Controleert of categorie een array is, zo niet wordt het omgezet naar een array
if (!is_array($categorie)) $categorie = [$categorie];

// Controleert of gekozen auteurs een array is, zo niet wordt het omgezet naar een array
if (!is_array($gekozen)) $gekozen = [$gekozen];

// Haalt auteurs op uit de database op basis van zoekterm en categoriefilter
$auteurs = Auteurs::getAuthors($zoek, $categorie);

// Loopt door alle auteurs en genereert HTML output
foreach ($auteurs as $a):

// Controleert of deze auteur geselecteerd is
$checked = in_array($a->id, $gekozen) ? "checked" : "";
?>

<!-- Label voor één auteur met checkbox -->
<label>
    <input type="checkbox"
           name="auteur[]"
           value="<?= $a->id ?>"
           <?= $checked ?>
           onchange="updateOverview()">

    <!-- Veilige weergave van de auteurnaam -->
    <?= htmlspecialchars($a->name) ?>
</label>

<?php endforeach; ?>