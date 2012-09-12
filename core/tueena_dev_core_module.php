<?php

/**
 * @author bastian.fenske@tueena.com
 * @package tueena_moduledev
 *
 */
class tueena_dev_core_Module extends \tueena_dev_core_Module_parent
{
    /**
     * Calls \tueena_dev_core_ModuleList::propagateDeactivations() after a
     * module has been deactivated.
     *
     * @param string $sModuleId
     * @return bool
     */
    public function deactivate($sModuleId = null)
    {
        if ($bResult = parent::deactivate($sModuleId)) {
            $oModuleList = oxNew('oxmodulelist');
            $oModuleList->propagateDeactivations();
        }
        return $bResult;
    }
}