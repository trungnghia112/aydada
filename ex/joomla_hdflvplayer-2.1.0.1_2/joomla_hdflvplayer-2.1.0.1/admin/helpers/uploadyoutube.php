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

class uploadYouTubeHelper
{
	// function to upload youtube video
	function uploadYoutube($arrFormData,$idval)
	{
		
		$videourl = $arrFormData['videourl-value'];
		$baseUrl = explode('administrator', JURI::base());
		$videoshareurl = $baseUrl[0] . "index.php?option=com_hdflvplayer&view=videourl";
		$timeout = '';
		$header = '';
		$fileoption = $arrFormData['fileoption'];
		
		// check video url is youtube
		if(strpos($videourl,'youtube') > 0)
		{
			$imgstr = explode('v=', $videourl);
			$imgval = explode('&', $imgstr[1]);
			$previewurl = 'http://img.youtube.com/vi/' . $imgval[0] . '/0.jpg';
			$img = 'http://img.youtube.com/vi/' . $imgval[0] . '/1.jpg';
                        $hdurl = $videourl;
		}
                 else if(strpos($videourl,'vimeo') > 0)
                    {

                       $split = explode("/",$videourl);
                       $doc = new DOMDocument();
                       $doc->load('http://vimeo.com/api/v2/video/'.$split[3].'.xml');
                       $videotags = $doc->getElementsByTagName('video');
                        foreach ($videotags as $videotag)
                            {
                              $imgnode = $videotag->getElementsByTagName('thumbnail_medium');
                              $img = $imgnode->item(0)->nodeValue;
                           }
                           $hdurl = $videourl;

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
			$locations = '';
			$location  = explode('&', $videoshareurl_location);
			$locations = explode('location2=', $location[2]);
			$img = explode('imageurl=', $location[4]);
			$img = $img[1];
			$hdurl = '';
			if (!empty($locations[1]))
			$hdurl = $videourl;
		}
			
		// update fields
		$db = & JFactory::getDBO();
		$query = 'UPDATE #__hdflvplayerupload SET streameroption= \'None\',filepath=\''.$fileoption.'\' ,videourl=\''.$videourl.'\',thumburl=\''.$img.'\',previewurl=\''.$previewurl.'\',hdurl=\''.$hdurl.'\' 
					WHERE id='.$idval;
		$db->setQuery($query);
		$db->query();
	}
}
?>