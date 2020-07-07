<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/UserFrosting
 * @copyright Copyright (c) 2020 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/UserFrosting/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\SprinkleManager;

use UserFrosting\Composer\Installed;
use UserFrosting\Composer\Package;

/**
 * Sprinkle manager class.
 *
 * Manages a collection of loaded Sprinkles for the application.
 * Handles Sprinkle class creation, event subscription, services registration, and resource stream registration.
 */
class SprinkleManager
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

    public function loadSprinkles(): void
    {
        $this->sprinkles = $this->getSprinkles();
    }

    /**
     * @return array<string,string> as SprinkleName => SprikleBootClass
     */
    protected function getSprinkles(): array
    {
        // Get composer installed sprinkles
        $installed = $this->composerInstalled->getSprinkles();
        
        // Get root defined sprinkles
        $root = $this->composerPackage->getSprinkles();

        // Return a merged list
        return array_merge($installed, $root);
    }

    protected function bootSprinkle(): bool 
    {
        return true;
    }
}
