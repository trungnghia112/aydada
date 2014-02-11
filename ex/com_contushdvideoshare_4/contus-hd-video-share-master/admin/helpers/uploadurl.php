<?php
/*
 ***********************************************************/
/**
 * @name          : Joomla HD Video Share
 * @version	  	  : 3.4
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component Showvideos Uploadurl Helper
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */

/*
 ***********************************************************/
// No direct access to this file
defined('_JEXEC') or die;
/**
 * uploading videos
 * type : URL
 * Contushdvideoshare Component Showvideos Uploadurl Helper
 */
class uploadUrlHelper
{
	// function to upload url video
function uploadUrl($arrFormData,$idval)
	{
		$db = & JFactory::getDBO();
		$videourl = "";
		$baseUrl = str_replace("administrator/","",JURI::base());
		$thumburl = $baseUrl.'components/com_contushdvideoshare/videos/default_thumb.jpg';		
		$previewurl = $baseUrl.'components/com_contushdvideoshare/videos/default_preview.jpg';
		$hdurl = "";
		$streamer_option = "";
		
		// assign streameroption
		$streamer_option = $arrFormData['streameroption-value'];
		$fileoption = $arrFormData['fileoption'];

		// assign video url
		if ($arrFormData['videourl-value'] != "") {
		$videourl = $arrFormData['videourl-value'];
		}
		
		// assign hd url
		if ($arrFormData['hdurl-value'] != "") {
		$hdurl = $arrFormData['hdurl-value'];
		}
		
		// assign thumb image url
		if ($arrFormData['thumburl-value'] != "") {
		$thumburl = $arrFormData['thumburl-value'];
		}
			
		// assign preview image url
		if ($arrFormData['previewurl-value'] != "") {
		$previewurl = $arrFormData['previewurl-value'];
		}		

		// assign streamer path
		$streamer_path = ($arrFormData['streamerpath-value'] != '')?$arrFormData['streamerpath-value']:'';	
		$isLive = $arrFormData['islive-value'];
		// update streameroption,streamerpath,etc
		$query = "UPDATE #__hdflv_upload 
				  SET streameroption= '$streamer_option',streamerpath='$streamer_path', filepath='$fileoption',
				  videourl='$videourl',thumburl='$thumburl',previewurl='$previewurl',hdurl='$hdurl',islive='$isLive'
				  where id=$idval";
                $db->setQuery($query);
		$db->query();
                ##  get and set subtitle1 of the video
		$strSrtFile1 = $arrFormData['subtitle_video_srt1form-value'];
		$arrSrtFile1 = explode('uploads/', $strSrtFile1);
		if (isset($arrSrtFile1[1]))
		$strSrtFile1 = $arrSrtFile1[1];	
                
		##  get and set subtitle2 of the video
		$strSrtFile2 = $arrFormData['subtitle_video_srt2form-value'];
		$arrSrtFile2 = explode('uploads/', $strSrtFile2);
		if (isset($arrSrtFile2[1]))
		$strSrtFile2 = $arrSrtFile2[1];	
			
                $subtile_lang1 = $arrFormData['subtile_lang1'];
                $subtile_lang2 = $arrFormData['subtile_lang2'];
                ## Get upload helper file to upload thumb
                require_once(FVPATH.DS.'helpers'.DS.'uploadfile.php');
                uploadFileHelper::uploadVideoProcessing($subtile_lang1,$subtile_lang2,$idval, '', '', '',$strSrtFile1, $strSrtFile2, '', $arrFormData['newupload'], $fileoption);
                ## Delete temp file
                if ($strSrtFile1 != '')
		uploadFileHelper::unlinkUploadedTmpFiles($strSrtFile1);				
		if ($strSrtFile2 != '')
		uploadFileHelper::unlinkUploadedTmpFiles($strSrtFile2);
	}
}
?>