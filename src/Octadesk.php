<?php
/**
 * Created by PhpStorm.
 * User: joao
 * Date: 16/04/18
 * Time: 09:51
 */

namespace marqu3s\octadesk;


class Octadesk
{
    const APIURL = 'https://api.octadesk.services/';

    public $curl;
    public $responseType = 'application/json';
    public $headers = [];

    public function __construct()
    {
        $this->curl = curl_init();

        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->curl, CURLOPT_HEADER, 1);
    }

    public function queryApi()
    {
        # Add the headers
        $this->headers[] = 'Accept: ' . $this->responseType;
        $this->headers[] = 'Content-Type: ' . $this->responseType;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

        $response = curl_exec($ch);
        $httpResponseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $headerSize);
        $body = substr($response, $headerSize);

        curl_close($ch);

        return [
            'httpResponseCode' => $httpResponseCode,
            'header' => $header,
            'body' => $body
        ];
    }
}
