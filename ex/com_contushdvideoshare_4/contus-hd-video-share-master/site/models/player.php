<?php
/**
 * @name          : Joomla HD Video Share
 * @version	  : 3.4.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component Player Model
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */
## No direct acesss
defined('_JEXEC') or die('Restricted access');
##  import Joomla model library
jimport('joomla.application.component.model');

## Contushdvideoshare Component Player Model

class Modelcontushdvideoshareplayer extends ContushdvideoshareModel {

    ## function to get video id
    function getVideoId($video) {
        $db             = JFactory::getDBO();
        if (!version_compare(JVERSION, '3.0.0', 'ge')) {
            $video      = $db->getEscaped($video);
        }
        $query          = 'SELECT id,playlistid,videourl
                        FROM #__hdflv_upload 
                        WHERE seotitle="' . $video . '"';
        $db->setQuery($query);
        $videodetails   = $db->loadObject();
        return $videodetails;
    }

    ## function to get video id 
    function getVideoCatId($video, $category) {
        $db             = JFactory::getDBO();
        if (!version_compare(JVERSION, '3.0.0', 'ge')) {
            $video      = $db->getEscaped($video);
        }
        $adminview      = JRequest::getString('adminview');
        if ($adminview == true) {
            $publish    = '';
        } else {
            $publish    = 'a.published=1 AND';
        }
        $query          = "SELECT a.id,a.playlistid,a.videourl
                        FROM #__hdflv_upload a
                        LEFT JOIN #__hdflv_video_category e ON e.vid=a.id
                        LEFT JOIN #__hdflv_category b ON e.catid=b.id
                        WHERE $publish b.published='1' AND a.seotitle='" . $video . "' AND b.seo_category='" . $category . "'";
        $db->setQuery($query);
        $videodetails   = $db->loadObject();
        return $videodetails;
    }

    ## function to get featured videos 
    function getfeatured() {
        $db             = JFactory::getDBO();
        $adminview      = JRequest::getString('adminview');
        if ($adminview == true) {
            $publish    = '';
        } else {
            $publish    = 'published=1 AND';
        }
        $query          = 'SELECT id FROM #__hdflv_upload
                        WHERE ' . $publish . ' featured="1" AND type="0" 
                        ORDER BY ordering ASC';
        $db->setQuery($query);
        $feavideo = $db->loadObject();
        return $feavideo;
    }

    ## function to get video details for video id 
    function getVideodetail($video) {
        $db             = JFactory::getDBO();
        if (!version_compare(JVERSION, '3.0.0', 'ge')) {
            $video      = $db->getEscaped($video);
        }
        $query          = 'SELECT id,playlistid,videourl
                        FROM #__hdflv_upload 
                        WHERE id="' . $video . '"';
        $db->setQuery($query);
        $videodetails   = $db->loadObject();
        return $videodetails;
    }

    ## function to get videodetails and show dh player 
    function showhdplayer($videoid) {
        $playid         = $thumbid = $start = $total = 0;
        $db             = JFactory::getDBO();
        $length         = $pageno = 1;
        $hd_bol         = "false";
        
        $query          = "SELECT player_values,logopath,player_icons FROM #__hdflv_player_settings";
        $db->setQuery($query);
        $settingsrows   = $db->loadObjectList();
        $player_values  = unserialize($settingsrows[0]->player_values);
        if ($videoid){
            $playid     = $videoid;
        }
        $query_all_count = "SELECT count(id) FROM #__hdflv_upload WHERE published='1' ORDER BY id desc ";
        $db->setQuery($query_all_count);
        $rs_count       = $db->loadResult();
        
        if ($rs_count > 0){
            $total      = $rs_count;
        }
        if (JRequest::getVar('page', '', 'post', 'string')) {
            $pageno     = JRequest::getVar('page', '', 'post', 'string');
            $_SESSION['commentappendpageno'] = $pageno;
        }
        if ($player_values['nrelated'] != ""){
            $length     = $player_values['nrelated'];
        } else {
            $length = 4;
        }

        if ($length == 0){
            $length = 1;
        }

        if ($pageno == 1){
            $start = 0;
        } else {
            $start = ($pageno - 1) * $length;
        }
        
        $current_path   = "components/com_contushdvideoshare/images/";
        $videoquery     = "select * from #__hdflv_upload where published='1'";
        $db->setQuery($videoquery);
        $rows           = $db->loadObjectList();
        $hdvideo        = false;
        if (isset($rows[0]->id)){
            $thumbid    = $rows[0]->id;
        }

        if (count($rows) > 0) {
            if ($rows[0]->filepath == "File" || $rows[0]->filepath == "FFmpeg") {
                $video          = JURI::base() . $current_path . $rows[0]->videourl;
                ($rows[0]->hdurl != "") ? $hdvideo = JURI::base() . $current_path . $rows[0]->hdurl : $hdvideo = "";
                $previewimage   = JURI::base() . $current_path . $rows[0]->previewurl;
                if ($rows[0]->hdurl){
                    $hd_bol =    "true";
                } else {
                    $hd_bol     = "false";
                }
            } elseif ($rows[0]->filepath == "Url") {
                $video          = $rows[0]->videourl;
                $previewimage   = $rows[0]->previewurl;
                if ($rows[0]->hdurl){
                    $hd_bol     = "true";
                } else {
                    $hd_bol     = "false";
                }
                $hdvideo        = $rows[0]->hdurl;
            } elseif ($rows[0]->filepath == "Youtube") {
                $video          = $rows[0]->videourl;
                $previewimage   = $rows[0]->previewurl;
                if ($rows[0]->hdurl){
                    $hd_bol     = "true";
                } else {
                    $hd_bol     = "false";
                }
                $hdvideo        = $rows[0]->videourl;
            }
            $playid             = $rows[0]->id;
        }
        $relatedvideo_query     = "SELECT * FROM #__hdflv_upload WHERE published='1' AND id NOT IN ($playid) ORDER BY ordering asc LIMIT $start,$length ";
        $db->setQuery($relatedvideo_query);
        $rs_playlist            = $db->loadobjectList();
        
        $playerpath             = JURI::base() . 'components/com_contushdvideoshare/hdflvplayer/hdplayer.swf';
        $base_url               = str_replace(':', '%3A', JURI::base());
        $url_base               = substr_replace($base_url, "", -1);
        $baseurl                = str_replace('/', '%2F', $url_base);
        
        $ad_query               = "SELECT * FROM #__hdflv_googlead WHERE publish='1' AND id='1'";
        $db->setQuery($ad_query);
        $fields                 = $db->loadObjectList();
        if (isset($fields[0]->publish)){
            $insert_data_array = array('playerpath' => $playerpath, 'baseurl' => $baseurl, 'thumbid' => $thumbid, 'rs_playlist' => $rs_playlist, 'length' => $length, 'total' => $total, 'closeadd' => $fields[0]->closeadd, 'reopenadd' => $fields[0]->reopenadd, 'ropen' => $fields[0]->ropen, 'publish' => $fields[0]->publish, 'showaddc' => $fields[0]->showaddc);
        } else {
            $insert_data_array = array('playerpath' => $playerpath, 'baseurl' => $baseurl, 'thumbid' => $thumbid, 'rs_playlist' => $rs_playlist, 'length' => $length, 'total' => $total);
        }
        $merged_result         = array_merge($settingsrows, $insert_data_array);
        return $merged_result;
    }

    ## function for rating calculation 
    function ratting($videoid) {
        $db             = $this->getDBO();
        if ($videoid){
            $id         = $videoid;
        } else {
            $query      = "SELECT a.*,b.category,d.username,e.*
                        FROM  #__hdflv_upload a 
                        LEFT JOIN #__users d ON a.memberid=d.id 
                        LEFT JOIN #__hdflv_video_category e ON e.vid=a.id 
                        LEFT JOIN #__hdflv_category b ON e.catid=b.id 
                        WHERE a.published='1' AND a.featured='1' AND a.type='0' 
                        GROUP BY e.vid 
                        ORDER BY a.ordering ASC"; ##  Query is to display recent videos in home page
            $db->setQuery($query);
            $rs_video   = $db->loadObjectList();
            if (isset($rs_video[0]) && $rs_video[0] != ''){
                $id     = $rs_video[0]->id;
            } else {
                $id     = '';
            }
        }
        if (version_compare(JVERSION, '3.0.0', 'ge')) {
            $get_rate   = JRequest::getVar('rate');
        } else {
            $get_rate   = JRequest::getVar('rate', '', 'get', 'int');
        }
        if ($get_rate) {
            $query      = "UPDATE #__hdflv_upload
                        SET rate=" . $get_rate . "+rate,ratecount=1+ratecount
                        WHERE id=$id";
            $db->setQuery($query);
            $db->query();
            $query      = "SELECT ratecount FROM #__hdflv_upload WHERE id=$id";
            $db->setQuery($query);
            $ratings    = $db->loadResult();
            echo $ratings;
            exit;
        }
        if ($id != '') {
            ## Get Views counting 
            $titlequery = "SELECT a.times_viewed,a.rate,a.ratecount,a.memberid,b.username
                        FROM #__hdflv_upload a 
                        LEFT JOIN #__users b on a.memberid=b.id WHERE a.id=$id"; ## This query is to display the title and times of views in the video page
            $db->setQuery($titlequery);
            $commenttitle = $db->loadObjectList();
            return $commenttitle;
        }
    }

    ## function to display comments 
    function displaycomments($videoid) {
        if ($videoid) {
            $commenttitle       = array();
            $db                 = $this->getDBO();
            $id                 = $videoid;
            $pageno             = 1;
            $length             = 10;
            if (JRequest::getVar('name', '', 'get', 'string') && JRequest::getVar('message', '', 'get', 'string')) {
                $parentid       = JRequest::getVar('pid', '', 'get', 'int'); ## Getting the parent id value
                $name           = JRequest::getVar('name', '', 'get', 'string'); ##  Getting the name who is posting the comments
                $message        = JRequest::getVar('message', '', 'get', 'string'); ##  Getting the message
                if (strlen($message) > 500) {
                    $message    = JHTML::_('string.truncate', ($message), 500);
                }
                if (!version_compare(JVERSION, '3.0.0', 'ge')) {
                    $name       = $db->getEscaped($name);
                    $message    = $db->getEscaped($message);
                }
                $message        = $db->quote($message);
                ##  insert query to post a new comment for a particular video
                $commentquery   = "INSERT INTO #__hdflv_comments(parentid,videoid,name,message,published) VALUES ('$parentid','$id','$name',$message,'1')";
                $db->setQuery($commentquery);
                $db->query();
            }
            ## Following code is to display the title and times of views for a particular video 
            $titlequery         = "SELECT a.title,a.description,a.times_viewed,a.memberid,b.username
                                FROM #__hdflv_upload a 
                                LEFT JOIN #__users b ON a.memberid=b.id 
                                WHERE a.id=$id"; ## This query is to display the title and times of views in the video page
            $db->setQuery($titlequery);
            $commenttitle       = $db->loadObjectList();

            ##  Query is to get the pagination value for comments display
            $commenttotalquery  = "SELECT count(id)
                                FROM #__hdflv_comments 
                                WHERE published=1 AND videoid=$id";
            $db->setQuery($commenttotalquery);
            $total              = $db->loadResult();
            
            if (JRequest::getVar('page', '', 'post', 'int')) {
                $pageno         = JRequest::getVar('page', '', 'post', 'int');
            }
            $pages              = ceil($total / $length);
            if ($pageno == 1) {
                $start          = 0;
            } else {
                $start          = ( $pageno - 1) * $length;
            }
            $commentscount      = "SELECT id AS number,id,parentid,videoid,subject,name,created,message
                                FROM #__hdflv_comments 
                                WHERE parentid = 0 AND published=1 AND videoid=$id UNION 
                                SELECT parentid AS number,id,parentid,videoid,subject,name,created,message 
                                FROM #__hdflv_comments 
                                WHERE parentid !=0 AND published=1 AND videoid=$id 
                                ORDER BY number DESC,parentid "; ##  Query is to display the comments posted for particular video
            $db->setQuery($commentscount);
            $rowscount          = $db->loadObjectList();
            $totalcomment       = count($rowscount);
            $comments           = "SELECT id AS number,id,parentid,videoid,subject,name,created,message
                                FROM #__hdflv_comments 
                                WHERE parentid = 0 AND published=1 AND videoid=$id UNION 
                                SELECT parentid as number,id,parentid,videoid,subject,name,created,message 
                                FROM #__hdflv_comments 
                                WHERE parentid !=0 AND published=1 AND videoid=$id 
                                ORDER BY number DESC,parentid LIMIT $start,$length"; ##  Query is to display the comments posted for particular video
            $db->setQuery($comments);
            $rows               = $db->loadObjectList();
            ##  Below code is to merge the pagination values like pageno,pages,start value,length value
            $insert_data_array = array('pageno' => $pageno);
            $commenttitle = array_merge($commenttitle, $insert_data_array);
            $insert_data_array = array('pages' => $pages);
            $commenttitle = array_merge($commenttitle, $insert_data_array);
            $insert_data_array = array('start' => $start);
            $commenttitle = array_merge($commenttitle, $insert_data_array);
            $insert_data_array = array('length' => $length);
            $commenttitle = array_merge($commenttitle, $insert_data_array);
            $insert_data_array = array('totalcomment' => $totalcomment);
            $commenttitle = array_merge($commenttitle, $insert_data_array);
            ##  merge code ends here
            return array($commenttitle, $rows);
        }
    }

    ## function to get home page videos 
    function gethomepagebottom() {
        $db             = $this->getDBO();
        ## function to get homa page video settings 
        $viewrow        = $this->gethomepagebottomsettings();
        $thumbview      = unserialize($viewrow[0]->homethumbview);
        $featurelimit   = $thumbview['homefeaturedvideorow'] * $thumbview['homefeaturedvideocol'];
        ## query to get featured videos 
        $featuredquery  = "SELECT a.*,b.category,b.seo_category,d.username,e.*
                        FROM #__hdflv_upload a 
                        LEFT JOIN #__users d ON a.memberid=d.id 
                        LEFT JOIN #__hdflv_video_category e ON e.vid=a.id 
                        LEFT JOIN #__hdflv_category b ON e.catid=b.id 
                        WHERE a.published='1' AND a.featured='1' AND b.published='1' AND a.type='0' AND d.block='0'
                        GROUP BY e.vid 
                        ORDER BY rand() 
                        LIMIT 0,$featurelimit ";                        ##  Query is to display featured videos in home page randomly
        $db->setQuery($featuredquery);
        $featuredvideos = $db->loadobjectList();                        ##  $featuredvideos contains the results
        $recentlimit    = $thumbview['homerecentvideorow'] * $thumbview['homerecentvideocol'];
        ## query to get recent videos 
        $recentquery    = "SELECT a.*,b.category,b.seo_category,d.username,e.*
                        FROM  #__hdflv_upload a 
                        LEFT JOIN #__users d ON a.memberid=d.id 
                        LEFT JOIN #__hdflv_video_category e ON e.vid=a.id 
                        LEFT JOIN #__hdflv_category b ON e.catid=b.id 
                        WHERE a.published='1' AND b.published='1' AND a.type='0' AND d.block='0' 
                        GROUP BY e.vid 
                        ORDER BY a.id DESC 
                        LIMIT 0,$recentlimit ";                         ##  Query is to display recent videos in home page
        $db->setQuery($recentquery);    
        $recentvideos   = $db->loadobjectList();                        ## $recentvideos contains the results
        $popularlimit   = $thumbview['homepopularvideorow'] * $thumbview['homepopularvideocol'];
        ## query to get popular videos 
        $popularquery   = "SELECT a.*,b.category,b.seo_category,d.username,e.*
                    FROM #__hdflv_upload a 
                    LEFT JOIN #__users d ON a.memberid=d.id 
                    LEFT JOIN #__hdflv_video_category e ON e.vid=a.id 
                    LEFT JOIN #__hdflv_category b ON e.catid=b.id 
                    WHERE a.published='1' AND b.published='1' AND a.type='0' AND d.block='0' 
                    GROUP BY e.vid 
                    ORDER BY a.times_viewed DESC 
                    LIMIT 0,$popularlimit";                             ## Query is to display popular videos in home page
        $db->setQuery($popularquery);
        $popularvideos  = $db->loadobjectList();                        ## $popularvideos contains the results
        return array($featuredvideos, $recentvideos, $popularvideos);   ##  Merging the featured,recent,popular videos results
    }

    ## Function to get home page bottom settings 
    function gethomepagebottomsettings() {
        $db                         = $this->getDBO();
        ## Query is to select the home page botom videos settings
        $homepagebottomsettings     = "SELECT dispenable,homethumbview FROM #__hdflv_site_settings";
        $db->setQuery($homepagebottomsettings);
        $rows                       = $db->LoadObjectList();
        return $rows;
    }

    ## function to get html video details 
    function getHTMLVideoDetails($videoId) {

        $adminview      = JRequest::getString('adminview');
        if ($adminview == true) {
            $publish    = '';
        } else {
            $publish    = 'a.published=1 AND';
        }
        if (isset($videoId) && $videoId != '') {
            $condition  = $publish . ' b.published=1 AND a.id=' . $videoId . ' ORDER BY a.ordering ASC';
        } else {
            $condition  = 'a.featured=1 AND ' . $publish . ' b.published=1 AND a.type=0 GROUP BY e.vid ORDER BY a.ordering ASC LIMIT 1';
        }
        $db             = $this->getDBO();
        $query          = "SELECT a.* FROM #__hdflv_upload a 
                        LEFT JOIN #__hdflv_video_category e ON e.vid=a.id
                        LEFT JOIN #__hdflv_category b ON e.catid=b.id WHERE " . $condition; ## Query is to select the popular videos row
        $db->setQuery($query);
        $rows           = $db->LoadObject();

        if (empty($videoId)) {
            if (count($rows) == 0) {
                $query  = "SELECT a.*,b.category,d.username,e.*
                        FROM  #__hdflv_upload a
                        LEFT JOIN #__users d ON a.memberid=d.id
                        LEFT JOIN #__hdflv_video_category e ON e.vid=a.id
                        LEFT JOIN #__hdflv_category b ON e.catid=b.id
                        WHERE $publish b.published='1' AND a.type='0'
                        GROUP BY e.vid
                        ORDER BY a.ordering ASC LIMIT 0,1"; ##  Query is to display recent videos in home page
                $db->setQuery($query);
                $rows   = $db->LoadObject();
            }
        }
        if (!empty($rows) && (((preg_match('/vimeo/', $rows->videourl)) && ($rows->videourl != '')) || $rows->filepath == 'Embed')) {
            $query = "UPDATE #__hdflv_upload SET times_viewed=1+times_viewed WHERE id=".$rows->id;
                        $db->setQuery($query);
                        $db->query();
        }
                        
        return $rows;
    }

    ## function to get html video access level 
    function getHTMLVideoAccessLevel() {
        $db             = JFactory::getDBO();
        $user           = JFactory::getUser();
        if (version_compare(JVERSION, '1.6.0', 'ge')) {
            $uid        = $user->get('id');
            if ($uid) {
                $db     = JFactory::getDBO();
                $query  = $db->getQuery(true);
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
        $videoid = 0;

        ## CODE FOR SEO OPTION OR NOT - START 
        $video      = JRequest::getVar('video');
        $id         = JRequest::getInt('id');
        $flagVideo  = is_numeric($video);
        if (isset($video) && $video != "") {
            if ($flagVideo != 1) {
                ##  joomla router replaced to : from - in query string
                $videoTitle     = JRequest::getString('video');
                $videoid        = str_replace(':', '-', $videoTitle);
                if ($videoid != "") {
                    $videoid    = $videoid;
                }
                $catidquery     = "SELECT DISTINCT a.*,b.category
                                FROM #__hdflv_upload a 
                                LEFT JOIN #__hdflv_category b ON a.playlistid=b.id OR a.playlistid=b.parent_id 
                                WHERE a.published='1' AND a.seotitle ='$videoid'";
                $db->setQuery($catidquery);
                $rowsVal        = $db->loadAssoc();
            } else {
                $videoid        = JRequest::getInt('video');
                $catidquery     = "SELECT distinct a.*,b.category
                                FROM #__hdflv_upload a
                                LEFT JOIN #__hdflv_category b ON a.playlistid=b.id OR a.playlistid=b.parent_id
                                WHERE a.published='1' AND a.id='$videoid'";
                $db->setQuery($catidquery);
                $rowsVal        = $db->loadAssoc();
            }
        } else if (isset($id) && $id != '') {
            $videoid            = JRequest::getInt('id');
            $catidquery         = "SELECT DISTINCT a.*,b.category
                                FROM #__hdflv_upload a 
                                LEFT JOIN #__hdflv_category b ON a.playlistid=b.id OR a.playlistid=b.parent_id
                                WHERE a.published='1' AND a.id='$videoid'";
            $db->setQuery($catidquery);
            $rowsVal            = $db->loadAssoc();
        }
        ## CODE FOR SEO OPTION OR NOT - END 
        else {
            $query              = "SELECT a.*,b.category,d.username,e.*
                                FROM  #__hdflv_upload a 
                                LEFT JOIN #__users d ON a.memberid=d.id 
                                LEFT JOIN #__hdflv_video_category e ON e.vid=a.id 
                                LEFT JOIN #__hdflv_category b ON e.catid=b.id 
                                WHERE a.published='1' AND b.published='1' AND a.featured='1' AND a.type='0' AND d.block='0' 
                                GROUP BY e.vid 
                                ORDER BY a.ordering ASC"; ##  Query is to display recent videos in home page
            $db->setQuery($query);
            $rowsVal            = $db->loadAssoc();
            if (count($rowsVal) == 0) {
                $query          = "SELECT a.*,b.category,d.username,e.*
                                FROM  #__hdflv_upload a 
                                LEFT JOIN #__users d ON a.memberid=d.id 
                                LEFT JOIN #__hdflv_video_category e ON e.vid=a.id 
                                LEFT JOIN #__hdflv_category b ON e.catid=b.id 
                                WHERE a.published='1' AND b.published='1' AND a.type='0' AND d.block='0'
                                GROUP BY e.vid 
                                ORDER BY a.ordering ASC 
                                LIMIT 0,1"; ##  Query is to display recent videos in home page
                $db->setQuery($query);
                $rowsVal        = $db->loadAssoc();
            }
        }
        if (count($rowsVal) > 0) {
            if (version_compare(JVERSION, '1.6.0', 'ge')) {
                $query          = $db->getQuery(true);
                if ($rowsVal['useraccess'] == 0) {
                    $rowsVal['useraccess'] = 1;
                }
                $query->select('rules as rule')
                        ->from('#__viewlevels AS view')
                        ->where('id = ' . (int) $rowsVal['useraccess']);
                $db->setQuery($query);
                $message        = $db->loadResult();
                $accessLevel    = json_decode($message);
            }
            $member             = "true";
            if (version_compare(JVERSION, '1.6.0', 'ge')) {
                $member = "false";
                foreach ($accessLevel as $useracess) {
                    if (in_array("$useracess", $accessid) || $useracess == 1) {
                        $member = "true";
                        break;
                    }
                }
            } else {
                if ($rowsVal['useraccess'] != 0) {
                    if ($accessid != $rowsVal['useraccess'] && $accessid != 2) {
                        $member = "false";
                    }
                }
            }
            return $member;
        }
    }

    ## function to get initial video details
    function initialPlayer() {
        $videoid            = 0;
        $db                 = JFactory::getDBO();
        if (JRequest::getvar('id', '', 'get', 'int') || JRequest::getVar('video', '', 'get', 'int')) {
            if (JRequest::getVar('video', '', 'get', 'int')) {
                $videoid    = JRequest::getVar('video', '', 'get', 'int');
            } else {
                $videoid    = JRequest::getvar('id', '', 'get', 'int');
            }
            if ($videoid != "") {
                $query      = "SELECT DISTINCT a.*,b.category FROM #__hdflv_upload a 
                            LEFT JOIN #__hdflv_category b ON a.playlistid=b.id OR a.playlistid=b.parent_id 
                            WHERE a.published='1' AND a.id=$videoid ";
                $db->setQuery($query);
                $rowsVal    = $db->loadAssoc();
            }
        } elseif (JRequest::getVar('video', '', 'get', 'string')) {
            $video_string   = JRequest::getVar('video', '', 'get', 'string');
            $video          = str_replace(':', '-', $video_string);
            $query          = 'SELECT DISTINCT a.*,b.category FROM #__hdflv_upload a 
                            LEFT JOIN #__hdflv_category b ON a.playlistid=b.id OR a.playlistid=b.parent_id 
                            WHERE a.published="1" AND seotitle="' . $video . '"';
            $db->setQuery($query);
            $rowsVal        = $db->loadAssoc();
        } else {
            $query          = "SELECT a.*,b.category,d.username,e.* FROM  #__hdflv_upload a 
                            LEFT JOIN #__users d ON a.memberid=d.id 
                            LEFT JOIN #__hdflv_video_category e ON e.vid=a.id 
                            LEFT JOIN #__hdflv_category b ON e.catid=b.id 
                            WHERE a.published='1' AND a.featured='1' AND a.type='0' 
                            GROUP BY e.vid ORDER BY a.ordering ASC"; ##  Query is to display recent videos in home page
            $db->setQuery($query);
            $rowsVal    = $db->loadAssoc();
            if (count($rowsVal) == 0) {
                $query      = "SELECT a.*,b.category,d.username,e.* FROM  #__hdflv_upload a 
                            LEFT JOIN #__users d ON a.memberid=d.id 
                            LEFT JOIN #__hdflv_video_category e ON e.vid=a.id 
                            LEFT JOIN #__hdflv_category b ON e.catid=b.id 
                            WHERE a.published='1' AND b.published='1' AND a.type='0' 
                            GROUP BY e.vid ORDER BY a.ordering ASC LIMIT 0,1"; ##  Query is to display recent videos in home page
                $db->setQuery($query);
                $rowsVal    = $db->loadAssoc();
            }
        }
        return $rowsVal;
    }
}