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
 * @abstract      : Contus HD Video Share Component Editvideos Model 
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
 * Contushdvideoshare Component Editvideos model
 */
class contushdvideoshareModeleditvideos extends ContushdvideoshareModel {

	//function to edit videos
	function editvideosmodel()
	{
		$db = JFactory::getDBO();
		//query to fetch category list
		$query = "SELECT `id`,`category`
		          FROM `#__hdflv_category` 
		          WHERE `published`=1 ORDER BY `id` desc";
		$db->setQuery( $query);
		$rs_play = $db->loadObjectList();
		//query to fetch pre/post roll ads
		$query = "SELECT `id`,`adsname`
		          FROM `#__hdflv_ads` 
		          WHERE `published`=1 and `typeofadd` <> 'mid' and `typeofadd` <> 'ima' ORDER BY `adsname` asc";
		$db->setQuery($query);
		$rs_ads = $db->loadObjectList();
		//get adminvideos table object
		$rs_editupload = JTable::getInstance('adminvideos', 'Table');
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		// To get the id no to be edited...
		$id = $cid[0];
		$rs_editupload->load($id);
		$lists['published'] = JHTML::_('select.booleanlist','published',$rs_editupload->published);		
		if(version_compare(JVERSION,'1.6.0','ge'))
		{
			$strTable = '#__viewlevels';
			$strName = 'title';
		}
		else
		{
			$strTable = '#__groups';
			$strName = 'name';
		}
		//query to fetch user groups
		$query = "SELECT `id` as id ,`$strName` as title FROM `$strTable` ORDER BY `id` asc";
		$db->setQuery($query);
		$usergroups = $db->loadObjectList();
		$editadd = array('rs_editupload' => $rs_editupload,'rs_play'=>$rs_play,'rs_ads'=>$rs_ads,'user_groups'=>$usergroups);
		return $editadd;
	}
        
        /**
	 * function to get player settings
	 */
        function showplayersettings()
	{
		$db = JFactory::getDBO();
		//query to fetch player settings
		$query = "SELECT `player_values` FROM #__hdflv_player_settings";
		$db->setQuery( $query);
		return $db->loadResult();
	}
        
	//function to remove videos
	function removevideos()
	{
		$option = 'com_contushdvideoshare';
		global $mainframe;
		$cid = JRequest::getVar( 'cid', array(), '', 'array' );
		$db = JFactory::getDBO();
		$cids = implode( ',', $cid );			
		// Get count
		if(count($cid))
		{
			//query to fetch video details for selected videos
			$qry="SELECT `videourl`,`thumburl`,`previewurl`,`hdurl` 
				  FROM `#__hdflv_upload`
				  WHERE `filepath`='File' OR `filepath`='FFmpeg' AND `id` IN ( $cids )";
			$db->setQuery( $qry );
			$arrVideoIdList = $db->loadObjectList();
			
			/**
			 * VPATH to get target path
			 * target path @ /components/com_contushdvideoshare/videos
			 */
			
			$strVideoPath = VPATH."/";
			//removed the video and image files for selected videos
			if(count(  $arrVideoIdList ))
			{
				for ($i=0; $i < count($arrVideoIdList); $i++)
				{					
					if($arrVideoIdList[$i]->videourl && JFile::exists($strVideoPath.$arrVideoIdList[$i]->videourl))
					JFile::delete($strVideoPath.$arrVideoIdList[$i]->videourl);					
					if($arrVideoIdList[$i]->thumburl != 'default_thumb.jpg' && JFile::exists($strVideoPath.$arrVideoIdList[$i]->thumburl))
					JFile::delete($strVideoPath.$arrVideoIdList[$i]->thumburl);
					if($arrVideoIdList[$i]->previewurl != 'default_thumb.jpg' && JFile::exists($strVideoPath.$arrVideoIdList[$i]->previewurl))
					JFile::delete($strVideoPath.$arrVideoIdList[$i]->previewurl);
					if($arrVideoIdList[$i]->hdurl && JFile::exists($strVideoPath.$arrVideoIdList[$i]->hdurl))
					JFile::delete($strVideoPath.$arrVideoIdList[$i]->hdurl);
				}
			}
			//query to delete selected videos	
			$query = "DELETE FROM #__hdflv_upload WHERE id IN ( $cids )";
			$db->setQuery( $query );
			if (!$db->query())
			{
				JError::raiseWarning($db->getErrorNum(), JText::_($db->getErrorMsg()));					
			}
			else
			{
				//query to delete video id in #__hdflv_video_category table
				$query = "DELETE FROM #__hdflv_video_category 
						  WHERE vid IN ( $cids )";
				$db->setQuery( $query );
			}
		}
		// page redirect
		$mainframe = JFactory::getApplication();
		if(count($cid)>1){
		$msg = JText::_('Videos Deleted Successfully');
		}else{
			$msg = JText::_('Video Deleted Successfully');
		}
		// set redirect to videos list page
		$mainframe->redirect( 'index.php?option=' . $option.'&layout=adminvideos&user='.JRequest::getVar('user'),$msg);
	}
}
?>