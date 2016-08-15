<?php
/**
* @version   $Id$
* @package   Vrijwilligersvacaturebank_nl
* @copyright (C) vrijwilligersvacaturebank
* @license   GNU/GPL v3 http://www.gnu.org/licenses/gpl.html
*/

function Vrijwilligersvacaturebank_nlBuildRoute(&$query) {
    $db = JFactory::getDBO();
    $segments = array();

    if(isset($query['fileid'])) {
        $db->setQuery('select route from #__vrijwilligersvacaturebank_nl where id = '.$query['fileid']);
        $segments[] = $db->loadResult();
        unset($query['fileid']);
    }
	
    return $segments;
}

function Vrijwilligersvacaturebank_nlParseRoute($segments) {
    $db = JFactory::getDBO();
    $vars = array();
    $db->setQuery('select id from #__vrijwilligersvacaturebank_nl where route = "'.$segments[0].'"');
    $vars['fileid'] = $db->loadResult();

    return $vars;
}