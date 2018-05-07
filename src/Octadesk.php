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
    public $endpoint;
    public $verb = 'GET';
    public $responseType = 'application/json';
    public $headers = [];
    public $postFields = [];

    public function __construct($token = null)
    {
        $this->token = $token;

        if (!empty($this->token)) {
            $this->headers[] = 'Authorization: Bearer ' . $this->token;
        }
    }

    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;
    }

    public function isGet()
    {
        $this->verb = 'GET';
    }

    public function isPost()
    {
        $this->verb = 'POST';
    }

    public function isPut()
    {
        $this->verb = 'PUT';
    }

    public function queryApi()
    {
        $this->curl = curl_init();

        # Add the headers
        $this->headers[] = 'Accept: ' . $this->responseType;
        $this->headers[] = 'Content-Type: ' . $this->responseType;
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $this->headers);

        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->curl, CURLOPT_HEADER, 1);
        curl_setopt($this->curl, CURLOPT_URL, self::APIURL . $this->endpoint);

        if ($this->verb === 'POST') {
            curl_setopt($this->curl, CURLOPT_POST, 1);
        } elseif ($this->verb === 'PUT') {
            curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, "PUT");
        }

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
