<?php

class CurrencyLayer
{
    public static function getExchangeRates()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.apilayer.com/currency_data/live?source=USD&currencies=JPY%2CEUR%2CGBP",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: text/plain",
                "apikey: zZtumHMhASTqKhnTuvMCSRe0GoewYymy"
            ),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET"
        ));

        $response = curl_exec($curl);

        if ($response === false) {
            throw new Exception("CURL Error: " . curl_error($curl));
        }

        $responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        /*
         * 4xx status codes are client errors
         * 5xx status codes are server errors
         */
        if ($responseCode >= 400) {
            throw new Exception("HTTP Error: " . $responseCode);
        }

        curl_close($curl);
        return $response;
    }
}
