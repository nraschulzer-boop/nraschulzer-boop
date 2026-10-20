<?php
include "Classes/database.php"; 
include "Classes/product.php";      

// Dit ID gebruiken we om te weten welk product we moeten verwijderen
$id = $_GET["id"];

// We zoeken in de database naar het blog met dat specifieke ID
$productId = $_GET["id"];
$product = Product::vindProductOpId($productId);

// Als de product is gevonden, dan verwijderen we het met de delete() functie
$product->delete();

// Daarna sturen we de gebruiker terug naar products.php met een melding in de URL
header("Location: products.php?error=Product+is+verwijderd");
exit; // Zorgt ervoor dat de rest van het script niet verder wordt uitgevoerd

?>