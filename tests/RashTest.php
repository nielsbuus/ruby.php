<?php

class RashTest extends PHPUnit_Framework_TestCase {

  public function test_clear() {
    $rash = rash(["name" => "Jack", "age" => 34]);
    $empty_rash = rash([]);
    $rash->clear();
    $this->assertEquals($rash, $empty_rash);
  }

  public function test_clear_return_value() {
    $rash = rash(["name" => "Jack", "age" => 34]);
    $empty_rash = rash([]);
    $this->assertEquals($rash->clear(), $empty_rash);
  }

  public function test_delete() {
    $rash = rash(["red" => "FF0000", "green" => "00FF00", "blue" => "0000FF"]);
    $modified_rash = rash(["red" => "FF0000", "blue" => "0000FF"]);
    $rash->delete("green");
    $this->assertEquals($rash, $modified_rash);
  }

  public function test_delete_return_value() {
    $rash = rash(["red" => "FF0000", "green" => "00FF00", "blue" => "0000FF"]);
    $return_value = $rash->delete("green");
    $this->assertEquals($return_value, "00FF00");
  }

  public function test_delete_if() {
    $rash = rash(["red" => "FF0000", "green" => "00FF00", "blue" => "0000FF"]);
    $modified_rash = rash(["green" => "00FF00", "blue" => "0000FF"]);
    $rash->delete_if(function($key, $value) {
      if (strpos($key, 'ed') !== false) {
        return true;
      } else {
        return false;
      }
    });
    $this->assertEquals($modified_rash, $rash);
  }


}

