<?php
/**
 * Newsletter2Go model based API integration
 *
 * @copyright Copyright (c) 2016 Richard Henkenjohann
 * @license   LGPL-3.0+
 * @author    Richard Henkenjohann <richardhenkenjohann@googlemail.com>
 */


namespace Richardhj\Newsletter2Go\Api\Model;

/**
 * Class NewsletterList
 *
 * @method NewsletterList setName($name)
 * @method NewsletterList setUsesEconda($usesEconda)
 * @method NewsletterList setUsesGoogleanalytics($usesGoogleanalytics)
 * @method NewsletterList setHasOpentracking($hasOpentracking)
 * @method NewsletterList setHasClicktracking($hasClicktracking)
 * @method NewsletterList setHasConversiontracking($hasConversiontracking)
 * @method NewsletterList setImprint($imprint)
 * @method NewsletterList setHeaderFromEmail($headerFromEmail)
 * @method NewsletterList setHeaderFromName($headerFromName)
 * @method NewsletterList setHeaderReplyEmail($headerReplayEmail)
 * @method NewsletterList setHeaderReplayName($headerReplyName)
 * @method NewsletterList setTrackingUrl($trackingUrl)
 * @method string getId()
 * @method string getName()
 * @method string getUsesEconda()
 * @method string getUsesGoogleanalytics()
 * @method string getHasOpentracking()
 * @method string getHasClicktracking()
 * @method string getConversiontracking()
 * @method string getImprint()
 * @method string getHeaderFromEmail()
 * @method string getHeaderFromName()
 * @method string getHeaderReplyEmail()
 * @method string getHeaderReplyName()
 * @method string getTrackingUrl()
 *
 * @package Richardhj\Newsletter2Go\Api\Model
 */
class NewsletterList extends AbstractModel implements ModelDeletableInterface
{

    use ModelBasicFindTrait;
    use ModelBasicSaveTrait;

    /**
     * Resource path on endpoint
     *
     * @var string
     */
    protected static $endpointResource = '/lists';

    /**
     * An array containing all field that can be configured and will be represented in the json
     *
     * @var array
     */
    protected static $configurableFields = [
        'name',
        'uses_econda',
        'uses_googleanalytics',
        'has_opentracking',
        'has_clicktracking',
        'has_conversiontracking',
        'imprint',
        'header_from_email',
        'header_from_name',
        'header_reply_email',
        'header_reply_name',
        'tracking_url',
    ];

    // TODO: Implement https://docs.newsletter2go.com/#!/List/createList (in conflict with save())

    // TODO: Implement
    //          https://docs.newsletter2go.com/#!/List/removeRecipientsFromList,
    //          https://docs.newsletter2go.com/#!/List/getRecipients,
    //          https://docs.newsletter2go.com/#!/List/updateRecipients
    //          (same in NewsletterRecipient)

    /**
     * Delete the current model
     *
     * @return void
     */
    public function delete()
    {
        // TODO: Implement delete() method.
    }
}
