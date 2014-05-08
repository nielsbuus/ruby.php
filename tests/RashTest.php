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

  public function test_delete_honors_type() {
    $rash = rash();
    $rash->set(12, "songs");
    $rash->set("12", "days of christmas");
    $rash->delete(12);
    $expected_rash = rash();
    $expected_rash->set("12", "days of christmas");
    $this->assertEquals($rash, $expected_rash);
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

  public function test_keys() {
    $rash = rash();
    $rash->set(12, "days of christmas");
    $rash->set("18", "holes");
    $rash->set("fifty", "shades of grey");
    $rash_keys = $rash->keys();
    $expected_keys = ray([12, "18", "fifty"]);
    $this->assertEquals($rash_keys, $expected_keys);
  }

  public function test_type_awareness() {
    $rash = rash();
    $rash->set(true, "Truth knows me");
    $rash->set(1, "Numbers know me");
    $rash->set("1", "Strings know me");

    $this->assertEquals($rash->get(true), "Truth knows me");
    $this->assertEquals($rash->get(1), "Numbers know me");
    $this->assertEquals($rash->get("1"), "Strings know me");
  }

  public function test_absent_keys_return_null() {
    $rash = rash(["foo" => "bar"]);
    $return_value = $rash->get('baz');
    $this->assertEquals($return_value, null);
  }

  public function test_fetch_throws_exceptions() {
    $rash = rash();
    $this->setExpectedException('KeyError');
    $rash->fetch("some_missing_key");
  }

  public function test_fetch_returns_default_value() {
    $rash = rash();
    $return_value = $rash->fetch("foo", "fallback");
    $this->assertEquals($return_value, "fallback");
  }

  public function test_fetch_works_like_get() {
    $rash = rash(["foo" => "bar"]);
    $return_value = $rash->fetch("foo");
    $this->assertEquals($return_value, "bar");
  }

  public function test_has_key() {
    $rash = rash(["capital" => "Berlin"]);
    $this->assertEquals($rash->has_key("capital"), true);
    $this->assertEquals($rash->has_key("population"), false);
  }

  public function test_has_value() {
    $rash = rash(["answer" => "42"]);
    $this->assertEquals($rash->has_value(42), false);
    $this->assertEquals($rash->has_value("42"), true);
  }

  public function test_invert() {
    $rash = rash(["denmark" => "danish", "norway" => "norwegian"]);
    $return_value = $rash->invert();
    $expected_value = rash(["danish" => "denmark", "norwegian" => "norway"]);
    $this->assertEquals($return_value, $expected_value);
  }

  public function test_keep_if() {
    $rash = rash(["denmark" => 5.6, "sweden" => 9.0, "britain" => 65]);
    $rash->keep_if(function($country, $population) {
      return $population < 10;
    });
    $expected_value = rash(["denmark" => 5.6, "sweden" => 9.0]);
    $this->assertEquals($rash, $expected_value);
  }

  public function test_key() {
    $rash = rash(["name" => "Alice", "age" => 28]);
    $this->assertEquals($rash->key("Alice"), "name");
    $this->assertEquals($rash->key("Bob"), null);
  }

  public function test_key_returns_first_key() {
    $rash = rash(["best_friend" => "Bob", "boyfriend" => "Bob"]);
    $this->assertEquals($rash->key("Bob"), "best_friend");
  }



}

