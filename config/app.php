<?php

/**
 * Database connection
 */
Database::conn('mysql:host=localhost;dbname=note', 'root', '');

/**
 * Template Engine
 */
Tpl::config([
    'dev' => true,
    'template_dir' => dirname(getcwd()) . '/app/View/'
]);
