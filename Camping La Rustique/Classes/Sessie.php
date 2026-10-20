<?php

class Sessie
{
    public string $sessionId;
    public string $userId;
    public string $sessionKey;
    public string $sessionStart;
    public string $sessionEnd;

    public function insert()
    {
        $conn = Database::start();

        $userId = mysqli_real_escape_string($conn, $this->userId);
        $key = mysqli_real_escape_string($conn, $this->sessionKey);
        $start = mysqli_real_escape_string($conn, $this->sessionStart);
        $end = mysqli_real_escape_string($conn, $this->sessionEnd);

        $sql = "INSERT INTO sessies (
            account_id,
            session_key,
            gestart_op,
            verloopt_op
        ) VALUES (
            '$userId',
            '$key',
            '$start',
            '$end'
        )";

        $conn->query($sql);
        $conn->close();
    }

    public static function vindActieveSessie($sessionKey = "")
    {
        $sessie = null;

        $conn = Database::start();

        if (empty($sessionKey)) {
            return null;
        }

        $key = mysqli_real_escape_string($conn, $sessionKey);

        $query = "SELECT * FROM sessies
                  WHERE session_key = '$key'
                  AND verloopt_op > '" . date("Y-m-d H:i:s") . "'";

        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $rij = $result->fetch_assoc();

            $sessie = new Sessie();
            $sessie->sessionId = $rij['sessie_id'];
            $sessie->userId = $rij['account_id'];
            $sessie->sessionKey = $rij['session_key'];
            $sessie->sessionStart = $rij['gestart_op'];
            $sessie->sessionEnd = $rij['verloopt_op'];
        }

        $conn->close();

        return $sessie;
    }

    public static function logout($sessionKey)
    {
        $conn = Database::start();

        $key = mysqli_real_escape_string($conn, $sessionKey);

        $sql = "UPDATE sessies
                SET verloopt_op = '" . date("Y-m-d H:i:s") . "'
                WHERE session_key = '$key'";

        $conn->query($sql);
        $conn->close();
    }
}