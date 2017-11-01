<?php
namespace Module\Perevent\Services;

use Module\Perevent\Services\Perevents\PluginsPereventsManager;
use Poirot\Application\aSapi;
use Poirot\Ioc\Container\BuildContainer;
use Poirot\Ioc\Container\Service\aServiceContainer;
use Poirot\Std\Struct\DataEntity;


class ServicePereventManagers
    extends aServiceContainer
{
    const CONF = 'plugins';


    /**
     * Create Service
     *
     * @return mixed
     */
    function newService()
    {
        $plugins = new PluginsPereventsManager;
        $builder = new BuildContainer($this->_getConf());
        $builder->build($plugins);

        return $plugins;
    }


    // ..

    /**
     * Get Config Values
     *
     * @return mixed|null
     * @throws \Exception
     */
    protected function _getConf()
    {
        // retrieve and cache config
        $services = $this->services();

        /** @var aSapi $config */
        $config = $services->get('/sapi');
        $config = $config->config();

        /** @var DataEntity $config */
        $config = $config->get( \Module\Perevent\Module::CONF, []);
        $config = $config[self::CONF];
        return $config;
    }
}
