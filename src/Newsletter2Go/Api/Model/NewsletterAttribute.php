<?php
/**
 * Newsletter2Go model based API integration
 *
 * @copyright Copyright (c) 2016-2017 Richard Henkenjohann
 * @license   LGPL-3.0+
 * @author    Richard Henkenjohann <richardhenkenjohann@googlemail.com>
 */


namespace Newsletter2Go\Api\Model;

use Newsletter2Go\Api\Tool\ApiCredentials;
use Newsletter2Go\Api\Tool\GetParameters;


/**
 * Class NewsletterAttribute
 *
 * @method NewsletterAttribute setListIds(array $listIds)
 * @method NewsletterAttribute setId($id)
 * @method NewsletterAttribute setName($name)
 * @method NewsletterAttribute setType($type) One of ['number', 'date', 'boolean', 'text']
 * @method NewsletterAttribute setSubType($subType)
 * @method string getId()
 * @method string getCompanyId()
 * @method string getName()
 * @method string getDisplay()
 * @method string getType()
 * @method string getSubType()
 * @method string getIsEnum()
 * @method string getIsPublic()
 * @method string getIsMultiselect()
 * @method string getHtmlElementType()
 * @method string getIsGlobal()
 * @method string getDefaultValue()
 * @method string getListId()
 *
 * @package Newsletter2Go\Api\Model
 */
class NewsletterAttribute extends AbstractModel implements ModelDeletableInterface
{

    /**
     * An array containing all field that can be configured and will be represented in the json
     *
     * @var array
     */
    protected static $configurableFields = [
        'list_ids',
        'name',
        'type',
        'sub_type',
    ];


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

        $endpoint = $model->getApi()->fillEndpointWithParams('/lists/%s/attributes', $lid);
        $endpoint = $model->getApi()->addGetParametersToEndpoint($endpoint, $getParams);

        $response = $model->getApi()
            ->getHttpClient()
            ->get($endpoint);

        return $model->createCollectionFromResponse($response);
    }


    /**
     * Delete the current model
     *
     * @return void
     */
    public function delete()
    {
        $endpoint = $this->getApi()->fillEndpointWithParams(
            '/lists/%s/attributes/%s',
            [
                $this->getListId(),
                $this->getId()
            ]
        );

        $this->getApi()
            ->getHttpClient()
            ->delete($endpoint);
    }


    /**
     * Save the current model
     *
     * @return self
     */
    public function save()
    {
        if (array_key_exists('id', $this->getData())) {
            return $this->update();
        }

        $response = $this->getApi()->getHttpClient()
            ->post(
                '/attributes',
                [
                    'json' => $this,
                ]
            );

        $json = \GuzzleHttp\json_decode($response->getBody()->getContents());
        $this->setId($json->value[0]->id);

        return $this;
    }


    /**
     * Update the current recipient by a given id
     *
     * @return self
     */
    private function update()
    {
        $endpoint = $this->getApi()->fillEndpointWithParams('/attributes/%s', $this->getId());

        $this->getApi()
            ->getHttpClient()
            ->patch(
                $endpoint,
                [
                    'json' => $this,
                ]
            );

        return $this;
    }
}
