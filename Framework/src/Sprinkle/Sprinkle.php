<?php declare(strict_types=1);

namespace UserFrosting\System;

use Psr\Container\ContainerInterface;
// TODO: This is deprecated, we need to switch to PSR-14
use RocketTheme\Toolbox\Event\EventSubscriberInterface;
use UserFrosting\System\Router\RoutesInterface;

abstract class Sprinkle implements EventSubscriberInterface
{
    /**
     * @var ContainerInterface The global container object, which holds all your services.
     */
    protected $ci;

    /**
     * @var string[] List of services provider to register
     *
     * @todo Move all theses to their own class (Target UF 5.0) and list the one need registering in config
     */
    protected $servicesproviders = [];

    /**
     * Create a new Sprinkle object.
     *
     * @param ContainerInterface $ci The global container object, which holds all your services.
     */
    public function __construct(ContainerInterface $ci)
    {
        $this->ci = $ci;
    }

    /**
     * Returns sprinkles routes.
     * @return RoutesInterface[]
     */
    public function getRoutes(): array
    {
        // noop
        return [];
    }

    /**
     * By default assign all methods as listeners using the default priority.
     */
    public static function getSubscribedEvents(): array
    {
        $methods = get_class_methods(get_called_class());

        $list = [];
        foreach ($methods as $method) {
            if (strpos($method, 'on') === 0) {
                $list[$method] = [$method, 0];
            }
        }

        return $list;
    }

    /**
     * Register all services providers.
     */
    public function registerServices(): void
    {
        foreach ($this->servicesproviders as $provider) {
            if (class_exists($provider)) {
                $instance = new $provider($this->ci);
                $instance->register();
            }
        }
    }
}
