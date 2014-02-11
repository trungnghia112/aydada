<?php

/*
 * ********************************************************* */
/**
 * @name          : Joomla HD Video Share
 * @version	  : 3.4
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2012 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component Playxml Model
 * @Creation Date : March 2010
 * @Modified Date : May 2013
 * */
/*
 * ********************************************************* */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import joomla model library
jimport('joomla.application.component.model');

/**
 * Contushdvideoshare Component Playxml Model
 */
class Modelcontushdvideosharerss extends ContushdvideoshareModel {

    function playgetrecords() {
        $db = JFactory::getDBO();
        $type = JRequest::getvar('type', '', 'get', 'string');
        $orderby = '';
        switch ($type) {
            case 'popular' :
                 $orderby = " ORDER BY a.times_viewed desc";
                break;
            case 'recent' :
                $orderby = " ORDER BY a.id desc";
                break;
            case 'featured' :
                 $orderby = "  AND a.featured='1'";
                break;
            case 'category' :
                $playid = JRequest::getvar('catid', '', 'get', 'int');
                $orderby = "  AND a.playlistid='".$playid."'";
                break;
            default;
        }
        $query = "SELECT distinct a.*,b.category
                    FROM #__hdflv_upload a
                    LEFT JOIN #__hdflv_category b on a.playlistid=b.id
                    WHERE a.published='1' and b.published='1' $orderby";
        $db->setQuery($query);
        $rs_video = $db->loadObjectList();
        $this->showxml($rs_video);
    }

    function showxml($rs_video) {

        ob_clean();
        header("Cache-Control: no-cache, must-revalidate");
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("content-type: text/xml");
        echo '<?xml version="1.0" encoding="utf-8"?>';
        echo '<rss xmlns:content="http://purl.org/rss/1.0/modules/content/" version="2.0">';
        $config = JFactory::getConfig();
        $mainframe = JFactory::getApplication();

        if(version_compare(JVERSION, '3.0.0', 'ge')) {
            $siteName = $mainframe->getCfg('sitename');
        }else{
            $siteName = $config->getValue('config.sitename');
        }
        echo '<title>'.$siteName.'</title>';
        echo '<link>'.JURI::base().'</link>';

        $current_path = "components/com_contushdvideoshare/videos/";
        if (count($rs_video) > 0) {
            foreach ($rs_video as $rows) {
                $timage = "";
                if ($rows->filepath == "File" || $rows->filepath == "FFmpeg") {
                    if ($hddefault == 0 && $rows->hdurl != '') {
                        $video = '';
                    } else {
                        $video = JURI::base() . $current_path . $rows->videourl;
                    }
                    $video = JURI::base() . $current_path . $rows->videourl;
                    if (!empty($rows->previewurl))
                        $preview_image = $rows->previewurl;
                    else
                        $preview_image='default_preview.jpg';
                    $previewimage = JURI::base() . $current_path . $preview_image;
                    $timage = JURI::base() . $current_path . $rows->thumburl;
                }
                elseif ($rows->filepath == "Url") {
                    $video = $rows->videourl;

                    if (!empty($rows->previewurl))
                        $previewimage = $rows->previewurl;
                    else
                        $previewimage = JURI::base() . $current_path . 'default_preview.jpg';
                    $timage = $rows->thumburl;
                }
                elseif ($rows->filepath == "Youtube") {
                    $video = $rows->videourl;
                    $regexwidth = '/\components\/(.*?)/i';

                    $str2 = strstr($rows->previewurl, 'components');

                    if ($str2 != "") {
                        $previewimage = JURI::base() . $rows->previewurl;
                        $timage = JURI::base() . $rows->thumburl;
                    } else {
                        $previewimage = $rows->previewurl;
                        $timage = $rows->thumburl;
                    }
                    $hd_bol = "false";
                }
                $db = JFactory::getDBO();
                $settingQuery="select dispenable from #__hdflv_site_settings";
                $db->setQuery($settingQuery);
                $resultSetting = $db->loadResult();
                $dispenable      = unserialize($resultSetting);
                $categoryQuery="select seo_category from #__hdflv_category WHERE id=$rows->playlistid";
                $db->setQuery($categoryQuery);
                $categorySeo = $db->loadObjectList();
                if($dispenable['seo_option'] == 1){
                    $fbCategoryVal = "category=" . $categorySeo[0]->seo_category;
                    $fbVideoVal = "video=" . $rows->seotitle;
                }else{
                    $fbCategoryVal = "catid=" . $rows->playlistid;
                    $fbVideoVal = "id=" . $rows->id;
                    }

                $baseUrl = JURI::base();
                $baseUrl1 = parse_url($baseUrl);
                $baseUrl1 = $baseUrl1['scheme'] . '://' . $baseUrl1['host'];

                $fbPath = $baseUrl1 . JRoute::_('index.php?option=com_contushdvideoshare&view=player&' . $fbCategoryVal . '&' . $fbVideoVal);
                $title = $rows->title;
                $rate = $rows->rate;
                $ratecount = $rows->ratecount;
                $views = $rows->times_viewed;
                $date = '';
                $date = date("m-d-Y", strtotime($rows->created_date));
                $tags = $rows->tags;

                echo '<item>';
                echo '<videoId>' . $rows->id . '</videoId>';
                echo '<videoUrl>' . $video . '</videoUrl>';
                echo '<thumbImage>' . $timage . '</thumbImage>';
                echo '<previewImage>' . $previewimage . '</previewImage>';
                echo '<views>' . $views . '</views>';
                echo '<createdDate>' . $date . '</createdDate>';
                echo '<title>';
                echo '<![CDATA[' . $rows->title . ']]>';
                echo '</title>';
                echo '<description>';
                echo '<![CDATA[' . $rows->description . ']]>';
                echo '</description>';
                echo '<tags>';
                echo '<![CDATA[' . $rows->tags . ']]>';
                echo '</tags>';
                echo '<link>' . $fbPath . '</link>';
                echo '<generator>Video_Share_Feed</generator>';
                echo '<docs>http://blogs.law.harvard.edu/tech/rss</docs>';
                echo '</item>';
            }
        }
        echo '</rss>';
        exit();
    }

}