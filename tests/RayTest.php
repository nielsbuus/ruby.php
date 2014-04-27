<?php

class RayTest extends PHPUnit_Framework_TestCase
{

  protected $defaultRay;

  protected function setUp() {
    $this->defaultRay = ray(["foo", "bar", "baz"]);
  }

  public function test_build_functions()
  {
    $quickRay = ray([1, 2, 3]);
    $normalRay = new Ray([1, 2, 3]);

    $this->assertEquals($quickRay, $normalRay);

  }

  public function test_array_access() {
    $this->assertEquals($this->defaultRay[1], "bar");
  }

  public function test_each() {

    $testRay = ray([1, 2, 3]);

    $output_array = [];

    $handler = function($element) use (&$output_array) {
      $output_array[] = $element * 2;
    };

    $testRay->each($handler);
    $this->assertEquals($output_array, [2,4,6]);
  }

  public function test_push() {
    $push_value = 42;
    $original = ray([1,2,3]);
    $pushed = ray([1,2,3,$push_value]);

    $return_value = $original->push($push_value);

    $this->assertEquals($original, $pushed);
    $this->assertEquals($return_value, $push_value);
  }

  public function test_pop() {
    $pop_value = 3;
    $original = ray([1,2,$pop_value]);
    $popped = ray([1,2]);

    $return_value = $original->pop();

    $this->assertEquals($original, $popped);
    $this->assertEquals($return_value, $pop_value);
  }

  public function test_shift() {
    $shift_value = 1;
    $original = ray([$shift_value,2,3]);
    $shifted = ray([2,3]);

    $return_value = $original->shift();

    $this->assertEquals($return_value, $shift_value);
    $this->assertEquals($original, $shifted);
  }

  public function test_unshift() {
    $unshift_value = 1;
    $original = ray([2,3]);
    $unshifted = ray([$unshift_value, 2,3]);

    $return_value = $original->unshift($unshift_value);
    $this->assertEquals($original, $unshifted); #The value was shifted
    $this->assertEquals($original, $return_value); # The return value is the now unshifted ray
  }

  public function test_filter_with_all_true() {
    $filteredRay = $this->defaultRay->filter(function($element) { return true; });
    $this->assertEquals($filteredRay, $this->defaultRay);
  }

  public function test_filter_with_all_false() {
    $filteredRay = $this->defaultRay->filter(function($element) { return false; });
    $this->assertEquals($filteredRay, ray([]));
  }

  public function test_filter_with_odds() {
    $numbers = ray([1,2,3,4,5,7,10,15]);
    $even_numbers = ray([2,4,10]);
    $output = $numbers->filter(function($element) { return $element % 2 == 0; });
    $this->assertEquals($even_numbers, $output);
  }

  public function test_map() {
    $original = ray([1,2,3]);
    $mapped = ray([10,20,30]);
    $output = $original->map(function($element) { return $element * 10; });
    $this->assertEquals($output, $mapped);
  }

  public function test_slice() {
    $original = ray(["foo", "bar", "baz"]);
    $sliced = ray(["bar", "baz"]);
    $output = $original->slice(1);
    $this->assertEquals($output, $sliced);
  }

  public function test_slice_with_length() {
    $original = ray(["foo", "bar", "baz", "biz"]);
    $sliced = ray(["bar", "baz"]);
    $output = $original->slice(1, 2);
    $this->assertEquals($output, $sliced);
  }

  public function test_merge() {
    $ray1 = ray([1,2]);
    $ray2 = ray([2,3]);
    $combined_ray = ray([1,2,2,3]);
    $output = $ray1->merge($ray2);

    $this->assertEquals($output, $combined_ray);
  }

  public function test_merge_with_raw_array() {
    $ray = ray([1,2]);
    $array = [2,3];
    $combined_ray = ray([1,2,2,3]);
    $output = $ray->merge($array);

    $this->assertEquals($output, $combined_ray);
  }

  public function test_merge_self() {
    $ray = ray([1,2]);
    $array = [2,3];
    $combined_ray = ray([1,2,2,3]);
    $ray->merge_self($array);

    $this->assertEquals($ray, $combined_ray);
  }

  public function test_to_a() {
    $ray = ray([1,2,3]);
    $array = [1,2,3];
    $output = $ray->to_a();
    $this->assertEquals($output, $array);
  }

  public function test_sort() {
    $ray = ray(["charlie", "alice", "dan", "ellis", "bob"]);
    $sorted_ray = ray(["alice", "bob", "charlie", "dan", "ellis"]);
    $output = $ray->sort();
    $this->assertEquals($output, $sorted_ray);
  }

  public function test_sort_self() {
    $ray = ray([5, 2, 1, 4, 3]);
    $sorted_ray = ray([1, 2, 3, 4, 5]);
    $ray->sort_self();
    $this->assertEquals($ray, $sorted_ray);
  }

  public function test_count() {
    $ray = ray([1,5,2]);
    $count = 3;
    $output = $ray->count();
    $this->assertEquals($output, $count);
  }

  public function test_is_empty() {
    $empty_ray = ray([]);
    $filled_ray = ray([1,2,3]);

    $this->assertEquals(true, $empty_ray->is_empty());
    $this->assertEquals(false, $filled_ray->is_empty());
  }

  public function test_any_match() {
    $ray_with_match = ray(["dud", "dud", "match", "dud"]);
    $ray_without_match = ray(["dud", "dud"]);

    $matcher = function($element) { return $element == "match"; };

    $this->assertEquals(true, $ray_with_match->any_match($matcher));
    $this->assertEquals(false, $ray_without_match->any_match($matcher));
  }

  public function test_all_match() {
    $ray_with_all_match = ray(["match", "match", "match", "match"]);
    $ray_without_all_match = ray(["match", "dud", "match", "match"]);

    $matcher = function($element) { return $element == "match"; };

    $this->assertEquals(true, $ray_with_all_match->all_match($matcher));
    $this->assertEquals(false, $ray_without_all_match->all_match($matcher));
  }

  public function test_shuffle() {
    # Can't do because of the unreliable output and PHP's inability to stub out the global shuffle() method.
  }

}

