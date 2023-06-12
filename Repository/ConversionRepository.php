<?php

require_once('AbstractRepository.php');

class ConversionRepository extends AbstractRepository
{

    /**
     * @return array
     */
    public function fetchAllRows(): array
    {
        $query = $this->mysqli->query(
            "SELECT * FROM conversion");

        return $query->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * @param float $amount
     * @param string $baseCurrencyCode
     * @param string $targetCurrencyCode
     * @param float $result
     * @return void
     */
    public function saveNewRow(float $amount, string $baseCurrencyCode, string $targetCurrencyCode, float $result)
    {
        $sql = "INSERT INTO conversion (`amount`, `base_currency_code`, `target_currency_code`, `result`) VALUES (?, ?, ?, ?)";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("dssd", $amount, $baseCurrencyCode, $targetCurrencyCode, $result);
        $stmt->execute();
        $stmt->close();
    }
}