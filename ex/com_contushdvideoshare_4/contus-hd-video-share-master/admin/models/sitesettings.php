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
 * @abstract      : Contus HD Video Share Component Sitesettings Model 
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
 * Contushdvideoshare Component Administrator Sitesettings Model
 *
 */ 

class contushdvideoshareModelsitesettings extends ContushdvideoshareModel
{	
	/**
	 * function to get sitesettings 
	 */ 
	function getsitesetting()
	{
		$jcomment = $jomcomment = 0;
		//query to fetch site settings
		$query = 'SELECT `id`, `published`, `thumbview`, `dispenable`, `homethumbview`,`sidethumbview` 
		          FROM #__hdflv_site_settings 
		          WHERE `id` = 1';
		$db = $this->getDBO();
		$db->setQuery($query);
		$settings = $db->loadObject();
		//query to check jomcomment component exists
		if (version_compare(JVERSION, '1.6.0', 'ge')) {
			$query = "SELECT COUNT(extension_id) 
					  FROM  #__extensions 
					  WHERE `element`='com_jomcomment' 
					  AND enabled =1";
		} else {
			$query = "SELECT COUNT(extension_id) 
					  FROM  #__components 
				      WHERE `option`='com_jomcomment' 
					  AND enabled =1";
		}
		$db->setQuery($query);
		$jomcomment = $db->loadResult();
		//query to check jcomments component exists		
		if (version_compare(JVERSION, '1.6.0', 'ge')) {
			$query = "SELECT COUNT(extension_id) 
				      FROM  #__extensions 
					  WHERE `element`='com_jcomments' 
					  AND enabled =1";
		} else {
			$query = "SELECT COUNT(extension_id) 
					  FROM  #__components 
					  WHERE `option`='com_jcomments' 
					  AND enabled =1";
		}

		$db->setQuery($query);
		$jcomment = $db->loadResult();		
		if (empty($settings)){
		JError::raiseError(500, 'detail with ID: ' . $id . ' not found.');
		}else
		return array($settings, $jomcomment, $jcomment);
	}

	/**
	 * save sitesettings fields
	 */ 
	function savesitesettings($arrFormData)
	{
		$option = JRequest::getCmd('option');
		$mainframe = JFactory::getApplication();		
		$db = & JFactory::getDBO();		
		$cid = JRequest::getVar('cid', array(0), '', 'array');
		$id = $cid[0];
		//Get the object for site settings table.
		$objSitesettingsTable = & $this->getTable('sitesettings');
                
                ## Get thumbview details and serialize data
                $thumbview               = array(
                    'featurrow'             => $arrFormData['featurrow'],
                    'featurcol'             => $arrFormData['featurcol'],
                    'recentrow'             => $arrFormData['recentrow'],
                    'recentcol'             => $arrFormData['recentcol'],
                    'categoryrow'           => $arrFormData['categoryrow'],
                    'categorycol'           => $arrFormData['categorycol'],
                    'popularrow'            => $arrFormData['popularrow'],
                    'popularcol'            => $arrFormData['popularcol'],
                    'searchrow'             => $arrFormData['searchrow'],
                    'searchcol'             => $arrFormData['searchcol'],
                    'relatedrow'            => $arrFormData['relatedrow'],
                    'relatedcol'            => $arrFormData['relatedcol'],
                    'featurwidth'           => $arrFormData['featurwidth'],
                    'recentwidth'           => $arrFormData['recentwidth'],
                    'categorywidth'         => $arrFormData['categorywidth'],
                    'popularwidth'          => $arrFormData['popularwidth'],
                    'searchwidth'           => $arrFormData['searchwidth'],
                    'relatedwidth'          => $arrFormData['relatedwidth'],
                    'memberpagewidth'       => $arrFormData['memberpagewidth'],
                    'memberpagerow'         => $arrFormData['memberpagerow'],
                    'memberpagecol'         => $arrFormData['memberpagecol'],
                    'myvideorow'            => $arrFormData['myvideorow'],
                    'myvideocol'            => $arrFormData['myvideocol'],
                    'myvideowidth'          => $arrFormData['myvideowidth']
                 );
                $arrFormData['thumbview'] = serialize($thumbview);
                
                ## Get home page thumb details and serialize data
                $homethumbview               = array(
                    'homepopularvideo'      => $arrFormData['homepopularvideo'],
                    'homepopularvideorow'   => $arrFormData['homepopularvideorow'],
                    'homepopularvideocol'   => $arrFormData['homepopularvideocol'],
                    'homefeaturedvideo'     => $arrFormData['homefeaturedvideo'],
                    'homefeaturedvideorow'  => $arrFormData['homefeaturedvideorow'],
                    'homefeaturedvideocol'  => $arrFormData['homefeaturedvideocol'],
                    'homerecentvideo'       => $arrFormData['homerecentvideo'],
                    'homerecentvideorow'    => $arrFormData['homerecentvideorow'],
                    'homerecentvideocol'    => $arrFormData['homerecentvideocol'],
                    'homepopularvideoorder' => $arrFormData['homepopularvideoorder'],
                    'homefeaturedvideoorder'=> $arrFormData['homefeaturedvideoorder'],
                    'homerecentvideoorder'  => $arrFormData['homerecentvideoorder'],
                    'homefeaturedvideoorder'=> $arrFormData['homefeaturedvideoorder'],
                    'homepopularvideowidth' => $arrFormData['homepopularvideowidth'],
                    'homefeaturedvideowidth'=> $arrFormData['homefeaturedvideowidth'],
                    'homerecentvideowidth'  => $arrFormData['homerecentvideowidth'],
                 );
                $arrFormData['homethumbview'] = serialize($homethumbview);
                ## Get home page thumb details and serialize data
                $sidethumbview               = array(
                    'sidepopularvideorow'   => $arrFormData['sidepopularvideorow'],
                    'sidepopularvideocol'   => $arrFormData['sidepopularvideocol'],
                    'sidefeaturedvideorow'  => $arrFormData['sidefeaturedvideorow'],
                    'sidefeaturedvideocol'  => $arrFormData['sidefeaturedvideocol'],
                    'siderelatedvideorow'   => $arrFormData['siderelatedvideorow'],
                    'siderelatedvideocol'   => $arrFormData['siderelatedvideocol'],
                    'siderecentvideorow'    => $arrFormData['siderecentvideorow'],
                    'siderecentvideocol'    => $arrFormData['siderecentvideocol']
                 );
                $arrFormData['sidethumbview'] = serialize($sidethumbview);
                ## Get thumbview details and serialize data
                $dispenable               = array(
                    'allowupload'         => $arrFormData['allowupload'],
                    'user_login'          => $arrFormData['user_login'],
                    'ratingscontrol'      => $arrFormData['ratingscontrol'],
                    'viewedconrtol'       => $arrFormData['viewedconrtol'],
                    'seo_option'          => $arrFormData['seo_option'],
                    'language_settings'   => 'English.php',
                    'disqusapi'           => $arrFormData['disqusapi'],
                    'facebookapi'         => $arrFormData['facebookapi'],
                    'comment'             => $arrFormData['comment'],
                    'facebooklike'        => $arrFormData['facebooklike']
                 );
                $arrFormData['dispenable'] = serialize($dispenable);

		// Bind data to the table object.
		if (!$objSitesettingsTable->bind($arrFormData))
		{
			JError::raiseError(500, $objSitesettingsTable->getError());
		}
		// Check that the node data is valid.
		if (!$objSitesettingsTable->check())
		{
			JError::raiseError(500, $objSitesettingsTable->getError());
		}
		// Store the node in the database table.
		if (!$objSitesettingsTable->store())
		{			
			JError::raiseError(500, $objSitesettingsTable->getError());
		}		
		// page redirect
		$link = 'index.php?option=' . $option.'&layout=sitesettings';
		$mainframe->redirect($link, 'Saved Successfully');		
	}
}
?>
