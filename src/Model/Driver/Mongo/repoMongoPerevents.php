<?php
namespace Module\Perevent\Model\Driver\Mongo;

use Module\MongoDriver\Services\aServiceRepository;
use Poirot\Perevent\Repo\RepoMongo;


class repoMongoPerevents
    extends aServiceRepository
{
    /** @var string Service Name */
    protected $name = 'Perevents';


    /**
     * Return new instance of Repository
     *
     * @param \MongoDB\Database  $mongoDb
     * @param string             $collection
     * @param string|object|null $persistable
     *
     * @return RepoMongo
     */
    function newRepoInstance($mongoDb, $collection, $persistable = null)
    {
        $repo = new RepoMongo($mongoDb, $collection, $persistable);
        return $repo;
    }
}
