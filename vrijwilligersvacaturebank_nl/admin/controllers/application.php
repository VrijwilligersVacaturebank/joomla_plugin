<?php
/**
 * Joomla! 1.5 component Vrijwilligersvacaturebank_nl
 *
 * @version 1.0.0 $
 * @author vrijwilligersvacaturebank
 * @package Joomla
 * @subpackage Vrijwilligersvacaturebank_nl
 * @license GNU/GPL
 *
 * Vrijwilligersvacaturebank_nl
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.controller' );

/**
 * Vrijwilligersvacaturebank_nl Controller
 *
 * @package Joomla
 * @subpackage Vrijwilligersvacaturebank_nl
 */
class Vrijwilligersvacaturebank_nlControllerapplication extends Vrijwilligersvacaturebank_nlController {

    /**
     * constructor (registers additional tasks to methods)
     * @return void
     */
    function __construct()
    {
        parent::__construct();

        // Register Extra tasks
        $this->registerTask( 'add'  ,   'edit' );
        $this->registerTask( 'unpublish',   'publish');
    }

    /**
     * display the edit form
     * @return void
     */
    function edit()
    {
        JRequest::setVar( 'view', 'editapplication' );
        JRequest::setVar('hidemainmenu', 1);

        parent::display();
    }

    /**
     * save a record (and redirect to main page)
     * @return void
     */
    function save()
    {
        $model = $this->getModel('editapplication');
		
		$consumerkey         = JRequest::getString('key');
        $consumersecert      = JRequest::getString('secert');
		$token = $this->authorize_keys("http://api.vvb-staging-nl.eu", "POST", $consumerkey,$consumersecert);
		if(!empty($token))
		{
			if ($model->store()) {
				$msg = JText::_( 'Application Saved' );
			} else {
				$msg = JText::_( 'Provided key and secert are not found on erver.' );
			}
		}
		else
		{
			$msg = JText::_( 'Error Getting Token. Provided key and secert are not found on server..' );
		}

        // Check the table in so it can be edited.... we are done with it anyway
        $link = 'index.php?option=com_vrijwilligersvacaturebank_nl';
        $this->setRedirect($link, $msg);
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
		elseif($httpcode == '200' && !strstr($resp,' '))
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
     * save a record (and redirect to main page)
     * @return void
     */
    function apply()
    {
        $model = $this->getModel('editapplication');
		$consumerkey         = JRequest::getString('key');
        $consumersecert      = JRequest::getString('secert');
		$token = $this->authorize_keys("http://api.vvb-staging-nl.eu", "POST", $consumerkey,$consumersecert);
		if(!empty($token))
		{
			if ($model->store()) {
				$msg = JText::_( 'Changes to Application saved' );
			} else {
				$msg = JText::_( 'Error Saving Application' );
			}
		}
		else
		{
			$msg = JText::_( 'Error Getting Token. Provided key and secert are not found on server..' );
		}
        $array = JRequest::getVar('cid',  0, '', 'array');
        $id = (int)$array[0];
        $this->setRedirect( 'index.php?option=com_vrijwilligersvacaturebank_nl&controller=application&task=edit&cid[]=' . $id, $msg );

    }

    /**
     * publish a record (and redirect to main page)
     * @return void
     */
    function publish()
    {
        $publish = ( $this->getTask() == 'publish' ? 1 : 0 );
        $model = $this->getModel('editapplication');
        if(!$model->publish($publish)) {
            $msg = JText::_( 'Error: One or More Applications Could not be Published/Unbublished' );
        } else {
            $msg = '';
        }

        $this->setRedirect( 'index.php?option=com_vrijwilligersvacaturebank_nl', $msg );
    }

    /**
     * remove record(s)
     * @return void
     */
    function remove()
    {
        $model = $this->getModel('editapplication');
        if(!$model->delete()) {
            $msg = JText::_( 'Error: One or More Applications Could not be Deleted' );
        } else {
            $msg = JText::_( 'Application(s) Deleted' );
        }

        $this->setRedirect( 'index.php?option=com_vrijwilligersvacaturebank_nl', $msg );
    }

    /**
     * cancel editing a record
     * @return void
     */
    function cancel()
    {
        $msg = JText::_( 'Operation Cancelled' );
        $this->setRedirect( 'index.php?option=com_vrijwilligersvacaturebank_nl', $msg );
    }

}
?>