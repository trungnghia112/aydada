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
 * @abstract      : Contus HD Video Share Component Memberdetails Model
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */

/*
 ***********************************************************/
// No direct access to this file
defined( '_JEXEC' ) or die( 'Restricted access' );
// import joomla model library
jimport('joomla.application.component.model');
// import Joomla pagination library
jimport('joomla.html.pagination');
/**
 * Contushdvideoshare Component Memberdetails Model
 */
class contushdvideoshareModelmemberdetails extends ContushdvideoshareModel {
	
	
	/**
	 * Constructor
	 * global variable initialization
	 */

	function __construct() {
		global $mainframe;
		parent::__construct();
		$mainframe = JFactory::getApplication();		
	}

        function phpSlashes($string, $type='add') {
        if ($type == 'add') {
            if (get_magic_quotes_gpc ()) {
                return $string;
            } else {
                if (function_exists('addslashes')) {
                    return addslashes($string);
                } else {
                    return mysql_real_escape_string($string);
                }
            }
        } else if ($type == 'strip') {
            return stripslashes($string);
        } else {
            die('error in PHP_slashes (mixed,add | strip)');
        }
    }

	/**
	 * function to get member details
	 */
	function getmemberdetails()
	{
		global $mainframe;
		$option = JRequest::getCmd('option');
		$mainframe = JFactory::getApplication();
		$db = $this->getDBO();
                if(version_compare(JVERSION, '3.0.0', 'ge')) {
                    $mainQuery = "SELECT a.`id`,a.`name`,a.`username`,a.`email`,a.`registerDate`,a.`block`,b.`allowupload`
					   FROM #__users a
					   LEFT JOIN #__hdflv_user b
					   ON a.`id` = b.`member_id`
					   ";
                }else{

		$mainQuery = "SELECT a.`id`,a.`name`,a.`username`,a.`email`,a.`registerDate`,a.`block`,b.`allowupload`
					   FROM #__users a 
					   LEFT JOIN #__hdflv_user b 
					   ON a.`id` = b.`member_id`
					   ";
                }
		// filter variable for member order
		$strMemberOrder = $mainframe->getUserStateFromRequest($option . 'filter_order_member', 'filter_order', 'name', 'cmd');
		// filter variable for member order direction
		$strMemberDir = $mainframe->getUserStateFromRequest($option . 'filter_order_Dir_member', 'filter_order_Dir', 'asc', 'word');
		// filter variable for member name search
		$strMemberSearch = $mainframe->getUserStateFromRequest($option . 'member_search', 'member_search', '', 'string');
		// filter variable for member status
		$strMemberStatus = $mainframe->getUserStateFromRequest($option . 'member_status', 'member_status', '', 'int');
		// filter variable for member upload
		$strMemberUpload = $mainframe->getUserStateFromRequest($option . 'member_upload', 'member_upload', '', 'int');
		/**
		 * for page navigation
		 * get default list limit from global settings
		 * and limit start @ initial value is 0
		 * */
$search1=$strMemberSearch;
 $strMemberSearch = $this->phpSlashes($strMemberSearch);
		$limit = $mainframe->getUserStateFromRequest($option.'limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart = $mainframe->getUserStateFromRequest($option.'limitstart', 'limitstart', 0, 'int');

		$arrMemberFilter['filter_order_Dir']= $strMemberDir;
		$arrMemberFilter['filter_order']= $strMemberOrder;
		
		// filtering based on search keyword
		if ($strMemberSearch)
		{
			$mainQuery .= " AND a.name LIKE '%$strMemberSearch%'";
			$arrMemberFilter['member_search'] = $search1;
		}
		
		// filtering based on status
		if($strMemberUpload) {
			$strMemberUploadVal = ($strMemberUpload == '1')?'1':'0';
			$mainQuery .= " AND b.allowupload = $strMemberUploadVal";
			$arrMemberFilter['member_upload'] = $strMemberUpload;
		}
		
		// filtering based on status
		if($strMemberStatus) {
			$strMemberStatusVal = ($strMemberStatus == '1')?'0':'1';
			$mainQuery .= " AND a.block = $strMemberStatusVal";
			$arrMemberFilter['member_status'] = $strMemberStatus;
		}
		$mainQuery .= " ORDER BY $strMemberOrder $strMemberDir";
			
		$db->setQuery($mainQuery);
		$settingupload = $db->loadObjectList();
		$strMemberCount = count($settingupload);
			
		// set pagination
		$pageNav = new JPagination($strMemberCount, $limitstart, $limit);
			
		$mainQuery .= " LIMIT $pageNav->limitstart,$pageNav->limit";
		$db->setQuery( $mainQuery );
		$memberdetails = $db->loadObjectList();

		$query = "SELECT `dispenable` FROM #__hdflv_site_settings";
		$db->setQuery( $query );
		$res_disenable = $db->loadResult();
		$ser_disenable = unserialize($res_disenable);
		$disenable = $ser_disenable['allowupload'];
		/**
		 * get the most recent database error code
		 * display the last database error message in a standard format
		 *
		 */
		if ($db->getErrorNum())
		{
			JError::raiseWarning($db->getErrorNum(), $db->stderr());
		}	
		
		return array('pageNav' => $pageNav,'limitstart'=>$limitstart,'memberFilter'=>$arrMemberFilter,'memberdetails'=>$memberdetails,'settingupload'=>$disenable);

	}


	/**
	 * function to activate or deactivate users
	 */
	function memberActivation($arrayIDs)
	{
		global $mainframe;
		$db = $this->getDBO();
		if($arrayIDs['task']=="publish")
		{
			$publish=0;
			$msg = 'Published Successfully';
		}
		else
		{
			$publish=1;
			$msg = 'Unpublished Successfully';
		}
		$cids = implode( ',', $arrayIDs['cid'] );
                if(version_compare(JVERSION, '3.0.0', 'ge')) {
                    $query = "UPDATE #__users set block=".$publish."
				  WHERE `id` IN ( $cids )";
                }else{
		$query = "UPDATE #__users set block=".$publish."
				  WHERE usertype <> 'Super Administrator' 
				  AND `id` IN ( $cids )";
                }
		$db->setQuery($query);
		$db->query();
		$link = 'index.php?option=com_contushdvideoshare&layout=memberdetails';
		$mainframe->redirect($link, $msg);
	}

	/**
	 * function to activate or deactivate user upload
	 */
	function allowUpload($arrayIDs)
	{
		global $mainframe;
		$db = $this->getDBO();
		if($arrayIDs['task']=="allowupload")
		{
			$publish=1;
			$msg = 'Updated Successfully';
		}
		else
		{
			$publish=0;
			$msg = 'Updated Successfully';
		}
		$strMemberCount = count($arrayIDs['cid']);
		/**
		 * execute a query
		 */		
		for($i=0;$i<$strMemberCount;$i++)
		{
			$idval = $arrayIDs['cid'][$i];

			$query = "INSERT INTO #__hdflv_user (member_id,allowupload) VALUES ($idval,$publish)
  					  ON DUPLICATE KEY UPDATE member_id=".$idval.", allowupload=".$publish;	
			$db->setQuery($query);
			$db->query();
		}
		$link = 'index.php?option=com_contushdvideoshare&layout=memberdetails';
		$mainframe->redirect($link, $msg);	
	}
}
?>
