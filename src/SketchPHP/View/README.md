Table of Contents
-----------------

* [Prerequisites](#prerequisites)
* [Installation](#installation)
* [Basic Usage](#basic-usage)
* [Sketch Tags](#sketch-tags)
    * [Variables](#variables)
    * [Conditional Expression](#conditional-expression)
    * [Loop](#loop)
    * [Function](#function)
    * [Include](#include)
* [Contributing](#contributing)
* [Security](#security)
* [Credits](#credits)
* [License](#license)

Prerequisites
-------------

* PHP 7.1+

Installation
------------

Require via [composer](https://getcomposer.org/download/)

``` sh
$ composer require sketchphp/sketch:^2.1
```

Basic usage
-----------

Create an **index.php** file and require the autoload.php of composer

``` php
<?php

include 'vendor/autoload.php';
```

After that, let's to do all necessary configuration

``` php
use Sketch\Tpl;

Tpl::config([
    //'environment' => 'production',
    'environment'   => 'development',
    'template_dir'  => 'path/to/templates',
    'cache_dir'     => 'path/to/caches'
]);
```

Assign and render template

``` php
Tpl::assing('title', 'Hello!');
Tpl::render('test');
```

Sketch Tags
-----------

* [Variables](#variables)
* [Conditional Expression](#conditional-expression)
* [Loop](#loop)
* [Function](#function)
* [Include](#include)

### Variables

Variables are the dynamic content of the template, valorized on the execution of the script with Tpl::assing() static method. Variables names are case sensitive.

**Template:**
``` html
Welcome to {title}
```

**Data:**
``` php
<?php

Tpl::assign('title', 'Sketch');
```

**Output:**
``` html
Welcome to Sketch
```

### Modifiers on variables

You can add modifiers that are executed on the variables.

**Template:**
``` html
Hello {name|capitalize}!
```

**Data:**
``` php
<?php

Tpl::assign('name', 'edson onildo');
```

**Output:**
``` html
Hello Edson Onildo!
```

#### Conditional Expression

Checks an expression and print the code between {if}{else} if the conditions is true or {else}{/if} if the condition is false. Try to use nested blocks :)

**Template:**
``` html
{if age >= 18}
    Adult
{else}
    Minor
{/if}
```

**Data:**
``` php
<?php

Tpl::assign('age', 19);
```

**Output:**
``` html
Adult
```

you can also use the {if condition}content{elseif condition}content{else}content{/if} or any combination of if and else.

### Loop

Allow to loop through the value of arrays or objects.

**Template:**
``` html
<ul>
    {loop authors as author}
    <li>
        {author.name}: {author.page}
    </li>
    {/loop}
</ul>
```

**Data:**
``` php
<?php

$authors = [
    [
        'name' => 'Edson Onildo',
        'page' => 'https://github.com/EdsonOnildoJR'
    ],
    [
        'name' => 'Contributors',
        'page' => 'https://github.com/EdsonOnildoJR/Sketch/contributors'
    ]
];

Tpl::assign('authors', $authors);
```

**Output:**
``` html
Edson Onildo: https://github.com/EdsonOnildoJR
Contributors: https://github.com/EdsonOnildoJR/Sketch/contributors
```

### Function

Use {func  funcname()} tag to execute a PHP function and print the result. You can pass strings, numbers and variables as parameters.

**Template:**
``` html
{func date('Y')}
```

**Output:**
``` html
2018
```

### Include

With **{include 'template'}** tag you can include external template as blocks.

**Template:**
``` html
<h1>New user:</h1>
{template 'userForm'}
```

**Output:**
``` html
<h1>New user:</h1>
<form class="user" action="" method="post">
    ...
</form>
```
