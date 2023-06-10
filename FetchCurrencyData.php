<?php

require_once('DataService.php');

$dataService = new DataService("https://api.nbp.pl/api/exchangerates/tables/D");
try {
    $data = $dataService->getData();
} catch (Exception $e) {
    echo $e->getMessage();
    die();
}
$decodedData = json_decode($data);