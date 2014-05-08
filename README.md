# ruby.php

An incomplete PHP port of the Ruby standard library.

## Background

I work professionally as a Ruby on Rails developer, but once in a while I also write PHP for personal projects. Not because I like the language, but because I like the ubiquitous hosting options and the absence of operation concerns. There are no unicorns to monitor, no rubies to patch and with the proliferation of Laravel, you are getting a Railesque experience.

However, I loathe and despise the standard API and its quagmire of global functions. This library aims to bring the powerful Ruby standard API to PHP. The first goal is to implement the Array and Hash classes, but more classes may make it later.

# API

To legitimize dumping my classes in the global namespace (which is polluted enough already), I have nicknamed my classes with unusual names which should avoid collisions in most projects. The Ruby Array has been named Ray and the Ruby Hash has been named Rash.

### No bang for the buck

Since PHP does not permit exclamation marks into method names, self is used instead of ! for self-mutating methods. E.g. `merge_self` or `sort_self`.

### Don't question PHP

In addition to exclamation marks, question marks are also out of the question. Instead ruby.php will try to use `is_method` in lieu of `method?`, e.g. `is_empty`.

## Ray (Ruby Array)

Ray is a wrapper class, currently for the standard PHP array which allows you to operate on the array in a way similar to that of the Ruby Array class.

### Usage

Construction

    $ray = new Ray;  // Or it can be created from a PHP array
    $ray = new Ray(["alice", "bob", "charlie"]);

Ray offers a strong subset of the methods available in a Ruby array. Here are the instance methods

    each($handler)
    Iterates over all elements and calls the supplied handler function with each element.

    push($element)
    Adds $element to the end of the array. Returns $element.

    pop()
    Removes the last element from the array and returns it.

    shift()
    Removes the first element from the array and returns it.

    unshift($element)
    Adds $element to the beginning of the array. Returns $element.

    filter/select/find_all($handler)
    Runs the supplied handler against each element in the array and returns a new ray containing the elements for which the handler returned true.

    map/collect($handler)
    Runs the supplied handler against each element and collects the return values for the handler in a new ray which is then returned.

    merge($other)
    Merge the array with another array/Ray. Returns a new ray.

    merge_self($other)
    Just like merge, but mutates the array and returns a reference to it.

    to_a()
    Returns a standard PHP array.

    sort()
    Returns a new sorted Ray

    sort_self()
    Like sort(), but sorts the subject ray.

    count()
    Returns the number of elements in the ray.

    is_empty()
    Returns a boolean indicating if the ray is empty

    any($handler)
    Runs the supplied handler against each element and returns true if any of the handler calls return true.

    shuffle()
    Returns a new ray with elements shuffled.

    shuffle_self()
    Shuffles elements in the ray and returns reference to ray.

## Rash (Ruby Hash)

Rash is a wrapper class, currently for the standard PHP associative array, which allows you to operate on the dictionary in a way similar to that of the Ruby Hash class. Ideally it would implement the ArrayAccess interface, allowing you to use bracket access like legacy PHP arrays (and ruby hashes), however the PHP interpreter vehemently typecasts string keys that are parseable as integers into integers, making it impossible to map $rash["42"] and $rash[42] to distinct entries.

Because of this, ArrayAccess has been scrapped for now and replaced with the more verbose get and set methods.

Usage through factory function

    $rash = rash(["name" => "Alice", "age" => 28]);

Keep in mind that you are using PHP's native associative array for the function, meaning that everything will be typecasted into integers if possible and the last declared value will override previous values. E.g.

    $rash = rash([true => "Alice, 1 => "Bob", "1" => "Charlie"]);

will only contain one entry, which is `1 => "Charlie"`

However, if you skip the literal associative array notation and add one element at a time, different types are honored as distinct keys.

    $rash = rash();
    $rash->set(1, "integer as key");
    $rash->set(1.0, "float as key");
    $rash->set(true, "boolean as key");

    $rash->get(1.0);
    => 'float as key'

Check the code and the unit tests for more information on how to use Rash.

# Bottomline

### Specs

Currently there are no specs to verify ruby.php's behavior - this is on the todo list.

### Performance

I have no clue. This will need exploration.