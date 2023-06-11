<?php

require_once('AbstractRepository.php');

class CurrencyRepository extends AbstractRepository
{

    public function fetchAllRows()
    {
        // TODO: Implement fetchAllRows() method.
    }

    public function saveOrUpdateRates(array $data)
    {
        $sql = "INSERT INTO currency (`name`, `code`, `amount`, `rate`) VALUES (?, ?, ?, ?)";
        $stmt = $this->mysqli->prepare($sql);

        $this->mysqli->query("START TRANSACTION");
        foreach ($data as $datum) {
            $amount = 1;
            $rate = $datum['mid'];
            while ($rate < 0.01) {
                $amount *= 100;
                $rate *= 100;
            }
            $rate *= 100;
            $stmt->bind_param("ssii", $datum['currency'], $datum['code'], $amount, $rate);
            $stmt->execute();
        }

        $stmt->close();
        $this->mysqli->query("COMMIT");
    }
}