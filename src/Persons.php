<?php
/**
 * Created by PhpStorm.
 * User: joao
 * Date: 16/04/18
 * Time: 13:10
 */

namespace marqu3s\octadesk;


class Persons extends Octadesk
{
    const PERSON_TYPE_NONE = 0;
    const PERSON_TYPE_EMPLOYEE = 1;
    const PERSON_TYPE_CUSTOMER = 2;
    const PERSON_TYPE_HANDLER = 3;
    const PERSON_TYPE_SYSTEM = 4;
    const PERSON_TYPE_FORWARDING_EMPLOYEE = 5;

    const PERMISSION_VIEW_NONE = 0;
    const PERMISSION_VIEW_MY_REQUESTS = 1;
    const PERMISSION_VIEW_MY_ORGANIZATION = 2;

    const PERMISSION_TYPE_NONE = 0;
    const PERMISSION_TYPE_ALL = 1;
    const PERMISSION_TYPE_GROUP = 2;

    const ROLE_TYPE_NONE = 0;
    const ROLE_TYPE_OWNER = 1;
    const ROLE_TYPE_ADMIN = 2;
    const ROLE_TYPE_AGENT_MASTER = 3;
    const ROLE_TYPE_AGENT = 4;
    const ROLE_TYPE_CLIENT = 5;
    const ROLE_TYPE_CORPORATE_PERSON = 6;


    /**
     * Search for a person by email.
     *
     * @param string $email
     *
     * @return array
     *
     * @see https://api.octadesk.services/docs/#/person/getPersonByEmail
     */
    public function getByEmail($email)
    {
        $this->isGet();
        $this->setEndpoint('?email=' . htmlentities($email));

        return $this->queryApi();
    }

    /**
     * Creates a person.
     *
     * @param string $email
     * @param string $name
     * @param integer $type
     * @param integer $permissionView
     * @param integer $permissionType
     * @param integer $role
     *
     * @return array
     *
     * @see https://api.octadesk.services/docs/#/person/createPerson
     */
    public function create($email, $name, $type = self::PERSON_TYPE_CUSTOMER, $permissionView = self::PERMISSION_VIEW_MY_REQUESTS, $permissionType = self::PERMISSION_TYPE_GROUP, $role = self::ROLE_TYPE_CLIENT, $customFields = [])
    {
        $this->isPost();
        $this->setEndpoint('');

        $this->postFields['type'] = $type;
        $this->postFields['permissionView'] = $permissionView;
        $this->postFields['permissionType'] = $permissionType;
        $this->postFields['roleType'] = $role;
        $this->postFields['email'] = $email;
        $this->postFields['name'] = $name;

        if (count($customFields)) {
            $this->postFields['customField'] = $customFields;
        }

        return $this->queryApi();
    }

    /**
     * Updates a person's data.
     *
     * @param string $uuid
     * @param string|null $email
     * @param string|null $name
     * @param integer $type
     * @param integer $permissionView
     * @param integer $permissionType
     * @param integer $role
     *
     * @return array
     *
     * @see https://api.octadesk.services/docs/#/person/updatePerson
     */
    public function update($uuid, $email = null, $name = null, $type = self::PERSON_TYPE_CUSTOMER, $permissionView = self::PERMISSION_VIEW_MY_REQUESTS, $permissionType = self::PERMISSION_TYPE_GROUP, $role = self::ROLE_TYPE_CLIENT, $customFields = [])
    {
        $this->isPut();
        $this->setEndpoint($uuid);

        $this->postFields['type'] = $type;
        $this->postFields['permissionView'] = $permissionView;
        $this->postFields['permissionType'] = $permissionType;
        $this->postFields['roleType'] = $role;
        $this->postFields['email'] = $email;
        $this->postFields['name'] = $name;
        $this->postFields['isEnabled'] = true;

        if (count($customFields)) {
            $this->postFields['customField'] = $customFields;
        }

        return $this->queryApi();
    }

    /**
     * Disable a person.
     *
     * @param string  $uuid
     */
    public function disable($uuid)
    {
        $this->isPut();
        $this->setEndpoint($uuid);

        $this->postFields['isEnabled'] = false;

        return $this->queryApi();
    }

    /**
     * Set the endpoint to send the request to.
     *
     * @param string $endpoint
     */
    public function setEndpoint($endpoint)
    {
        $endpoint = 'persons/' . $endpoint;

        parent::setEndpoint($endpoint);
    }
}
