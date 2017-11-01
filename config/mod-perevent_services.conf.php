<?php

return [
    'services' => [
        'Perevent' => \Module\Perevent\Services\ServicePereventManagers::class,
    ],
    'nested' => [
        'repository' => [
            'services' => [
                'repoMongodb' => \Module\Perevent\Model\Driver\Mongo\repoMongoPerevents::class,
            ],
        ],
    ],
];
