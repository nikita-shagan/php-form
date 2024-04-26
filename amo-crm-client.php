<?php

class AmoCrmClient {
    const subdomain = 'petrpetrushin01';
    const headers = [
        'Authorization: Bearer '
    ];
    const useragent = 'amoCRM-oAuth-client/1.0';
    const errors = [
        400 => 'Bad request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not found',
        500 => 'Internal server error',
        502 => 'Bad gateway',
        503 => 'Service unavailable',
    ];

    public static function post($url, $body) {
        $curl = curl_init();
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl,CURLOPT_USERAGENT, self::useragent);
        curl_setopt($curl,CURLOPT_URL, $url);
        curl_setopt($curl,CURLOPT_HTTPHEADER, self::headers);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl,CURLOPT_HEADER, false);
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
        $out = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $code = (int)$code;
    
        try {
            if ($code < 200 || $code > 204) {
                throw new Exception(isset(self::errors[$code]) ? self::errors[$code] : 'Undefined error', $code);
            }
        } catch(\Exception $e) {
            die('Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
        }

        return $out;
    }

    public static function get($url) {
        $curl = curl_init();
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl,CURLOPT_USERAGENT, self::useragent);
        curl_setopt($curl,CURLOPT_URL, $url);
        curl_setopt($curl,CURLOPT_HTTPHEADER, self::headers);
        curl_setopt($curl,CURLOPT_HEADER, false);
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
        $out = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $code = (int)$code;
    
        try {
            if ($code < 200 || $code > 204) {
                throw new Exception(isset(self::errors[$code]) ? self::errors[$code] : 'Undefined error', $code);
            }
        } catch(\Exception $e) {
            die('Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
        }

        return $out;
    }

    public static function createLead($data) {
        $link = 'https://' . self::subdomain . '.amocrm.ru/api/v4/leads';
        self::post($link, json_encode($data, true));
    }

    public static function getLeads() {
        $link = 'https://' . self::subdomain . '.amocrm.ru/api/v4/leads';
        $leads = json_decode(self::get($link), true);
        if ($leads !== null) {
            return $leads['_embedded']['leads'];
        } else {
            return [];
        }
    }
}
