const chatBerichten = document.getElementById("chatBerichten");
const chatFormulier = document.getElementById("chatFormulier");
const berichtInput = document.getElementById("bericht");
const chatFout = document.getElementById("chatFout");

const chatUrl = chatFormulier.dataset.chatUrl;


// Berichten ophalen.
function laadBerichten() {

    fetch(chatUrl)

        .then(response => {

            if (!response.ok) {
                throw new Error("Server geeft een foutmelding.");
            }

            return response.json();

        })

        .then(data => {

            if (!data.success) {

                chatFout.textContent = data.message;

                return;
            }

            chatFout.textContent = "";
            chatBerichten.innerHTML = "";

            data.berichten.forEach(bericht => {

                const berichtDiv = document.createElement("div");
                berichtDiv.className = "chat-bericht";

                const naam = document.createElement("div");
                naam.className = "chat-naam";
                naam.textContent = bericht.naam;

                const rol = document.createElement("div");
                rol.className = "chat-rol";
                rol.textContent = bericht.rol;

                const tekst = document.createElement("div");
                tekst.className = "chat-tekst";
                tekst.textContent = bericht.bericht;

                const datum = document.createElement("div");
                datum.className = "chat-datum";
                datum.textContent = bericht.verstuurdOp;

                berichtDiv.appendChild(naam);
                berichtDiv.appendChild(rol);
                berichtDiv.appendChild(tekst);
                berichtDiv.appendChild(datum);

                // Alleen managers krijgen een verwijderknop.
                if (data.isBeheerder) {

                    const verwijderKnop =
                        document.createElement("button");

                    verwijderKnop.type = "button";
                    verwijderKnop.className = "chat-verwijderen";
                    verwijderKnop.textContent = "Verwijderen";

                    verwijderKnop.addEventListener("click", function () {
                        verwijderBericht(bericht.id);
                    });

                    berichtDiv.appendChild(verwijderKnop);
                }

                chatBerichten.appendChild(berichtDiv);

            });

            chatBerichten.scrollTop = chatBerichten.scrollHeight;

        })

        .catch(error => {

            console.error(error);

            chatFout.textContent =
                "Er is een fout opgetreden bij het ophalen van de berichten.";

        });

}


// Bericht versturen.
chatFormulier.addEventListener("submit", function (event) {

    event.preventDefault();

    const bericht = berichtInput.value.trim();

    if (bericht === "") {
        return;
    }

    const formulierData = new FormData();
    formulierData.append("bericht", bericht);

    fetch(chatUrl, {
        method: "POST",
        body: formulierData
    })

        .then(response => {

            if (!response.ok) {
                throw new Error("Server geeft een foutmelding.");
            }

            return response.json();

        })

        .then(data => {

            if (!data.success) {

                chatFout.textContent = data.message;

                return;
            }

            berichtInput.value = "";
            chatFout.textContent = "";

            laadBerichten();

        })

        .catch(error => {

            console.error(error);

            chatFout.textContent =
                "Er is een fout opgetreden bij het versturen van het bericht.";

        });

});


// Bericht verwijderen.
function verwijderBericht(chatId) {

    const bevestigen = confirm(
        "Weet je zeker dat je dit bericht wilt verwijderen?"
    );

    if (!bevestigen) {
        return;
    }

    const formulierData = new FormData();

    formulierData.append("actie", "verwijderen");
    formulierData.append("chat_id", chatId);

    fetch(chatUrl, {
        method: "POST",
        body: formulierData
    })

        .then(response => {

            if (!response.ok) {
                throw new Error("Server geeft een foutmelding.");
            }

            return response.json();

        })

        .then(data => {

            if (!data.success) {

                chatFout.textContent = data.message;

                return;
            }

            chatFout.textContent = "";

            laadBerichten();

        })

        .catch(error => {

            console.error(error);

            chatFout.textContent =
                "Er is een fout opgetreden bij het verwijderen.";

        });

}


// Berichten laden en iedere drie seconden vernieuwen.
laadBerichten();

setInterval(laadBerichten, 3000);