<?php

class Kampeerplaats
{
    public int $id;
    public int $plaatsNummer;
    public string $categorie;
    public float $nachtprijs;
    public int $beschikbaar;

    public static function getAll()
    {
        self::updateBeschikbaarheid();
        
        $conn = Database::start();

        $sql = "SELECT * FROM kampeerplaatsen
                ORDER BY plaats_nummer";

        $result = $conn->query($sql);

        $plaatsen = [];

        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {

                $plaats = new Kampeerplaats();

                $plaats->id = $row["plaats_id"];
                $plaats->plaatsNummer = $row["plaats_nummer"];
                $plaats->categorie = $row["categorie"];
                $plaats->nachtprijs = $row["nachtprijs"];
                $plaats->beschikbaar = $row["beschikbaar"];

                $plaatsen[] = $plaats;
            }
        }

        $conn->close();

        return $plaatsen;
    }

    public static function findById(int $id)
    {
        $conn = Database::start();

        $id = mysqli_real_escape_string($conn, $id);

        $sql = "SELECT * FROM kampeerplaatsen
                WHERE plaats_id = '$id'";

        $result = $conn->query($sql);

        $plaats = null;

        if ($result->num_rows > 0) {

            $row = $result->fetch_assoc();

            $plaats = new Kampeerplaats();

            $plaats->id = $row["plaats_id"];
            $plaats->plaatsNummer = $row["plaats_nummer"];
            $plaats->categorie = $row["categorie"];
            $plaats->nachtprijs = $row["nachtprijs"];
            $plaats->beschikbaar = $row["beschikbaar"];
        }

        $conn->close();

        return $plaats;
    }

    public function insert()
    {
        $conn = Database::start();

        $plaatsNummer = mysqli_real_escape_string($conn, $this->plaatsNummer);
        $categorie = mysqli_real_escape_string($conn, $this->categorie);
        $nachtprijs = mysqli_real_escape_string($conn, $this->nachtprijs);
        $beschikbaar = mysqli_real_escape_string($conn, $this->beschikbaar);

        $sql = "INSERT INTO kampeerplaatsen (
                    plaats_nummer,
                    categorie,
                    nachtprijs,
                    beschikbaar
                ) VALUES (
                    '$plaatsNummer',
                    '$categorie',
                    '$nachtprijs',
                    '$beschikbaar'
                )";

        $conn->query($sql);

        $conn->close();
    }

    public static function getBeschikbaarVoorPeriode($start, $einde)
    {
        $conn = Database::start();

        $start = mysqli_real_escape_string($conn, $start);
        $einde = mysqli_real_escape_string($conn, $einde);

        $sql = "SELECT *
            FROM kampeerplaatsen
            WHERE beschikbaar = 1
            AND plaats_id NOT IN (
                SELECT plaats_id
                FROM boekingen
                WHERE status != 'geannuleerd'
                AND datum_aankomst < '$einde'
                AND datum_vertrek > '$start'
            )
            ORDER BY plaats_nummer";

        $result = $conn->query($sql);

        $campingplekken = [];

        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {

                $campingplek = new Kampeerplaats();

                $campingplek->id = $row["plaats_id"];
                $campingplek->plaatsNummer = $row["plaats_nummer"];
                $campingplek->categorie = $row["categorie"];
                $campingplek->nachtprijs = $row["nachtprijs"];
                $campingplek->beschikbaar = $row["beschikbaar"];

                $campingplekken[] = $campingplek;
            }
        }

        $conn->close();

        return $campingplekken;
    }

    public static function updateBeschikbaarheid()
    {
        $conn = Database::start();

        $sql = "
        UPDATE kampeerplaatsen kp

        LEFT JOIN boekingen b
        ON kp.plaats_id = b.plaats_id

        AND b.status != 'geannuleerd'

        AND NOW() >= b.datum_aankomst
        AND NOW() < b.datum_vertrek

        SET kp.beschikbaar =
        CASE
            WHEN b.boeking_id IS NULL THEN 1
            ELSE 0
        END
    ";

        $conn->query($sql);

        $conn->close();
    }

    public static function isBeschikbaarVoorPeriode($id, $start, $einde)
    {
        $conn = Database::start();

        $id = mysqli_real_escape_string($conn, $id);
        $start = mysqli_real_escape_string($conn, $start);
        $einde = mysqli_real_escape_string($conn, $einde);

        $sql = "SELECT plaats_id
            FROM boekingen
            WHERE plaats_id = '$id'
            AND status != 'geannuleerd'
            AND datum_aankomst < '$einde'
            AND datum_vertrek > '$start'";

        $result = $conn->query($sql);

        $beschikbaar = $result->num_rows == 0;

        $conn->close();

        return $beschikbaar;
    }

    public function update()
    {
        $conn = Database::start();

        $id = mysqli_real_escape_string($conn, $this->id);
        $plaatsNummer = mysqli_real_escape_string($conn, $this->plaatsNummer);
        $categorie = mysqli_real_escape_string($conn, $this->categorie);
        $nachtprijs = mysqli_real_escape_string($conn, $this->nachtprijs);
        $beschikbaar = mysqli_real_escape_string($conn, $this->beschikbaar);

        $sql = "UPDATE kampeerplaatsen SET
                    plaats_nummer = '$plaatsNummer',
                    categorie = '$categorie',
                    nachtprijs = '$nachtprijs',
                    beschikbaar = '$beschikbaar'
                WHERE plaats_id = '$id'";

        $conn->query($sql);

        $conn->close();
    }

    public function delete()
    {
        $conn = Database::start();

        $id = mysqli_real_escape_string($conn, $this->id);

        $sql = "DELETE FROM kampeerplaatsen
                WHERE plaats_id = '$id'";

        $conn->query($sql);

        $conn->close();
    }
}