<?php

include_once __DIR__ . '/../config/Database.php';

class Currency extends Database
{
    private $db_table = "currencies";

    private $id;
    private $name;
    private $code;
    private $exchange_rate;
    private $surcharge;
    private $discount;

    public function getCurrencies()
    {
        $sqlQuery = "SELECT id, code, exchange_rate, surcharge FROM " . $this->db_table . " WHERE id <> 1";
        $stmt = self::getConnection()->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }

    public function getSingleCurrency($currency_id)
    {
        if(!isset($currency_id)){
            die('No currency ID');
        }

        $sqlQuery = "SELECT
                        id, 
                        code, 
                        discount,
                        exchange_rate, 
                        surcharge
                    FROM
                        " . $this->db_table . "
                    WHERE 
                        id = ?
                    LIMIT 0,1";

        $stmt = self::getConnection()->prepare($sqlQuery);
        $stmt->bindParam(1, $currency_id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->setId($currency_id);
        $this->setExchangeRate($dataRow['exchange_rate']);
        $this->setSurcharge($dataRow['surcharge']);
        $this->setDiscount($dataRow['discount']);
    }

    public function updateCurrency()
    {
        $sqlQuery = "UPDATE
                        " . $this->db_table . "
                    SET
                        exchange_rate = :exchange_rate
                    WHERE 
                        code = :code";

        $stmt = self::getConnection()->prepare($sqlQuery);

        $this->setExchangeRate(htmlspecialchars(strip_tags($this->getExchangeRate())));
        $this->setCode(htmlspecialchars(strip_tags($this->getCode())));

        $stmt->bindValue(":exchange_rate", $this->getExchangeRate());
        $stmt->bindValue(":code", $this->getCode());

        return $stmt->execute();
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setExchangeRate($exchange_rate)
    {
        $this->exchange_rate = $exchange_rate;
    }

    public function setSurcharge($surcharge)
    {
        $this->surcharge = $surcharge;
    }

    public function setDiscount($discount)
    {
        $this->discount = $discount;
    }

    public function setCode($code)
    {
        $this->code = $code;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getId()
    {
       return $this->id;
    }

    public function getName()
    {
       return $this->name;
    }

    public function getCode()
    {
       return $this->code;
    }
    
    public function getSurcharge()
    {
       return $this->surcharge;
    }
    
    public function getDiscount()
    {
       return $this->discount;
    }
    
    public function getExchangeRate()
    {
       return $this->exchange_rate;
    }
}
