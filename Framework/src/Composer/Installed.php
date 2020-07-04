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
 * Read a composer installed.json and returned the decoded information about installed packages.
 */
class Installed
{
    /**
     * @var string The composer.json file content.
     */
    protected $content = '';

    /**
     * @var string The sprinkle composer pacakge type.
     */
    protected $sprinkleTypeKey = 'userfrosting-sprinkle';

    /**
     * @var string The key in `extra` portion of composer.json used to list sprinkle boot class.
     */
    protected $sprinkleBootKey = 'sprinkle-boot';

    /**
     * Load `installed.json` from the specified location.
     *
     * @param string $path The path where installed.json can be found.
     *
     * @return self
     */
    public function load(string $path)
    {
        return $this->loadFile($path . '/installed.json');
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
     * @return \stdClass[]
     */
    public function getInstalled(): array
    {
        return json_decode($this->content);
    }

    /**
     * Returns the processed json data as an array of objects, filtered by the package type.
     *
     * @return \stdClass[]
     */
    public function getInstalledForType(string $type): array
    {
        $installed = array_filter($this->getInstalled(), function ($package) use ($type) {
            return $package->type == $type;
        });

        // Rebase index
        $installed = array_values($installed);

        return $installed;
    }

    /**
     * Return the list of sprinkles installed by composer.
     *
     * @return array<string,string> Presented as array<fullname,bootclass>
     */
    public function getSprinkles(): array
    {
        $packages = $this->getInstalledForType($this->sprinkleTypeKey);

        // Create the return array to be consumed
        $result = [];

        foreach ($packages as $package) {
            if (isset($package->extra) && isset($package->extra->{$this->sprinkleBootKey})) {
                $bootClass = (string) $package->extra->{$this->sprinkleBootKey};
            } else {
                $bootClass = '';
            }

            $result[(string) $package->name] = $bootClass;
        }

        return $result;
    }
}
