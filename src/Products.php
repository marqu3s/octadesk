<?php
/**
 * Created by PhpStorm.
 * User: joao
 * Date: 04/05/18
 * Time: 17:18
 */

namespace marqu3s\octadesk;


class Products extends Octadesk
{
    public function create($postFields)
    {
        $this->isPost();
        $this->postFields = $postFields;
        $this->setEndpoint('/');

        return $this->queryApi();
    }

    public function update($uuid, $postFields)
    {
        if (!isset($postFields['id'])) {
            $postFields['id'] = $uuid;
        }

        if (!isset($postFields['isEnabled'])) {
            $postFields['isEnabled'] = true;
        }

        $this->isPut();
        $this->postFields = $postFields;
        $this->setEndpoint('?id=' . $uuid);

        return $this->queryApi();
    }

    public function disable($uuid)
    {
        $postFields['isEnabled'] = false;

        return $this->update($uuid, $postFields);
    }


    /**
     * Set the endpoint to send the request to.
     *
     * @param string $endpoint
     */
    public function setEndpoint($endpoint = '')
    {
        $endpoint = 'products' . $endpoint;

        parent::setEndpoint($endpoint);
    }
}
