<?php
//application/libraries/CreatorJwt.php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/JWT.php';

class CreatorJwt
{
    /*************This function generate token private key**************/

    private $key = "PSCRS-TOKEN-KEY";
    public function GenerateToken($data)
    {
        $jwt = JWT::encode($data, $this->key);
        return $jwt;
    }

    /*************This function DecodeToken token **************/

    public function DecodeToken($token)
    {
        $decoded = JWT::decode($token, $this->key, array('HS256'));
        $decodedData = (array) $decoded;

        return $decodedData;
    }

    /*************This function generate token private key**************/

    private $OneTimekey = "PSCRS-ONE-TIME-KEY";
    public function GenerateOTT($data)
    {
        $jwt = JWT::encode($data, $this->OneTimekey);
        return $jwt;
    }

    /*************This function DecodeToken token **************/

    public function DecodeOTT($token)
    {
        $decoded = JWT::decode($token, $this->OneTimekey, array('HS256'));
        $decodedData = (array) $decoded;

        return $decodedData;
    }
}
