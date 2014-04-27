<?php

class Ray implements arrayaccess {

  public function __construct($array = []) {
    $this->internal_array = $array;
  }

  public function each($handler) {
    foreach($this->internal_array as $element) {
      $handler($element);
    }
  }

  public function push($element) {
    $this->internal_array[] = $element;
    return $element;
  }

  public function pop() {
    return array_pop($this->internal_array);
  }

  public function shift() {
    return array_shift($this->internal_array);
  }

  public function unshift($element) {
    array_unshift($this->internal_array, $element);
    return $element;
  }

  public function filter($handler) {
    return new Ray(array_filter($this->internal_array, $handler));
  }

  public function select($handler) {
    return $this->filter($handler);
  }

  public function find_all($handler) {
    return $this->filter($handler);
  }

  public function map($handler) {
    return new Ray(array_map($handler, $this->internal_array));
  }

  public function collect($handler) {
    return $this->map($handler);
  }

  public function slice($offset, $length = NULL) {
    return new Ray(array_slice($this->internal_array, $offset, $length));
  }

  public function merge($other) {
    $other = $this->extract_raw_array($other);
    return new Ray(array_merge($this->to_a(), $other));
  }

  public function merge_self($other) {
    $other = $this->extract_raw_array($other);
    $this->internal_array = array_merge($this->to_a(), $other);
    return $this;
  }

  public function to_a() {
    return $this->internal_array;
  }

  public function sort() {
    $copy = $this->internal_array;
    sort($copy);
    return new Ray($copy);
  }

  public function sort_self() {
    sort($this->internal_array);
    return $this;
  }

  public function count() {
    return count($this->internal_array);
  }

  public function is_empty() {
    return $this->count() == 0;
  }

  public function any($handler) {
    return $this->filter($handler)->count() > 0;
  }

  public function all($handler) {
    return $this->filter($handler)->count() == $this->count();
  }

  public function shuffle() {
    $copy = $this->internal_array;
    shuffle($copy);
    return new Ray($copy);
  }

  public function shuffle_self() {
    shuffle($this->internal_array);
    return this;
  }

  private function extract_raw_array($subject) {
    if(is_object($subject) && get_class($subject) == 'Ray') {
      $subject = $subject->to_a();
    }
    return $subject;
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
