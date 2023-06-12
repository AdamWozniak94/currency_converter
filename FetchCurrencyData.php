<?php

require_once('Service/DataService.php');
require_once('Repository/CurrencyRepository.php');

// try to get data from API
$dataService = new DataService("https://api.nbp.pl/api/exchangerates/tables/A");
try {
    $data = $dataService->getData();
} catch (Exception $e) {
    error_log($e->getMessage());
    die();
}

// decode data from JSON and save into database
$decodedData = json_decode($data, true);
$currencyRepository = new CurrencyRepository();
$currencyRepository->saveOrUpdateRates($decodedData[0]['rates']);