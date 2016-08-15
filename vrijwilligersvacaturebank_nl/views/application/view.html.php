<?php
/**
* @version   $Id$
* @package   Vrijwilligersvacaturebank_nl
* @copyright (C) vrijwilligersvacaturebank
* @license   GNU/GPL v3 http://www.gnu.org/licenses/gpl.html
*/

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

/**
 * HTML Contact View class for the Contact component
 *
 * @package     Joomla.Site
 * @subpackage  com_vrijwilligersvacaturebank_nl
 * @since       1.5
 */
if(JV == 'j2') {
    //j2 stuff here///////////////////////////////////////////////////////////////////////////////////////////////////////
    class Vrijwilligersvacaturebank_nlViewApplication extends JView {
        function display($tpl = null) {
            // Initialise variables.
            $fileid    = JRequest::getInt('fileid');
			$consumerkey    = JRequest::getString('consumerkey');
			$consumersecert    = JRequest::getString('consumersecert');
			$route    = JRequest::getString('route');
			$routepage    = JRequest::getString('routepage');
			///echo $consumerkey; die;
			$conf = &JFactory::getConfig();
			$r = JURI::base( true ).'/'.$route;
			if($conf->get('sef') != 1)
			{
				
				$db = JFactory::getDBO();
				
				$db->setQuery('select `key`,`secert` from #__vrijwilligersvacaturebank_nl where route = "'.$route.'"');
				$details = $db->loadObject();
				$consumerkey = $details->key;
				$consumersecert = $details->secert;
				$r = JURI::base( true ).'/index.php?option=com_vrijwilligersvacaturebank_nl&view=application&route='.$route;
			}
			if($conf->get('sef_rewrite') != 1)
			{
				$r = JURI::base( true ).'/index.php/'.$route;
			}
			
            $database  = JFactory::getDBO();
            $user      = JFactory::getUser();
            $document  = JFactory::getDocument();
            $mainframe = JFactory::getApplication();
			
			$session = JFactory::getSession();
			$jinput = JFactory::getApplication()->input;
			$sess = $jinput->get->get('session', '', 'STRING');
			if(!empty($sess))
			{
				$session->set( 'sess'.$route, $sess );
				$mainframe->redirect(JURI::base( true ).'/'.$route);
			}
		
            $token = authorize_keys("http://api.vvb-staging-nl.eu", "POST", $consumerkey,$consumersecert);
			if(!empty($token))
				publish("http://api.vvb-staging-nl.eu",$token,$r ,$routepage,$route);
			else
			{
				echo JText::_( 'Error Getting Token. Please check your configuration.' );
				exit(0);
			}
			
            parent::display($tpl);
        }
		
	}
}
else {
    //j3 stuff here///////////////////////////////////////////////////////////////////////////////////////////////////////
    class Vrijwilligersvacaturebank_nlViewApplication extends JViewLegacy {
        function display($tpl = null) {
            // Initialise variables.
            $fileid    = JRequest::getInt('fileid');
			$consumerkey    = JRequest::getString('consumerkey');
			$consumersecert    = JRequest::getString('consumersecert');
			$route    = JRequest::getString('route');
			$routepage    = JRequest::getString('routepage');
            $database  = JFactory::getDBO();
            $user      = JFactory::getUser();
            $document  = JFactory::getDocument();
            $mainframe = JFactory::getApplication();
			$session = JFactory::getSession();
			$jinput = JFactory::getApplication()->input;
			$sess = $jinput->get->get('session', '', 'STRING');
			if(!empty($sess))
			{
				$session->set( 'sess'.$route, $sess );
				$mainframe->redirect(JURI::base( true ).'/'.$route);
			}
			$conf = &JFactory::getConfig();
			$r = JURI::base( true ).'/'.$route;
			if($conf->get('sef_rewrite') != 1)
			{
				$r = JURI::base( true ).'/index.php/'.$route;
			}
			$token = authorize_keys("http://api.vvb-staging-nl.eu", "POST", $consumerkey,$consumersecert);
			if(!empty($token))
				publish("http://api.vvb-staging-nl.eu",$token, $r,$routepage,$route); 
			else
			{
				echo JText::_( 'Error Getting Token. Please check your configuration.' );
				exit(0);
			}
			
            parent::display($tpl);
        }
	}
}

function authorize_keys($target_url,$method,$consumerkey='',$consumersecret='')
	{
		
		$curl = curl_init();
		$token = '';

		$curl_options = array(
		  CURLOPT_URL => $target_url.'/api/oauth/authorize',
		  CURLOPT_POST => $method == "POST",
		  CURLOPT_RETURNTRANSFER =>true,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_TIMEOUT => 5
		);
		$keys = 'consumerKey='.$consumerkey.'&consumerSecret='.$consumersecret;

		$curl_options[CURLOPT_POSTFIELDS] = $keys;
		curl_setopt_array($curl, $curl_options);
		$resp = curl_exec($curl);
		$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		
		if(!$resp)
		{
			echo JText::_( 'Error Getting Token. Please check your configuration.' );
			http_response_code($httpcode);
			exit(0);
		}
		elseif($httpcode == '200')
		{
			$token = $resp;
		}
		else
		{
			http_response_code($httpcode);
		}
		curl_close($curl);
		return $token;
	}
		/**
		* publish
		*
		* Get page from api and Publish them on front.
		*
		*/

function publish($target_url,$token, $route,$page,$sessionroute)
	{
	$method = "POST";
	$queryparams = $_GET;
	$query_string = '';
	foreach($queryparams as $id=>$param)
	{
		$query_string .= '&'.$id.'='.$param;
	}
	$curl = curl_init();
	$curl_options = array(
	  CURLOPT_URL => $target_url.'/api/plugin/orgpage?token='.$token.$query_string,
	  CURLOPT_POST => $method == "POST",
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_RETURNTRANSFER =>true,
	  CURLOPT_TIMEOUT => 50
	);
	$keys = 'route='.$route.'&page='.$page;
	
	$session =& JFactory::getSession();
	$sess = $session->get( 'sess'.$sessionroute, '' );
	if(!empty($sess))
	{
		$keys .= '&session='.$sess;
	}
	
	
	$curl_options[CURLOPT_POSTFIELDS] = $keys;
	curl_setopt_array($curl, $curl_options);
	$resp = curl_exec($curl);
	$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	if(!$resp)
	{
		echo JText::_( 'Error Getting Token. Please check your configuration.' );
		http_response_code($httpcode);
		exit(0);
	}
	else
	{
		
		$result = json_decode($resp);
		
		if (json_last_error() === JSON_ERROR_NONE && @$result->ExceptionMessage) {
			echo $result->ExceptionMessage;exit(0);
			http_response_code($httpcode);
		}
		elseif($httpcode == '200')
		{
			
		echo stripslashes(str_replace('\r\n','
		',trim($resp,'"')));
		exit(0);
		}
		else
		{
			http_response_code($httpcode);
		}
	}
	curl_close($curl);
	}
    