<?php

class Klant
{
    public int $id;
    public string $naam;
    public string $email;
    public string $telefoonnummer;
    public string $straat;
    public string $postcode;
    public string $woonplaats;

    public static function getAll()
    {
        $conn = Database::start();

        $sql = "SELECT * FROM klanten
                ORDER BY klant_id";

        $result = $conn->query($sql);

        $klanten = [];

        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {

                $klant = new Klant();

                $klant->id = $row["klant_id"];
                $klant->naam = $row["volledige_naam"];
                $klant->email = $row["emailadres"];
                $klant->telefoonnummer = $row["telefoonnummer"];
                $klant->straat = $row["straat"];
                $klant->postcode = $row["postcode"];
                $klant->woonplaats = $row["woonplaats"];

                $klanten[] = $klant;
            }
        }

        $conn->close();

        return $klanten;
    }

    public static function findById(int $id)
    {
        $conn = Database::start();

        $id = mysqli_real_escape_string($conn, $id);

        $sql = "SELECT * FROM klanten
                WHERE klant_id = '$id'";

        $result = $conn->query($sql);

        $klant = null;

        if ($result->num_rows > 0) {

            $row = $result->fetch_assoc();

            $klant = new Klant();

            $klant->id = $row["klant_id"];
            $klant->naam = $row["volledige_naam"];
            $klant->email = $row["emailadres"];
            $klant->telefoonnummer = $row["telefoonnummer"];
            $klant->straat = $row["straat"];
            $klant->postcode = $row["postcode"];
            $klant->woonplaats = $row["woonplaats"];
        }

        $conn->close();

        return $klant;
    }

    public function insert()
    {
        $conn = Database::start();

        $naam = mysqli_real_escape_string($conn, $this->naam);
        $email = mysqli_real_escape_string($conn, $this->email);
        $telefoonnummer = mysqli_real_escape_string($conn, $this->telefoonnummer);
        $straat = mysqli_real_escape_string($conn, $this->straat);
        $postcode = mysqli_real_escape_string($conn, $this->postcode);
        $woonplaats = mysqli_real_escape_string($conn, $this->woonplaats);

        $sql = "INSERT INTO klanten (
                    volledige_naam,
                    emailadres,
                    telefoonnummer,
                    straat,
                    postcode,
                    woonplaats
                ) VALUES (
                    '$naam',
                    '$email',
                    '$telefoonnummer',
                    '$straat',
                    '$postcode',
                    '$woonplaats'
                )";

        $conn->query($sql);

        $conn->close();
    }

    public function update()
    {
        $conn = Database::start();

        $id = mysqli_real_escape_string($conn, $this->id);
        $naam = mysqli_real_escape_string($conn, $this->naam);
        $email = mysqli_real_escape_string($conn, $this->email);
        $telefoonnummer = mysqli_real_escape_string($conn, $this->telefoonnummer);
        $straat = mysqli_real_escape_string($conn, $this->straat);
        $postcode = mysqli_real_escape_string($conn, $this->postcode);
        $woonplaats = mysqli_real_escape_string($conn, $this->woonplaats);

        $sql = "UPDATE klanten SET
                    volledige_naam = '$naam',
                    emailadres = '$email',
                    telefoonnummer = '$telefoonnummer',
                    straat = '$straat',
                    postcode = '$postcode',
                    woonplaats = '$woonplaats'
                WHERE klant_id = '$id'";

        $conn->query($sql);

        $conn->close();
    }

    public function delete()
    {
        $conn = Database::start();

        $id = mysqli_real_escape_string($conn, $this->id);

        $sql = "DELETE FROM klanten
                WHERE klant_id = '$id'";

        $conn->query($sql);

        $conn->close();
    }
}
