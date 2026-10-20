<?php

class Gebruiker
{
    public string $user_id;
    public string $username;
    public string $password;
    public string $userAdmin;
    public string $userFirstname;

    public static function vindGebruiker($username, $password)
    {
        include "connectie.php";

        // Maakt de variabelen veilig
        $username = mysqli_real_escape_string($conn, $username);
        $password = mysqli_real_escape_string($conn, $password);

        // SQL-query om de gebruiker op te zoeken met de opgegeven gebruikersnaam en wachtwoord
        $query = "SELECT * FROM users WHERE user_username = '$username' AND user_password = '$password'";
        $resultaat = $conn->query($query);
        
        // Voor de zekerheid standaardwaarde, als er geen gebruiker wordt gevonden
        $user = null;
        
        // Dit werkt alleen als er minstens één resultaat is, dus de gebruiker
        if ($resultaat->num_rows > 0) {
            while ($row = $resultaat->fetch_assoc()) {
                // Dit maakt een Gebruiker-object aan en vul het met de opgehaalde gegevens
                $user = new Gebruiker();
                $user->user_id = $row['user_id'];
                $user->username = $row['user_username'];
                $user->password = $row['user_password'];
                $user->userAdmin = $row['user_admin']; 
            }
        }

        // Sluit de databaseverbinding
        $conn->close();

        // Retourneer het gevonden gebruiker-object, of null als geen gebruiker werd gevonden
        return $user;
    }

    public static function vindAdmin($userId)
    {
        include "connectie.php";

        // Maakt de variabelen veilig
        $userId = mysqli_real_escape_string($conn, $userId);

        // SQL-query om een gebruiker op te zoeken op basis van user_id
        $query = "SELECT * FROM users WHERE user_id = '$userId'";
        $resultaat = $conn->query($query);

        // Voor de zekerheid standaardwaarde, als er geen gebruiker wordt gevonden
        $user = null;

        // Dit gaat alleen gebeuren als er een resultaat is gevonden
        if ($resultaat->num_rows > 0) {
            $row = $resultaat->fetch_assoc(); // Haal de gegevens van de gebruiker op

            // Maakt een nieuw Gebruiker-object aan en vult het met de opgehaalde gegevens
            $user = new Gebruiker();
            $user->user_id = $row['user_id'];
            $user->userFirstname = $row['user_firstname'];
            $user->username = $row['user_username'];
            $user->password = $row['user_password'];
            $user->userAdmin = $row['user_admin'];
        }

        $conn->close();

        return $user;
    }
}

?>