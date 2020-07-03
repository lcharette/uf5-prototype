<?php

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/UserFrosting
 * @copyright Copyright (c) 2020 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/UserFrosting/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Composer;

class Installed
{
    /** @var string */
    protected $installed = '';

    public function __construct()
    {

    }

    public function loadFile(string $file): void
    {
        if (!$content = @file_get_contents($file)) {
            throw new \Exception('');
        }

        $this->installed = $content;
    }

    public function getRawContent(): string
    {
        return $this->installed;
    }

    /**
     * @return mixed[]
     */
    public function getInstalled(): array
    {
        return json_decode($this->installed);
    }

    /**
     * @return mixed[]
     */
    public function getInstalledForType(string $type): array
    {
        $installed = array_filter($this->getInstalled(), function($package) use ($type) {
            return $package->type == $type;
        });

        // Rebase index
        $installed = array_values($installed);

        return $installed;
    }
}
