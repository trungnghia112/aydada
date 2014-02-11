<?php
/**
 * @name 	        HVS Article Plugin
 * @version	        1.0
 * @package	        Apptha
 * @since	        Joomla 1.5
 * @author      	Apptha - http://www.apptha.com/
 * @copyright 		Copyright (C) 2013 Powered by Apptha
 * @license 		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      	HVS Article Plugin file.
 * @Creation Date	July 2013
 * @modified Date	July 2013
 */

## No direct access to this file
define('_JEXEC', 1);

$path = explode("plugins", dirname(__FILE__));
define('JPATH_BASE', $path[0]);
define('DS', DIRECTORY_SEPARATOR);

require_once ( JPATH_BASE .DS . 'configuration.php' );
require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );

require_once ( JPATH_BASE .DS.'libraries'.DS.'joomla'.DS.'factory.php' );

$type       = JRequest::getVar('type');
$order      = $query = NULL;
$db         = JFactory::getDbo();
$baseUrl    = JURI::base();
$baseUrl1   = parse_url($baseUrl);
$baseUrl1   = $baseUrl1['scheme'] . '://' . $baseUrl1['host'];
$baseUrl2   = str_replace('/plugins/content/hvsarticle', '', $baseUrl);

switch ($type) {
    case 'rec':
        $order = "ORDER BY `id` DESC ";
        break;
    case 'fea':
        $query = "AND `featured`=1 ";
        break;
    case 'pop':
         $order = "ORDER BY `times_viewed` DESC ";
        break;
}

## Get player settings
$qry_settings                   = "SELECT player_icons FROM #__hdflv_player_settings LIMIT 1";
$db->setQuery($qry_settings);
$rs_settings                    = $db->loadResult();
$player_icons                   = unserialize($rs_settings);

if ($player_icons['playlist_autoplay'] == 1) {
    $playlistautoplay = "true";
}

## Query to get Video details
$query = "SELECT a.*, b.category, d.username,e.* "
        . "FROM #__hdflv_upload a "
        . "LEFT JOIN #__users d ON a.memberid=d.id "
        . "LEFT JOIN #__hdflv_video_category e ON e.vid=a.id "
        . "LEFT JOIN #__hdflv_category b ON e.catid=b.id "
        . "WHERE a.published='1' AND b.published='1' $query AND a.type='0' AND a.filepath!='Embed'"
        . "GROUP BY e.vid "
        . $order;
$db->setQuery($query);
$records    = $db->loadObjectList();
$accessid   = getUserAccessId();

$hdvideo        = $timage = $streamername = $targeturl = '';
$islive         = "false";
$postrollid     = $prerollid = 0;
ob_clean();
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("content-type: text/xml");
echo '<?xml version="1.0" encoding="utf-8"?>';
echo '<playlist autoplay="'.$playlistautoplay.'">';
$current_path   = "components/com_contushdvideoshare/videos/";

foreach ($records as $record) {

    if (version_compare(JVERSION, '1.6.0', 'ge')) {
        if ($record->useraccess == 0){
            $record->useraccess = 1;
        }
        $query          = "SELECT rules FROM #__viewlevels "
                        . " WHERE id = " . $record->useraccess;
        $db->setQuery($query);
        $message        = $db->loadResult();
        $accessLevel    = json_decode($message);
    }

    ## To check video access for members
    $member = "true";
    if (version_compare(JVERSION, '1.6.0', 'ge')) {
        $member = "false";
        foreach ($accessLevel as $useracess) {
            if ( (is_array($useracess) && in_array("$useracess", $accessid)) || $useracess == 1) {
                $member = "true";
                break;
            }
        }
    } else {
        if ($record->useraccess != 0) {
            if ($accessid != $record->useraccess && $accessid != 2) {
                $member = "false";
            }
        }
    }
         
    ## To get the video url
        
    if ($record->filepath == "File" || $record->filepath == "FFmpeg") {
            
        $video              = $baseUrl2 . $current_path . $record->videourl;
        if ($record->hdurl != "") {
            $hdvideo        = $baseUrl2 . $current_path . $record->hdurl;
        }
        if (!empty($record->previewurl)){
            $preview_image  = $record->previewurl;
        } else {
            $preview_image  = 'default_preview.jpg';
        }
        $previewimage       = $baseUrl2 . $current_path . $preview_image;
        $timage             = $baseUrl2 . $current_path . $record->thumburl;
        if ($record->hdurl) {
            $hd_bol         = "true";
        } else {
            $hd_bol         = "false";
        }
    } elseif ($record->filepath == "Url") {
        $video              = $record->videourl;
        if (!empty($record->previewurl)) {
            $previewimage   = $record->previewurl;
        } else {
            $previewimage   = $baseUrl2 . $current_path . 'default_preview.jpg';
        }
        $timage             = $record->thumburl;

        if ($record->hdurl) {
            $hd_bol         = "true";
        } else { 
            $hd_bol         = "false";
        }
        $hdvideo            = $record->hdurl;
    }
    elseif ($record->filepath == "Youtube") {
        $video              = $record->videourl;
        $str2               = strstr($record->previewurl, 'components');

        if ($str2 != "") {
            $previewimage   = $baseUrl2 . $record->previewurl;
            $timage         = $baseUrl2 . $record->thumburl;
        } else {
            $previewimage   = $record->previewurl;
            $timage         = $record->thumburl;
        }
        $hd_bol             = "false";
        $hdvideo            = "";
    }

    if ($record->streameroption == "lighttpd") {
        $streamername       = $record->streameroption;
    }
    if ($record->streameroption == "rtmp") {
        $streamername       = $record->streamerpath;
    }

    $categoryQuery  = "SELECT seo_category FROM #__hdflv_category WHERE id=$record->playlistid";
    $db->setQuery($categoryQuery);
    $seo_category   = $db->loadResult();                      ## Get seo category title

    ## To get the fb path
    $settingQuery   = "SELECT dispenable FROM #__hdflv_site_settings";
    $db->setQuery($settingQuery);
    $resultSetting  = $db->loadResult();
    $dispenable     = unserialize($resultSetting);
    if ($dispenable['seo_option'] == 1) {               ## If seo option enabled
        $fbCategoryVal  = "category=" . $seo_category;
        $fbVideoVal     = "video=" . $record->seotitle;
    } else {                                                ## If seo option disabled
        $fbCategoryVal  = "catid=" . $record->playlistid;
        $fbVideoVal     = "id=" . $record->id;
    }
    
    $fbPath     = $baseUrl1 . '/index.php?option=com_contushdvideoshare&view=player&' . $fbCategoryVal . '&' . $fbVideoVal;
    
    ## Get post roll ad id for video
    $query_postads          = "SELECT * FROM #__hdflv_ads WHERE published=1 AND id=$record->postrollid"; 
    $db->setQuery($query_postads);
    $rs_postads             = $db->loadObjectList();
    $postroll               = ' allow_postroll = "false"';
    $postroll_id            = ' postroll_id = "0"';
    if (count($rs_postads) > 0) {
        if ($record->postrollads == 1) {
            $postroll       = ' allow_postroll = "true"';
            $postroll_id    = ' postroll_id = "'.$record->postrollid.'"';
        }
    }

    ## Get pre roll ad id for video
    $query_preads           = "SELECT * FROM #__hdflv_ads WHERE published=1 AND id=$record->prerollid";
    $db->setQuery($query_preads);
    $rs_preads              = $db->loadObjectList();
    $preroll                = ' allow_preroll = "false"';
    $preroll_id             = ' preroll_id = "0"';
    if (count($rs_preads) > 0) {
        if ($record->prerollads == 1) {
            $preroll        = ' allow_preroll = "true"';
            $preroll_id     = ' preroll_id = "'.$record->prerollid.'"';
        }
    }

    ## Get mid ad id for video
    $query_ads              = "SELECT * FROM #__hdflv_ads WHERE published=1 AND typeofadd='mid' "; 
    $db->setQuery($query_ads);
    $rs_ads                 = $db->loadObjectList();
    $midroll                = ' allow_midroll = "false"';
    if (count($rs_ads) > 0) {
        if ($record->midrollads == 1) {
            $midroll        = ' allow_midroll = "true"';
        }
    }

    ## Get ima ad for video
    $query_imaads           = "SELECT * FROM #__hdflv_ads WHERE published=1 AND typeofadd='ima' "; 
    $db->setQuery($query_imaads);
    $rs_imaads                 = $db->loadObjectList();
    $imaad                  = ' allow_ima = "false"';
    if (count($rs_imaads) > 0) {
        if ($record->imaads == 1) {
            $imaad          = ' allow_ima = "true"';
        }
    }

    if ($record->targeturl != "") {
        $targeturl = $record->targeturl;                                  ## Get target url for a video
    }
    if ($record->postrollads == "1") {
        $postrollid = $record->postrollid;                                ## Get pre roll id for a video
    }
    if ($record->prerollads == "1") {
        $prerollid = $record->prerollid;                                  ## Get post roll id for a video
    }
    
    ## To get the other values
    if ($record->filepath == "Youtube") {
        $download = "false";
    }
    $views = $record->times_viewed;
    $tags = $record->tags;
    if ($streamername != ""){
        if ($record->islive == 1) {
            $islive = "true" ;
        } 
    }
    
    echo    '<mainvideo
            views="' . $views . '"
            streamer_path="' . $streamername . '"
            video_isLive="' . $islive . '"
            video_id = "' . htmlspecialchars($record->id) . '"
            fbpath = "' . $fbPath . '"
            video_url = "' . htmlspecialchars($video) . '"
            thumb_image = "' . htmlspecialchars($timage) . '"
            preview_image = "' . htmlspecialchars($previewimage) . '"
            ' . $midroll . '
            ' . $imaad . '
            ' . $postroll . '
            ' . $preroll . '
            ' . $postroll_id . '
            ' . $preroll_id . '
            Tag =  "' . $tags . '"
            allow_download = "' . $download . '"
            video_hdpath = "' . $hdvideo . '"
            copylink = "">
            <title><![CDATA[' . htmlspecialchars($record->title) . ']]></title>
            <tagline targeturl="' . $targeturl . '"><![CDATA[' . htmlspecialchars($record->description) . ']]></tagline>
        </mainvideo>';
}
echo "</playlist>";
exit;

function getUserAccessId() {
    $user = JFactory::getUser();
    $uid = '';
    if (version_compare(JVERSION, '1.6.0', 'ge')) {
        $uid = $user->get('id');
        if ($uid) {
            $db = &JFactory::getDBO();
            $query = $db->getQuery(true);
            $query->select('g.id AS group_id')
                    ->from('#__usergroups AS g')
                    ->leftJoin('#__user_usergroup_map AS map ON map.group_id = g.id')
                    ->where('map.user_id = ' . (int) $uid);
            $db->setQuery($query);
            $message = $db->loadObjectList();
            foreach ($message as $mess) {
                $accessid[] = $mess->group_id;
            }
        } else {
            $accessid[] = 1;
        }
    } else {
        $accessid = $user->get('aid');
    }
}
?>