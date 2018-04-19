<?php
/**
 * Created by PhpStorm.
 * User: joao
 * Date: 16/04/18
 * Time: 09:51
 */

namespace marqu3s\octadesk;


abstract class Octadesk
{
    const APIURL = 'https://api.octadesk.services/';
    const TOKEN_EXPIRATION_MINUTES = 3;

    public $curl;
    public $token;
    public $responseType = 'application/json';
    public $headers = [];
    public $postFields = [];

    public function __construct($token = null)
    {
        $this->curl = curl_init();

        $this->token = $token;

        if (!empty($this->token)) {
            $this->headers[] = 'Authorization: Bearer ' . $this->token;
        }

        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->curl, CURLOPT_HEADER, 1);
    }

    public function setEndpoint($endpoint)
    {
        curl_setopt($this->curl, CURLOPT_URL, self::APIURL . $endpoint);
    }

    public function isPost()
    {
        curl_setopt($this->curl, CURLOPT_POST, 1);
    }

    public function isPut()
    {
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, "PUT");
    }

    public function queryApi()
    {
        # Add the headers
        $this->headers[] = 'Accept: ' . $this->responseType;
        $this->headers[] = 'Content-Type: ' . $this->responseType;
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $this->headers);

        # Post fields
        if (count($this->postFields)) {
            curl_setopt($this->curl, CURLOPT_POSTFIELDS, json_encode($this->postFields));
        }

        $response = curl_exec($this->curl);
        $httpResponseCode = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
        $headerSize = curl_getinfo($this->curl, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $headerSize);
        $body = substr($response, $headerSize);

        curl_close($this->curl);

        return [
            'httpResponseCode' => $httpResponseCode,
            'header' => $header,
            'body' => $body
        ];
    }
}
