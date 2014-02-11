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
/*
 ***********************************************************/
// No direct access to this file
defined('_JEXEC') or die;

class uploadUrlHelper
{
	// function to upload url video
	function uploadUrl($arrFormData,$idVal)
	{
		$db = & JFactory::getDBO();
		$videourl = '';
		$baseUrl = str_replace("administrator/","",JURI::base());
		$thumburl = $baseUrl.'components/com_hdflvplayer/videos/default_thumb.jpg';
		$previewurl = $baseUrl.'components/com_hdflvplayer/videos/default_thumb.jpg';
		$hdurl = '';
		$streamer_option = '';
		$streamer_path = '';
		$streamer_option = $arrFormData['streameroption-value'];
		$videourl = $arrFormData['videourl-value'];
		$fileoption = $arrFormData['fileoption'];
		
		// assign thumb image url
		if ($arrFormData['thumburl-value'] != '')
		{
		$thumburl = $arrFormData['thumburl-value'];
		}
		
		// assign preview image url
		if ($arrFormData['previewurl-value'] != '')
		{
		$previewurl = $arrFormData['previewurl-value'];
		}
			
		// assign hd url
		$hdurl = $arrFormData['hdurl-value'];
			
		// assign streamerpath
		($streamer_option == 'rtmp') ? $streamer_path = $arrFormData['streamerpath-value'] : $streamer_path = '';
			
		// update streameroption,streamerpath,etc
		$query = 'UPDATE #__hdflvplayerupload SET streameroption= \''.$streamer_option.'\',streamerpath=\''.$streamer_path.'\', filepath=\''.$fileoption.'\',videourl=\''.$videourl.'\',thumburl=\''.$thumburl.'\',previewurl=\''.$previewurl.'\',hdurl=\''.$hdurl.
				'\' WHERE id='.$idVal;
		$db->setQuery($query);
		$db->query();
	}
}
?>