<?php

class Gebruiker
{
    public int $id;
    public string $naam;
    public string $username;
    public string $password;
    public string $rol;

    public static function Login($username, $password)
    {
        $conn = Database::start();

        $username = mysqli_real_escape_string($conn, $username);
        $password = mysqli_real_escape_string($conn, $password);

        $sql = "SELECT * FROM accounts
                WHERE gebruikersnaam = '$username'
                AND wachtwoord = '$password'";

        $result = $conn->query($sql);

        $user = null;

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $user = new Gebruiker();
            $user->id = $row['account_id'];
            $user->naam = $row['volledige_naam'];
            $user->username = $row['gebruikersnaam'];
            $user->password = $row['wachtwoord'];
            $user->rol = $row['rol'];
        }

        $conn->close();

        return $user;
    }

    public static function getAll()
    {
        $conn = Database::start();

        $sql = "SELECT * FROM accounts";

        $result = $conn->query($sql);
        $gebruikers = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

                $gebruiker = new Gebruiker();

                $gebruiker->id = $row["account_id"];
                $gebruiker->naam = $row["volledige_naam"];
                $gebruiker->username = $row["gebruikersnaam"];
                $gebruiker->password = $row["wachtwoord"];
                $gebruiker->rol = $row["rol"];

                $gebruikers[] = $gebruiker;
            }
        }

        $conn->close();

        return $gebruikers;
    }

    public function insert()
    {
        $conn = Database::start();

        $naam = mysqli_real_escape_string($conn, $this->naam);
        $username = mysqli_real_escape_string($conn, $this->username);
        $password = mysqli_real_escape_string($conn, $this->password);
        $rol = mysqli_real_escape_string($conn, $this->rol);

        $sql = "INSERT INTO accounts (
            volledige_naam,
            gebruikersnaam,
            wachtwoord,
            rol
        ) VALUES (
            '$naam',
            '$username',
            '$password',
            '$rol'
        )";

        $conn->query($sql);

        $conn->close();
    }

    public function update()
    {
        $conn = Database::start();

        $id = mysqli_real_escape_string($conn, $this->id);
        $naam = mysqli_real_escape_string($conn, $this->naam);
        $username = mysqli_real_escape_string($conn, $this->username);
        $password = mysqli_real_escape_string($conn, $this->password);
        $rol = mysqli_real_escape_string($conn, $this->rol);

        $sql = "UPDATE accounts SET
                volledige_naam = '$naam',
                gebruikersnaam = '$username',
                wachtwoord = '$password',
                rol = '$rol'
                WHERE account_id = '$id'";

        $conn->query($sql);

        $conn->close();
    }

    public static function findById(int $id)
    {
        $conn = Database::start();

        $id = mysqli_real_escape_string($conn, $id);

        $sql = "SELECT * FROM accounts
                WHERE account_id = '$id'";

        $result = $conn->query($sql);

        $gebruiker = null;

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $gebruiker = new Gebruiker();

            $gebruiker->id = $row["account_id"];
            $gebruiker->naam = $row["volledige_naam"];
            $gebruiker->username = $row["gebruikersnaam"];
            $gebruiker->password = $row["wachtwoord"];
            $gebruiker->rol = $row["rol"];
        }

        $conn->close();

        return $gebruiker;
    }

    public function delete()
    {
        $conn = Database::start();

        $id = mysqli_real_escape_string($conn, $this->id);

        // Verwijdert eerst de sessies van deze gebruiker.
        $conn->query("
            DELETE FROM sessies
            WHERE account_id = '$id'
        ");

        // Verwijdert daarna de gebruiker.
        $conn->query("
            DELETE FROM accounts
            WHERE account_id = '$id'
        ");

        $conn->close();
    }
}