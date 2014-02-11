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

//importing default joomla components
jimport('joomla.application.component.model');

/*
 * HDFLV player Model class to save functions,fetch playlist details while edit.
 */
class hdflvplayerModeleditplaylistname extends HdflvplayerModel {

	//Function to fetch play list details while edit
	function editplaylistmodel() {
		$db = JFactory::getDBO();

		//Initialize table name
		$rs_editplaylistname = JTable::getInstance('hdflvplayername', 'Table');

		// To get the id no to be edited...
		$cid = JRequest::getVar('cid', array(0), '', 'array');
		$id = $cid[0];
		$rs_editplaylistname->load($id);

		//Fetch the published status
		$lists['published'] = JHTML::_('select.booleanlist', 'published', $rs_editplaylistname->published);
		return $rs_editplaylistname;

	}

	//Function calls when click on add playlist
	function playlistnameadd() {
		//Initialize table name
		$rs_addplaylist = JTable::getInstance('hdflvplayername', 'Table');
		return $rs_addplaylist;
	}

	//Function to save playlist
	function saveplaylistname($task) {
		$option = 'com_hdflvplayer';
		global $mainframe;
		$db = JFactory::getDBO();
		$rs_saveplaylistname = JTable::getInstance('hdflvplayername', 'Table');
		
		//Loads record based on id
		$cid = JRequest::getVar('cid', array(0), '', 'array');
		$id = $cid[0];
		$rs_saveplaylistname->load($id);
		
		 //Binds the given input from post with Table columns
		if (!$rs_saveplaylistname->bind(JRequest::get('post'))) {
			JError::raiseError(500, JText::_($rs_saveplaylistname->getError()));
		}
		
		//Stores value into table with appropriate column
		if (!$rs_saveplaylistname->store()) {
			JError::raiseError(500, JText::_($rs_saveplaylistname->getError()));
		}
		
		//Assigns message with redirect link based on task
		switch ($task) {
			case 'applyplaylistname':
				$msg = 'Changes Saved';
				$link = 'index.php?option=' . $option . '&task=editplaylistname&cid[]=' . $rs_saveplaylistname->id;
				break;
			case 'saveplaylistname':
			default:
				$msg = 'Saved';
				$link = 'index.php?option=' . $option . '&task=playlistname';
				break;
		}
		
		// page redirect
		$app =JFactory::getApplication();
		$app->redirect($link, 'Saved');
	}
	
	//Function to remove playlist record from table
	function removeplaylistname() {
		
		$option = 'com_hdflvplayer';
		global $mainframe;
		
		//Fetch the selected rows id
		$cid = JRequest::getVar('cid', array(), '', 'array');
		$db = JFactory::getDBO();
		$cids = implode(',', $cid);
		
		if (count($cid)) {
						
			//Delete the selected playlist from table
			$query = 'DELETE FROM #__hdflvplayername WHERE id IN ( '.$cids.' )';
			$qryRes=$db->setQuery($query);
			

			if (!$db->query()) {
				JError::raiseError(500, JText::_($db->getErrorMsg()));
		
			}
		}

		// page redirects
		$link='index.php?option=' . $option . '&task=playlistname';
		$app =JFactory::getApplication();
		$app->redirect($link, 'Deleted');
	}
}
?>
