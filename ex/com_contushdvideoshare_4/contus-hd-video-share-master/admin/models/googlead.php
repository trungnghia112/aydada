<?php
/*
 ***********************************************************/
/**
 * @name          : Joomla HD Video Share
 ****@version	  : 3.4.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component Googlead Model
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */

/*
 ***********************************************************/
// No direct access to this file
defined( '_JEXEC' ) or die( 'Restricted access' );
// import joomla model library
jimport('joomla.application.component.model');
/**
 * Contushdvideoshare Component Administrator Googlead Model
 */
class contushdvideoshareModelgooglead extends ContushdvideoshareModel {

	/**
	 * Fuction to get google ad
	 */
	function getgooglead()
	{
		$db = $this->getDBO();
		$rs_googlead = JTable::getInstance('googlead', 'Table');
		// To get the id no to be edited...
		$id = 1;
		$rs_googlead->load($id);
		$lists['published'] = JHTML::_('select.booleanlist','published',$rs_googlead->publish);
		return $rs_googlead;
	}
	/**
	 * Fuction to save google ad
	 */

	function savegooglead()
	{
		$option = JRequest::getCmd('option');
		$arrFormData = JRequest::get('POST');
		$mainframe = JFactory::getApplication();
		$db = JFactory::getDBO();
		$objGoogleAdTable =& JTable::getInstance('googlead', 'Table');
		$id = 1;
		if(JRequest::getVar('showoption') == '0') {
			$arrFormData['closeadd'] = '';
		}
		if(JRequest::getVar('reopenadd') == '') {
			$arrFormData['reopenadd'] = '1';
			$arrFormData['ropen'] = '';
		}

//		$code = JRequest::getVar('code','','post');
		$code = JRequest::getVar('code', '', 'post', 'string', JREQUEST_ALLOWRAW); ;
		//Convert all applicable characters to HTML entities
		$arrFormData['code'] = htmlentities(stripslashes($code));
		// Get the node from the table.
		$objGoogleAdTable->load($id);
		// Bind data to the table object.
		if (!$objGoogleAdTable->bind($arrFormData)) {
			JError::raiseWarning(500, $objGoogleAdTable->getError());
		}
		// Store the node in the database table.
		if (!$objGoogleAdTable->store()) {
			JError::raiseWarning(500, $objGoogleAdTable->getError());
		}
		// page redirect
		$link = 'index.php?option=' . $option.'&layout=googlead';
		$mainframe->redirect($link, 'Saved Successfully');
	}
}
?>
