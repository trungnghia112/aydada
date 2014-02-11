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
// No Access
defined('_JEXEC') or die();

// importing default joomla components
jimport('joomla.application.component.model');

/*
 * HDFLV player Model class to Edit & Remove Ads.
 */
class hdflvplayerModeleditads extends HdflvplayerModel {
	//Function invokes when click on add Ads
	function addadsmodel() {
		$rs_ads = JTable::getInstance('hdflvplayerads', 'Table');
		$add = array('rs_ads' => $rs_ads);
		return $add;
	}
	//Function invokes when click on edit Ads
	function editadsmodel() {
		$rs_edit = JTable::getInstance('hdflvplayerads', 'Table');
		$cid = JRequest::getVar('cid', array(0), '', 'array');
		$id = $cid[0];
		$rs_edit->load($id);
		$add = array('rs_ads' => $rs_edit);
		return $add;
	}

	// function invokes when click on Delete Button
	function removeads() {
		global $mainframe;
		$cid = JRequest::getVar('cid', array(), '', 'array');
		$db = JFactory::getDBO();
		$cids = implode(',', $cid);
		if (count($cid)) {
			$cids = implode(',', $cid);
			$query = 'DELETE FROM #__hdflvplayerads WHERE id IN ( '.$cids.' )';
			$db->setQuery($query);
			if (!$db->query()) {
				JError::raiseError(500, JText::_($db->getErrorMsg()));
			}
			$query = 'UPDATE #__hdflvplayerupload SET midrollads=0 WHERE midrollid=\''.$cids.'\'';
			$db->setQuery($query);
			$db->query();
		}
		// Page Redirect
		$link='index.php?option=com_hdflvplayer&task=ads';
		$app =JFactory::getApplication();
		$app->redirect($link, 'Deleted');
	}
}
?>
