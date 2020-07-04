<?php

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/UserFrosting
 * @copyright Copyright (c) 2020 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/UserFrosting/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Tests\Unit\Composer;

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
        $result = $installed->loadFile(__DIR__ . '/data/installed.json');
        $this->assertInstanceOf(Installed::class, $result);

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

        $this->assertIsObject($array[0]);
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
        $this->assertIsObject($array[0]);

        // Get only the names.
        $names = array_map(function ($value) {
            return $value->name;
        }, $array);

        $this->assertSame([
            'userfrosting/account',
            'userfrosting/admin',
            'userfrosting/core',
        ], $names);
    }

    /**
     * @depends testLoadFile
     * @depends testgetInstalledForType
     */
    public function testgetSprinkles(Installed $installed): void
    {
        $sprinkles = $installed->getSprinkles();

        $this->assertIsArray($sprinkles);
        $this->assertCount(3, $sprinkles);
        $this->assertSame([
            'userfrosting/account' => '',
            'userfrosting/admin'   => '',
            'userfrosting/core'    => 'UserFrosting\\Sprinkle\\Core\\Core',
        ], $sprinkles);
    }
}
