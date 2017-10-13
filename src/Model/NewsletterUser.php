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
 * Class NewsletterUser
 *
 * @method NewsletterUser setEmail($email)
 * @method NewsletterUser setFirstName($firstName)
 * @method NewsletterUser setLastName($lastName)
 * @method NewsletterUser setGender($gender)
 * @method string getId()
 * @method string getAccountId()
 * @method string getCompanyId()
 * @method string getIsDeveloperMode()
 * @method string getEmail()
 * @method string getModifiedAt()
 * @method string getCreatedAt()
 * @method string getGender()
 * @method string getFirstName()
 * @method string getLastName()
 * @method string getActivatedAt()
 * @method string getActivationcode()
 * @method string getIsActive()
 * @method string getPhone()
 * @method string getAgbAcceptedAt()
 * @method string getName()
 * @method string getAddress()
 * @method string getCity()
 * @method string getPostcode()
 * @method string getCountry()
 * @method string getBillFirstName()
 * @method string getBillLastName()
 * @method string getBillGender()
 * @method string getBillAddress()
 * @method string getBillCity()
 * @method string getBillPostcode()
 * @method string getBillCountry()
 * @method string getBillEmail()
 * @method string getDefaultListId()
 * @method string getRegisterTld()
 * @method string getLanguage()
 * @method string getCreditsEmail
 * @method string getCreditsFreemail()
 * @method string getCreditsAbo()
 * @method string getUsesPostpaid()
 * @method string getState()
 * @method string getMfaStatus()
 * @method string getMfaMethod()
 * @method string getMfaSecret()
 * @method string getMfaContact()
 * @method string getEkomiDone()
 * @method string getUsesClientTesting()
 * @method string getWebsite()
 * @method string getIndustryId()
 * @method string getFrequency()
 * @method string getNumRecipients()
 * @method string getIpClass()
 * @method string getDoupleoptout()
 * @method string getDatabase()
 * @method string getEditorVersion()
 * @method string getIsArchiveActive()
 * @method string getIsArchiveAutoupdate()
 * @method string getIsOpentrackingAllowed()
 * @method string getIsClicktrackingAllowed()
 * @method string getIsRecipienttrackingAllowed()
 * @method string getIsWhitelisted()
 * @method string getTimezone()
 * @method string getDateformat()
 * @method string getDatetimeformat()
 * @method string getNumberFormat()
 * @method string getProfileImageUrl()
 * @method string getRole()
 *
 * @package Richardhj\Newsletter2Go\Api\Model
 */
class NewsletterUser extends AbstractModel
{

    use ModelBasicFindTrait;
    use ModelBasicSaveTrait;

    /**
     * Resource path on endpoint
     *
     * @var string
     */
    protected static $endpointResource = '/users';

    /**
     * An array containing all field that can be configured and will be represented in the json
     *
     * @var array
     */
    protected static $configurableFields = [
        'email',
        'first_name',
        'last_name',
        'gender',
    ];
}
