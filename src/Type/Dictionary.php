<?php

namespace Linio\Type;

class Dictionary implements \JsonSerializable, \Countable
{
    /**
     * @var array
     */
    protected $data;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if (!isset($this->data[$key])) {
            return $default;
        }

        return $this->data[$key];
    }

    /**
     * @param string $key
     * @param string $value
     */
    public function set($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * @param string $key
     */
    public function remove($key)
    {
        unset($this->data[$key]);
    }

    /**
     * @param string $key
     *
     * @return boolean
     */
    public function has($key)
    {
        return isset($this->data[$key]);
    }

    /**
     * @param string $value
     *
     * @return boolean
     */
    public function contains($value)
    {
        return in_array($value, $this->data);
    }

    /**
     * @param array $data
     */
    public function replace(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getKeys()
    {
        return array_keys($this->data);
    }

    /**
     * @return boolean
     */
    public function isEmpty()
    {
        return empty($this->data);
    }

    public function count()
    {
        return count($this->data);
    }

    public function clear()
    {
        $this->data = [];
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function jsonSerialize()
    {
        return json_encode($this->data);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->jsonSerialize();
    }
}
