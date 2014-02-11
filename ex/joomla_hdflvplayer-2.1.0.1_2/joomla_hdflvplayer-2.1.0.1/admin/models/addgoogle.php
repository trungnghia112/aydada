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
//No direct acesss
defined('_JEXEC') or die();

// importing default joomla components
jimport('joomla.application.component.model');

/*
 * HDFLV player Model class to fetching checklist info.
 */
class hdflvplayerModeladdgoogle extends HdflvplayerModel {

	//Function invoke when click on add button
	function addgooglemodel() {
		
		$db =JFactory::getDBO();
		$rs_addgoogle =JTable::getInstance('hdflvaddgoogle', 'Table');

		// To get the id no to be edited...
		$id = 1;
		$rs_addgoogle->load($id);

		//Fetch the published status
		$lists['published'] = JHTML::_('select.booleanlist','published',$rs_addgoogle->publish);
		return $rs_addgoogle;
	}

	//Saves the google ads changes
	function saveaddgoogle($task) {
		
		$option = 'com_hdflvplayer';
		
		//Instantiate database connection and table into variables
		$db =JFactory::getDBO();
		$rs_saveaddgoogle =JTable::getInstance('hdflvaddgoogle', 'Table');
		$id = 1;

		//Gets the input given in the form to save
		$adsInfo = JRequest::get('post');
		
		//If Show option is "Always Show", then the "Close After" time reset to 0

		if($adsInfo['showadd'][0]== 'showaddc') {
			$adsInfo['showaddc'] = '1';
		}
		else{
			$adsInfo['showaddc'] = '0';
		}
		if($adsInfo['showadd'][1] == 'showaddp') {
			$adsInfo['showaddp'] = '1';
		}
		else{
			$adsInfo['showaddp'] = '0';
		}
		if($adsInfo['showoption'] == '0') {
			$adsInfo['closeadd'] = '0';
		}
		
		//If Reopen After is not selected means, the time reset to 0
		if(!isset($adsInfo['reopenadd'])) {
			$adsInfo['reopenadd'] = '1';
			$adsInfo['ropen'] = '0';
		}
		
		//Fetch Google Ads code from POST and assign into array
                $adsInfo['code'] = JRequest::getVar('code', '', 'post', 'string', JREQUEST_ALLOWRAW); ;
		$rs_saveaddgoogle->load($id);

		//Binds the given input with table columns
		if (!$rs_saveaddgoogle->bind($adsInfo)) {
			JError::raiseError(500, JText::_($rs_saveaddgoogle->getError()));
		}
		
		//Stores the input into table columns
		if (!$rs_saveaddgoogle->store()) {
			JError::raiseError(500, JText::_($rs_saveaddgoogle->getError()));
		}
		
		//assigns message, redirect url based on task
		switch ($task) {
			case 'applyaddgoogle':
				$msg = 'Changes Saved';
				$link = 'index.php?option=' . $option .'&task=addgoogle';
				break;
			case 'saveaddgoogle':
			default:
				$msg = 'Saved';
				$link = 'index.php?option=' . $option.'&task=addgoogle';
				break;
		}
		
		// page redirect
		$app =JFactory::getApplication();
		$app->redirect($link, 'Saved');
	}
}
?>
