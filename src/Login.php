<?php
/**
 * Created by PhpStorm.
 * User: joao
 * Date: 16/04/18
 * Time: 09:52
 */

namespace marqu3s\octadesk;


class Login extends Octadesk
{
    public function login()
    {

    }

    public function validateSubDomain($subdomain)
    {
        curl_setopt($this->curl, CURLOPT_URL, self::APIURL . 'validate?subdomain=' . $subdomain);

        return $this->queryApi();
    }
}
