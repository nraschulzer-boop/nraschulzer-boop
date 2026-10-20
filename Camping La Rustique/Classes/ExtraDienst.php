<?php

class ExtraDienst
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

        $diensten = [];

        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {

                $dienst = new ExtraDienst();

                $dienst->id = $row["dienst_id"];
                $dienst->naam = $row["naam"];
                $dienst->omschrijving = $row["omschrijving"];
                $dienst->prijs = $row["prijs"];

                $diensten[] = $dienst;
            }
        }

        $conn->close();

        return $diensten;
    }

    public static function findById(int $id)
    {
        $conn = Database::start();

        $id = mysqli_real_escape_string($conn, $id);

        $sql = "SELECT * FROM extra_diensten
                WHERE dienst_id = '$id'";

        $result = $conn->query($sql);

        $dienst = null;

        if ($result->num_rows > 0) {

            $row = $result->fetch_assoc();

            $dienst = new ExtraDienst();

            $dienst->id = $row["dienst_id"];
            $dienst->naam = $row["naam"];
            $dienst->omschrijving = $row["omschrijving"];
            $dienst->prijs = $row["prijs"];
        }

        $conn->close();

        return $dienst;
    }
}