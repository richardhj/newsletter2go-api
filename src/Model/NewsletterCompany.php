<?php

/**
 * This file is part of richardhj/newsletter2go-api.
 *
 * Copyright (c) 2016-2017 Richard Henkenjohann
 *
 * @package   richardhj/newsletter2go-api
 * @author    Richard Henkenjohann <richardhenkenjohann@googlemail.com>
 * @copyright 2016-2017 Richard Henkenjohann
 * @license   https://github.com/richardhj/newsletter2go-api/blob/master/LICENSE LGPL-3.0
 */

namespace Richardhj\Newsletter2Go\Api\Model;


/**
 * Class NewsletterCompany
 *
 * @method NewsletterCompany setName($name)
 * @method NewsletterCompany setAddress($address)
 * @method NewsletterCompany setCity($city)
 * @method NewsletterCompany setPostcode($postcode)
 * @method NewsletterCompany setCountry($country)
 * @method NewsletterCompany setBillName($billName)
 * @method NewsletterCompany setBillFirstName($billFirstName)
 * @method NewsletterCompany setBillLastName($billLastName)
 * @method NewsletterCompany setBillAddress($billAddress)
 * @method NewsletterCompany setBillCity($billCity)
 * @method NewsletterCompany setBillPostcode($billPostcode)
 * @method NewsletterCompany setBillCountry($billCountry)
 * @method NewsletterCompany setDefaultListId($defaultListId)
 * @method string getId()
 * @method string getName()
 * @method string getAddress()
 * @method string getCity()
 * @method string getPostcode()
 * @method string getCountry()
 * @method string getBillName()
 * @method string getBillFirstName()
 * @method string getBillLastName()
 * @method string getBillAddress()
 * @method string getBillCity()
 * @method string getBillPostcode()
 * @method string getBillCountry()
 * @method string getDefaultListId()
 * @method string getState()
 * @method string getCreditsEmail()
 * @method string getCreditsFreemail()
 * @method string getCreditsAbo()
 *
 * @package Richardhj\Newsletter2Go\Api\Model
 */
class NewsletterCompany extends AbstractModel
{

    use ModelBasicFindTrait;
    use ModelBasicSaveTrait;

    /**
     * Resource path on endpoint
     *
     * @var string
     */
    protected static $endpointResource = '/companies';

    /**
     * An array containing all field that can be configured and will be represented in the json
     *
     * @var array
     */
    protected static $configurableFields = [
        'name',
        'address',
        'city',
        'postcode',
        'country',
        'bill_name',
        'bill_first_name',
        'bill_last_name',
        'bill_address',
        'bill_city',
        'bill_postcode',
        'bill_country',
        'default_list_id',
    ];
}
