<?php

class Rekening
{
    public int $id;
    public int $boekingId;
    public string $aangemaaktOp;
    public float $totaalbedrag;
    public string $betaalstatus;

    public static function getAll()
    {
        $conn = Database::start();

        $sql = "SELECT * FROM rekeningen
                ORDER BY rekening_id";

        $result = $conn->query($sql);

        $rekeningen = [];

        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {

                $rekening = new Rekening();

                $rekening->id = $row["rekening_id"];
                $rekening->boekingId = $row["boeking_id"];
                $rekening->aangemaaktOp = $row["aangemaakt_op"];
                $rekening->totaalbedrag = $row["totaalbedrag"];
                $rekening->betaalstatus = $row["betaalstatus"];

                $rekeningen[] = $rekening;
            }
        }

        $conn->close();

        return $rekeningen;
    }

    public static function findById(int $id)
    {
        $conn = Database::start();

        $id = mysqli_real_escape_string($conn, $id);

        $sql = "SELECT * FROM rekeningen
                WHERE rekening_id = '$id'";

        $result = $conn->query($sql);

        $rekening = null;

        if ($result->num_rows > 0) {

            $row = $result->fetch_assoc();

            $rekening = new Rekening();

            $rekening->id = $row["rekening_id"];
            $rekening->boekingId = $row["boeking_id"];
            $rekening->aangemaaktOp = $row["aangemaakt_op"];
            $rekening->totaalbedrag = $row["totaalbedrag"];
            $rekening->betaalstatus = $row["betaalstatus"];
        }

        $conn->close();

        return $rekening;
    }

    public function insert()
    {
        $conn = Database::start();

        $boekingId = mysqli_real_escape_string($conn, $this->boekingId);
        $aangemaaktOp = mysqli_real_escape_string($conn, $this->aangemaaktOp);
        $totaalbedrag = mysqli_real_escape_string($conn, $this->totaalbedrag);
        $betaalstatus = mysqli_real_escape_string($conn, $this->betaalstatus);

        $sql = "INSERT INTO rekeningen (
                boeking_id,
                aangemaakt_op,
                totaalbedrag,
                betaalstatus
            ) VALUES (
                '$boekingId',
                '$aangemaaktOp',
                '$totaalbedrag',
                '$betaalstatus'
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
        $boekingId = mysqli_real_escape_string($conn, $this->boekingId);
        $aangemaaktOp = mysqli_real_escape_string($conn, $this->aangemaaktOp);
        $totaalbedrag = mysqli_real_escape_string($conn, $this->totaalbedrag);
        $betaalstatus = mysqli_real_escape_string($conn, $this->betaalstatus);

        $sql = "UPDATE rekeningen SET
                    boeking_id = '$boekingId',
                    aangemaakt_op = '$aangemaaktOp',
                    totaalbedrag = '$totaalbedrag',
                    betaalstatus = '$betaalstatus'
                WHERE rekening_id = '$id'";

        $conn->query($sql);

        $conn->close();
    }

    public function delete()
    {
        $conn = Database::start();

        $id = mysqli_real_escape_string($conn, $this->id);

        $sql = "DELETE FROM rekeningen
                WHERE rekening_id = '$id'";

        $conn->query($sql);

        $conn->close();
    }
}