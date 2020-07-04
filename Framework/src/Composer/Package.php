<?php

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/UserFrosting
 * @copyright Copyright (c) 2020 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/UserFrosting/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Composer;

/**
 * Read a `composer.json` file and returned the decoded information about installed packages.
 */
class Package
{
    /**
     * @var string The composer.json file content.
     */
    protected $content = '';

    /**
     * @var string The key in `extra` portion of composer.json used to list sprinkle boot class.
     */
    protected $sprinkleKey = 'sprinkles';

    /**
     * Load `composer.json` from the specified location.
     *
     * @param string $path The path where composer.json can be found.
     *
     * @return self
     */
    public function load(string $path)
    {
        return $this->loadFile($path . '/composer.json');
    }

    /**
     * Load the specified json file.
     *
     * @param string $file
     *
     * @return self
     */
    public function loadFile(string $file)
    {
        if (!$content = @file_get_contents($file)) {
            throw new \Exception('');
        }

        $this->content = $content;

        return $this;
    }

    /**
     * Returns the raw json data from the file.
     *
     * @return string
     */
    public function getRawContent(): string
    {
        return $this->content;
    }

    /**
     * Returns the processed json data as an array of objects.
     *
     * @return \stdClass
     */
    public function getContent(): \stdClass
    {
        return json_decode($this->content);
    }

    /**
     * Returns the sprinkles that are defined in the composer.json file, under the `extra` property.
     *
     * @return array<string,string> Presented as array<fullname,bootclass>
     */
    public function getSprinkles(): array
    {
        // Get content
        $content = $this->getContent();

        // Exit if the extra doesn't exist.
        if (!isset($content->extra) || !isset($content->extra->{$this->sprinkleKey})) {
            return [];
        }

        $sprinkles = [];
        foreach ($content->extra->{$this->sprinkleKey} as $name => $class) {
            $sprinkles[(string) $name] = (string) $class;
        }

        return $sprinkles;
    }
}
