<?php
class Database
{
    // Statische functie om verbinding te maken met de database
    public static function start()
    {
        // Database instellingen
        $dbSevername = "127.0.0.1"; // Serveradres, localhost in dit geval
        $dbUsername = "root";        // Database gebruikersnaam
        $dbPassword = "mysql";            // Wachtwoord (leeg hier)
        $dbDatabase = "garage"; // Naam van de database

        // Maak een nieuwe MySQLi connectie aan
        $conn = new mysqli($dbSevername, $dbUsername, $dbPassword, $dbDatabase);

        // Check of de connectie gelukt is, anders stop script met foutmelding
        if ($conn->connect_error) {
            die("Connectie mislukt: ". $conn->connect_error);
        }

        // Return de connectie zodat andere classes/methodes hem kunnen gebruiken
        return $conn;
    }
}
