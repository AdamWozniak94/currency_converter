<?php

require_once('AbstractRepository.php');

class ConversionRepository extends AbstractRepository
{

    public function fetchAllRows()
    {
        $query = $this->mysqli->query(
            "SELECT c.amount, bc.code AS base_currency, tc.code AS target_currency, c.result FROM conversion AS c
                    JOIN currency AS bc ON c.base_currency_id = bc.id
                    JOIN currency AS tc ON c.target_currency_id = tc.id"
        );

        return $query->fetch_all(MYSQLI_ASSOC);
    }

    public function saveNewRow(float $amount, int $baseCurrencyId, int $targetCurrencyId, float $result)
    {
        $sql = "INSERT INTO conversion (`amount`, `base_currency_id`, `target_currency_id`, `result`) VALUES (?, ?, ?, ?)";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("diid", $amount, $baseCurrencyId, $targetCurrencyId, $result);
        $stmt->execute();
        $stmt->close();
    }
}