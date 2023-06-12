<?php

require_once('Service/ConversionService.php');
require_once('Repository/ConversionRepository.php');

// check data was sent at all
if (empty($_POST)) {
    error_log("No POST data - redirecting to conversions page");
    header("Location: conversions.php");
    exit();
}

// get data from $_POST
$amount = $_POST['amount'];
$baseCurrencyCode = $_POST['base_currency_code'];
$targetCurrencyCode = $_POST['target_currency_code'];

// both codes shouldn't be the same
if ($baseCurrencyCode == $targetCurrencyCode) {
    error_log("Currency codes are the same - redirecting to conversions page");
    header("Location: conversions.php");
    exit();
}

// convert one currency to another
$conversionService = new ConversionService();
$conversionResult = $conversionService->convert($amount, $baseCurrencyCode, $targetCurrencyCode);

// save conversion result to database
$conversionRepository = new ConversionRepository();
$conversionRepository->saveNewRow($amount, $baseCurrencyCode, $targetCurrencyCode, $conversionResult);

// redirect back to conversions page
header("Location: conversions.php");
exit();



