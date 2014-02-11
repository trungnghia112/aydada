<?php
/**
 * @name          : Joomla HD Video Share
 * @version	  : 3.4.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2012 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component Playxml Model
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */

## No direct access to this file
defined('_JEXEC') or die('Restricted access');
## import joomla model library
jimport('joomla.application.component.model');

##Contushdvideoshare Component Playxml Model

class Modelcontushdvideoshareplayxml extends ContushdvideoshareModel {

    function playgetrecords() {
        $db                 = JFactory::getDBO();
        $videoid            = 0;
        $vid                = JRequest::getvar('id');
        $categ_id           = JRequest::getvar('catid');
        $mid                = JRequest::getString('mid');
        $adminview          = JRequest::getString('adminview');
        if($adminview == true){
            $publish = '';
        } else {
            $publish = 'a.published=1 AND';
        }
        if ($vid != 0) {
                $query      = "UPDATE #__hdflv_upload SET times_viewed=1+times_viewed WHERE id=" . $vid;
                $db->setQuery($query);
                $db->query();
                $query      = "SELECT distinct a.*,b.category
                            FROM #__hdflv_upload a 
                            LEFT JOIN #__hdflv_category b on a.playlistid=b.id 
                            WHERE $publish b.published='1' AND a.id=$vid AND a.filepath!='Embed'";
                $db->setQuery($query);
                $rows       = $db->loadObjectList();
            }
            
        if($mid == 'playerModule'){
            if (count($rows) > 0) {
                $query          = "SELECT distinct a.*,b.category
                                FROM #__hdflv_upload a 
                                LEFT JOIN #__hdflv_category b on a.playlistid=b.id or a.playlistid=b.parent_id 
                                WHERE $publish b.published='1' AND a.featured='1' AND a.id != $vid AND a.filepath!='Embed' 
                                    ORDER BY a.id DESC LIMIT 3";
                $db->setQuery($query);
                $playlist_loop  = $db->loadObjectList();
                
                ## Array rotation to autoplay the videos correctly
                $arr1           = array();
                $arr2           = array();
                if (count($playlist_loop) > 0) {
                    foreach ($playlist_loop as $r):
                        if ($r->id > $rows[0]->id) {      ##Storing greater values in an array
                            $query      = "SELECT DISTINCT a.*,b.category
                                        FROM #__hdflv_upload a 
                                        LEFT JOIN #__hdflv_category b ON a.playlistid=b.id 
                                        WHERE $publish b.published='1' AND a.id=$r->id  AND a.filepath!='Embed'";
                            $db->setQuery($query);
                            $arrGreat   = $db->loadObject();
                            $arr1[]     = $arrGreat;
                        } else {                          ##Storing lesser values in an array
                            $query      = "SELECT DISTINCT a.*,b.category
                                        FROM #__hdflv_upload a 
                                        LEFT JOIN #__hdflv_category b ON a.playlistid=b.id 
                                        WHERE $publish b.published='1' AND a.id=$r->id  AND a.filepath!='Embed'";
                            $db->setQuery($query);
                            $arrLess    = $db->loadObject();
                            $arr2[]     = $arrLess;
                        }
                    endforeach;
                }
                $playlist               = array_merge($arr2, $arr1);
            }
        } else if ($vid) {
            $videoid        = $vid;
            if ($categ_id) {
                $videocategory = $categ_id;
            } else {
                $videocategory = $rows[0]->playlistid;
            }
            if (count($rows) > 0) {
                $query          = "SELECT distinct a.*,b.category
                                FROM #__hdflv_upload a 
                                LEFT JOIN #__hdflv_category b on a.playlistid=b.id or a.playlistid=b.parent_id 
                                WHERE $publish b.published='1' AND b.id=" . $videocategory . " AND a.id != $videoid AND a.filepath!='Embed'";
                $db->setQuery($query);
                $playlist_loop  = $db->loadObjectList();
                
                ## Array rotation to autoplay the videos correctly
                $arr1           = array();
                $arr2           = array();
                if (count($playlist_loop) > 0) {
                    foreach ($playlist_loop as $r):
                        if ($r->id > $rows[0]->id) {      ##Storing greater values in an array
                            $query      = "SELECT DISTINCT a.*,b.category
                                        FROM #__hdflv_upload a 
                                        LEFT JOIN #__hdflv_category b ON a.playlistid=b.id 
                                        WHERE $publish b.published='1' AND a.id=$r->id  AND a.filepath!='Embed'";
                            $db->setQuery($query);
                            $arrGreat   = $db->loadObject();
                            $arr1[]     = $arrGreat;
                        } else {                          ##Storing lesser values in an array
                            $query      = "SELECT DISTINCT a.*,b.category
                                        FROM #__hdflv_upload a 
                                        LEFT JOIN #__hdflv_category b ON a.playlistid=b.id 
                                        WHERE $publish b.published='1' AND a.id=$r->id  AND a.filepath!='Embed'";
                            $db->setQuery($query);
                            $arrLess    = $db->loadObject();
                            $arr2[]     = $arrLess;
                        }
                    endforeach;
                }
                $playlist               = array_merge($arr1, $arr2);
            }
        } else {
            $query                      = "SELECT a.*,b.category,d.username,e.*
                                        FROM #__hdflv_upload a 
                                        LEFT JOIN #__users d ON a.memberid=d.id 
                                        LEFT JOIN #__hdflv_video_category e ON e.vid=a.id 
                                        LEFT JOIN #__hdflv_category b ON e.catid=b.id 
                                        WHERE $publish b.published='1' AND a.featured='1' AND a.type='0' AND a.filepath!='Embed'
                                        GROUP BY e.vid 
                                        ORDER BY a.ordering ASC"; ## Query is to display recent videos in home page
            $db->setQuery($query);
            $rs_video                   = $db->loadObjectList();
            if (JRequest::getvar('featured') && !empty($rs_video)) {
                $featured               = JRequest::getvar('featured');
                if ($featured == "true") {
                    $query              = "UPDATE #__hdflv_upload SET times_viewed=1+times_viewed WHERE id=" . $rs_video[0]->id;
                    $db->setQuery($query);
                    $db->query();
                }
            }
            if (count($rs_video) == 0) {
                $query                  = "SELECT a.*,b.category,d.username,e.* 
                                        FROM  #__hdflv_upload a 
                                        LEFT JOIN #__users d ON a.memberid=d.id 
                                        LEFT JOIN #__hdflv_video_category e ON e.vid=a.id 
                                        LEFT JOIN #__hdflv_category b ON e.catid=b.id 
                                        WHERE $publish b.published='1' AND a.type='0' AND a.filepath!='Embed'
                                        GROUP BY e.vid 
                                        ORDER BY a.ordering ASC LIMIT 0,1"; ## Query is to display recent videos in home page
                $db->setQuery($query);
                $rs_video               = $db->loadObjectList();
            }
        }

        if (isset($rows) && count($rows) > 0){
            $rs_video                   = array_merge($rows, $playlist);
        }
        $this->showxml($rs_video);
    }

    function showxml($rs_video) {
        $user           = JFactory::getUser();
        $db             = JFactory::getDBO();
        $rows           = $uid = $hdvideo = $timage = $streamername = $targeturl = $subtitle = '';
        $postrollid     = $prerollid = 0;
        $download = $playlistautoplay = $islive ="false";
        $member         = "true";
        $current_path   = "components/com_contushdvideoshare/videos/";
        
        if (version_compare(JVERSION, '1.6.0', 'ge')) {
            $uid        = $user->get('id');
            if ($uid) {
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

        ## Get player settings
        $qry_settings                   = "SELECT player_icons FROM #__hdflv_player_settings LIMIT 1";
        $db->setQuery($qry_settings);
        $rs_settings                    = $db->loadResult();
        $player_icons                   = unserialize($rs_settings);
        
            if ($player_icons['playlist_autoplay'] == 1) {
                $playlistautoplay = "true";
            }
            $hddefault = $player_icons['hddefault'];
        
        ## Generate Playlist xml here
        ob_clean();
        header("content-type: text/xml");
        echo '<?xml version="1.0" encoding="utf-8"?>';
        echo '<playlist autoplay="' . $playlistautoplay . '">';
       
        if (count($rs_video) > 0) {
            foreach ($rs_video as $rows) {
                ## Get user access level
                if (version_compare(JVERSION, '1.6.0', 'ge')) {
                    $query          = $db->getQuery(true);
                    if ($rows->useraccess == 0)
                        $rows->useraccess = 1;
                    $query->select('rules as rule')
                            ->from('#__viewlevels AS view')
                            ->where('id = ' . (int) $rows->useraccess);
                    $db->setQuery($query);
                    $message        = $db->loadResult();
                    $accessLevel    = json_decode($message);
                }
                ## Get details of upload and FFMPEG type videos
                if ($rows->filepath == "File" || $rows->filepath == "FFmpeg") {
                    if ($hddefault == 0 && $rows->hdurl != '') {
                        $video = '';
                    } else {
                        $video = JURI::base() . $current_path . $rows->videourl;
                    }
                    $video = JURI::base() . $current_path . $rows->videourl;
                    if ($rows->hdurl != "") {
                        $hdvideo = JURI::base() . $current_path . $rows->hdurl;
                    }
                    if (!empty($rows->previewurl)) {
                        $preview_image = $rows->previewurl;
                    } else {
                        $preview_image = 'default_preview.jpg';
                    }
                    $previewimage = JURI::base() . $current_path . $preview_image;
                    $timage = JURI::base() . $current_path . $rows->thumburl;
                    if ($rows->hdurl) {
                        $hd_bol = "true";
                    } else {
                        $hd_bol = "false";
                    }
                }
                ## Get details of URL type videos
                elseif ($rows->filepath == "Url") {
                    $video = $rows->videourl;
                    if (!empty($rows->previewurl)){
                        $previewimage = $rows->previewurl;
                    } else {
                        $previewimage = JURI::base() . $current_path . 'default_preview.jpg';
                    }
                    $timage = $rows->thumburl;

                    if ($rows->hdurl) {
                        $hd_bol = "true";
                    } else {
                        $hd_bol = "false";
                    }
                    $hdvideo = $rows->hdurl;
                }
                ## Get details of Youtube type videos
                elseif ($rows->filepath == "Youtube") {
                    $video = $rows->videourl;
                    $str2 = strstr($rows->previewurl, 'components');

                    if ($str2 != "") {
                        $previewimage = JURI::base() . $rows->previewurl;
                        $timage = JURI::base() . $rows->thumburl;
                    } else {
                        $previewimage = $rows->previewurl;
                        $timage = $rows->thumburl;
                    }
                    $hd_bol = "false";
                    $hdvideo = "";
                }
                ## Get streaming option
                if ($rows->streameroption == "lighttpd") {
                    $streamername = $rows->streameroption;
                }
                ## Get RTMP path
                if ($rows->streameroption == "rtmp") {
                    $streamername = $rows->streamerpath;
                }
                ## Get subtitles
                $subtitle1 = $rows->subtitle1;
                $subtitle2 = $rows->subtitle2;
                $subtitle_path = JURI::base() . $current_path;
                if(!empty($subtitle1) && !empty($subtitle2)){
                    $subtitle = $subtitle_path.$subtitle1.','.$subtitle_path.$subtitle2;
                } else if(!empty($subtitle1)){
                    $subtitle = $subtitle_path.$subtitle1;
                } else if(!empty($subtitle2)){
                    $subtitle = $subtitle_path.$subtitle2;
                }
                
                ## Get post roll ad id for video
                $query_postads          = "SELECT * FROM #__hdflv_ads WHERE published=1 AND id=$rows->postrollid"; 
                $db->setQuery($query_postads);
                $rs_postads             = $db->loadObjectList();
                $postroll               = ' allow_postroll = "false"';
                $postroll_id            = ' postroll_id = "0"';
                if (count($rs_postads) > 0) {
                    if ($rows->postrollads == 1) {
                        $postroll       = ' allow_postroll = "true"';
                        $postroll_id    = ' postroll_id = "'.$rows->postrollid.'"';
                    }
                }
                
                ## Get pre roll ad id for video
                $query_preads           = "SELECT * FROM #__hdflv_ads WHERE published=1 AND id=$rows->prerollid";
                $db->setQuery($query_preads);
                $rs_preads              = $db->loadObjectList();
                $preroll                = ' allow_preroll = "false"';
                $preroll_id             = ' preroll_id = "0"';
                if (count($rs_preads) > 0) {
                    if ($rows->prerollads == 1) {
                        $preroll        = ' allow_preroll = "true"';
                        $preroll_id     = ' preroll_id = "'.$rows->prerollid.'"';
                    }
                }
                
                ## Get mid ad id for video
                $query_ads              = "SELECT * FROM #__hdflv_ads WHERE published=1 AND typeofadd='mid' "; 
                $db->setQuery($query_ads);
                $rs_ads                 = $db->loadObjectList();
                $midroll                = ' allow_midroll = "false"';
                if (count($rs_ads) > 0) {
                    if ($rows->midrollads == 1) {
                        $midroll        = ' allow_midroll = "true"';
                    }
                }
                
                ## Get ima ad for video
                $query_imaads           = "SELECT * FROM #__hdflv_ads WHERE published=1 AND typeofadd='ima' "; 
                $db->setQuery($query_imaads);
                $rs_imaads                 = $db->loadObjectList();
                $imaad                  = ' allow_ima = "false"';
                if (count($rs_imaads) > 0) {
                    if ($rows->imaads == 1) {
                        $imaad          = ' allow_ima = "true"';
                    }
                }
                                
                ## Get download option for particular video
                if ($rows->download == 1) {
                    $download = "true";
                }

                ## Video restriction based on access level starts here
                if (version_compare(JVERSION, '1.6.0', 'ge')) {
                    $member = "false";
                    foreach ($accessLevel as $useracess) {
                        if (in_array("$useracess", $accessid) || $useracess == 1) {
                            $member = "true";
                            break;
                        }
                    }
                } else {
                    if ($rows->useraccess != 0) {
                        if ($accessid != $rows->useraccess && $accessid != 2) {
                            $member = "false";
                        }
                    }
                }
                ## Video restriction based on access level ends here
                
                $categoryQuery  = "SELECT seo_category FROM #__hdflv_category WHERE id=$rows->playlistid";
                $db->setQuery($categoryQuery);
                $seo_category   = $db->loadResult();                      ## Get seo category title
                
                $settingQuery   = "SELECT dispenable FROM #__hdflv_site_settings";
                $db->setQuery($settingQuery);
                $resultSetting  = $db->loadResult();
                $dispenable      = unserialize($resultSetting);
                if ($dispenable['seo_option'] == 1) {               ## If seo option enabled
                    $fbCategoryVal = "category=" . $seo_category;
                    $fbVideoVal = "video=" . $rows->seotitle;
                } else {                                                ## If seo option disabled
                    $fbCategoryVal = "catid=" . $rows->playlistid;
                    $fbVideoVal = "id=" . $rows->id;
                }

                ## Genearte Base URL
                $baseUrl = JURI::base();
                $baseUrl1 = parse_url($baseUrl);
                $baseUrl1 = $baseUrl1['scheme'] . '://' . $baseUrl1['host'];

                ## Generate URL for every video
                $fbPath = $baseUrl1 . JRoute::_('index.php?option=com_contushdvideoshare&view=player&' . $fbCategoryVal . '&' . $fbVideoVal);

                if ($rows->targeturl != "") {
                    $targeturl = $rows->targeturl;                                  ## Get target url for a video
                }
                if ($rows->postrollads == "1") {
                    $postrollid = $rows->postrollid;                                ## Get pre roll id for a video
                }
                if ($rows->prerollads == "1") {
                    $prerollid = $rows->prerollid;                                  ## Get post roll id for a video
                }
                $title          = $rows->title;                                     ## Get title of the video
                $rate           = $rows->rate;                                      ## Get rate amount of the video
                $ratecount      = $rows->ratecount;                                 ## Get rate count of the video
                $views          = $rows->times_viewed;                              ## Get view count of the video
                $date           = date("m-d-Y", strtotime($rows->created_date));    ## Get video creation date
                $tags           = $rows->tags;                                      ## Get tag name for video
                $video_id       = $rows->id;                                        ## Get video ID
                $playlist_id    = $rows->playlistid;                                ## Get playlist ID
                $description    = $rows->description;                               ## Get video Description
                
                if ($rows->filepath == "Youtube" || $rows->filepath == "Url") {
                    $download   = "false";                                          ## Display download option for youtube videos
                }
                
                if ($streamername != ""){
                    if ($rows->islive == 1) {
                        $islive = "true";                                           ## Check for RTMP video is live one or not
                    }
                }
                
                ## Restrict playxml for vimeo videos.
                if (!preg_match('/vimeo/', $video)) {
                    
                    echo    '<mainvideo member="' . $member . '" uid="'.$uid.'" subtitle ="'.$subtitle.'"
                                views="' . $views . '"
                                streamer_path="' . $streamername . '"
                                video_isLive="' . $islive . '"
                                video_id = "' . htmlspecialchars($video_id) . '"
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
                                <title><![CDATA[' . htmlspecialchars($title) . ']]></title>
                                <tagline targeturl="' . $targeturl . '"><![CDATA[' . strip_tags($description) . ']]></tagline>
                            </mainvideo>';
                }
            }
        }
        echo '</playlist>';
        exit();
    }
}