<?php

require_once('Service/ConversionService.php');
require_once('Repository/ConversionRepository.php');

if (empty($_POST)) {
    error_log("No POST data - exiting");
    die();
}
$conversionService = new ConversionService();
$amount = $_POST['amount'];
$baseCurrencyId = $_POST['base_currency_id'];
$targetCurrencyId = $_POST['target_currency_id'];
$conversionResult = $conversionService->convert($amount, $baseCurrencyId, $targetCurrencyId);

$conversionRepository = new ConversionRepository();
$conversionRepository->saveNewRow($amount, $baseCurrencyId, $targetCurrencyId, $conversionResult);



