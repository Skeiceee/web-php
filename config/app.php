<?php

    return [
        'host' => 'localhost',
        'dbname' => 'web_php',
        'username' => 'postgres',
        'password' => 'postgres',
        'port' => 5432,
        'options' => [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    ];