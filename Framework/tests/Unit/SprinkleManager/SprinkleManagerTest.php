<?php

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/UserFrosting
 * @copyright Copyright (c) 2020 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/UserFrosting/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Tests\Unit\SprinkleManager;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use UserFrosting\Composer\Installed;
use UserFrosting\Composer\Package;
use UserFrosting\SprinkleManager\SprinkleManager;

class SprinkleManagerTest extends TestCase
{
    public function testConstructor(): void 
    {
        /** @var Package */
        $package = m::mock(Package::class);

        /** @var Installed */
        $installed = m::mock(Installed::class);
        
        $manager = new SprinkleManager($package, $installed);
        $this->assertInstanceOf(SprinkleManager::class, $manager);
    }
}
