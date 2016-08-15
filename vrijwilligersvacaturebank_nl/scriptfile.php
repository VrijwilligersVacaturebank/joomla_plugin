<?php
/**
* @version   $Id$
* @package   Vrijwilligersvacaturebank_nl
* @copyright Copyright (C) 2006 - 2015 vrijwilligersvacaturebank. All rights reserved.
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

defined('_JEXEC') or die('Restricted access');

class com_vrijwilligersvacaturebank_nlInstallerScript {

    /**
     * method to install the component
     *
     * @return void
     */
    function install($parent) {
        // $parent is the class calling this method
        
        // installing router
        $plugin_installer = new JInstaller;
        if($plugin_installer->install(dirname(__FILE__).DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'router'))
            echo 'Router install success', '<br />';
        else
            echo 'Router install failed', '<br />';

        // enabling plugin
        $db = JFactory::getDBO();
        // enabling router
        $db->setQuery('update #__extensions set enabled = 1, ordering = 100 where element = "vrijwilligersvacaturebank_nlrouter" and folder = "system"');
        $db->query();
    }

    /**
     * method to uninstall the component
     *
     * @return void
     */
    function uninstall($parent) {
        // $parent is the class calling this method

        $db = JFactory::getDBO();

        // uninstalling vrijwilligersvacaturebank_nl router
        $db->setQuery("select extension_id from #__extensions where name = 'System - Vrijwilligersvacaturebank_nl Router' and type = 'plugin' and element = 'vrijwilligersvacaturebank_nlrouter'");
        $vrijwilligersvacaturebank_nl_router = $db->loadObject();
        $plugin_uninstaller = new JInstaller;
        if($plugin_uninstaller->uninstall('plugin', $vrijwilligersvacaturebank_nl_router->extension_id))
            echo 'Router uninstall success', '<br />';
        else
            echo 'Router uninstall failed', '<br />';
    }

    /**
     * method to update the component
     *
     * @return void
     */
    function update($parent) {
        
    }

    /**
     * method to run before an install/update/uninstall method
     *
     * @return void
     */
    function preflight($type, $parent) {
        
    }

    /**
     * method to run after an install/update/uninstall method
     *
     * @return void
     */
    function postflight($type, $parent) {
    }
}