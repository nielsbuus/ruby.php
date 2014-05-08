<?php

class Rash implements arrayaccess {

  private $internal_array;

  public function __construct($dictionary) {
    $this->internal_array = $dictionary;
  }

  public function clear() {
    $this->internal_array = [];
    return $this;
  }

  public function delete($key) {
    $val = $this->internal_array[$key];
    unset($this->internal_array[$key]);
    return $val;
  }

  public function delete_if($handler) {
    $kept_elements = [];
    foreach ($this->internal_array as $key => $value) {
      if($handler($key, $value)) {
        # do nothing
      } else {
        $kept_elements[$key] = $value;
      }
    }
    $this->internal_array = $kept_elements;
  }

  public function each($handler) {
    foreach ($this->internal_array as $key => $value) {
      $handler($key, $value);
    }
  }

  public function fetch($key, $default) {
    # coming
  }

  public function flatten() {
    # coming
  }

  public function has_key($key) {
    return $this->offsetExists($key);
  }

  public function has_value($value) {
    # coming
  }

  public function invert() {
    # coming
  }

  public function keep_if() {
    # coming
  }

  public function key($value) {
    # coming
  }

  public function keys() {
    return array_keys($this->internal_array);
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