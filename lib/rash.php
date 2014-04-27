<?php

class Rash implements arrayaccess {

  private $internal_array;

  public function __construct($dictionary) {
    $this->internal_array = $dictionary;
  }

  public function offsetExists($offset)
  {
    return array_key_exists($offset, $this->internal_array);
  }

  public function offsetGet($offset)
  {
    return $this->internal_array[$offset];
  }

  public function offsetSet($offset, $value)
  {
    $this->internal_array[$offset] = $value;
  }

  public function offsetUnset($offset)
  {
    unset($this->internal_array[$offset]);
  }
}