<?php

require_once('DataService.php');
require_once('Repository/CurrencyRepository.php');

$dataService = new DataService("https://api.nbp.pl/api/exchangerates/tables/A");
try {
    $data = $dataService->getData();
} catch (Exception $e) {
    error_log($e->getMessage());
    die();
}
$decodedData = json_decode($data, true);
$currencyRepository = new CurrencyRepository();
$currencyRepository->saveOrUpdateRates($decodedData[0]['rates']);