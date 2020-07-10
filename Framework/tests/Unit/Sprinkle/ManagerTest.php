<?php

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/UserFrosting
 * @copyright Copyright (c) 2020 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/UserFrosting/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Framework\Tests\Unit\Sprinkle;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use UserFrosting\Framework\Composer\Installed;
use UserFrosting\Framework\Composer\Package;
use UserFrosting\Framework\Sprinkle\Manager;

class ManagerTest extends TestCase
{
    public function testConstructor(): void 
    {
        /** @var Package */
        $package = m::mock(Package::class);

        /** @var Installed */
        $installed = m::mock(Installed::class);
        
        $manager = new Manager($package, $installed);
        $this->assertInstanceOf(Manager::class, $manager);
    }
}
