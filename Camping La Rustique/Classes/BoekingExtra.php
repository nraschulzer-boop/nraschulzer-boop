<?php

class BoekingExtra
{
    public int $id;
    public int $boekingId;
    public int $dienstId;
    public int $aantal;

    public static function getAll()
    {
        $conn = Database::start();

        $sql = "SELECT * FROM boeking_extra
                ORDER BY boeking_extra_id";

        $result = $conn->query($sql);

        $boekingenExtra = [];

        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {

                $boekingExtra = new BoekingExtra();

                $boekingExtra->id = $row["boeking_extra_id"];
                $boekingExtra->boekingId = $row["boeking_id"];
                $boekingExtra->dienstId = $row["dienst_id"];
                $boekingExtra->aantal = $row["aantal"];

                $boekingenExtra[] = $boekingExtra;
            }
        }

        $conn->close();

        return $boekingenExtra;
    }

    public static function findById(int $id)
    {
        $conn = Database::start();

        $id = mysqli_real_escape_string($conn, $id);

        $sql = "SELECT * FROM boeking_extra
                WHERE boeking_extra_id = '$id'";

        $result = $conn->query($sql);

        $boekingExtra = null;

        if ($result->num_rows > 0) {

            $row = $result->fetch_assoc();

            $boekingExtra = new BoekingExtra();

            $boekingExtra->id = $row["boeking_extra_id"];
            $boekingExtra->boekingId = $row["boeking_id"];
            $boekingExtra->dienstId = $row["dienst_id"];
            $boekingExtra->aantal = $row["aantal"];
        }

        $conn->close();

        return $boekingExtra;
    }

    public function insert()
    {
        $conn = Database::start();

        $boekingId = mysqli_real_escape_string($conn, $this->boekingId);
        $dienstId = mysqli_real_escape_string($conn, $this->dienstId);
        $aantal = mysqli_real_escape_string($conn, $this->aantal);

        $sql = "INSERT INTO boeking_extra (
                    boeking_id,
                    dienst_id,
                    aantal
                ) VALUES (
                    '$boekingId',
                    '$dienstId',
                    '$aantal'
                )";

        $conn->query($sql);

        $conn->close();
    }

    public function update()
    {
        $conn = Database::start();

        $id = mysqli_real_escape_string($conn, $this->id);
        $boekingId = mysqli_real_escape_string($conn, $this->boekingId);
        $dienstId = mysqli_real_escape_string($conn, $this->dienstId);
        $aantal = mysqli_real_escape_string($conn, $this->aantal);

        $sql = "UPDATE boeking_extra SET
                    boeking_id = '$boekingId',
                    dienst_id = '$dienstId',
                    aantal = '$aantal'
                WHERE boeking_extra_id = '$id'";

        $conn->query($sql);

        $conn->close();
    }

    public function delete()
    {
        $conn = Database::start();

        $id = mysqli_real_escape_string($conn, $this->id);

        $sql = "DELETE FROM boeking_extra
                WHERE boeking_extra_id = '$id'";

        $conn->query($sql);

        $conn->close();
    }
}