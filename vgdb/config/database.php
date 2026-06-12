<?php

Env::load(BASE_PATH . '/.env');

return [
    'host' => Env::get('DB_HOST'),
    'database' => Env::get('DB_DATABASE'),
    'username' => Env::get('DB_USERNAME'),
    'password' => Env::get('DB_PASSWORD', ''),
    'charset' => Env::get('DB_CHARSET', 'utf8mb4'),
];
