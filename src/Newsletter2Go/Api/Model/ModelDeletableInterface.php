<?php
/**
 * Newsletter2Go model based API integration
 *
 * @copyright Copyright (c) 2016 Richard Henkenjohann
 * @license   LGPL-3.0+
 * @author    Richard Henkenjohann <richardhenkenjohann@googlemail.com>
 */


namespace Newsletter2Go\Api\Model;


/**
 * Interface ModelDeletableInterface
 *
 * @package Newsletter2Go\Api\Model
 */
interface ModelDeletableInterface
{

    /**
     * Delete the current model
     *
     * @return void
     */
    public function delete();
}
