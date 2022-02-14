<?php

declare(strict_types=1);

return [
    // Show Members
    'show_members' => [
        'path' => '/show_members',
        'target' =>  Qc\QcInfoRights\Report\QcInfoRightsReport::class . '::showMembers'
    ],

    // Render Users
    'render_users' => [
        'path' => '/render_users',
        'target' =>  Qc\QcInfoRights\Report\QcInfoRightsReport::class . '::renderUsers'
    ],
];
