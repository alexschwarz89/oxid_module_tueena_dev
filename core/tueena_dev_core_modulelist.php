<?php

/**
 * Adds a method to \oxModuleList to remove module config of deactivated
 * modules.
 *
 * @author bastian.fenske@tueena.com
 * @package tueena_dev
 */
class tueena_dev_core_ModuleList extends \tueena_dev_core_ModuleList_parent
{
    /**
     * Removes disabled modules from the database and emties the tmp dir.
     */
    public function propagateDeactivations()
    {
        $aDisabledModules = $this->getDisabledModules();

        // Remove from aModules config variable.
        $aExt = $this->getAllModules();
        foreach ($aExt as $sClassName => &$aExtensions) {
            foreach ($aExtensions as $i => $sExtensionPath) {
                $sModule = substr($sExtensionPath, 0, strpos($sExtensionPath, '/'));
                if (in_array($sModule, $aDisabledModules))
                    unset($aExtensions[$i]);
            }
            if (empty($aExtensions))
                unset($aExt[$sClassName]);
        }
        $aUpdatedExt = $this->diffModuleArrays( $aExt, $aDeletedExt );
        $aExt = $this->buildModuleChains( $aExt );
        $this->getConfig()->saveShopConfVar( 'aarr', 'aModules', $aExt );

        // Remove from config tables and templates blocks table.
        $this->_removeFromDatabase($aDisabledModules);
    }
}