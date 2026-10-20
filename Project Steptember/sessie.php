<?php
// Dit is de sessie class
class Sessie
{
    // Hier slaan we de info van een sessie op (gebruiker, sleutel, begin- en eindtijd)
    public string $session_id;
    public string $session_user_id;
    public string $session_key;
    public string $session_start;
    public string $session_end;

    // Deze functie voegt een nieuwe sessie toe aan de database
    public function insert()
    {
        include "connectie.php";

        // Maakt de variabelen veilig
        $userId = mysqli_real_escape_string($conn, $this->userId);
        $key = mysqli_real_escape_string($conn, $this->key);
        $start = mysqli_real_escape_string($conn, $this->start);
        $end = mysqli_real_escape_string($conn, $this->end);

        // SQL die de sessie in de database gooit
        $sql = "INSERT INTO sessions (
            session_user_id,
            session_key,
            session_start,
            session_end
        ) VALUES (
            '" . $userId . "',
            '" . $key . "',
            '" . $start . "',
            '" . $end . "'
        )";
        // We sturen de query naar de database
        $conn->query($sql);

        // We sluiten de connectie
        $conn->close();
    }

    // Deze functie kijkt of er een actieve sessie is (dus of iemand nog is ingelogd)
    public static function vindActieveSessie()
    {
        $sessie = null;

        // Check of de cookie bestaat (dus of de gebruiker een sessie-cookie heeft)
        if (isset($_COOKIE["steptember-session"])) {
            include "connectie.php";

            // Haal de key uit de cookie, en escape voor veiligheid
            $key = mysqli_real_escape_string($conn, $_COOKIE["steptember-session"]);

            // Zoek in de database naar een sessie met die key én die nog niet verlopen is
            $query = "SELECT * FROM sessions WHERE session_key = '" . $key . "' AND session_end > '" . date("Y-m-d H:i:s") . "'";
            $resultaat = $conn->query($query);

            // Als er een resultaat is, dan bestaat de sessie dus en laden we die in
            if ($resultaat->num_rows > 0) {
                $rij = $resultaat->fetch_assoc();

                // Maak een nieuw sessie-object aan met de data uit de DB
                $sessie = new Sessie();
                $sessie->session_id = $rij['session_id'];
                $sessie->session_user_id = $rij['session_user_id'];
                $sessie->session_key = $rij['session_key'];
                $sessie->session_start = $rij['session_start'];
                $sessie->session_end = $rij['session_end'];
            }
            // Sluit ook hier netjes de database
            $conn->close();
        }

        // Geeft de actieve sessie terug (of null als er niks is)
        return $sessie;
    }
}