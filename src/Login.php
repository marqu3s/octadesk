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
    public function loginApiToken($apiToken, $userEmail, $returnTokenOnly = true)
    {
        $this->setEndpoint('login/apiToken');
        $this->isPost();

        $this->headers[] = 'apiToken: ' . $apiToken;
        $this->headers[] = 'username: ' . $userEmail;

        $response = $this->queryApi();

        if ($returnTokenOnly) {
            $body = json_decode($response['body']);
            return $body->token;
        } else {
            return $response;
        }
    }

    public function validateSubDomain($subdomain)
    {
        $this->setEndpoint('validate?subdomain=' . $subdomain);

        return $this->queryApi();
    }
}
