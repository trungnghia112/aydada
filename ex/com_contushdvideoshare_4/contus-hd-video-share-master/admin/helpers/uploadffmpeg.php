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
 * @abstract      : Contus HD Video Share Component Adminvideos Uploadffmpeg Helper
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */

/*
 ***********************************************************/
// No direct access to this file
defined('_JEXEC') or die;
jimport('joomla.filesystem.file');

/**
 * uploading videos
 * type : FFMPEG
 * Contushdvideoshare Component Adminvideos Uploadffmpeg Helper
 */
class uploadFfmpegHelper
{
	/**
	 * function to upload ffmpeg video
	 */ 
	function uploadFfmpeg($arrFormData,$idval)
	{
		$db = JFactory::getDBO();
				
		/**
		 * query for get HEIGTH,WIDTH player size and FFMPEG path from player settings		 
		 */	
		$query = "select player_values from  #__hdflv_player_settings limit 1";
		$db->setQuery($query);
		$arrPlayerSettings = $db->loadResult();
                $player_values      = unserialize($arrPlayerSettings);
		// check valid record
		if (count($arrPlayerSettings))
		{
			/**
			 * In Ffmpeg allowed width & height should be even nos.
			 * Hence 1 is added if it is odd no.
			 * 
			 */ 
			if (( $player_values['height'] % 2) == 0)
			$previewheight = $player_values['height'];
			else
			$previewheight = $player_values['height'] + 1;
			if (( $player_values['width'] % 2) == 0)
			$previewwidth = $player_values['width'];
			else
			$previewwidth= $player_values['width'] + 1;
			// To get ffmpeg path
			if ($player_values['ffmpegpath']) {
				$strFfmpegPath = $player_values['ffmpegpath'];
			}
		}
		
		
		$ffmpeg_video = $arrFormData['ffmpegform-value'];
		$video_name = explode('uploads/', $ffmpeg_video);		
                if(!empty($video_name[1])){

		$strTmpVidName = $video_name[1];
		
		/**
		 * VPATH to get target path
		 * target path @ /components/com_contushdvideoshare/videos
		 * FVPATH to get temporary path
		 * temp path @ /components/com_contushdvideoshare/images/uploads		 
		 */
		
		$strTmpPath = FVPATH . DS."images".DS."uploads".DS. $strTmpVidName;
		$strTargetPath = VPATH . DS;
		$exts = uploadFfmpegHelper::getFileExtension($strTmpVidName);		
		$strVidTargetPath = $strTargetPath . $idval . "_video" . "." . $exts;
		
		/**
		 * function to move video from temp path to target path		 
		 */			
		if (JFile::exists($strTmpPath))	
		rename($strTmpPath, $strVidTargetPath);		
		
		$strTmpPath = $strTargetPath . $idval . "_video" . "." . $exts;

		/**
		 * function to get FFMPEG video information		 
		 */	
		$arrData = uploadFfmpegHelper::getFfmpegVidInfo($strTmpPath, $strFfmpegPath);
		// Get file format
		$hdfile = $arrData['vdo_format'];		
		
		// To check for HD or Flv or other movies
		if ($hdfile == "h264") {
			$exts = uploadFfmpegHelper::getFileExtension($strTmpVidName);
			$video_name = $idval . '_hd' . ".flv";
			$flvpath = $strTargetPath . $idval . '_hd' . ".flv";
			exec($strFfmpegPath . ' ' . '-i' . ' ' . $strTmpPath . ' ' . '-sameq' . ' ' . $flvpath . ' ' . '2>&1');
			// To get Thumb image & Preview image from the original video file
			exec($strFfmpegPath . ' ' . "-i" . ' ' . $strTmpPath . ' ' . "-an -ss 00:00:05 -an -r 1 -s 120x68 -f image2" . ' ' . $strTargetPath . $idval . '_thumb' . ".jpeg");
			exec($strFfmpegPath . ' ' . "-i" . ' ' . $strTmpPath . ' ' . "-an -ss 00:00:05 -an -r 1 -s" . ' ' . $previewwidth . "x" . $previewheight . ' ' . " -f image2" . ' ' . $strTargetPath . $idval . '_preview' . ".jpeg");
			$hd_name = $idval . '_video.' . $exts;
		} else {
			exec($strFfmpegPath . ' ' . "-i" . ' ' . $strTmpPath . ' ' . "-sameq" . ' ' . $strTargetPath . $idval . '_video' . ".flv  2>&1");
			// To get Thumb image & Preview image from the original video file
			exec($strFfmpegPath . " -i " . $strTmpPath . ' ' . "-an -ss 00:00:05 -an -r 1 -s 120x68 -f image2" . ' ' . $strTargetPath . $idval . '_thumb' . ".jpeg");
			exec($strFfmpegPath . " -i " . $strTmpPath . ' ' . "-an -ss 00:00:05 -an -r 1 -s " . ' ' . $previewwidth . "x" . $previewheight . ' ' . "-f image2" . ' ' . $strTargetPath . $idval . '_preview' . ".jpeg");
			$video_name = $idval . '_video' . ".flv";
			$hd_name = "";
		}
        }else{
            $video_name=$video_name[0];
            $query = "select hdurl from  #__hdflv_upload WHERE id = $idval";
		$db->setQuery($query);
		$hd_name = $db->loadResult();
        }
		$thumb_name = $idval . '_thumb' . ".jpeg";
		$preview_name = $idval . '_preview' . ".jpeg";
		$fileoption = $arrFormData['fileoption'];
		// assign streameroption
		$streamer_option = $arrFormData['streameroption-value'];
		
		// To update the video file name in database table
		$query = "UPDATE #__hdflv_upload 
				  SET streameroption= '$streamer_option',filepath='$fileoption',videourl='$video_name',thumburl='$thumb_name',previewurl='$preview_name',hdurl='$hd_name' 
				  WHERE id = $idval";
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
	
	/**
	* function to get FFMPEG video information		 
	*/	
	function getFfmpegVidInfo($strVidPath, $strFfmpegPath) {		
		$commandline = $strFfmpegPath . " -i " . $strVidPath;
		$exec_return = uploadFfmpegHelper::ffmpeg_exec($commandline);
		$exec_return_content = explode("\n", $exec_return);
		if ($infos_line_id = uploadFfmpegHelper::ffmpeg_search('Video:', $exec_return_content)) {
			$infos_line = trim($exec_return_content[$infos_line_id]);
			$infos_cleaning = explode(': ', $infos_line);
			$infos_datas = explode(',', $infos_cleaning[2]);
			$return_array['vdo_format'] = trim($infos_datas[0]);
		}
		return($return_array);
	}

	/**
	* function to execute FFMPEG video using POPEN
	* The popen() function opens a process by creating a pipe, forking, and invoking the shell		 
	*/
	function ffmpeg_exec($commandline) {
		$read = '';
		$handle = popen($commandline . ' 2>&1', 'r');
		while (!feof($handle)) {
			$read .= fread($handle, 2096);
		}
		pclose($handle);
		return($read);
	}

	/**
	* function to reset array value
	* and search		 
	*/
	function ffmpeg_search($needle, $array_lines) {
		$return_val = false;
		reset($array_lines);
		foreach ($array_lines as $num_line => $line_content) {
			if (strpos($line_content, $needle) !== false) {
				return($num_line);
			}
		}
		return($return_val);
	}
	
	/**
	 * function to get file extensions	 
	 */
	function getFileExtension($strFileName){
		$strFileName = strtolower($strFileName);
		return JFile::getExt($strFileName);		
	}
}
?>