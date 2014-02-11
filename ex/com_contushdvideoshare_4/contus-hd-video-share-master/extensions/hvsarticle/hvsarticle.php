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
defined('_JEXEC') or die('Access Denied!');
jimport('joomla.plugin.plugin');

class plgContenthvsarticle extends JPlugin {

    function plgContenthvsarticle(&$subject, $config) {

        parent::__construct($subject, $config);
    }

    function onContentPrepare($context, &$article, &$params, $page=0) {
        $this->onPrepareContent($article, $params, $page);
    }

    function onPrepareContent(&$row, &$params, $limitstart) {
        $thumImg = $videos = $filepath = NULL;
        $db = JFactory::getDBO();

        ## Declare the variables
        $category = '';
        $type = '';

        $patterncode = '/\[hdvs(.*?)]/i';
        preg_match_all($patterncode, $row->text, $matches);

        $code = $matches[0];
        $count = count($code);

        for ($i = 0; $i < $count; $i++) {

            $string = $code[$i];
            $pattern = array("[", "]", "hdvs");
            $shortCode = str_replace($pattern, "", $string);
            $shortCode = trim(strip_tags($shortCode));
            $shortCode = iconv('utf-8', 'ascii//translit', $shortCode);
            $shortCode = preg_replace("/\s+/", "|", $shortCode);
            $finalCode = explode("|", trim($shortCode, "|"));
            $pwidth = $pheight = $pautoplay = $playautoplay = $idval = $swidth = $sheight = $sautoplay = $splayautoplay = $categoryid = NULL;
            foreach ($finalCode as $val) {

                $data = explode("=", $val);

                ##  To get the video details from the shortcode
                if ($data[0] == 'videoid') {
                    $idval = $data[1];
                } else if ($data[0] == 'width') {
                    $swidth = $data[1];
                } else if ($data[0] == 'height') {
                    $sheight = $data[1];
                } else if ($data[0] == 'autoplay') {
                    $sautoplay = $data[1];
                } else if ($data[0] == 'playlistautoplay') {
                    $splayautoplay = $data[1];
                } else if ($data[0] == 'categoryid') {
                    $categoryid = $data[1];
                } else if ($data[0] == 'type') {
                    $type = $data[1];
                }
            }

        if ($categoryid != '' || $idval != '' || $type!='') {
            ## Get the video details from the database using id
            if ($categoryid != '' && $idval != '') {

                $query = 'SELECT streamerpath,streameroption,filepath,videourl,thumburl,embedcode FROM #__hdflv_upload WHERE id=' . $idval . ' and playlistid=' . $categoryid;
                $db->setQuery($query);
                $field = $db->loadObjectList();
            }else if ($categoryid != '') {

                $query = 'SELECT streamerpath,streameroption,id,filepath,videourl,thumburl,embedcode FROM #__hdflv_upload WHERE playlistid=' . $categoryid;
                $db->setQuery($query);
                $field = $db->loadObjectList();
                if (!empty($field))
                $idval = $field[0]->id;
            }else if ($idval != '') {

                $query = 'SELECT streamerpath,streameroption,filepath,videourl,thumburl,embedcode FROM #__hdflv_upload WHERE id=' . $idval;
                $db->setQuery($query);
                $field = $db->loadObjectList();
            }else if ($type != '') {
                $order = $query_type = NULL;
                switch ($type) {
                    case 'rec':
                        $order = " ORDER BY a.id DESC ";
                        break;
                    case 'fea':
                        $query_type = " AND a.featured=1 ";
                        break;
                    case 'pop':
                         $order = " ORDER BY a.times_viewed DESC ";
                        break;
            }
                $query = "SELECT a.streamerpath,a.streameroption,a.filepath,a.videourl,a.thumburl,a.embedcode  "
                . "FROM #__hdflv_upload a "
                . "LEFT JOIN #__users d ON a.memberid=d.id "
                . "LEFT JOIN #__hdflv_video_category e ON e.vid=a.id "
                . "LEFT JOIN #__hdflv_category b ON e.catid=b.id "
                . "WHERE a.published='1' AND b.published='1' $query_type AND a.type='0'"
                . " GROUP BY e.vid "
                . $order;
                $db->setQuery($query);
                $field = $db->loadObjectList();
            }

            if (!empty($field)) {
                $filepath = $field[0]->filepath;
                $streameroption = $field[0]->streameroption;
                $streamerpath = $field[0]->streamerpath;

                ## If file option File or FFMpeg then, below fetch will work for Video & Thumb URL
                if ($filepath == "File" || $filepath == "FFmpeg" || $filepath == "Embed") {
                    $current_path = "components/com_contushdvideoshare/videos/";
                    if ($filepath == "File" || $filepath == "FFmpeg") {
                        $videos = JURI::base() . $current_path . $field[0]->videourl;
                    } else {
                        $videos = $field[0]->embedcode;
                    }
                    $thumImg = JURI::base() . $current_path . $field[0]->thumburl;
                }
                ## If file option Youtube then, below fetch will work for Video & Thumb URL
                elseif ($filepath == "Youtube") {
                    $videos = $field[0]->videourl;
                    $thumImg = $field[0]->thumburl;
                }
                elseif ($filepath == "Url") {
                    if($streameroption == 'rtmp'){
                          $rtmp = str_replace('rtmp','http',$streamerpath);
                          $videos = $rtmp.'_definst_/mp4:'.$field[0]->videourl.'/playlist.m3u8';
                      }else{
                    $videos = $field[0]->videourl;
                      }
                    $thumImg = $field[0]->thumburl;
                }
            }


            ## Fetch the height and width from the default settings
            $qry_settings                   = "SELECT player_icons,player_values FROM #__hdflv_player_settings LIMIT 1";
            $db->setQuery($qry_settings);
            $rs_settings                    = $db->loadObject();
            $player_icons                   = unserialize($rs_settings->player_icons);
            $player_values                   = unserialize($rs_settings->player_values);
        
            if ($player_icons['playlist_autoplay'] == 1) {
                $playautoplay = "true";
            } else {
                $playautoplay = 'false';
            }
 
            ## Fetch Width, Height param Values
            $plugin             = JPluginHelper::getPlugin('content', 'hvsarticle');

            if(!empty($plugin)){
            $plgParams          = json_decode($plugin->params);
            if(!empty($plgParams)){
            $pheight            = $plgParams->height;
            $pwidth             = $plgParams->width;
            $pautoplay          = $plgParams->autoplay;
            $playautoplay       = $plgParams->playautoplay;
            }
            }
            ## To assign the width
            if ($swidth != "") {
                $width          = $swidth;
            } else if ($pwidth != "") {
                $width          = $pwidth;
            } else {
                $width          = $player_values['width'];
            }
            ## To assign the height
            if ($sheight != "") {
                $height = $sheight;
            } else if ($pheight != "") {
                $height = $pheight;
            } else {
                $height = $player_values['height'];
            }
            ## To assign the autoplay
            if ($sautoplay != "") {
                $autoplay = $sautoplay;
            } else if ($pautoplay != "" && $pautoplay != "select") {
                $autoplay = $pautoplay;
            } else {
                if($player_icons['autoplay']==1)
                $autoplay = "true";
                else
                $autoplay = "false";
            }
            ## To assign the playlist autoplay
            if ($splayautoplay != "") {
                $playautoplay = $splayautoplay;
            } else if ($playautoplay != ""  && $playautoplay != "select") {
                $playautoplay = $playautoplay;
            }

            $replace = $this->addVideoHdvideo($width, $height, $idval, $categoryid, $autoplay, $filepath, $videos, $thumImg, $type, $playautoplay);
            $row->text = str_replace($string, $replace, $row->text);
        }
    }
    }

    function getthetype($shortcode) {

        switch (true) {

            case (strstr($shortcode, 'pop')):
                $type = 'pop';
                break;

            case (strstr($shortcode, 'rec')):
                $type = 'rec';
                break;

            case (strstr($shortcode, 'fea')):
                $type = 'fea';
                break;

            default:
                $type = '';
                break;
        }

        return $type;
    }

    function removesextraspace($str1) {
        $str2 = trim(str_replace("]", "", (trim($str1))));
        return $str2;
    }

    ## Function for loading player with necessary inputs
    function addVideoHdvideo($width, $height, $idval, $categoryid, $autoplay, $filepath, $videos, $thumImg, $type, $playautoplay) {

        ## Variables initialization
        $playlist_auto  = $category = $playxml = $replace = $windo = '';
        $baseurl        = JURI::base();
        $baseurl1       = substr_replace($baseurl, "", -1);
        $idval          = trim($idval);
        $playerpath     = JURI::base() . 'components/com_contushdvideoshare/hdflvplayer/hdplayer.swf';
        $useragent      = $_SERVER['HTTP_USER_AGENT'];
        ## Check for windows phone
        if(strpos($useragent,'Windows Phone') > 0){
        $windo='Windows Phone';
        }
        
        if ($type) {
            if (version_compare(JVERSION, '3.0', 'ge') || version_compare(JVERSION, '1.6', 'ge') || version_compare(JVERSION, '1.7', 'ge') || version_compare(JVERSION, '2.5', 'ge')){
                    $playlistpath = JURI::base() . "plugins/content/hvsarticle/playlist.php?type=" . $type;
            } else {
                    $playlistpath = JURI::base() . "plugins/content/playlist.php?type=" . $type;
            }
            $playxml        = "&amp;playlistXML=" . $playlistpath;
        }

        if (!empty($idval) && !empty($categoryid) ) {
            $video_params   = "&amp;id=".$idval."&amp;catid=" . $categoryid;
        } else if (!empty($categoryid)) {
            $video_params   = "&amp;catid=" . $categoryid;
        }else{
            $video_params   = "&amp;id=".$idval;
        }

        if ($playautoplay) {
            $playlist_auto  = "&amp;playlist_autoplay=" . $playautoplay;
        }

        $replace        = '<div id="pluginvideoshare-flashplayer'.$type . $idval . '">';

        if ($filepath == "Embed") {
            $replace   .= $videos;
        }
        ## Checks for Vimeo Player
        else if (strpos($videos,'vimeo') > 0) {
            $split      = explode("/", $videos);
            $replace   .= '<iframe src="http://player.vimeo.com/video/' . $split[3] . '?title=0&amp;byline=0&amp;portrait=0" width="' . $width . '" height="' . $height . '" frameborder="0"></iframe>';
        }
        ## Else normal player
        else {
            $replace   .= '<div class="videoshareplayer" id="videoshareplayer" style="width:' . $width . 'px;height:' . $height . 'px;" >'
                       . '<embed src="' . $playerpath . '" allowFullScreen="true"  allowScriptAccess="always" type="application/x-shockwave-flash" wmode="opaque" flashvars="baserefJHDV=' . $baseurl1 . $playxml . $video_params . $playlist_auto . '&amp;mid=1&amp;mtype=playerModule&amp;autoplay=' . $autoplay . '" style="width:' . $width . 'px;height:' . $height . 'px;" /></embed>'
                       . '</div></div>';
        }

        ## HTML5 PLAYER START
        $replace       .= '<div id="pluginvideoshare-html5player' .$type. $idval . '" style="display:none;">';

        ## Checks for File or FFMpeg
        if ($filepath == "File" || $filepath == "FFmpeg" || $filepath == "Url") {
            $replace   .='<video id="video" poster="' . $thumImg . '" src="' . $videos . '" autobuffer controls onerror="failed(event)">
                       Html5 Not support This video Format.
                       </video>';
        }

        ## Checks for Youtube, Viddle and Dailymotion videos
        elseif ($filepath == "Youtube") {
            if (preg_match('/www\.youtube\.com\/watch\?v=[^&]+/', $videos, $vresult)) {
                $urlArray   = explode("=", $vresult[0]);
                $videoid    = trim($urlArray[1]);
                $video      = "http://www.youtube.com/embed/$videoid";
                $replace    .='<iframe src="'.$video.'" class="iframe_frameborder" ></iframe>';
            } else if(strpos($videos,'dailymotion') > 0)
            {
                $video      = $videos;
                $replace   .='<iframe src="'.$video.'" class="iframe_frameborder" ></iframe>';
            } else if(strpos($videos,'viddler') > 0){
                 $imgstr    = explode("/", $videos);
                 $replace  .='<iframe id="viddler-'.$imgstr.'" src="//www.viddler.com/embed/'.$imgstr.'/?f=1&autoplay=0&player=full&secret=26392356&loop=false&nologo=false&hd=false" frameborder="0" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>';
            }
        }
        $replace .='</div><script>
            var txt     =  navigator.platform ;
            var windo   = "'.$windo.'";
            if(txt =="iPod" || txt =="iPad" || txt =="iPhone" || windo=="Windows Phone"  || txt =="Linux armv7l" || txt =="Linux armv6l" )
            {
               document.getElementById("pluginvideoshare-html5player'.$type . $idval . '").style.display = "block";
               document.getElementById("pluginvideoshare-flashplayer'.$type . $idval . '").style.display = "none";

            }else{
              document.getElementById("pluginvideoshare-html5player'.$type . $idval . '").style.display = "none";
            }
            function failed(e) {
                if(txt =="iPod" || txt =="iPad" || txt =="iPhone" || windo=="Windows Phone"  || txt =="Linux armv7l" || txt =="Linux armv6l")
                {
                    alert("Player doesnot support this video.");
                }
 	    }
        </script>';
        ## HTML5 PLAYER  END

        return $replace;
    }
}
?>