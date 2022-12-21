<?php

include_once __DIR__ . '/../classes/Order.php';
include_once __DIR__ . '/../classes/Currency.php';

$currency_id = isset($_POST['currency_id']) ? $_POST['currency_id'] : null;
$amount = isset($_POST['amount']) ? $_POST['amount'] : null;

$currency = new Currency();
$currency->getSingleCurrency($currency_id);

$item = new Order();

$item->setCurrencyId($currency->getId());
$item->setExchangeRate($currency->getExchangeRate());
$item->setSurcharge($currency->getSurcharge());
$item->setSurchargeAmount($amount / $currency->getSurcharge());
$item->setPurchasedAmount($amount * $currency->getExchangeRate());
$item->setPaidAmount($amount);

if ($currency->getDiscount() > 0) {
    $item->setDiscount($currency->getDiscount());
    $item->setDiscountAmount(($amount / $currency->getDiscount()) * $currency->getExchangeRate());
} else {
    $item->setDiscount(0);
    $item->setDiscountAmount(0);
}

$item->setDateCreated(date("Y-m-d H:i:s"));

if ($item->createOrder()) {
    echo json_encode("Order created");
    sendMail($item);
} else {
    echo json_encode("Order could not be created");
}

function sendMail($item)
{
    if ($item->getCurrencyId() == 3) {
        $to = 'cicmil.milos@gmail.com';
        $subject = 'Mail sent from sendmail PHP script';

        $date_created = strtotime($item->getDateCreated());
        $date_created = date('d.m.Y', $date_created);

        //TEXT at left margin because of end of file error
        $message = <<<TEXT
                        <p>
                        Exchange rate: {$item->getExchangeRate()}<br />
                        Surcharge: {$item->getSurcharge()}<br />
                        Surcharge amount: {$item->getSurchargeAmount()}<br />
                        Purchased amount: {$item->getPurchasedAmount()}<br />
                        Paid amount: {$item->getPaidAmount()}<br />
                        Discount: {$item->getDiscount()}<br />
                        Discount amount: {$item->getDiscountAmount()}<br />
                        Order created: {$date_created}<br />
                        </p>
TEXT;

        if (mail($to, $subject, nl2br($message))) {
            echo 'Mail sent successfully.';
        } else {
            echo 'Unable to send mail. Please try again.';
        }
    }
}
