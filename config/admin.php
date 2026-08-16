<?php

return [
    'name' => 'LyoVial Admin',
    'prefix' => 'admin',
    'guard' => 'web',

    'pagination' => 15,

    'upload' => [
        'max_image_kb' => 5120,
        'max_file_kb' => 10240,
        'image_mimes' => ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'],
        'document_mimes' => ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'csv', 'txt', 'zip'],
    ],

    'themes' => ['light', 'dark'],

    'permissions' => [
        'dashboard.view',
        'profile.manage',
        'settings.manage',
        'theme.manage',
        'media.manage',
        'files.manage',
        'pages.view',
        'pages.create',
        'pages.update',
        'pages.delete',
        'services.view',
        'services.create',
        'services.update',
        'services.delete',
        'industries.view',
        'industries.create',
        'industries.update',
        'industries.delete',
        'home.manage',
        'faqs.manage',
        'why_choose.manage',
        'testimonials.manage',
        'articles.manage',
        'contact.manage',
        'inquiries.view',
        'inquiries.manage',
        'inquiries.delete',
        'inquiries.export',
        'menus.manage',
        'roles.manage',
        'users.manage',
    ],
];
