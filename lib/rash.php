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
    $typed_keys = ray(array_keys($this->internal_array));
    $typed_keys->map(function($typed_key) {
      $type = explode("_", $typed_key)[0];
      settype($typed_key, $type);
      return $typed_key;
    });
  }

  public function offsetExists($offset)
  {
    return array_key_exists($this->resolve_typed_key($offset), $this->internal_array);
  }

  public function offsetGet($offset)
  {
    return $this->internal_array[$this->resolve_typed_key($offset)];
  }

  public function offsetSet($offset, $value)
  {
    var_dump($offset);
    $typed_key = $this->resolve_typed_key($offset);
    echo "Now setting " . $typed_key;
    $this->internal_array[$this->resolve_typed_key($offset)] = $value;
  }

  public function offsetUnset($offset)
  {
    unset($this->internal_array[$this->resolve_typed_key($offset)]);
  }

  private function resolve_typed_key($key) {
    $type = gettype($key);
    return $type . '_' . $key;
  }
}