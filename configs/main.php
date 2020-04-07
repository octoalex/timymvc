<?php
return [
    'database' => [
        'host' => 'localhost',
        'name' => 'forumedia',
        'password' => 'elfenlied1,',
        'username' => 'octo',
        'port' => 5433
    ],
    'dashboard' => [
        'login' => 'admin',
        'password' => 'e10adc3949ba59abbe56e057f20f883e',
        'email' => 'funyloony@gmail.com',
        'user_paginate' => 10
    ],

    'defaults' => [
        'activate_user_role' => '',
        'club_user' => [
            0 => 'Не состоит в клубе',
            1 => 'Состоит в клубе, имеет максимальные права',
            2 => 'Состоит в клубе, имеет стандартные права'
        ]
    ],
];
