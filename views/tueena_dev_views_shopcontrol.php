<?php

/**
 * This class overrides oxShopControl and emties the tmp/ dir on each request.
 *
 * @author bastian.fenske@tueena.com
 * @package tueena_dev
 */
class tueena_dev_views_ShopControl extends \tueena_dev_views_ShopControl_parent
{
    /**
     * Removes the file system cache on each request.
     */
    public function _runOnce()
    {
        $this->flushFsCache();
        return parent::_runOnce();
    }

    /**
     * Flushes the file system cache.
     */
    public function flushFsCache()
    {
        $DirectoryIterator = new \DirectoryIterator($this->getFsCachePath());
        foreach ($DirectoryIterator as $Entry) {
            // Don't want to remove dotfiles.
            if ('.' !== substr($Entry->getFilename(), 0, 1))
                @unlink(realpath($Entry->getPathname()));
        }
    }

    /**
     * Returns the file system cache path.
     *
     * @return string
     */
    public function getFsCachePath()
    {
        return $this->getConfig()->getConfigParam("sCompileDir") . '/';
    }
}