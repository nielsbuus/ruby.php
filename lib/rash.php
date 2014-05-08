<?php

class Rash {

  private $internal_array;

  public function __construct($dictionary) {
    $this->internal_array = [];
    $this->merge_self($dictionary);
  }

  public function merge_self($rash) {
    $assoc_array = $this->extract_raw_assoc_array($rash);
    foreach($assoc_array as $key => $value) {
      $this->set($key, $value);
    }
  }

  public function clear() {
    $this->internal_array = [];
    return $this;
  }

  public function delete($key) {
    $typed_key = $this->generate_typed_key($key);
    $val = $this->internal_array[$typed_key];
    unset($this->internal_array[$typed_key]);
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

  public function fetch($key, $default = null) {
    $return_value = $this->get($key);
    if(!is_null($return_value)) {
      return $return_value;
    } else {
      if(is_null($default)) {
        throw new KeyError();
      } else {
        return $default;
      }
    }
  }

  public function flatten() {
    # coming
  }

  public function has_key($key) {
    $typed_key = $this->generate_typed_key($key);
    return array_key_exists($typed_key, $this->internal_array);
  }

  public function has_value($value) {
    return in_array($value, $this->internal_array, true);
  }

  public function invert() {
    $new_rash = new Rash([]);
    foreach($this->internal_array as $key => $value) {
      $restored_key = $this->restore_typed_key($key);
      $new_rash->set($value, $restored_key);
    }
    return $new_rash;
  }

  public function keep_if($handler) {
    foreach($this->internal_array as $key => $value) {
      $restored_key = $this->restore_typed_key($key);
      if($handler($restored_key, $value)) {
        # Fine
      } else {
        $this->delete($restored_key);
      }
    }
  }

  public function key($needle) {
    foreach($this->internal_array as $key => $value) {
      if($value === $needle) { return $this->restore_typed_key($key); }
    }
    return null;
  }

  public function keys() {
    $typed_keys = ray(array_keys($this->internal_array));
    return $typed_keys->map(function($typed_key) {
      return $this->restore_typed_key($typed_key);
    });
  }

  public function get($key)
  {
    $typed_key = $this->generate_typed_key($key);
    if(isset($this->internal_array[$typed_key])) {
      return $this->internal_array[$typed_key];
    } else {
      return null;
    }
  }

  public function set($key, $value)
  {
    $typed_key = $this->generate_typed_key($key);
    $this->internal_array[$typed_key] = $value;
  }

  private function generate_typed_key($key) {
    $type = gettype($key);
    return $type . '_' . $key;
  }

  private function restore_typed_key($typed_key) {
    $split_typed_key = explode("_", $typed_key);
    $type = array_shift($split_typed_key);
    $key = join('_', $split_typed_key);
    settype($key, $type);
    return $key;
  }

  private function extract_raw_assoc_array($subject) {
    if(is_object($subject) && get_class($subject) == 'Rash') {
      $subject = $subject->to_a();
    }
    return $subject;
  }

}