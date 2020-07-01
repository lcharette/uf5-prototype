<?php

/*
 * UserFrosting (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/UserFrosting
 * @copyright Copyright (c) 2019 Alexander Weissman
 * @license   https://github.com/userfrosting/UserFrosting/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Tests\Unit\Composer;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use UserFrosting\Composer\Installed;

class InstalledTest extends TestCase
{
    public function testConstructor(): Installed
    {
        $installed = new Installed();
        $this->assertInstanceOf(Installed::class, $installed);

        return $installed;
    }

    /**
     * @depends testConstructor
     */
    public function testLoadFileWithNotFound(Installed $installed): void
    {
        $this->expectException(\Exception::class);
        $installed->loadFile('foo');
    }

    /**
     * @depends testConstructor
     */
    public function testLoadFile(Installed $installed): Installed
    {
        $installed->loadFile(__DIR__ . '/data/installed.json');

        $content = $installed->getRawContent();
        $this->assertJson($content);

        return $installed;
    }

    /**
     * @depends testLoadFile
     */
    public function testgetInstalled(Installed $installed): void
    {
        $array = $installed->getInstalled();
        $this->assertIsArray($array);
        $this->assertCount(7, $array);

        //$this->assertIsArray($array[0]);
        $this->assertSame('php-di/php-di', $array[0]->name);
        $this->assertSame('library', $array[0]->type);
    }

    /**
     * @depends testLoadFile
     */
    public function testgetInstalledForType(Installed $installed): void
    {
        $array = $installed->getInstalledForType('userfrosting-sprinkle');
        $this->assertIsArray($array);
        $this->assertCount(3, $array);

        $this->assertIsArray($array[3]);
        // $this->assertSame('php-di/php-di', $array[0]->name);
        // $this->assertSame('library', $array[0]->type);
    }
}
