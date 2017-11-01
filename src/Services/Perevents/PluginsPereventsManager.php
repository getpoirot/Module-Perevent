<?php
namespace Module\Perevent\Services\Perevents;

use Poirot\Ioc\Container\aContainerCapped;
use Poirot\Ioc\Container\Exception\exContainerInvalidServiceType;
use Poirot\Perevent\ManagerOfPerevent;


class PluginsPereventsManager
    extends aContainerCapped
{
    /**
     * Validate Plugin Instance Object
     *
     * @param mixed $pluginInstance
     *
     * @throws \Exception
     */
    function validateService($pluginInstance)
    {
        if (! is_object($pluginInstance) )
            throw new \Exception(sprintf('Can`t resolve to (%s) Instance.', $pluginInstance));

        if (! $pluginInstance instanceof ManagerOfPerevent )
            throw new exContainerInvalidServiceType('Invalid Plugin Of Perevent Provided.');
    }
}
