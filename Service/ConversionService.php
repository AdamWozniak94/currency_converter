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
     * @param string $baseCurrencyCode
     * @param string $targetCurrencyCode
     * @return float
     */
    public function convert(float $amount, string $baseCurrencyCode, string $targetCurrencyCode): float
    {
        if ("PLN" == $baseCurrencyCode) {
            $result = $this->convertFromPln($amount, $targetCurrencyCode);
        } elseif ("PLN" == $targetCurrencyCode) {
            $result = $this->convertToPln($amount, $baseCurrencyCode);
        } else {
            // baseCurrency -> PLN -> targetCurrency
            $result = $this->convertFromPln($this->convertToPln($amount, $baseCurrencyCode), $targetCurrencyCode);
        }

        return round($result,2);
    }

    /**
     * @param float $amount
     * @param string $currencyCode
     * @return float
     */
    private function convertFromPln(float $amount, string $currencyCode): float
    {
        $currency = $this->currencyRepository->findOneByCode($currencyCode);

        return $amount / $currency['rate'] * $currency['amount'];
    }

    /**
     * @param float $amount
     * @param string $currencyCode
     * @return float
     */
    private function convertToPln(float $amount, string $currencyCode): float
    {
        $currency = $this->currencyRepository->findOneByCode($currencyCode);

        return $amount * $currency['rate'] / $currency['amount'];
    }
}