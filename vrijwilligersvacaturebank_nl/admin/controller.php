<?php
/**
 * Joomla component
 *
 * @version 1.0.0 $
 * @author vrijwilligersvacaturebank
 * @package Joomla
 * @subpackage vrijwilligersvacaturebank_nl
 * @license GNU/GPL
 *
 * Vrijwilligersvacaturebank_nl
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.controller' );

/**
 * vrijwilligersvacaturebank_nl Controller
 *
 * @package Joomla
 * @subpackage com_vrijwilligersvacaturebank_nl
 */

if(JV == 'j2') {
    //j2 stuff here///////////////////////////////////////////////////////////////////////////////////////////////////////
    class Vrijwilligersvacaturebank_nlController extends JController {
        function display($cachable = false, $urlparams = array())
        {

            addSub( 'Application Manager', 'showapplications');

            //Set the default view, just in case
            $view = JRequest::getCmd('view');
            if(empty($view)) {
                JRequest::setVar('view', 'showApplications');
            };

            parent::display();
        }// function
    };
}
else {
    //j3 stuff here///////////////////////////////////////////////////////////////////////////////////////////////////////
    class Vrijwilligersvacaturebank_nlController extends JControllerLegacy{
        function display($cachable = false, $urlparams = array())
        {

            addSub( 'Application Manager', 'showapplications');

            //Set the default view, just in case
            $view = JRequest::getCmd('view');
            if(empty($view)) {
                JRequest::setVar('view', 'showApplications');
            };

            parent::display();
        }// function
    };
}
?>