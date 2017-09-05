<?php
use Poirot\Sms\Interfaces\iClientOfSMS;

return [

    ## Mongo Driver
    #
    Module\MongoDriver\Module::CONF_KEY => [
        \Module\MongoDriver\Services\aServiceRepository::CONF_REPOSITORIES => [
            // Perevents Repository
            \Module\Perevent\Model\Driver\Mongo\PereventsRepoService::class => [
                'collection' => [
                    // query on which collection
                    'name' => 'perevents',
                    // which client to connect and query with
                    'client' => 'master',
                    // ensure indexes
                    'indexes' => [
                        ['key' => ['uid' => 1]],
                        ['key' => ['uid' => 1], 'unique' => true ],
                        // db.database_name.collection_name.createIndex({"datetime_expiration_mongo": 1}, {expireAfterSeconds: 0});
                        ['key' => ['datetime_expiration_mongo' => 1], 'expireAfterSeconds' => 0 ],
                    ],],],
        ],
    ],
];
