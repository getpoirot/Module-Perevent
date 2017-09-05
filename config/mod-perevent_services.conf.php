<?php

return [
    'services' => [
        'Perevent' => new \Poirot\Ioc\instance(
            Poirot\Perevent\ManagerOfPerevents::class,
            [
                'repository' => new \Poirot\Ioc\instance('/module/perevent/services/repository/Perevents'),
                'plugins'    => \Poirot\Std\catchIt(function () {
                    if (false === $c = \Poirot\Config\load(__DIR__.'/perevent/command-plugins'))
                        throw new \Exception('Config (perevent/command-plugins) not loaded.');

                        return $c->value;
                })
            ]
        ),
    ],
    'nested' => [
        'repository' => [
            'implementations' => [
                'Perevents' => \Poirot\Perevent\Interfaces\iRepoPerEvent::class,
            ],
            'services' => [
                'Perevents' => \Module\Perevent\Model\Driver\Mongo\PereventsRepoService::class,
            ],
        ],
    ],
];
