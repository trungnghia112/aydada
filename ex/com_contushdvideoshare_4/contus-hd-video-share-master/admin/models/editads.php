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
 * @abstract      : Contus HD Video Share Component Editads Model
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */

/*
 ***********************************************************/
//No direct acesss
defined( '_JEXEC' ) or die( 'Restricted access' );
// import joomla model library
jimport('joomla.application.component.model');

/**
 * Contushdvideoshare Component Administrator Editads Model
 */

class contushdvideoshareModeleditads extends ContushdvideoshareModel {

	/**
	 * function to populate values into form
	 */

	function editadsmodel()
	{
		$db = JFactory::getDBO();
		$objAdsTable = JTable::getInstance('ads', 'Table');
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		$id = $cid[0];
		$objAdsTable->load($id);
		$lists['published'] = JHTML::_('select.booleanlist','published',$objAdsTable->published);
		$add = array('rs_ads' => $objAdsTable);
		return $add;
	}

	/**
	 * function to remove ad
	 */

	function removeads()
	{
		$mainframe = JFactory::getApplication();
		$cid = JRequest::getVar( 'cid', array(), '', 'array' );
		$db = JFactory::getDBO();
		$cids = implode( ',', $cid );
		if(count($cid))
		{
			//query to fetch ad details for selected ads
			$qry="SELECT `postvideopath`
				  FROM `#__hdflv_ads`
				  WHERE `id` IN ( $cids )";
			$db->setQuery( $qry );
			$arrAdsIdList = $db->loadResultArray();

			/**
			 * VPATH to get target path
			 * target path @ /components/com_contushdvideoshare/videos
			 */
				
			$strVideoPath = VPATH."/";
			//removed the video and image files for selected videos
			if(count(  $arrAdsIdList ))
			{
				for ($i=0; $i < count($arrAdsIdList); $i++)
				{
					if($arrAdsIdList[$i] && JFile::exists($strVideoPath.$arrAdsIdList[$i]))
					JFile::delete($strVideoPath.$arrAdsIdList[$i]);
				}
			}
				
			$cids = implode( ',', $cid );
			$query = "DELETE
					  FROM #__hdflv_ads 
					  WHERE id IN ( $cids )";
			$db->setQuery( $query );
			if (!$db->query())
			{
				JError::raiseWarning($db->getErrorNum(), JText::_($db->getErrorMsg()));				
			}
		}

		if(count($cid)>1){
			$msg = 'Ads Deleted Successfully';
		}else{
			$msg = 'Ad Deleted Successfully';
		}
		// set to redirect
		$mainframe->redirect( 'index.php?option=com_contushdvideoshare&layout=ads',$msg );
	}
}
?>
