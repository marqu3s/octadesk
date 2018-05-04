<?php
/**
 * Created by PhpStorm.
 * User: joao
 * Date: 03/05/18
 * Time: 10:58
 */

namespace marqu3s\octadesk;


class CustomFields extends Octadesk
{
    public function getFieldDetails($uuid)
    {
        $this->setEndpoint($uuid);

        return $this->queryApi();
    }

    /**
     * Set the endpoint to send the request to.
     *
     * @param string $endpoint
     */
    public function setEndpoint($endpoint)
    {
        $endpoint = 'custom-fields/' . $endpoint;

        parent::setEndpoint($endpoint);
    }
}
