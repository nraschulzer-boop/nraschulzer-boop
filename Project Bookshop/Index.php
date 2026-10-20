<?php

// Inclusie van database en benodigde classes voor categorieën en auteurs
include "Classes/Database.php";
include "Classes/Categories.php";
include "Classes/Auteurs.php";

// Haalt alle categorieën op uit de database
$categories = Categories::findAll();

?>

<!DOCTYPE html>
<html lang="nl">
<head>

<!-- Meta-informatie voor karakterset -->
<meta charset="UTF-8">

<!-- Titel van de webpagina -->
<title>Boeken</title>

<!-- Koppeling naar externe CSS file -->
<link rel="stylesheet" href="css/style.css">

</head>

<body onload="updateOverview()">

<!-- Header van de pagina -->
<div class="header">Boeken overzicht</div>

<!-- Hoofdcontainer voor layout -->
<div class="container">

<!-- Filtersectie links -->
<div class="filters">

<!-- Formulier voor filters (zoek, categorie, auteurs) -->
<form id="filterForm">

<!-- Zoekveld voor boekentitels -->
<input type="text"
       id="zoek"
       name="zoek"
       class="zoekbalk"
       placeholder="Zoek op titel..."
       onkeyup="updateOverview()">

<br><br>

<!-- Dropdown voor auteursfilter -->
<div class="dropdown" id="dropAuthors">

    <!-- Knop om dropdown te openen/sluiten -->
    <button type="button"
            class="dropdown-btn"
            onclick="toggleDrop('dropAuthors')">
        Auteurs ▼
    </button>

    <!-- Container waar auteurs via AJAX worden geladen -->
    <div class="dropdown-content" id="auteurFilter">

    </div>
</div>

<!-- Dropdown voor categoriefilter -->
<div class="dropdown" id="dropCategories">

    <!-- Knop om categorie dropdown te openen/sluiten -->
    <button type="button"
            class="dropdown-btn"
            onclick="toggleDrop('dropCategories')">
        Categorieën ▼
    </button>

    <!-- Lijst met categorieën uit database -->
    <div class="dropdown-content">

        <?php foreach ($categories as $c): ?>

            <!-- Label met checkbox voor elke categorie -->
            <label>
                <input type="checkbox"
                       name="categorie[]"
                       value="<?= $c->id ?>"
                       onchange="updateOverview()">

                <!-- Veilige weergave van categorienaam -->
                <?= htmlspecialchars($c->name) ?>
            </label>

        <?php endforeach; ?>

    </div>
</div>

</form>
</div>

<!-- Rechterkant: overzicht van boeken -->
<div class="overview">
    <div id="bookOverview"></div>
</div>

<!-- JavaScript bestand voor AJAX en interacties -->
<script src="java.js"></script>

</div>

</body>
</html>