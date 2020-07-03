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
     * @var string The file content.
     */
    protected $installed = '';

    /**
     * Load the specified file.
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

        $this->installed = $content;

        return $this;
    }

    /**
     * Returns the raw json data from the file.
     *
     * @return string
     */
    public function getRawContent(): string
    {
        return $this->installed;
    }

    /**
     * Returns the processed json data as an array of objects.
     *
     * @return \stdClass[]
     */
    public function getInstalled(): array
    {
        return json_decode($this->installed);
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
}
