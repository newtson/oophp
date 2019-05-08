<?php
//namespace Anax\View;


/**
 * Config file for Database.
 *
 * Example for MySQL.
 *  "dsn" => "mysql:host=localhost;dbname=test;",
 *  "username" => "test",
 *  "password" => "test",
 *  "driver_options"  => [\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"],
 *
 * Example for SQLite.
 *  "dsn" => "sqlite:memory::",
 *
 */
return [
    "dsn"             => "mysql:host=blu-ray.student.bth.se;dbname=anei17;",
    "username"        => "anei17",
    "password"        => "jr5LhzJFaVSY",
    "driver_options"  => [
        \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"
    ],
    "fetch_mode"      => \PDO::FETCH_OBJ,
    "table_prefix"    => null,
    "session_key"     => "Anax\Database",
    "emulate_prepares" => false,

    // True to be very verbose during development
    "verbose"         => false,

    // True to be verbose on connection failed
    "debug_connect"   => true,
    /*"dsn"              => null,
    "username"         => null,
    "password"         => null,
    "driver_options"   => null,
    "fetch_mode"       => \PDO::FETCH_OBJ,
    "table_prefix"     => null,
    "session_key"      => "Anax\Database",
    "emulate_prepares" => false,

    // True to be very verbose during development
    "verbose"         => null,

    // True to be verbose on connection failed
    "debug_connect"   => false,*/
];
