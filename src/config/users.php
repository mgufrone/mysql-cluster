<?php

/*
|--------------------------------------------------------------------------
| Users
|--------------------------------------------------------------------------
|
| Array of users keyed by identifier
|
*/

return array(
    'admin' => array(
        'username' => 'admin',
        'password' => Hash::make('admin'),
        'email' => 'mgufronefendi@gmail.com',
    ),
    'user' => array(
        'username' => 'user',
        'password' => Hash::make('user'),
        'email' => 'user@example.com',
    ),
);
