<?php

/**
 * This class overrides \oxShopControl, empties the tmp/ dir and refreshes the
 * modules information on each request.
 *
 * @author bastian.fenske@tueena.com
 * @package tueena_dev
 */
class tueena_dev_views_ShopControl extends \tueena_dev_views_ShopControl_parent
{
    /**
     * Removes the file system cache and refreshes module information on each
     * request.
     */
    public function _runOnce()
    {
        $this->flushFsCache();
        $this->rebuildModulesInformation();
        return parent::_runOnce();
    }

    /**
     * Flushes the file system cache.
     */
    public function flushFsCache()
    {
        $oDirectoryIterator = new \DirectoryIterator($this->getFsCachePath());
        foreach ($oDirectoryIterator as $oEntry) {
            if (!$oEntry->isDot())
                @unlink($oEntry->getPathname());
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

    /**
     * Removes module information from the database (except for the module
     * settings) and reloads all activated modules.
     */
    public function rebuildModulesInformation()
    {
        // First remove all module information from the db.
        $oConfig = $this->getConfig();

        $oConfig->setConfigParam('aModules', array());
        $oConfig->saveShopConfVar('aarr', 'aModules', array());

        $oConfig->setConfigParam('aModuleFiles', array());
        $oConfig->saveShopConfVar('aarr', 'aModuleFiles', array());

        $oConfig->setConfigParam('aModuleTemplates', array());
        $oConfig->saveShopConfVar('aarr', 'aModuleTemplates', array());

        oxDb::getDb()->execute('DELETE FROM `oxtplblocks`');

        // Then re-activate all modules that are not listed as disabled.
        foreach ($this->getActiveModules() as $sModuleId) {
            try {
                $oModule = new \oxModule;
                if ($oModule->load($sModuleId))
                    $oModule->activate();
            } catch (\Exception $Exception) {
            }
        }
    }

    /**
     * Returns an array of all active module IDs.
     *
     * @return array
     */
    public function getActiveModules()
    {
        $aAllModules = $this->getAllModules();
        $aDisabledModules = $this->getDisabledModules();
        return array_diff($aAllModules, $aDisabledModules);
    }

    /**
     * Finds all metadata.php files in the modules/ directory and returns
     * an array of all IDs defined in those metadata files.
     *
     * @return array
     */
    public function getAllModules()
    {
        $sModulesDir = realpath(__DIR__ . '/../../') . '/';
        $Directory = new RecursiveDirectoryIterator($sModulesDir);
        $Iterator = new RecursiveIteratorIterator($Directory);
        foreach ($Iterator as $FileInfo) {
            if ('metadata.php' === $FileInfo->getFilename()) {
                include $FileInfo->getPathname();
                if (isset($aModule['id']))
                    $aModules[] = $aModule['id'];
                $aModule = null;
            }
        }
        return $aModules;
    }

    /**
     * Returns the "disabled modules" array, stored in the database.
     *
     * @return array
     */
    public function getDisabledModules()
    {
        return $this->getConfig()->getConfigParam('aDisabledModules');
    }
}