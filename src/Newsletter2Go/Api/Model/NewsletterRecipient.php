<?php
/**
 * Newsletter2Go model based API integration
 *
 * @copyright Copyright (c) 2016 Richard Henkenjohann
 * @license   LGPL-3.0+
 * @author    Richard Henkenjohann <richardhenkenjohann@googlemail.com>
 */


namespace Newsletter2Go\Api\Model;

use Newsletter2Go\Api\Tool\ApiCredentials;
use Newsletter2Go\Api\Tool\GetParameters;


/**
 * Class NewsletterRecipient
 *
 * @method NewsletterRecipient setListId($listId)
 * @method NewsletterRecipient setEmail($email)
 * @method NewsletterRecipient setPhone($phone)
 * @method NewsletterRecipient setGender($gender)
 * @method NewsletterRecipient setFirstName($firstName)
 * @method NewsletterRecipient setLastName($lastName)
 * @method NewsletterRecipient setIsUnsubscribed($isUnsubscribed)
 * @method NewsletterRecipient setIsBlacklisted($isBlacklisted)
 * @method string getId()
 * @method string getListId()
 * @method string getEmail()
 * @method string getPhone()
 * @method string getGender()
 * @method string getFirstName()
 * @method string getLastName()
 * @method string getIsUnsubscribed()
 * @method string getIsBlacklisted()
 *
 * @package Newsletter2Go\Api\Model
 */
class NewsletterRecipient extends AbstractModel implements ModelDeletableInterface
{

    /**
     * {@inheritdoc}
     */
    protected static $configurableFields = [
        'list_id',
        'email',
        'phone',
        'gender',
        'first_name',
        'last_name',
        'is_unsubscribed',
        'is_blacklisted',
    ];


    /**
     * Find recipients by a selected list and group
     *
     * @param string         $lid The list id
     * @param string         $gid The group id
     * @param GetParameters  $getParams
     * @param ApiCredentials $credentials
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public static function findByListAndGroup(
        $lid,
        $gid,
        GetParameters $getParams = null,
        ApiCredentials $credentials = null
    ) {
        $model = static::createInstance();
        $model->setApiCredentials($credentials);

        $endpoint = $model->api->fillEndpointWithParams('/lists/%s/groups/%s/recipients', [$lid, $gid]);
        $endpoint = $model->api->addGetParametersToEndpoint($endpoint, $getParams);

        $response = $model->api
            ->getHttpClient()
            ->get($endpoint);

        return $model->createCollectionFromResponse($response);
    }


    /**
     * Find recipients by a selected list
     *
     * @param string         $lid The list id
     * @param GetParameters  $getParams
     * @param ApiCredentials $credentials
     *
     * @return Collection|null
     */
    public static function findByList($lid, GetParameters $getParams = null, ApiCredentials $credentials = null)
    {
        $model = static::createInstance();
        $model->setApiCredentials($credentials);

        $endpoint = $model->api->fillEndpointWithParams('/lists/%s/recipients', $lid);
        $endpoint = $model->api->addGetParametersToEndpoint($endpoint, $getParams);

        $response = $model->api
            ->getHttpClient()
            ->get($endpoint);

        return $model->createCollectionFromResponse($response);
    }


    /**
     * {@inheritdoc}
     */
    public function save()
    {
        $this->api->getHttpClient()
            ->post(
                '/recipients',
                [
                    'json' => $this,
                ]
            );

        return $this;
    }


    /**
     * {@inheritdoc}
     */
    public function delete()
    {
        $endpoint = $this->api->fillEndpointWithParams('/lists/%s/recipients/%s', [$this->getListId(), $this->getId()]);

        $this->api
            ->getHttpClient()
            ->delete($endpoint);

        return true;
    }
}
