<?php
/**
 * Created by PhpStorm.
 * User: joao
 * Date: 16/04/18
 * Time: 13:10
 */

namespace marqu3s\octadesk;

/**
 * Class that offers methods to create and update persons via the Octadesk API.
 *
 * @package marqu3s\octadesk
 */
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
    const PERMISSION_TYPE_GROUP_PLUS_INTERACTED = 3;

    const PARTICIPANT_PERMISSION_NONE = 0;
    const PARTICIPANT_PERMISSION_VIEW_ONLY = 1;
    const PARTICIPANT_PERMISSION_VIEW_EDIT = 2;

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
     * Return agents.
     *
     * @param string $keyword
     * @param int $page
     * @param bool $detailed
     *
     * @return array
     */
    public function getAgents($keyword = null, $page = 1, $detailed = false)
    {
        $this->isGet();
        $this->setEndpoint("agents?keyword=$keyword&page=$page&detailed=$detailed");

        return $this->queryApi();
    }

    /**
     * Updates an agent avatar URL.
     *
     * @param string $uuid
     * @param string $email
     * @param string $url
     *
     * @return array
     */
    public function updateAvatarUrl($uuid, $email, $url)
    {
        $this->isPut();
        $this->setEndpoint($uuid);

        $this->postFields['email'] = $email;
        $this->postFields['thumbUrl'] = $url;

        return $this->queryApi();
    }

    /**
     * Creates a person.
     * The the $idGroups if null, all the groups will be removed from the person.
     * It's mandatory to always send the group IDs to keep the existing person's groups.
     *
     * @param string $email
     * @param string $name
     * @param integer $type
     * @param integer $permissionView
     * @param integer $permissionType
     * @param integer $participantPermission
     * @param integer $role
     * @param array|null $idGroups
     * @param array|null $customFields
     *
     * @return array
     *
     * @see https://api.octadesk.services/docs/#/person/createPerson
     */
    public function create($email, $name, $type = self::PERSON_TYPE_CUSTOMER, $permissionView = self::PERMISSION_VIEW_MY_REQUESTS, $permissionType = self::PERMISSION_TYPE_GROUP, $participantPermission = self::PARTICIPANT_PERMISSION_NONE, $role = self::ROLE_TYPE_CLIENT, $idGroups = [], $customFields = [])
    {
        $this->isPost();
        $this->setEndpoint('');

        $this->postFields['type'] = $type;
        $this->postFields['permissionView'] = $permissionView;
        $this->postFields['permissionType'] = $permissionType;
        $this->postFields['participantPermission'] = $participantPermission;
        $this->postFields['roleType'] = $role;
        $this->postFields['email'] = $email;
        $this->postFields['name'] = $name;

        if (count($customFields)) {
            $this->postFields['customField'] = $customFields;
        }

        if (count($idGroups)) {
            $this->postFields['idGroups'] = $idGroups;
        }

        return $this->queryApi();
    }

    /**
     * Updates a person's data.
     * The the $idGroups if null, all the groups will be removed from the person.
     * It's mandatory to always send the group IDs to keep the existing person's groups.
     *
     * @param string $uuid
     * @param string|null $email
     * @param string|null $name
     * @param integer $type
     * @param integer $permissionView
     * @param integer $permissionType
     * @param integer $participantPermission
     * @param integer $role
     * @param array|null $idGroups
     * @param array|null $customFields
     *
     * @return array
     *
     * @see https://api.octadesk.services/docs/#/person/updatePerson
     */
    public function update($uuid, $email = null, $name = null, $type = self::PERSON_TYPE_CUSTOMER, $permissionView = self::PERMISSION_VIEW_MY_REQUESTS, $permissionType = self::PERMISSION_TYPE_GROUP, $participantPermission = self::PARTICIPANT_PERMISSION_NONE, $role = self::ROLE_TYPE_CLIENT, $idGroups = [], $customFields = [])
    {
        $this->isPut();
        $this->setEndpoint($uuid);

        $this->postFields['type'] = $type;
        $this->postFields['permissionView'] = $permissionView;
        $this->postFields['permissionType'] = $permissionType;
        $this->postFields['participantPermission'] = $participantPermission;
        $this->postFields['roleType'] = $role;
        $this->postFields['email'] = $email;
        $this->postFields['name'] = $name;
        $this->postFields['isEnabled'] = true;

        if (count($customFields)) {
            $this->postFields['customField'] = $customFields;
        }

        if (count($idGroups)) {
            $this->postFields['idGroups'] = $idGroups;
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
