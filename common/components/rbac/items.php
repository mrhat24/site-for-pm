<?php
return [
    'user' => [
        'type' => 1,
        'description' => 'Пользователь',
        'ruleName' => 'userRole',
    ],
    'student' => [
        'type' => 1,
        'description' => 'Студент',
        'ruleName' => 'userRole',
        'children' => [
            'user',
        ],
    ],
    'teacher' => [
        'type' => 1,
        'description' => 'Преподаватель',
        'ruleName' => 'userRole',
        'children' => [
            'student',
        ],
    ],
    'chief' => [
        'type' => 1,
        'description' => 'Заведующий кафедрой',
        'ruleName' => 'userRole',
        'children' => [
            'teacher',
        ],
    ],
    'admin' => [
        'type' => 1,
        'description' => 'Администратор',
        'ruleName' => 'userRole',
        'children' => [
            'chief',
        ],
    ],
];
