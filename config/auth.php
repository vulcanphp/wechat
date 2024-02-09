<?php

return [

    // AuthDriver configuration <START>
    'roles'  => ['admin', 'editor', 'user'],
    'rights' => [
        'admin'  => ['super', 'read', 'create', 'edit', 'delete'],
        'editor' => ['read', 'create', 'edit'],
        'user'   => ['read'],
    ],
    'status' => [
        'activated'   => 1,
        'deactivated' => 2,
        'suspended'   => 3,
    ],
    'use_cache'     => true,
    'use_cookie'    => true,
    // AuthDriver configuration <END>

];
