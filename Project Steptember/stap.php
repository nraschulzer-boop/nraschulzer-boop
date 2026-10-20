<?php
// Deze class gaat over stappen die je hebt gezet
class Stap
{
    public string $stepUserId;
    public string $stepDate;
    public int $stepTotal;

    // Haalt alle stappen op van een specifieke gebruiker
    public static function vindStappen($stepUserId)
    {
        include "connectie.php";

        // Zorg dat de userId veilig is
        $stepUserId = mysqli_real_escape_string($conn, $stepUserId);

        // Zoek alle stappen van die gebruiker
        $query = "SELECT * FROM steps WHERE step_user_id = '$stepUserId'";
        $result = $conn->query($query);

        $stappen = []; // Hier gaan we alle gevonden stappen inzetten

        // Als er stappen zijn gevonden, doen we dit
        if ($result->num_rows > 0) {
            // Loop door alle resultaten heen
            while ($row = $result->fetch_assoc()) {
                $step = new Stap();
                $step->stepUserId = $row['step_user_id'];
                $step->stepDate = $row['step_date'];
                $step->stepTotal = $row['step_total'];
                $stappen[] = $step;
            }
        }

        // Sluit de verbinding met de database
        $conn->close();

        return $stappen; // Geef de stappen terug
    }

    // Haalt ALLE stappen van iedereen op (bijvoorbeeld voor een admin)
    public static function vindAlleStappen()
    {
        include "connectie.php";

        // Query die gewoon alles uit de stappen-tabel haalt
        $query = "SELECT * FROM steps";
        $result = $conn->query($query);

        $stappen = []; // Lijstje waar we alle stappen in zetten

        // Als er resultaten zijn:
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $step = new Stap(); // Maak weer een nieuwe stap aan
                $step->stepUserId = $row['step_user_id'];
                $step->stepDate = $row['step_date'];
                $step->stepTotal = $row['step_total'];
                $stappen[] = $step; // Gooi hem in de lijst
            }
        }

        $conn->close(); // Database sluiten

        return $stappen; // Geef alle stappen terug
    }
}