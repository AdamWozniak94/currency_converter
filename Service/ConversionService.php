<?php

require_once('Repository/CurrencyRepository.php');

class ConversionService
{
    private CurrencyRepository $currencyRepository;

    public function __construct()
    {
        $this->currencyRepository = new CurrencyRepository;
    }


    /**
     * @param float $amount
     * @param int $baseCurrencyId
     * @param int $targetCurrencyId
     * @return float
     */
    public function convert(float $amount, int $baseCurrencyId, int $targetCurrencyId): float
    {
        // 0 is PLN
        if (0 == $baseCurrencyId) {
            $result = $this->convertFromPln($amount, $targetCurrencyId);
        } elseif (0 == $targetCurrencyId) {
            $result = $this->convertToPln($amount, $baseCurrencyId);
        } else {
            $result = $this->convertFromPln($this->convertToPln($amount, $baseCurrencyId), $targetCurrencyId);
        }

        return round($result,2);
    }

    /**
     * @param float $amount
     * @param int $currencyId
     * @return float
     */
    private function convertFromPln(float $amount, int $currencyId): float
    {
        $currency = $this->currencyRepository->findOneById($currencyId);

        return $amount / $currency['rate'] * $currency['amount'];
    }

    /**
     * @param float $amount
     * @param int $currencyId
     * @return float
     */
    private function convertToPln(float $amount, int $currencyId): float
    {
        $currency = $this->currencyRepository->findOneById($currencyId);

        return $amount * $currency['rate'] / $currency['amount'];
    }
}