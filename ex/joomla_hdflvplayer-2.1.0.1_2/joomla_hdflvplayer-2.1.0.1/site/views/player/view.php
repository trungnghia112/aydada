<?php
/**
 * @name 	        hdflvplayer
 ** @version	        2.1.0.1
 * @package	        Apptha
 * @since	        Joomla 1.5
 * @subpackage	        hdflvplayer
 * @author      	Apptha - http://www.apptha.com/
 * @copyright 		Copyright (C) 2011 Powered by Apptha
 * @license 		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      	com_hdflvplayer installation file.
 ** @Creation Date	23 Feb 2011
 ** @modified Date	28 Aug 2013
 */


// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

//Imports for joomla libraries here 
jimport( 'joomla.application.component.view');


/*
 * HDFLV player View Class for Player view 
 */
class hdflvplayerViewplayer extends HdflvplayerView
{
	//Function to fetch Video details
	function displayplayer()
	{
        $model =$this->getModel();
        
        //Function calling for Video details. 
		$detail = $model->showhdplayer();
		
		//Function calling for player settings
		$settings = $model->getplayersettings();
		//print_r($detail);
		$this->assignRef('detail', $detail);
		$this->assignRef('settings', $settings);
                $homeAccessLevel = false;
                if(!empty($detail['rs_title'])){
                $homeAccessLevel = $model->getHTMLVideoAccessLevel($detail['rs_title']->id);
                }
		$this->assignRef('homepageaccess', $homeAccessLevel);
                $this->setLayout('playerlayout');
		parent::display();
	}

}
?>