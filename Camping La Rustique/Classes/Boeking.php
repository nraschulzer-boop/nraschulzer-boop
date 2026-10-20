<?php
class Boeking
{
    public string $klantNaam;
    public ?string $tarieven;
    public int $id;
    public int $klantId;
    public int $plaatsId;
    public string $datumAankomst;
    public string $datumVertrek;
    public int $volwassenen;
    public int $kinderen;
    public string $status;

    public static function getAll()
    {
        $conn = Database::start();

        $sql = "SELECT * FROM boekingen
                ORDER BY datum_aankomst";

        $result = $conn->query($sql);

        $boekingen = [];

        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {

                $boeking = new Boeking();

                $boeking->id = $row["boeking_id"];
                $boeking->klantId = $row["klant_id"];
                $boeking->plaatsId = $row["plaats_id"];
                $boeking->datumAankomst = $row["datum_aankomst"];
                $boeking->datumVertrek = $row["datum_vertrek"];
                $boeking->volwassenen = $row["volwassenen"];
                $boeking->kinderen = $row["kinderen"];
                $boeking->status = $row["status"];

                $boekingen[] = $boeking;
            }
        }

        $conn->close();

        return $boekingen;
    }

    public static function getAllWithDetails()
    {
        $conn = Database::start();

        $sql = "SELECT 
                boekingen.boeking_id,
                boekingen.klant_id,
                boekingen.plaats_id,
                boekingen.datum_aankomst,
                boekingen.datum_vertrek,
                boekingen.volwassenen,
                boekingen.kinderen,
                boekingen.status,
                klanten.volledige_naam,
                GROUP_CONCAT(
                    CONCAT(
                        extra_diensten.naam,
                        ' (',
                        boeking_extra.aantal,
                        'x)'
                    )
                    SEPARATOR ', '
                ) AS tarieven
            FROM boekingen

            INNER JOIN klanten
                ON boekingen.klant_id = klanten.klant_id

            LEFT JOIN boeking_extra
                ON boekingen.boeking_id = boeking_extra.boeking_id

            LEFT JOIN extra_diensten
                ON boeking_extra.dienst_id = extra_diensten.dienst_id

            GROUP BY 
                boekingen.boeking_id,
                boekingen.klant_id,
                boekingen.plaats_id,
                boekingen.datum_aankomst,
                boekingen.datum_vertrek,
                boekingen.volwassenen,
                boekingen.kinderen,
                boekingen.status,
                klanten.volledige_naam

            ORDER BY boekingen.datum_aankomst";

        $result = $conn->query($sql);

        $boekingen = [];

        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {

                $boeking = new Boeking();

                $boeking->id = $row["boeking_id"];
                $boeking->klantId = $row["klant_id"];
                $boeking->plaatsId = $row["plaats_id"];
                $boeking->datumAankomst = $row["datum_aankomst"];
                $boeking->datumVertrek = $row["datum_vertrek"];
                $boeking->volwassenen = $row["volwassenen"];
                $boeking->kinderen = $row["kinderen"];
                $boeking->status = $row["status"];

                // Extra gegevens voor het reserveringsoverzicht.
                $boeking->klantNaam = $row["volledige_naam"];
                $boeking->tarieven = $row["tarieven"];

                $boekingen[] = $boeking;
            }
        }

        $conn->close();

        return $boekingen;
    }

    public static function findById(int $id)
    {
        $conn = Database::start();

        $id = mysqli_real_escape_string($conn, $id);

        $sql = "SELECT * FROM boekingen
                WHERE boeking_id = '$id'";

        $result = $conn->query($sql);

        $boeking = null;

        if ($result->num_rows > 0) {

            $row = $result->fetch_assoc();

            $boeking = new Boeking();

            $boeking->id = $row["boeking_id"];
            $boeking->klantId = $row["klant_id"];
            $boeking->plaatsId = $row["plaats_id"];
            $boeking->datumAankomst = $row["datum_aankomst"];
            $boeking->datumVertrek = $row["datum_vertrek"];
            $boeking->volwassenen = $row["volwassenen"];
            $boeking->kinderen = $row["kinderen"];
            $boeking->status = $row["status"];
        }

        $conn->close();

        return $boeking;
    }

    public function insert()
    {
        $conn = Database::start();

        $klantId = mysqli_real_escape_string($conn, $this->klantId);
        $plaatsId = mysqli_real_escape_string($conn, $this->plaatsId);
        $datumAankomst = mysqli_real_escape_string($conn, $this->datumAankomst);
        $datumVertrek = mysqli_real_escape_string($conn, $this->datumVertrek);
        $volwassenen = mysqli_real_escape_string($conn, $this->volwassenen);
        $kinderen = mysqli_real_escape_string($conn, $this->kinderen);
        $status = mysqli_real_escape_string($conn, $this->status);

        $sql = "INSERT INTO boekingen (
                klant_id,
                plaats_id,
                datum_aankomst,
                datum_vertrek,
                volwassenen,
                kinderen,
                status
            ) VALUES (
                '$klantId',
                '$plaatsId',
                '$datumAankomst',
                '$datumVertrek',
                '$volwassenen',
                '$kinderen',
                '$status'
            )";

        $conn->query($sql);

        $this->id = $conn->insert_id;

        $conn->close();

        return $this->id;
    }

    public function update()
    {
        $conn = Database::start();

        $id = mysqli_real_escape_string($conn, $this->id);
        $klantId = mysqli_real_escape_string($conn, $this->klantId);
        $plaatsId = mysqli_real_escape_string($conn, $this->plaatsId);
        $datumAankomst = mysqli_real_escape_string($conn, $this->datumAankomst);
        $datumVertrek = mysqli_real_escape_string($conn, $this->datumVertrek);
        $volwassenen = mysqli_real_escape_string($conn, $this->volwassenen);
        $kinderen = mysqli_real_escape_string($conn, $this->kinderen);
        $status = mysqli_real_escape_string($conn, $this->status);

        $sql = "UPDATE boekingen SET
                    klant_id = '$klantId',
                    plaats_id = '$plaatsId',
                    datum_aankomst = '$datumAankomst',
                    datum_vertrek = '$datumVertrek',
                    volwassenen = '$volwassenen',
                    kinderen = '$kinderen',
                    status = '$status'
                WHERE boeking_id = '$id'";

        $conn->query($sql);

        $conn->close();
    }

    public function delete()
    {
        $conn = Database::start();

        $id = mysqli_real_escape_string($conn, $this->id);

        // Eerst de rekeningregels verwijderen.
        $conn->query("
        DELETE rr
        FROM rekening_regels rr
        INNER JOIN rekeningen r
        ON rr.rekening_id = r.rekening_id
        WHERE r.boeking_id = '$id'
    ");

        // Daarna de rekening verwijderen.
        $conn->query("
        DELETE FROM rekeningen
        WHERE boeking_id = '$id'
    ");

        // Daarna de extra diensten van de reservering verwijderen.
        $conn->query("
        DELETE FROM boeking_extra
        WHERE boeking_id = '$id'
    ");

        // Als laatste de reservering verwijderen.
        $conn->query("
        DELETE FROM boekingen
        WHERE boeking_id = '$id'
    ");

        $conn->close();
    }
}