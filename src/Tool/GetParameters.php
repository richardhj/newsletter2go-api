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

namespace Richardhj\Newsletter2Go\Api\Tool;


/**
 * Class GetParameters
 *
 * @package Richardhj\Newsletter2Go\Api\Tool
 */
final class GetParameters
{

    /**
     * A FIQL-Filter
     * The filter language for filtering results is based on FIQL.
     * With the only restriction, that plain values must be surrounded by `"`. For example first_name=="Max"
     * The following operators are supported
     * * Equals `==`
     * * Not equals `=ne=`
     * * Greater than `=gt=`
     * * Greater than equals `=ge=`
     * * Lower than `=lt=`
     * * Lower than equals `=le=`
     * * Like `=like=` (in combination with % you are able to search for starts with, ends with, contains)
     * * Not like `=nlike=`
     * * Logical and `;`
     * * Logical or `,`
     *
     * @var string
     */
    public $_filter;

    /**
     * A limit for list-responses
     * `50` is api server default, using `-1` here to fetch all items per default
     *
     * @var int
     */
    public $_limit = -1;

    /**
     * An offset for list-responses
     *
     * @var int
     */
    public $_offset = 0;

    /**
     * True if attributes should be returned or not
     * `false` is api server default, using `true` here to fetch all item properties per default
     *
     * @var bool
     */
    public $_expand = true;

    /**
     * List of case-sensitive fields which should be returned. Only needed if _expand is false or special attributes
     * are needed
     *
     * @var string[]
     */
    public $_fields;

    /**
     * @param string $filter
     *
     * @return GetParameters
     */
    public function setFilter($filter)
    {
        $this->_filter = $filter;

        return $this;
    }

    /**
     * @return string
     */
    public function getFilter()
    {
        return $this->_filter;
    }

    /**
     * @param int $limit
     *
     * @return GetParameters
     */
    public function setLimit($limit)
    {
        $this->_limit = $limit;

        return $this;
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->_limit;
    }

    /**
     * @param int $offset
     *
     * @return GetParameters
     */
    public function setOffset($offset)
    {
        $this->_offset = $offset;

        return $this;
    }

    /**
     * @return int
     */
    public function getOffset()
    {
        return $this->_offset;
    }

    /**
     * @param boolean $expand
     *
     * @return GetParameters
     */
    public function setExpand($expand)
    {
        $this->_expand = $expand;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isExpand()
    {
        return $this->_expand;
    }

    /**
     * @param \string[] $fields
     *
     * @return GetParameters
     */
    public function setFields($fields)
    {
        $this->_fields = $fields;

        return $this;
    }

    /**
     * @return \string[]
     */
    public function getFields()
    {
        return $this->_fields;
    }
}
