<?php

function get_roles_array()
{
    return [
        App\Models\User::ROLE_USER => 'Member',
        App\Models\User::ROLE_ADMIN => 'Admin'
    ];
}