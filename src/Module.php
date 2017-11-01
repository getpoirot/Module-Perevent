<?php
namespace Module\Perevent
{
    use Module\OAuth2\Services\BuildServices;
    use Poirot\Application\aSapi;
    use Poirot\Application\Interfaces\iApplication;
    use Poirot\Application\Interfaces\Sapi\iSapiModule;
    use Poirot\Application\Interfaces\Sapi;

    use Poirot\Application\Sapi\Module\ContainerForFeatureActions;
    use Poirot\Ioc\Container;
    use Poirot\Ioc\Container\BuildContainer;
    use Poirot\Loader\Autoloader\LoaderAutoloadAggregate;
    use Poirot\Loader\Autoloader\LoaderAutoloadNamespace;
    use Poirot\Router\BuildRouterStack;
    use Poirot\Router\Interfaces\iRouterStack;
    use Poirot\Std\Interfaces\Struct\iDataEntity;


    class Module implements iSapiModule
        , Sapi\Module\Feature\iFeatureModuleInitSapi
        , Sapi\Module\Feature\iFeatureModuleAutoload
        , Sapi\Module\Feature\iFeatureModuleMergeConfig
        , Sapi\Module\Feature\iFeatureModuleNestServices
        , Sapi\Module\Feature\iFeatureModuleNestActions
        , Sapi\Module\Feature\iFeatureOnPostLoadModulesGrabServices
    {
        const CONF = 'module.perevents';


        /**
         * Init Module Against Application
         *
         * - determine sapi server, cli or http
         *
         * priority: 1000 A
         *
         * @param iApplication|aSapi $sapi Application Instance
         *
         * @return false|null False mean not setup with other module features (skip module)
         * @throws \Exception
         */
        function initialize($sapi)
        {
            if ( \Poirot\isCommandLine( $sapi->getSapiName() ) )
                // Sapi Is Not HTTP. SKIP Module Load!!
                return false;
        }

        /**
         * @inheritdoc
         */
        function initAutoload(LoaderAutoloadAggregate $baseAutoloader)
        {
            #$nameSpaceLoader = \Poirot\Loader\Autoloader\LoaderAutoloadNamespace::class;
            $nameSpaceLoader = 'Poirot\Loader\Autoloader\LoaderAutoloadNamespace';
            /** @var LoaderAutoloadNamespace $nameSpaceLoader */
            $nameSpaceLoader = $baseAutoloader->loader($nameSpaceLoader);
            $nameSpaceLoader->addResource(__NAMESPACE__, __DIR__);
        }

        /**
         * @inheritdoc
         */
        function initConfig(iDataEntity $config)
        {
            return \Poirot\Config\load(__DIR__ . '/../config/mod-perevent');
        }

        /**
         * Get Nested Module Services
         *
         * it can be used to manipulate other registered services by modules
         * with passed Container instance as argument.
         *
         * priority not that serious
         *
         * @param Container $moduleContainer
         *
         * @return null|array|BuildContainer|\Traversable
         */
        function getServices(Container $moduleContainer = null)
        {
            $conf    = \Poirot\Config\load(__DIR__ . '/../config/mod-perevent_services');

            $builder = new BuildServices;
            $builder->with($builder::parseWith($conf));
            return $builder;
        }

        /**
         * Get Action Services
         *
         * priority not that serious
         *
         * - return Array used to Build ModuleActionsContainer
         *
         * @return array|ContainerForFeatureActions|BuildContainer|\Traversable
         */
        function getActions()
        {
            return \Poirot\Config\load(__DIR__ . '/../config/mod-perevent.actions');
        }

        /**
         * @inheritdoc
         *
         * @param iRouterStack   $router
         */
        function resolveRegisteredServices(
            $router = null
        ) {
            # Register Http Routes:
            #
            if ( $router ) {
                $routes = include __DIR__ . '/../config/mod-perevent.routes.conf.php';
                $buildRoute = new BuildRouterStack;
                $buildRoute->setRoutes($routes);
                $buildRoute->build($router);
            }
        }
    }
}

namespace Module\Perevent
{
    use Module\Perevent\Services\Perevents\PluginsPereventsManager;


    /**
     * @method static PluginsPereventsManager Perevent()
     */
    class Services extends \IOC
    { }
}
