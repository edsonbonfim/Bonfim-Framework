<?php

/**
 * Database connection
 */
Database::connection('mysql:host=localhost;dbname=note', 'root', 'batatapalha123');

/**
 * Template Engine
 */
Tpl::config([
    'dev' => true,
    'template_dir' => dirname(getcwd()) . '/app/View/'
]);
