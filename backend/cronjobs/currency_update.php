<?php

include_once __DIR__ . '/../config/Database.php';
include_once __DIR__ . '/../classes/Currency.php';
include_once __DIR__ . '/../api/CurrencyLayer.php';

$item = new Currency();

try {
    $data = CurrencyLayer::getExchangeRates();
} catch (Exception $e) {
    die($e->getMessage());
}

$data = json_decode($data);

if ($data->success) {
    foreach ($data->quotes as $currency => $exchange_rate) {
        $item->setCode(substr($currency, 3));
        $item->setExchangeRate($exchange_rate);

        if ($item->updateCurrency()) {
            echo "Currency {$item->getCode()} data updated.\n";
        } else {
            echo "Currency {$item->getCode()} data could not be updated\n";
        }
    }
} else {
    echo "Request returned with error\n";
}
