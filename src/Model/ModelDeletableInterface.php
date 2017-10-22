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
 * Interface ModelDeletableInterface
 *
 * @package Richardhj\Newsletter2Go\Api\Model
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
