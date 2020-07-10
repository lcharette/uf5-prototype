<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/UserFrosting
 * @copyright Copyright (c) 2020 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/UserFrosting/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle;

use UserFrosting\Composer\Installed;
use UserFrosting\Composer\Package;
use UserFrosting\Exception\ClassNotFoundException;
use UserFrosting\Exception\ClassNotInstanceOfException;
use UserFrosting\Sprinkle\BootInterface;

/**
 * Sprinkle manager class.
 *
 * Manages a collection of loaded Sprinkles for the application.
 * Handles Sprinkle class creation, event subscription, services registration, and resource stream registration.
 */
class Manager
{
    /**
     * @var Installed
     */
    protected $composerInstalled;

    /**
     * @var Package
     */
    protected $composerPackage;

    /**
     * @var array<string,string> List of loaded sprinkles, presented as array<fullname,bootclass>.
     */
    protected $sprinkles;
    
    public function __construct(Package $composerPackage, Installed $composerInstalled)
    {
        $this->composerPackage = $composerPackage;
        $this->composerInstalled = $composerInstalled;
    }

    /**
     * Load the sprinkle lsit from the definition schema.
     */
    public function loadSprinkles(): void
    {
        // Get composer installed sprinkles
        $installed = $this->composerInstalled->getSprinkles();
        
        // Get root defined sprinkles
        $root = $this->composerPackage->getSprinkles();

        // Return a merged list
        $this->sprinkles = array_merge($installed, $root);
    }

    /**
     * @return array<string,string> as SprinkleName => SprikleBootClass
     */
    public function getSprinkles(): array
    {
        return $this->sprinkles;
    }

    /**
     * Boot all sprinkles.
     */
    public function bootSprinkles(): void 
    {
        foreach ($this->sprinkles as $name => $className) {            
            $class = $this->getSprinkleClass($name, $className);
            $this->bootSprinkle($class);
        }
    }

    /**
     * Validate the classname and return the instance of the class.
     *
     * @param string $name
     * @param string $className
     * @throws ClassNotFoundException
     * @throws ClassNotInstanceOfException
     * 
     * @return BootInterface
     */
    protected function getSprinkleClass(string $name, string $className): BootInterface 
    {
        // Throw error if class is not found
        if (!class_exists($className)) {
            throw new ClassNotFoundException("Sprinkle `$name` boot class `$className` not found.");
        }

        // Create instance 
        $class = new $className;

        // Validate method
        if (!$class instanceof BootInterface) {
            throw new ClassNotInstanceOfException("Sprinkle `$name` boot class `$className` doesn't implement `".BootInterface::class."`.");
        }

        return $class;
    }

    protected function bootSprinkle(BootInterface $sprinkle): void 
    {
        $path = $sprinkle->getPath();
    }
}
