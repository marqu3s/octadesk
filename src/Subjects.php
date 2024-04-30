<?php
/**
 * User: joao
 * Date: 30/04/24
 */

namespace marqu3s\octadesk;

/**
 * Class Subjects
 * @package marqu3s\octadesk
 */
class Subjects extends Octadesk
{
    /**
     * Retorna todos os assuntos.
     * É possível filtrar pelo ID de uma categoria de assunto.
     *
     * @param string|null $topicGroupId
     *
     * @return array
     */
    public function get($topicGroupId = null)
    {
        $path = '';
        if (!empty($topicGroupId)) {
            $path = '?topicGroupId=' . $topicGroupId;
        }

        $this->setEndpoint($path);

        return $this->queryApi();
    }

    /**
     * Busca os assuntos por palavra chave, se estão ativos e se são invisíveis para o cliente.
     *
     * @param string|null $keywork
     * @param string|null $onlyEnabledItems ('true ou 'false')
     * @param string|null $invisibleToClient ('true ou 'false')
     *
     * @return array
     */
    public function search($keywork = null, $onlyEnabledItems = null, $invisibleToClient = null)
    {
        if (!empty($keywork)) {
            $path[] = "keywork=$keywork";
        }

        if (!empty($onlyEnabledItems)) {
            $path[] = "onlyEnabledItems=$onlyEnabledItems";
        }

        if (!empty($invisibleToClient)) {
            $path[] = "invisibleToClient=$invisibleToClient";
        }

        if (count($path)) {
            $path = '?' . implode('&', $path);
        } else {
            $path = '';
        }

        $this->setEndpoint('search' . $path);

        return $this->queryApi();
    }

    /**
     * Set the endpoint to send the request to.
     *
     * @param string $endpoint
     */
    public function setEndpoint($endpoint = '')
    {
        $endpoint = 'subjects/' . $endpoint;

        parent::setEndpoint($endpoint);
    }
}
