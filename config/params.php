<?php

return [
    'user.passwordResetTokenExpire' => 3600,
    'pagination' => [10 => 10, 25 => 25, 50 => 50, 75 => 75, 100 => 100],
    'chat_status' => [
        0 => [ 'id' => 0, 'label' => 'Answered', 'class' => 'success'],
        1 => [ 'id' => 1, 'label' => 'Un-Answered', 'class' => 'danger'],
        2 => [ 'id' => 2, 'label' => 'Trained', 'class' => 'primary'],
    ],
    'chat_type' => [
        0 => [ 'id' => 0, 'label' => 'BOT', 'class' => 'success'],
        1 => [ 'id' => 1, 'label' => 'User', 'class' => 'primary'],
    ],
    'record_status' => [
        0 => ['id' => 0, 'label' => 'In-active', 'class' => 'danger'],
        1 => ['id' => 1, 'label' => 'Active', 'class' => 'success'],
    ],
    'ip_types' => [
        0 => ['id' => 0, 'label' => 'Black List', 'class' => 'success'],
        1 => ['id' => 1, 'label' => 'White List', 'class' => 'danger'],
    ],
    'notification_status' => [
        0 => ['id' => 0, 'label' => 'New', 'class' => 'danger'],
        1 => ['id' => 1, 'label' => 'Read', 'class' => 'success'],
    ],
    'notification_types' => [
        0 => ['id' => 0, 'type' => 'notification_change_password', 'label' => 'Password Changed'],
        1 => ['id' => 1, 'type' => 'signup', 'label' => 'Signup'],
        2 => ['id' => 2, 'type' => 'announcement', 'label' => 'Announcement'],
        3 => ['id' => 3, 'type' => 'video', 'label' => 'Video'],
        4 => ['id' => 4, 'type' => 'event', 'label' => 'Event'],
    ],
    'user_status' => [
        0 => ['id' => 0, 'label' => 'Archived', 'class' => 'danger'],
        9 => ['id' => 9, 'label' => 'Not Verified', 'class' => 'warning'],
        10 => ['id' => 10, 'label' => 'Active', 'class' => 'success'],
    ],
    'user_block_status' => [
        0 => ['id' => 0, 'label' => 'Allowed', 'class' => 'success'],
        1 => ['id' => 1, 'label' => 'Blocked', 'class' => 'danger'],
    ],
    'visit_log_actions' => [
        0 => ['id' => 0, 'label' => 'Login', 'class' => 'success'],
        1 => ['id' => 1, 'label' => 'Logout', 'class' => 'danger'],
    ],
    'whitelist_ip_only' => [
        0 => ['id' => 0, 'label' => 'All', 'class' => 'danger'],
        1 => ['id' => 1, 'label' => 'Whitelist Only', 'class' => 'success'],
    ],
    'enable_visitor' => [
        0 => ['id' => 0, 'label' => 'Disable', 'class' => 'danger'],
        1 => ['id' => 1, 'label' => 'Enable (require internet connection)', 'class' => 'success'],
    ],
    'article_categories' => [
        'Poultry',
        'Farming',
        'Fishing',
    ]
];