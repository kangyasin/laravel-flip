<?php

namespace Kangyasin\LaravelFlip\Flip;
use  Kangyasin\LaravelFlip\Exceptions\FlipException as Exception;

class Flip
{

  /**
    * Your merchant's server key
    * @static
    */
    public static $serverKey;

    /**
      * true for production
      * false for sandbox mode
      * @static
      */
    public static $isProduction;

    /**
    * Default options for every request
    * @static
    */
    public static $curlOptions = array();

    const SANDBOX_BASE_URL = 'https://bigflip.id/big_sandbox_api/';
    const PRODUCTION_BASE_URL = 'https://bigflip.id/api/';
    const SNAP_SANDBOX_BASE_URL = 'https://bigflip.id/big_sandbox_api/';
    const SNAP_PRODUCTION_BASE_URL = 'https://bigflip.id/api/';


    public function config($params)
    {
        Flip::$serverKey = $params['server_key'];
        Flip::$isProduction = $params['production'];
    }

    /**
    * @return string Veritrans API URL, depends on $isProduction
    */
    public static function getBaseUrl()
    {
        return Flip::$isProduction ?
        Flip::PRODUCTION_BASE_URL : Flip::SANDBOX_BASE_URL;
    }

    public static function getSnapBaseUrl()
    {
        return Flip::$isProduction ?
        Flip::SNAP_PRODUCTION_BASE_URL : Flip::SNAP_SANDBOX_BASE_URL;
    }

    /**
     * Send GET request
     * @param string  $url
     * @param string  $server_key
     * @param mixed[] $data_hash
     */
    public static function get($url, $server_key, $data_hash, $id_empotency = '')
    {
        return self::remoteCall($url, $server_key, $data_hash, false, $id_empotency);
    }

    /**
     * Send POST request
     * @param string  $url
     * @param string  $server_key
     * @param mixed[] $data_hash
     */
    public static function post($url, $server_key, $data_hash, $id_empotency = '')
    {
        return self::remoteCall($url, $server_key, $data_hash, true, $id_empotency);
    }

    /**
   * Actually send request to API server
   * @param string  $url
   * @param string  $server_key
   * @param mixed[] $data_hash
   * @param bool    $post
   */
    public static function remoteCall($url, $server_key, $data_hash, $post = true, $id_empotency = '')
    {
        $ch = curl_init();

        $curl_options = array(
        CURLOPT_URL => $url,
        CURLOPT_HTTPHEADER => array(
          'Content-Type: application/x-www-form-urlencoded',
          'Authorization: Basic ' . base64_encode($server_key . ':'),
          'idempotency-key:' . $id_empotency,
        ),
        CURLOPT_RETURNTRANSFER => 1,
        // CURLOPT_CAINFO => dirname(__FILE__) . "/data/cacert.pem"
        );

        if (count(Flip::$curlOptions)) {
            if (Flip::$curlOptions[CURLOPT_HTTPHEADER]) {
                $mergedHeders = array_merge($curl_options[CURLOPT_HTTPHEADER], Flip::$curlOptions[CURLOPT_HTTPHEADER]);
                $headerOptions = array( CURLOPT_HTTPHEADER => $mergedHeders );
            } else {
                $mergedHeders = array();
            }

            $curl_options = array_replace_recursive($curl_options, Flip::$curlOptions, $headerOptions);
        }

        if ($post) {
            $curl_options[CURLOPT_POST] = 1;

            if ($data_hash) {
                $curl_options[CURLOPT_POSTFIELDS] = $data_hash;
            } else {
                $curl_options[CURLOPT_POSTFIELDS] = '';
            }
        }
        curl_setopt_array($ch, $curl_options);

        $result = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        if ($result === false) {
            throw new Exception('CURL Error: ' . curl_error($ch), curl_errno($ch));
        } else {
            $result_array = json_decode($result);
            if ($info['http_code'] != 200) {
                $message = json_encode($result_array);
                throw new Exception($message, $info['http_code']);
            } else {
                return $result_array;
            }
        }
    }

    public static function getSnapToken($params)
    {
        $result = Flip::post(
            Flip::getSnapBaseUrl() . 'v2/transactions',
            Flip::$serverKey,
            $params
        );

        return $result->token;
    }

    public static function postSnapBankInquiry($params, $id_empotency = '')
    {
        $result = Flip::post(
            Flip::getSnapBaseUrl() . 'v2/disbursement/bank-account-inquiry',
            Flip::$serverKey,
            $params,
            $id_empotency
        );
        return $result;
    }

    public static function postSnapDisbursementInquiry($params, $id_empotency = '')
    {
        $result = Flip::post(
            Flip::getSnapBaseUrl() . 'v3/disbursement',
            Flip::$serverKey,
            $params,
            $id_empotency
        );
        return $result;
    }

    public static function getSnapBalance($params = [])
    {
        $result = Flip::get(
            Flip::getSnapBaseUrl() . 'v2/general/balance',
            Flip::$serverKey,
            $params,
        );

        return $result;
    }

    public static function getDisbursement($params = [], $flip_id)
    {
        // dd($params);
        $url = Flip::getSnapBaseUrl() . 'v2/disbursement/'.$flip_id;
        if($flip_id === '')
        {
            $url = Flip::getSnapBaseUrl() . 'v2/disbursement?'.$params;
        }
        $result = Flip::get(
            $url,
            Flip::$serverKey,
            $params,
        );

        return $result;
    }

    public static function getSpecialByIdDisbursement($params = [], $flip_id)
    {
        $url = Flip::getSnapBaseUrl() . 'v3/disbursement?id='.$flip_id;
        if($flip_id === '')
        {
            $url = Flip::getSnapBaseUrl() . 'v3/disbursement';
        }
        $result = Flip::get(
            $url,
            Flip::$serverKey,
            $params,
        );

        return $result;
    }

    public static function getSpecialByIdEmpotencyDisbursement($params = [], $id_empotency)
    {
        $url = Flip::getSnapBaseUrl() . 'v3/get-disbursement?idempotency-key='.$id_empotency;
        if($id_empotency === '')
        {
            $url = Flip::getSnapBaseUrl() . 'v3/get-disbursement';
        }
        $result = Flip::get(
            $url,
            Flip::$serverKey,
            $params
        );

        return $result;
    }

    public static function getCityList($params = [])
    {
        $result = Flip::get(
            Flip::getSnapBaseUrl() . 'v2/disbursement/city-list',
            Flip::$serverKey,
            $params
        );
        return $result;
    }

    public static function getCountryList($params = [])
    {
        $result = Flip::get(
            Flip::getSnapBaseUrl() . 'v2/disbursement/country-list',
            Flip::$serverKey,
            $params
        );
        return $result;
    }

    public static function getCityCountryList($params = [])
    {
        $result = Flip::get(
            Flip::getSnapBaseUrl() . 'v2/disbursement/city-country-list',
            Flip::$serverKey,
            $params
        );
        return $result;
    }
}
