<?php
/**
* @version   $Id$
* @package   Vrijwilligersvacaturebank_nl
* @copyright (C) vrijwilligersvacaturebank
* @license   GNU/GPL v3 http://www.gnu.org/licenses/gpl.html
*/

defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.plugin.plugin' );

/**
 * Vrijwilligersvacaturebank_nlRouter plugin
 *
 */
class  plgSystemVrijwilligersvacaturebank_nlRouter extends JPlugin {
    function __construct(& $subject, $config) {
        // check to see if we are on frontend to execute plugin
        $mainframe = JFactory::getApplication();
        if($mainframe->isAdmin())
            return;

        parent::__construct($subject, $config);
    }

    /**
     * Routes URLs
     *
     * @access public
     */
    function onAfterInitialise() {
        $mainframe = JFactory::getApplication();

        $uri    = JURI::getInstance();
        $router = $mainframe->getRouter();

        $router->attachParseRule('parseVrijwilligersvacaturebank_nlRouter');

    }
}

/**
 * SEF url parser
 *
 * @access public
 * @static
 * @param $router object of JRouter class
 * @param $uri object of JURI class
 */
function parseVrijwilligersvacaturebank_nlRouter(& $router, & $uri) {
    if($router->getMode() == JROUTER_MODE_RAW)
        return array();

    $db = JFactory::getDBO();
    $db->setQuery('select id,`key`,route,secert from #__vrijwilligersvacaturebank_nl where published = 1');
    $apps = $db->loadRowList();
    $alias = array();
    foreach($apps as $i=>$app) {
        if(empty($app[2]))
            $apps[$i][2] = JFilterOutput::stringURLSafe($app[1]);
        $alias[$i] = $apps[$i][2];
    }

    $segments = explode('/', $uri->getPath());
	$url = array();
	$page = array();
	$route = false;
    foreach($segments as $i => $segment)
	{
		if($route) $page[] = $segment;
		
        if((($j = array_search($segment, $alias)) !== false) && $route == false)
		{
            unset($segments[$i]);
            $uri->setVar('option', 'com_vrijwilligersvacaturebank_nl');
            $uri->setVar('fileid', $apps[$j][0]);
			$uri->setVar('route', $apps[$j][2]);
			$uri->setVar('consumerkey', $apps[$j][1]);
			$uri->setVar('consumersecert', $apps[$j][3]);	
			$route = true;
        }
		if($route == false)
			$url[] = $segment;
			
	}
	
	if(count($page)<=0)
		$page = array('jobs');
	$uri->setVar('routepage', implode('/', $page));
    $uri->setPath(implode('/', $url));

    return array();
}