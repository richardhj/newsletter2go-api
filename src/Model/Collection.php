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

use ArrayAccess;
use ArrayIterator;
use BadFunctionCallException;
use Countable;
use InvalidArgumentException;
use IteratorAggregate;
use RuntimeException;

/**
 * Class Collection
 * Adapted from Contao Open Source CMS
 *
 * @package Richardhj\Newsletter2Go\Api\Model
 */
class Collection implements ArrayAccess, Countable, IteratorAggregate
{

    /**
     * Current index
     *
     * @var int
     */
    private $index = -1;

    /**
     * Models
     *
     * @var AbstractModel[]
     */
    private $models = [];

    /**
     * Create a new collection
     *
     * @param array $models An array of models
     *
     * @throws InvalidArgumentException
     */
    public function __construct(array $models)
    {
        $models = array_values($models);

        foreach ($models as $model) {
            if (!$model instanceof AbstractModel) {
                throw new InvalidArgumentException('Invalid type: '.gettype($model));
            }
        }

        $this->models = $models;
    }

    /**
     * Set an object property
     *
     * @param string $key   The property name
     * @param mixed  $value The property value
     */
    public function __set($key, $value)
    {
        if ($this->index < 0) {
            $this->first();
        }

        $this->models[$this->index]->$key = $value;
    }

    /**
     * Return an object property
     *
     * @param string $key The property name
     *
     * @return mixed|null The property value or null
     */
    public function __get($key)
    {
        if ($this->index < 0) {
            $this->first();
        }

        if (isset($this->models[$this->index]->$key)) {
            return $this->models[$this->index]->$key;
        }

        return null;
    }

    /**
     * Check whether a property is set
     *
     * @param string $key The property name
     *
     * @return boolean True if the property is set
     */
    public function __isset($key)
    {
        if ($this->index < 0) {
            $this->first();
        }

        return isset($this->models[$this->index]->$key);
    }

    /**
     * Return the current row as associative array
     *
     * @return array The current row as array
     */
    public function row()
    {
        if ($this->index < 0) {
            $this->first();
        }

        return $this->models[$this->index]->getData();
    }

    /**
     * Set the current row from an array
     *
     * @param array $data The row data as array
     *
     * @return static The model collection object
     */
    public function setRow(array $data)
    {
        if ($this->index < 0) {
            $this->first();
        }

        $this->models[$this->index]->setData($data);

        return $this;
    }

    /**
     * Save the current model
     *
     * @return static The model collection object
     */
    public function save()
    {
        if ($this->index < 0) {
            $this->first();
        }

        $this->models[$this->index]->save();

        return $this;
    }

    /**
     * Delete the current model and return the number of affected rows
     *
     * @return integer The number of affected rows
     */
    public function delete()
    {
        if ($this->index < 0) {
            $this->first();
        }

        if ($this->models[$this->index] instanceof ModelDeletableInterface) {
            /** @noinspection PhpUndefinedMethodInspection */
            return $this->models[$this->index]->delete();
        } else {
            throw new BadFunctionCallException(gettype($this->models[$this->index]).' is not deletable');
        }
    }

    /**
     * Return the models as array
     *
     * @return AbstractModel[] An array of models
     */
    public function getModels()
    {
        return $this->models;
    }

    /**
     * Return the number of rows in the result set
     *
     * @return integer The number of rows
     */
    public function count()
    {
        return count($this->models);
    }

    /**
     * Go to the first row
     *
     * @return static The model collection object
     */
    public function first()
    {
        $this->index = 0;

        return $this;
    }

    /**
     * Go to the previous row
     *
     * @return Collection|false The model collection object or false if there is no previous row
     */
    public function prev()
    {
        if ($this->index < 1) {
            return false;
        }

        --$this->index;

        return $this;
    }

    /**
     * Return the current model
     *
     * @return AbstractModel|static The model object
     */
    public function current()
    {
        if ($this->index < 0) {
            $this->first();
        }

        return $this->models[$this->index];
    }

    /**
     * Go to the next row
     *
     * @return Collection|boolean The model collection object or false if there is no next row
     */
    public function next()
    {
        if (!isset($this->models[$this->index + 1])) {
            return false;
        }

        ++$this->index;

        return $this;
    }

    /**
     * Go to the last row
     *
     * @return static The model collection object
     */
    public function last()
    {
        $this->index = $this->count() - 1;

        return $this;
    }

    /**
     * Reset the model
     *
     * @return static The model collection object
     */
    public function reset()
    {
        $this->index = -1;

        return $this;
    }

    /**
     * Fetch a column of each row
     *
     * @param string $key The property name
     *
     * @return array An array with all property values
     */
    public function fetchEach($key)
    {
        $this->reset();
        $return = [];

        while ($this->next()) {

            if ($key != 'id' && isset($this->id)) {
                $return[$this->id] = $this->$key;
            } else {
                $return[] = $this->$key;
            }
        }

        return $return;
    }

    /**
     * Fetch all columns of every row
     *
     * @return array An array with all rows and columns
     */
    public function fetchAll()
    {
        $this->reset();
        $return = [];

        while ($this->next()) {
            $return[] = $this->row();
        }

        return $return;
    }

    /**
     * Check whether an offset exists
     *
     * @param integer $offset The offset
     *
     * @return boolean True if the offset exists
     */
    public function offsetExists($offset)
    {
        return isset($this->models[$offset]);
    }

    /**
     * Retrieve a particular offset
     *
     * @param integer $offset The offset
     *
     * @return \Model|null The model or null
     */
    public function offsetGet($offset)
    {
        return $this->models[$offset];
    }

    /**
     * Set a particular offset
     *
     * @param integer $offset The offset
     * @param mixed   $value  The value to set
     *
     * @throws RuntimeException The collection is immutable
     */
    public function offsetSet($offset, $value)
    {
        throw new RuntimeException('This collection is immutable');
    }

    /**
     * Unset a particular offset
     *
     * @param integer $offset The offset
     *
     * @throws RuntimeException The collection is immutable
     */
    public function offsetUnset($offset)
    {
        throw new RuntimeException('This collection is immutable');
    }

    /**
     * Retrieve the iterator object
     *
     * @return ArrayIterator The iterator object
     */
    public function getIterator()
    {
        return new ArrayIterator($this->models);
    }
}
