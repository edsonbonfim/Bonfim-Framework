Table of Contents
-----------------

* [Prerequisites](#prerequisites)
* [Supported Databases](#supported-databases)
* [Installation](#installation)
* [Basic CRUD](#basic-crud)
    * [Retrieve](#retrieve)
    * [Create](#create)
    * [Update](#update)
    * [Delete](#delete)
* [Contributing](#contributing)
* [Security](#security)
* [Credits](#credits)
* [License](#license)

Prerequisites
-------------

* PHP 7.1+
* PDO driver for your respective database

Supported Databases
-------------------

* MySQL

Installation
------------

Require via [composer](https://getcomposer.org/download/)

``` sh
$ composer require keeporm/keep:^1.0
```

Create an **index.php** file and require the autoload.php of composer

```php
<?php

include 'vendor/autoload.php';
```

After that, let's to do all necessary configuration

```php
use Keep\DB;

DB::config([
    'driver' => 'mysql',
    'host'   => 'localhost',
    'dbname' => 'keep',
    'user'   => 'root',
    'pass'   => '1234'
]);

DB::conn();
```

Basic CRUD
----------

* [Retrieve](#retrieve)
* [Create](#create)
* [Update](#update)
* [Delete](#delete)

### Retrieve

These are your basic methods to find and retrieve records from your database:

```php
$post = Post::find(1);
echo $user->title; // 'My first blog post!!'
echo $user->author_name; // 'Edson Onildo'

// Finding using dynamic finders
$post = Post::find_by_title('My first blog post!!');
$post = Post::find_by_title_or_id('My first blog post!!', 1);
$post = Post::find_by_title_and_id('My first blog post!!', 1);

// Retrieve all records
$post = Post::all();
```

### Create

Here we create a new post by instantiating a new object and then invoking the save() method:

```php
$post = new Post();
$post->title = 'My first blog post!!';
$post->author_name = 'Edson Onildo';
$post->save();

// INSERT INTO `posts` (title, author_name) VALUES ('My first blog post!!', 'Edson Onildo');
```

### Update

To update you would just need to find a record first and then change one of its attributes.

```php
$post = Post::find(1);
echo $post->title; // 'My first blog post!!'
$post->title = 'Some title';
$post->save();

// UPDATE `posts` SET title='Some title' WHERE id=1
```

### Delete

Deleting a record will not destroy the object. This means that it will call sql to delete the record in your database but you can still use the object if you need to.

```php
$post = Post::find(1);
$post->delete();

// DELETE FROM `posts` WHERE id=1
```
