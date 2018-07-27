<?php
/**
 * Created by PhpStorm.
 * User: joao
 * Date: 16/04/18
 * Time: 09:52
 */

namespace marqu3s\octadesk;

/**
 * Class Login
 * @package marqu3s\octadesk
 */
class Login extends Octadesk
{
    /**
     * @param string $apiToken
     * @param string $userEmail
     * @param bool $returnTokenOnly
     *
     * @return array
     */
    public function loginApiToken($apiToken, $userEmail, $returnTokenOnly = true)
    {
        $this->setEndpoint('login/apiToken');
        $this->isPost();

        $this->headers[] = 'apiToken: ' . $apiToken;
        $this->headers[] = 'username: ' . $userEmail;

        $response = $this->queryApi();
        if ($response['httpResponseCode'] != 200) {
            \yii\helpers\VarDumper::dump($response); die;
        }

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
