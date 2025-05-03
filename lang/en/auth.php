<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed'   => 'These credentials do not match our records.',
    'password' => 'The provided password is incorrect.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',

    'users' => [
        'get_list_failed' => 'Cannot get users list',
        'register_failed' => 'Cannot register user'
    ],
    'profile' => [
        'not_found'         => 'Profile not found',
        'cannot_be_created' => 'User profile cannot be created',
        'cannot_be_updated' => 'User profile cannot be updated',
        'updated'           => 'Profile updated successfully'
    ]
];
