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
use UserFrosting\Composer\Package;

class PackageTest extends TestCase
{
    public function testConstructor(): Package
    {
        $package = new Package();
        $this->assertInstanceOf(Package::class, $package);

        return $package;
    }

    /**
     * @depends testConstructor
     */
    public function testLoadFileWithNotFound(Package $package): void
    {
        $this->expectException(\Exception::class);
        $package->loadFile('foo');
    }

    /**
     * @depends testConstructor
     */
    public function testLoad(Package $package): Package
    {
        $result = $package->load(__DIR__ . '/data/');
        $this->assertInstanceOf(Package::class, $result);

        $content = $package->getRawContent();
        $this->assertJson($content);

        return $package;
    }

    /**
     * @depends testLoad
     */
    public function testgetContent(Package $package): void
    {
        $result = $package->getContent();

        $this->assertIsObject($result);
        $this->assertSame('userfrosting/foobar', $result->name);
        $this->assertSame('project', $result->type);
    }

    /**
     * @depends testLoad
     */
    public function testgetSprinkles(Package $package): void
    {
        $sprinkles = $package->getSprinkles();

        $this->assertIsArray($sprinkles);
        $this->assertCount(2, $sprinkles);
        $this->assertSame([
            'foo/bar'  => 'Foo\\Sprinkle\\Bar\\Boot',
            'foo/site' => 'Foo\\Sprinkle\\Site\\Site',
        ], $sprinkles);
    }

    /**
     * @depends testgetSprinkles
     */
    public function testgetSprinklesWithNoExtra(): void
    {
        $package = new Package();
        $sprinkles = $package->loadFile(__DIR__ . '/data/composer_noextra.json')->getSprinkles();

        $this->assertIsArray($sprinkles);
        $this->assertCount(0, $sprinkles);
        $this->assertSame([], $sprinkles);
    }

    /**
     * @depends testgetSprinkles
     */
    public function testgetSprinklesWithNoSprinkleDefinition(): void
    {
        $package = new Package();
        $sprinkles = $package->loadFile(__DIR__ . '/data/composer_nosprinkles.json')->getSprinkles();

        $this->assertIsArray($sprinkles);
        $this->assertCount(0, $sprinkles);
        $this->assertSame([], $sprinkles);
    }

    /**
     * @depends testgetSprinkles
     */
    public function testgetSprinklesWithEmptySprinkleDefinition(): void
    {
        $package = new Package();
        $sprinkles = $package->loadFile(__DIR__ . '/data/composer_emptySprinkles.json')->getSprinkles();

        $this->assertIsArray($sprinkles);
        $this->assertCount(0, $sprinkles);
        $this->assertSame([], $sprinkles);
    }
}
