<?php

class DashboardStatistieken
{
    public static function getOverzicht()
    {
        $conn = Database::start();

        $sql = "
            SELECT

                (
                    SELECT COALESCE(SUM(totaalbedrag), 0)
                    FROM rekeningen
                    WHERE betaalstatus = 'betaald'
                ) AS totale_inkomsten,

                (
                    SELECT COUNT(*)
                    FROM boekingen
                ) AS totale_reserveringen,

                (
                    SELECT COUNT(*)
                    FROM klanten
                ) AS totale_klanten
        ";

        $result = $conn->query($sql);

        if (!$result) {
            $conn->close();
            return [
                "totale_inkomsten" => 0,
                "totale_reserveringen" => 0,
                "totale_klanten" => 0
            ];
        }

        $gegevens = $result->fetch_assoc();

        $conn->close();

        return [
            "totale_inkomsten" => (float) $gegevens["totale_inkomsten"],
            "totale_reserveringen" => (int) $gegevens["totale_reserveringen"],
            "totale_klanten" => (int) $gegevens["totale_klanten"]
        ];
    }
}