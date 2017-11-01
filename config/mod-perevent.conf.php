<?php

use Module\Perevent\Services\ServicePereventManagers;

return [

    Module\Perevent\Module::CONF => [
        ServicePereventManagers::CONF => [
            'services' => [
                'persist' => new \Poirot\Ioc\instance(
                    Poirot\Perevent\ManagerOfPerevent::class,
                    [
                        'repository' => new \Poirot\Ioc\instance('/module/perevent/services/repository/repoMongodb'),
                        'plugins'    => \Poirot\Std\catchIt(function () {
                            if (false === $c = \Poirot\Config\load(__DIR__.'/perevent/command-plugins'))
                                throw new \Exception('Config (perevent/command-plugins) not loaded.');

                            return $c->value;
                        })
                    ]
                ),
                'onthefly' => new \Poirot\Ioc\instance(
                    Poirot\Perevent\ManagerOfPerevent::class,
                    [
                        'repository' => null,
                        'plugins'    => \Poirot\Std\catchIt(function () {
                            if (false === $c = \Poirot\Config\load(__DIR__.'/perevent/command-plugins'))
                                throw new \Exception('Config (perevent/command-plugins) not loaded.');

                            return $c->value;
                        })
                    ]
                ),
            ],
        ],
    ],

    ## Mongo Driver
    #
    Module\MongoDriver\Module::CONF_KEY => [
        \Module\MongoDriver\Services\aServiceRepository::CONF_REPOSITORIES => [
            // Perevents Repository
            \Module\Perevent\Model\Driver\Mongo\repoMongoPerevents::class => [
                'collection' => [
                    // query on which collection
                    'name' => 'perevents',
                    // which client to connect and query with
                    'client' => 'master',
                    // ensure indexes
                    'indexes' => [
                        ['key' => ['cmd_hash' => 1]],
                        ['key' => ['cmd_hash' => 1], 'unique' => true ],
                        // db.database_name.collection_name.createIndex({"datetime_expiration_mongo": 1}, {expireAfterSeconds: 0});
                        ['key' => ['datetime_expiration_mongo' => 1], 'expireAfterSeconds' => 0 ],
                    ],],],
        ],
    ],
];
