<?php

function ray($array) {
  if(is_null($array)) {
    $assoc_array = [];
  }
  return new Ray($array);
};

function rash($assoc_array = NULL) {
  if(is_null($assoc_array)) {
    $assoc_array = [];
  }
  return new Rash($assoc_array);
}