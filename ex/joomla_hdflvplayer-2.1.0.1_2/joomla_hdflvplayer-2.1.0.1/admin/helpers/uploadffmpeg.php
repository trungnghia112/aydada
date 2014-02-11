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

class uploadFfmpegHelper
{
	// function to upload ffmpeg video
	function uploadFfmpeg($arrFormData,$idval)
	{
		
		$db = & JFactory::getDBO();
		$newUpload = $arrFormData['newupload'];
		/**
		 * query for get HEIGTH,WIDTH player size and FFMPEG path from player settings		 
		 */	
		$query = "select player_values from  #__hdflvplayersettings limit 1";
		$db->setQuery($query);
		$arrPlayerSettings = $db->loadResult();
                $arrPlayerSettings = unserialize($arrPlayerSettings);
		// check valid record
		if (count($arrPlayerSettings))
		{
			/**
			 * In Ffmpeg allowed width & height should be even nos.
			 * Hence 1 is added if it is odd no.
			 * 
			 */ 
			if (($arrPlayerSettings['height'] % 2) == 0)
			$previewheight = $arrPlayerSettings['height'];
			else
			$previewheight = $arrPlayerSettings['height'] + 1;
			if (( $arrPlayerSettings['width'] % 2) == 0)
			$previewwidth = $arrPlayerSettings['width'];
			else
			$previewwidth= $arrPlayerSettings['width'] + 1;
			// To get ffmpeg path
			if ($arrPlayerSettings['ffmpegpath']) {
				$strFfmpegPath = $arrPlayerSettings['ffmpegpath'];
			}
		}
		
		$ffmpeg_video = $arrFormData['ffmpegform-value'];
		$video_name = explode("uploads/", $ffmpeg_video);
		$file_video = $video_name[1];
		$target_path = FVPATH . "/images/uploads/" . $file_video;
		$vpath = VPATH . "/"; // To add / fwd slash at the end
	        $exts1 = uploadFfmpegHelper::findexts($file_video);
                $target_path1 = $vpath . $idval . "_video" . "." . $exts1;
                

		rename($target_path, $target_path1);
		
		//exit;
		// Get ffmpeg path from db
		$fileoption = $arrFormData['fileoption'];
		
		$data = uploadFfmpegHelper::ezffmpeg_vdofile_infos($target_path1, $strFfmpegPath);
		// Get file fmt..
		$hdfile = $data['vdo_format'];
		
		// To check for HD or Flv or other movies

		if ($hdfile == "h264") {
			$exts = uploadFfmpegHelper::findexts($file_video);
			$video_name = $idval . '_hd' . ".flv";
			$flvpath = $vpath . $idval . '_hd' . ".flv";
			exec($strFfmpegPath . ' ' . '-i' . ' ' . $target_path1 . ' ' . '-sameq' . ' ' . $flvpath . ' ' . '2>&1');
			// To get Thumb image & Preview image from the original video file
			exec($strFfmpegPath . ' ' . "-i" . ' ' . $target_path1 . ' ' . "-an -ss 00:00:10 -an -r 1 -s 130x80 -f image2" . ' ' . $vpath . $idval . '_thumb' . ".jpeg");
			exec($strFfmpegPath . ' ' . "-i" . ' ' . $target_path1 . ' ' . "-an -ss 00:00:10 -an -r 1 -s" . ' ' . $previewwidth . "x" . $previewheight . ' ' . " -f image2" . ' ' . $vpath . $idval . '_preview' . ".jpeg");
			$hd_name = $idval . '_video.' . $exts;
		} else {
			exec($strFfmpegPath . ' ' . "-i" . ' ' . $target_path1 . ' ' . "-sameq" . ' ' . $vpath . $idval . '_video' . ".flv  2>&1");
			// To get Thumb image & Preview image from the original video file
			exec($strFfmpegPath . " -i " . $target_path1 . ' ' . "-an -ss 00:00:10 -an -r 1 -s 130x80 -f image2" . ' ' . $vpath . $idval . '_thumb' . ".jpeg");
			exec($strFfmpegPath . " -i " . $target_path1 . ' ' . "-an -ss 00:00:10 -an -r 1 -s " . ' ' . $previewwidth . "x" . $previewheight . ' ' . "-f image2" . ' ' . $vpath . $idval . '_preview' . ".jpeg");
			$video_name = $idval . '_video' . ".flv";
			$hd_name = "";
		}
		$thumb_name = $idval . '_thumb' . ".jpeg";
		$preview_name = $idval . '_preview' . ".jpeg";
		// To update the video file name in DB

		$query = 'UPDATE #__hdflvplayerupload SET streameroption=\'None\',filepath=\''.$fileoption.'\', videourl=\''.$video_name.'\',thumburl=\''.$thumb_name.'\',previewurl=\''.$preview_name.'\',hdurl=\''.$hd_name.'\'
				   WHERE id = '.$idval;
		$db->setQuery($query);
		$db->query();
	}
	function ezffmpeg_vdofile_infos($src_filepath, $ffmpeg_path) {
		$EZFFMPEG_BIN_PATH = $ffmpeg_path;
		$commandline = $ffmpeg_path . " -i " . $src_filepath;
		$exec_return = uploadFfmpegHelper::ezffmpeg_exec($commandline);
		$exec_return_content = explode("\n", $exec_return);
		
		$return_array = array();
		if ($infos_line_id = uploadFfmpegHelper::ezffmpeg_array_search('Video:', $exec_return_content)) {
			$infos_line = trim($exec_return_content[$infos_line_id]);
			$infos_cleaning = explode(': ', $infos_line);
			$infos_datas = explode(',', $infos_cleaning[2]);
			$return_array['vdo_format'] = trim($infos_datas[0]);
		}
		return($return_array);
	}

	function ezffmpeg_exec($commandline) {
		$read = '';
		$handle = popen($commandline . ' 2>&1', 'r');
		while (!feof($handle)) {
			$read .= fread($handle, 2096);
		}
		pclose($handle);
		return($read);
	}


	function ezffmpeg_array_search($needle, $array_lines) {
		$return_val = false;
		reset($array_lines);
		foreach ($array_lines as $num_line => $line_content) {
			if (strpos($line_content, $needle) !== false) {
				return($num_line);
			}
		}
		return($return_val);
	}
	//function to find file existance
	function findexts($strFileName)
	{
		$strFileName = strtolower($strFileName);
                $arrFileExt = explode(".", $strFileName);
		return $arrFileExt['1'];
	}
}
?>