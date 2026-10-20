<?php

class Tarief
{
    public int $id;
    public string $naam;
    public ?string $omschrijving;
    public float $prijs;

    public static function getAll()
    {
        $conn = Database::start();

        $sql = "SELECT * FROM extra_diensten
                ORDER BY dienst_id";

        $result = $conn->query($sql);
        $tarieven = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

                $tarief = new Tarief();

                $tarief->id = $row["dienst_id"];
                $tarief->naam = $row["naam"];
                $tarief->omschrijving = $row["omschrijving"];
                $tarief->prijs = $row["prijs"];

                $tarieven[] = $tarief;
            }
        }

        $conn->close();

        return $tarieven;
    }

    public static function findById(int $id)
    {
        $conn = Database::start();

        $id = mysqli_real_escape_string($conn, $id);

        $sql = "SELECT * FROM extra_diensten
                WHERE dienst_id = '$id'";

        $result = $conn->query($sql);

        $tarief = null;

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $tarief = new Tarief();

            $tarief->id = $row["dienst_id"];
            $tarief->naam = $row["naam"];
            $tarief->omschrijving = $row["omschrijving"];
            $tarief->prijs = $row["prijs"];
        }

        $conn->close();

        return $tarief;
    }

    public function insert()
    {
        $conn = Database::start();

        $naam = mysqli_real_escape_string($conn, $this->naam);
        $omschrijving = mysqli_real_escape_string($conn, $this->omschrijving);
        $prijs = mysqli_real_escape_string($conn, $this->prijs);

        $sql = "INSERT INTO extra_diensten (
                    naam,
                    omschrijving,
                    prijs
                ) VALUES (
                    '$naam',
                    '$omschrijving',
                    '$prijs'
                )";

        $conn->query($sql);

        $conn->close();
    }

    public function update()
    {
        $conn = Database::start();

        $id = mysqli_real_escape_string($conn, $this->id);
        $naam = mysqli_real_escape_string($conn, $this->naam);
        $omschrijving = mysqli_real_escape_string($conn, $this->omschrijving);
        $prijs = mysqli_real_escape_string($conn, $this->prijs);

        $sql = "UPDATE extra_diensten SET
                    naam = '$naam',
                    omschrijving = '$omschrijving',
                    prijs = '$prijs'
                WHERE dienst_id = '$id'";

        $conn->query($sql);

        $conn->close();
    }

    public function delete()
    {
        $conn = Database::start();

        $id = mysqli_real_escape_string($conn, $this->id);

        $sql = "DELETE FROM extra_diensten
                WHERE dienst_id = '$id'";

        $conn->query($sql);

        $conn->close();
    }
}