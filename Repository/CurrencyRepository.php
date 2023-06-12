<?php

require_once('AbstractRepository.php');

class CurrencyRepository extends AbstractRepository
{

    /**
     * @return array
     */
    public function fetchAllRows(): array
    {
        $query = $this->mysqli->query("SELECT * FROM currency");

        return $query->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * @param int $id
     * @return array|false|null
     */
    public function findOneById(int $id)
    {
        $stmt = $this->mysqli->prepare("SELECT * FROM currency WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    /**
     * @param array $data
     * @return void
     */
    public function saveOrUpdateRates(array $data)
    {
        $sql = "INSERT INTO currency (`name`, `code`, `amount`, `rate`) VALUES (?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE `rate`= VALUES(rate)";
        $stmt = $this->mysqli->prepare($sql);

        $this->mysqli->query("START TRANSACTION");
        foreach ($data as $datum) {
            $amount = 1;
            $rate = $datum['mid'];
            while ($rate < 0.01) {
                $amount *= 100;
                $rate *= 100;
            }
            $stmt->bind_param("ssid", $datum['currency'], $datum['code'], $amount, $rate);
            $stmt->execute();
        }

        $stmt->close();
        $this->mysqli->query("COMMIT");
    }
}