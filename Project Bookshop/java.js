// Functie om een dropdown te openen of te sluiten door een CSS-class te toggelen
function toggleDrop(id) {
    // Selecteert het HTML-element op basis van ID en togglet de class "open"
    document.getElementById(id).classList.toggle("open");
}

// Functie die alle filters verwerkt en de pagina dynamisch bijwerkt
function updateOverview() {

    // Haalt het formulier op met alle filtervelden
    let form = document.getElementById("filterForm");

    // Zet alle form-data om naar een FormData object (voor POST request)
    let formData = new FormData(form);

    // Haalt de huidige waarde van de zoekbalk op
    let zoek = document.getElementById("zoek").value;

    // Zet de zoekwaarde expliciet in de FormData
    formData.set("zoek", zoek);

    // AJAX request om boekenoverzicht op te halen
    fetch("bookOverview.php", {
        method: "POST",
        body: formData
    })
    .then(r => r.text()) // Zet response om naar tekst (HTML)
    .then(html => {
        // Plaatst de ontvangen HTML in de boekencontainer
        document.getElementById("bookOverview").innerHTML = html;
    });

    // AJAX request om auteursfilter opnieuw op te bouwen
    fetch("auteurFilter.php", {
        method: "POST",
        body: formData
    })
    .then(r => r.text()) // Zet response om naar tekst (HTML)
    .then(html => {
        // Plaatst de ontvangen HTML in de auteursfilter container
        document.getElementById("auteurFilter").innerHTML = html;
    });
}

// Zorgt ervoor dat de overzicht direct geladen wordt bij het openen van de pagina
window.onload = function () {
    updateOverview();
};