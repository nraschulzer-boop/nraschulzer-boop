<?php

class Chat
{
    public int $id;
    public int $accountId;
    public string $naam;
    public string $rol;
    public string $bericht;
    public string $verstuurdOp;


    public static function getAll()
    {
        $conn = Database::start();

        $sql = "SELECT
                    chatberichten.chat_id,
                    chatberichten.account_id,
                    chatberichten.bericht,
                    chatberichten.verstuurd_op,
                    accounts.volledige_naam,
                    accounts.rol
                FROM chatberichten
                INNER JOIN accounts
                ON chatberichten.account_id = accounts.account_id
                ORDER BY chatberichten.verstuurd_op ASC";

        $result = $conn->query($sql);

        $berichten = [];

        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {

                $chat = new Chat();

                $chat->id = $row["chat_id"];
                $chat->accountId = $row["account_id"];
                $chat->naam = $row["volledige_naam"];
                $chat->rol = $row["rol"];
                $chat->bericht = $row["bericht"];
                $chat->verstuurdOp = $row["verstuurd_op"];

                $berichten[] = $chat;
            }
        }

        $conn->close();

        return $berichten;
    }


    public function insert()
    {
        $conn = Database::start();

        $accountId = mysqli_real_escape_string(
            $conn,
            $this->accountId
        );

        $bericht = mysqli_real_escape_string(
            $conn,
            $this->bericht
        );

        $sql = "INSERT INTO chatberichten (
                    account_id,
                    bericht
                ) VALUES (
                    '$accountId',
                    '$bericht'
                )";

        $conn->query($sql);

        $conn->close();
    }


    public static function deleteById(int $id)
    {
        $conn = Database::start();

        $id = mysqli_real_escape_string($conn, $id);

        $sql = "DELETE FROM chatberichten
                WHERE chat_id = '$id'";

        $conn->query($sql);

        $conn->close();
    }
}