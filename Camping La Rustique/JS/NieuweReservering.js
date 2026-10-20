document.addEventListener("DOMContentLoaded", function () {

    const bestaandeKlantKnop =
        document.getElementById("bestaandeKlantKnop");

    const nieuweKlantKnop =
        document.getElementById("nieuweKlantKnop");

    const bestaandeKlant =
        document.getElementById("bestaandeKlant");

    const nieuweKlant =
        document.getElementById("nieuweKlant");

    const klantKeuze =
        document.getElementById("klant_keuze");

    const alleenBeschikbaar =
        document.getElementById("alleenBeschikbaar");

    const datumAankomst =
        document.getElementById("datum_aankomst");

    const datumVertrek =
        document.getElementById("datum_vertrek");

    const volwassenen =
        document.getElementById("volwassenen");

    const kinderen =
        document.getElementById("kinderen");

    const totaalBedrag =
        document.getElementById("totaalBedrag");

    const tariefCheckboxes =
        document.querySelectorAll(".tarief-checkbox");

    const tariefAantallen =
        document.querySelectorAll(".tarief-aantal");

    const plekken =
        document.querySelectorAll(".medewerker-plek");


    function toonKlant(type)
    {
        if (type === "bestaand") {

            bestaandeKlant.classList.add("active");
            nieuweKlant.classList.remove("active");

            bestaandeKlantKnop.classList.add("active");
            nieuweKlantKnop.classList.remove("active");

            klantKeuze.value = "bestaand";

        } else {

            bestaandeKlant.classList.remove("active");
            nieuweKlant.classList.add("active");

            bestaandeKlantKnop.classList.remove("active");
            nieuweKlantKnop.classList.add("active");

            klantKeuze.value = "nieuw";
        }
    }


    function filterPlekken()
    {
        plekken.forEach(function (plek) {

            const beschikbaar =
                plek.dataset.beschikbaar === "1";


            if (
                alleenBeschikbaar.checked &&
                !beschikbaar
            ) {

                plek.style.display = "none";

            } else {

                plek.style.display = "block";
            }

        });
    }


    function berekenTotaal()
    {
        let totaal = 0;


        /*
         * Volwassenen.
         */
        const aantalVolwassenen =
            parseInt(volwassenen.value) || 0;


        /*
         * Kinderen.
         */
        const aantalKinderen =
            parseInt(kinderen.value) || 0;


        /*
         * Deze variabelen worden opgehaald
         * voor het aantal personen.
         */
        aantalVolwassenen;
        aantalKinderen;


        /*
         * Extra tarieven berekenen.
         */
        tariefCheckboxes.forEach(function (checkbox) {

            if (checkbox.checked) {

                const parent =
                    checkbox.closest(".medewerker-tarief");

                const aantal =
                    parseInt(
                        parent.querySelector(
                            ".tarief-aantal"
                        ).value
                    ) || 0;

                const prijs =
                    parseFloat(
                        checkbox.dataset.prijs
                    ) || 0;

                totaal += aantal * prijs;
            }

        });


        /*
         * Campingplek berekenen.
         */
        const gekozenPlek =
            document.querySelector(
                'input[name="plaats_id"]:checked'
            );


        if (gekozenPlek) {

            const plek =
                gekozenPlek.closest(".medewerker-plek");

            const tekst =
                plek.innerText;


            const match =
                tekst.match(
                    /€\s*([\d,]+)\s*per nacht/
                );


            if (match) {

                const prijs =
                    parseFloat(
                        match[1].replace(",", ".")
                    );


                const start =
                    datumAankomst.value;

                const einde =
                    datumVertrek.value;


                if (start && einde) {

                    const startDatum =
                        new Date(start);

                    const eindDatum =
                        new Date(einde);


                    const verschil =
                        eindDatum - startDatum;


                    const nachten =
                        Math.ceil(
                            verschil /
                            (1000 * 60 * 60 * 24)
                        );


                    if (nachten > 0) {

                        totaal +=
                            prijs * nachten;
                    }
                }
            }
        }


        totaalBedrag.innerText =
            "€ " +
            totaal.toFixed(2).replace(".", ",");
    }


    function controleerPlekken()
    {
        berekenTotaal();
    }


    /*
     * Klantkeuze.
     */
    bestaandeKlantKnop.addEventListener(
        "click",
        function () {
            toonKlant("bestaand");
        }
    );


    nieuweKlantKnop.addEventListener(
        "click",
        function () {
            toonKlant("nieuw");
        }
    );


    /*
     * Beschikbare campingplekken filteren.
     */
    alleenBeschikbaar.addEventListener(
        "change",
        filterPlekken
    );


    /*
     * Datumvelden controleren.
     */
    datumAankomst.addEventListener(
        "change",
        controleerPlekken
    );


    datumVertrek.addEventListener(
        "change",
        controleerPlekken
    );


    /*
     * Personen veranderen.
     */
    volwassenen.addEventListener(
        "change",
        berekenTotaal
    );


    kinderen.addEventListener(
        "change",
        berekenTotaal
    );


    /*
     * Extra tarieven.
     */
    tariefCheckboxes.forEach(
        function (checkbox) {

            checkbox.addEventListener(
                "change",
                berekenTotaal
            );

        }
    );


    tariefAantallen.forEach(
        function (input) {

            input.addEventListener(
                "change",
                berekenTotaal
            );


            input.addEventListener(
                "click",
                function () {

                    const checkbox =
                        this
                            .closest(".medewerker-tarief")
                            .querySelector(
                                ".tarief-checkbox"
                            );

                    checkbox.checked = true;

                    berekenTotaal();
                }
            );

        }
    );


    /*
     * Eerste keer laden.
     */
    filterPlekken();

    berekenTotaal();

});
