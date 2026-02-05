<?php
namespace App\PaymentGateways\Medoro;
use Illuminate\Support\Facades\Storage;
use SimpleXMLElement;
use stdClass;

ini_set("soap.wsdl_cache_enabled", "0");

class MedoroEcommerce {

    public $config;

    private $_merchantkey	= null,
        $_systemkey 	= null;

    public function __construct($config = array()) {
        $this->config = $config;
        $this->loadKeys();
    }

    public function __call($name, $arguments) {
        return $this->exec($name, $arguments[0]);
    }

    public function prepare($array_data, $additional_fields=array()) {

        $clean_data = $this->arrayToXml(new SimpleXMLElement('<data />'), $array_data)->asXML();

        $sign = $this->sign($clean_data);
        $tmp  = $this->encrypt($clean_data);

        /* Base64 encode everything */
        $sign = base64_encode($sign);
        $key  = base64_encode($tmp['key']);
        $data = base64_encode($tmp['data']);

        /* Form request */
        $request = new StdClass();
        $request->INTERFACE = $this->config['merchant_id'];
        $request->KEY_INDEX = $this->config['key_index'];
        $request->KEY = $key;
        $request->DATA = $data;
        $request->SIGNATURE = $sign;

        return $request;

    }

    public function parse($response) {

        $sign = base64_decode($response->SIGNATURE);
        $key  = base64_decode($response->KEY);
        $data = base64_decode($response->DATA);

        $data = $this->decrypt($data, $key);

        if (!$this->checkSignature($data, $sign)) {
            throw new Exception('Decryption failed, invalid signature!');
        }

        return simplexml_load_string($data);

    }

    private function sign($clean_data) {
        $merchantkeyid = openssl_get_privatekey($this->_merchantkey);
        if (!openssl_sign($clean_data, $sign, $merchantkeyid, OPENSSL_ALGO_SHA256)) {
            throw new Exception('Signing failed: ' . openssl_error_string());
        }
        $this->tryOpensslFreeKey($merchantkeyid);

        return $sign;
    }

    private function checkSignature($data, $sign) {
        $systemkeyid = openssl_get_publickey($this->_systemkey);
        $res = (openssl_verify($data, $sign, $systemkeyid, OPENSSL_ALGO_SHA256) == 1);
        $this->tryOpensslFreeKey($systemkeyid);

        return $res;
    }

    private function encrypt($cleardata) {
        $systemkeyid = openssl_get_publickey($this->_systemkey);
        if (openssl_seal($cleardata, $data, $ekeys, array($systemkeyid), 'aes-256-ecb')) {
            $key = $ekeys[0];
        } else {
            throw new Exception('Encryption failed: ' . openssl_error_string());
        }
        $this->tryOpensslFreeKey($systemkeyid);

        return array(
            'data' => $data,
            'key' => $key,
        );
    }

    private function decrypt($data, $key) {
        $merchantkeyid = openssl_get_privatekey($this->_merchantkey);
        if (!openssl_open($data, $cleardata, $key, $merchantkeyid, 'aes-256-ecb')) {
            throw new Exception('Decryption failed: ' . openssl_error_string());
        }
        $this->tryOpensslFreeKey($merchantkeyid);

        return $cleardata;
    }

    public function loadKeys() {

        $merchant_key_path = storage_path($this->config['merchant_key']);

        if (!file_exists($merchant_key_path)) {
            throw new \Exception('Merchant key not found at: ' . $merchant_key_path);
        }

        $gateway_key_path = storage_path($this->config['gateway_key']);

        if (!file_exists($gateway_key_path)) {
            throw new \Exception('Gateway key not found at: ' . $gateway_key_path);
        }

        $m_keyfile = fopen($merchant_key_path, 'r');
        $this->_merchantkey = fread($m_keyfile, filesize($merchant_key_path));
        fclose($m_keyfile);

        $s_keyfile = fopen($gateway_key_path, 'r');
        $this->_systemkey = fread($s_keyfile, filesize($gateway_key_path));
        fclose($s_keyfile);

        unset($m_keyfile);
        unset($s_keyfile);
    }

    private function tryOpensslFreeKey($keyId) {
        if (PHP_VERSION_ID < 80000) {
            openssl_free_key($keyId);
        }
    }

    private function arrayToXml($xml, array $children) {
        foreach ($children as $name => $value) {
            (is_array($value)) ? $this->arrayToXml($xml->addChild($name), $value) : $xml->addChild($name, $value);
        }

        return $xml;
    }

}

class EcommerceSOAP {

    private $_ecom,
        $_soap;

    public function __construct(Ecommerce $ecom) {
        $this->_ecom = $ecom;
        $this->_soap = new SoapClient($ecom->config['wsdl'], array('exceptions' => true));
    }

    public function __call($method, $arguments) {
        $request  = $this->_ecom->prepare($arguments[0]);
        try {
            $response = $this->_soap->{$method}($request);
        }
        catch (SoapFault $e) {
            throw $e;
        }
        return $this->_ecom->parse($response);
    }

}

class EcommerceFORM {

    private static $required = array('INTERFACE', 'KEY_INDEX', 'KEY', 'DATA', 'SIGNATURE');

    private static $allowed_additional_fields = array(
        'Callback' => 'CALLBACK',
        'ErrorCallback' => 'ERROR_CALLBACK',
    );

    private $_ecom;

    public function __construct(MedoroEcommerce $ecom) {
        $this->_ecom = $ecom;
    }

    /**
     * Returns array which should be POST'ed to FORMs URL
     * May throw Exception
     */
    public function getRequest($data, $additional) {

        $request = $this->_ecom->prepare($data);

        /* Copy additional fields to request */
        foreach (array_keys(self::$allowed_additional_fields) as $key) {
            if (array_key_exists($key, $additional)) {
                $realKey = self::$allowed_additional_fields[$key];
                $request->$realKey = $additional[$key];
            }
        }

        return (array) $request;

    }

    /**
     * Takes POST array as an argument
     * May throw Exception
     */
    public function getResponse($response) {

        if (count(array_diff(self::$required, array_keys($response))) > 0) {
            throw new \Exception('Some of required POST params are not included!');
        }

        // Convert array to object
        $responseObj = new stdClass();
        foreach ($response as $key => $value) {
            $responseObj->$key = $value;
        }

        return $this->_ecom->parse($responseObj);

    }

}
