<?php
/**
 * Created by PhpStorm.
 * User: joao
 * Date: 17/04/18
 * Time: 16:59
 */

namespace marqu3s\octadesk;

/**
 * Class Tickets
 * @package marqu3s\octadesk
 */
class Tickets extends Octadesk
{
    const TICKET_STATUS_NEW = 'novo';
    const TICKET_STATUS_PENDING = 'pendente';
    const TICKET_STATUS_SOLVED = 'resolvido';
    const TICKET_STATUS_OPEN = 'andamento';
    const TICKET_STATUS_REJECTED = 'rejeitado';
    const TICKET_STATUS_CANCELED = 'cancelado';

    const TICKET_SORTBY_NUMBER = 'number';
    const TICKET_SORTBY_LASTDATEUPDATE = 'lastDateUpdate';
    const TICKET_SORTBY_OPENDATE = 'openDate';
    const TICKET_SORTBY_SLADUEDATE = 'slaDueDate';

    const TICKET_SORTDIRECTION_ASC = 'asc';
    const TICKET_SORTDIRECTION_DESC = 'desc';


    /**
     * @param string|integer|null $number
     * @param string|null $requesterUuid
     * @param string|array|null $status
     * @param string|null $sortBy
     * @param string|null $sortDirection
     *
     * @return array
     */
    public function searchTickets($number = null, $requesterUuid = null, $status = null, $sortBy = null, $sortDirection = null)
    {
        if (!empty($number)) {
            $path[] = "number=$number";
        }

        if (!empty($requesterUuid)) {
            $path[] = "idRequester=$requesterUuid";
        }

        if (!empty($status)) {
            if (is_array($status)) {
                $status = implode('|', $status);
            }
            $path[] = "status=$status";
        }

        if (!empty($sortBy)) {
            $path[] = "sortBy=$sortBy";
        }

        if (!empty($sortDirection)) {
            $path[] = "sortDirection=$sortDirection";
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
     * Cria um novo ticket na plataforma da Octadesk.
     *
     * @param array $postFields
     *
     * @return array
     */
    public function create($postFields)
    {
        $this->isPost();
        $this->postFields = $postFields;
        $this->setEndpoint();

        return $this->queryApi();
    }

    /**
     * Set the endpoint to send the request to.
     *
     * @param string $endpoint
     */
    public function setEndpoint($endpoint = '')
    {
        $endpoint = 'tickets/' . $endpoint;

        parent::setEndpoint($endpoint);
    }

    /**
     * Retorna todas as interações de um ticket.
     *
     * @param integer $ticketNumber
     *
     * @return array
     */
    public function getInteractions($ticketNumber)
    {
        $this->setEndpoint("$ticketNumber/interactions");

        return $this->queryApi();
    }
}
