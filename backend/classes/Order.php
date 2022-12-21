<?php

include_once __DIR__ . '/../config/Database.php';

class Order extends Database
{
    private $db_table = "orders";

    private $currency_id;
    private $exchange_rate;
    private $surcharge;
    private $surcharge_amount;
    private $purchased_amount;
    private $paid_amount;
    private $discount;
    private $discount_amount;
    private $date_created;

    public function createOrder()
    {
        $sqlQuery = "INSERT INTO
                        " . $this->db_table . "
                    SET
                        currency_id = :currency_id, 
                        exchange_rate = :exchange_rate, 
                        surcharge = :surcharge, 
                        surcharge_amount = :surcharge_amount, 
                        purchased_amount = :purchased_amount, 
                        paid_amount = :paid_amount,
                        discount = :discount, 
                        discount_amount = :discount_amount, 
                        date_created = :date_created";

        $order = self::getConnection()->prepare($sqlQuery);

        $currency_id = $this->getCurrencyId();
        $exchange_rate = $this->getExchangeRate();
        $surcharge = $this->getSurcharge();
        $surcharge_amount = $this->getSurchargeAmount();
        $purchased_amount = $this->getPurchasedAmount();
        $paid_amount = $this->getPaidAmount();
        $discount = $this->getDiscount();
        $discount_amount = $this->getDiscountAmount();
        $date_created = $this->getDateCreated();

        $this->setCurrencyId(htmlspecialchars(strip_tags($currency_id)));
        $this->setExchangeRate(htmlspecialchars(strip_tags($exchange_rate)));
        $this->setSurcharge(htmlspecialchars(strip_tags($surcharge)));
        $this->setSurchargeAmount(htmlspecialchars(strip_tags($surcharge_amount)));
        $this->setPurchasedAmount(htmlspecialchars(strip_tags($purchased_amount)));
        $this->setPaidAmount(htmlspecialchars(strip_tags($paid_amount)));
        $this->setDiscount(htmlspecialchars(strip_tags($discount)));
        $this->setDiscountAmount(htmlspecialchars(strip_tags($discount_amount)));
        $this->setDateCreated(htmlspecialchars(strip_tags($date_created)));

        $order->bindParam(":currency_id", $currency_id);
        $order->bindParam(":exchange_rate", $exchange_rate);
        $order->bindParam(":surcharge", $surcharge);
        $order->bindParam(":surcharge_amount", $surcharge_amount);
        $order->bindParam(":purchased_amount", $purchased_amount);
        $order->bindParam(":paid_amount", $paid_amount);
        $order->bindParam(":discount", $discount);
        $order->bindParam(":discount_amount", $discount_amount);
        $order->bindParam(":date_created", $date_created);

        return $order->execute();
    }

    public function setCurrencyId($currency_id)
    {
        $this->currency_id = $currency_id;
    }

    public function getCurrencyId()
    {
        return $this->currency_id;
    }

    public function setExchangeRate($exchange_rate)
    {
        $this->exchange_rate = $exchange_rate;
    }

    public function getExchangeRate()
    {
        return $this->exchange_rate;
    }

    public function setSurcharge($surcharge)
    {
        $this->surcharge = $surcharge;
    }

    public function getSurcharge()
    {
        return $this->surcharge;
    }

    public function setSurchargeAmount($surcharge_amount)
    {
        $this->surcharge_amount = $surcharge_amount;
    }

    public function getSurchargeAmount()
    {
        return $this->surcharge_amount;
    }

    public function setPurchasedAmount($purchased_amount)
    {
        $this->purchased_amount = $purchased_amount;
    }

    public function getPurchasedAmount()
    {
        return $this->purchased_amount;
    }

    public function setPaidAmount($paid_amount)
    {
        $this->paid_amount = $paid_amount;
    }

    public function getPaidAmount()
    {
        return $this->paid_amount;
    }

    public function setDiscount($discount)
    {
        $this->discount = $discount;
    }

    public function getDiscount()
    {
        return $this->discount;
    }

    public function setDiscountAmount($discount_amount)
    {
        $this->discount_amount = $discount_amount;
    }

    public function getDiscountAmount()
    {
        return $this->discount_amount;
    }

    public function setDateCreated($date_created)
    {
        $this->date_created = $date_created;
    }

    public function getDateCreated()
    {
        return $this->date_created;
    }
}
