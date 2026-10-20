<?php

class RekeningRegel
{
    public int $id;
    public int $rekeningId;
    public string $omschrijving;
    public int $aantal;
    public float $prijsPerStuk;
    public float $regelTotaal;

    public static function getAll()
    {
        $conn = Database::start();

        $sql = "SELECT * FROM rekening_regels
                ORDER BY regel_id";

        $result = $conn->query($sql);

        $regels = [];

        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {

                $regel = new RekeningRegel();

                $regel->id = $row["regel_id"];
                $regel->rekeningId = $row["rekening_id"];
                $regel->omschrijving = $row["omschrijving"];
                $regel->aantal = $row["aantal"];
                $regel->prijsPerStuk = $row["prijs_per_stuk"];
                $regel->regelTotaal = $row["regel_totaal"];

                $regels[] = $regel;
            }
        }

        $conn->close();

        return $regels;
    }

    public static function findById(int $id)
    {
        $conn = Database::start();

        $id = mysqli_real_escape_string($conn, $id);

        $sql = "SELECT * FROM rekening_regels
                WHERE regel_id = '$id'";

        $result = $conn->query($sql);

        $regel = null;

        if ($result->num_rows > 0) {

            $row = $result->fetch_assoc();

            $regel = new RekeningRegel();

            $regel->id = $row["regel_id"];
            $regel->rekeningId = $row["rekening_id"];
            $regel->omschrijving = $row["omschrijving"];
            $regel->aantal = $row["aantal"];
            $regel->prijsPerStuk = $row["prijs_per_stuk"];
            $regel->regelTotaal = $row["regel_totaal"];
        }

        $conn->close();

        return $regel;
    }

    public function insert()
    {
        $conn = Database::start();

        $rekeningId = mysqli_real_escape_string($conn, $this->rekeningId);
        $omschrijving = mysqli_real_escape_string($conn, $this->omschrijving);
        $aantal = mysqli_real_escape_string($conn, $this->aantal);
        $prijsPerStuk = mysqli_real_escape_string($conn, $this->prijsPerStuk);
        $regelTotaal = mysqli_real_escape_string($conn, $this->regelTotaal);

        $sql = "INSERT INTO rekening_regels (
                    rekening_id,
                    omschrijving,
                    aantal,
                    prijs_per_stuk,
                    regel_totaal
                ) VALUES (
                    '$rekeningId',
                    '$omschrijving',
                    '$aantal',
                    '$prijsPerStuk',
                    '$regelTotaal'
                )";

        $conn->query($sql);

        $conn->close();
    }

    public function update()
    {
        $conn = Database::start();

        $id = mysqli_real_escape_string($conn, $this->id);
        $rekeningId = mysqli_real_escape_string($conn, $this->rekeningId);
        $omschrijving = mysqli_real_escape_string($conn, $this->omschrijving);
        $aantal = mysqli_real_escape_string($conn, $this->aantal);
        $prijsPerStuk = mysqli_real_escape_string($conn, $this->prijsPerStuk);
        $regelTotaal = mysqli_real_escape_string($conn, $this->regelTotaal);

        $sql = "UPDATE rekening_regels SET
                    rekening_id = '$rekeningId',
                    omschrijving = '$omschrijving',
                    aantal = '$aantal',
                    prijs_per_stuk = '$prijsPerStuk',
                    regel_totaal = '$regelTotaal'
                WHERE regel_id = '$id'";

        $conn->query($sql);

        $conn->close();
    }

    public function delete()
    {
        $conn = Database::start();

        $id = mysqli_real_escape_string($conn, $this->id);

        $sql = "DELETE FROM rekening_regels
                WHERE regel_id = '$id'";

        $conn->query($sql);

        $conn->close();
    }
}