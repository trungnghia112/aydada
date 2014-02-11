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
 * @abstract      : Contus HD Video Share Component Showvideos Uploadyoutube Helper
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */

/*
 ***********************************************************/
// No direct access to this file
defined('_JEXEC') or die;
/**
 * uploading videos
 * type : YOUTUBE
 * Contushdvideoshare Component Showvideos Uploadyoutube Helper
 */
class uploadYouTubeHelper
{
	// function to upload youtube video
	function uploadYouTube($arrFormData,$idval)
	{
		$videourl = $arrFormData['videourl-value'];
		$str1 = explode('administrator', JURI::base());
		$videoshareurl = $str1[0] . "index.php?option=com_contushdvideoshare&view=videourl";
		$timeout = $header = $hdurl = "";
		// check video url is youtube
		if(strpos($videourl,'youtube') > 0)
		{
			$imgstr = explode("v=", $videourl);
			$imgval = explode("&", $imgstr[1]);
			$previewurl = "http://img.youtube.com/vi/" . $imgval[0] . "/maxresdefault.jpg";
			$img = "http://img.youtube.com/vi/" . $imgval[0] . "/mqdefault.jpg";
		}
		else if(strpos($videourl,'youtu.be') > 0)
		{
			$imgstr = explode("/", $videourl);
			$previewurl = "http://img.youtube.com/vi/" . $imgstr[3] . "/maxresdefault.jpg";
			$img = "http://img.youtube.com/vi/" . $imgstr[3] . "/mqdefault.jpg";
                        $videourl="http://www.youtube.com/watch?v=".$imgstr[3];
		}

		// check video url is youtube
		else if(strpos($videourl,'vimeo') > 0)
		{
		 $split=explode("/",$videourl);
                 if( ini_get('allow_url_fopen') ) {
			$doc = new DOMDocument();
			$doc->load('http://vimeo.com/api/v2/video/'.$split[3].'.xml');
			$videotags = $doc->getElementsByTagName('video');
			foreach ($videotags as $videotag)
			{
				$imgnode = $videotag->getElementsByTagName('thumbnail_medium');
				$img = $imgnode->item(0)->nodeValue;
			}
                }else{
                        $url="http://vimeo.com/api/v2/video/" . $split[3] . ".xml";
                        $curl = curl_init($url);
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                        $result = curl_exec($curl);
                        curl_close($curl);
                        $xml = simplexml_load_string($result);
                        $img = $xml->video->thumbnail_medium;
                }
		}
		// check video url is dailymotion
		else if(strpos($videourl,'dailymotion') > 0)
		{
                    $split      = explode("/",$videourl);
                    $split_id   = explode("_",$split[4]);
                    $img        = $previewurl = 'http://www.dailymotion.com/thumbnail/video/'.$split_id[0];
		}
                // check video url is viddler
		else if(strpos($videourl,'viddler') > 0)
		{
			$imgstr = explode("/", $videourl);
			$img    = $previewurl = "http://cdn-thumbs.viddler.com/thumbnail_2_" . $imgstr[4] . "_v1.jpg";
		}	
		// check video url is site url
		else
		{
			// is cURL exit or not
			if (!function_exists('curl_init')) {
				echo "<script> alert('Sorry cURL is not installed!');window.history.go(-1); </script>\n";
				exit();
			}

			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $videoshareurl . '&url=' . $videourl . '&imageurl=' . $videourl);
			curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
			curl_setopt($curl, CURLOPT_USERAGENT, sprintf("Mozilla/%d.0", rand(4, 5)));
			curl_setopt($curl, CURLOPT_HEADER, (int) $header);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
			$videoshareurl_location = curl_exec($curl);
			curl_close($curl);
			$location1 = "";
			$location2 = "";
			$location3 = "";
			$location = explode('&', $videoshareurl_location);
			$location1 = explode('location1=', $location[1]);
			$location2 = explode('location2=', $location[2]);
			$location3 = explode('location3=', $location[3]);
			$img = explode('imageurl=', $location[4]);
			$img = $img[1];
			$hdurl = "";
			if ($location2[1] != "")
			$hdurl = $videourl;
		}
		
		$streamer_option = "";		
		// assign streameroption
		$streamer_option = $arrFormData['streameroption-value'];
		$fileoption = $arrFormData['fileoption'];
		
		// update fields
		$db = JFactory::getDBO();
		$query = "UPDATE #__hdflv_upload SET streameroption= '$streamer_option',filepath='$fileoption' ,videourl='$videourl',thumburl='$img',previewurl='$previewurl',hdurl='$hdurl' where id=$idval";
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