<?php

/**
 * @name          : Joomla HD Video Share
 * @version	  : 3.4.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component Midrollxml Model
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */
## No direct acesss
defined('_JEXEC') or die('Restricted access');
## import Joomla model library
jimport('joomla.application.component.model');

## Contushdvideoshare Component Midrollxml Model

class Modelcontushdvideosharemidrollxml extends ContushdvideoshareModel {
## function to get midroll ads 

    function getads() {
        $db                 = JFactory::getDBO();
        $query              = "SELECT * FROM `#__hdflv_ads` WHERE published=1 AND typeofadd='mid'";
        $db->setQuery($query);
        $rs_modulesettings  = $db->loadObjectList();
        $qry_settings       = "SELECT player_icons FROM #__hdflv_player_settings LIMIT 1 ";
        $db->setQuery($qry_settings);
        $rs_random          = $db->loadObject();
        $player_icons       = unserialize($rs_random->player_icons);
        $player_values      = unserialize($rs_random->player_values);
        $random             = $player_icons['midrandom'];
        $adrotate           = $player_icons['midadrotate'];
        $interval           = $player_values['midinterval'];
        $begin              = $player_values['midbegin'];
                
        if ($random == 1)   $random = 'true'; else $random = 'false';
        if ($adrotate == 1) $adrotate = 'true'; else $adrotate = 'false';
        if ($rs_modulesettings) {
            $this->showadsxml($rs_modulesettings, $random, $begin, $interval, $adrotate);
        }
    }

    /* function to show midroll ads */

    function showadsxml($midroll_video, $random, $begin, $interval, $adrotate) {
        ob_clean();
        header("content-type: text/xml");
        echo '<?xml version="1.0" encoding="utf-8"?>';
        echo '<midrollad begin="' . $begin . '" adinterval="' . $interval . '" random="' . $random . '" adrotate="' . $adrotate . '">';
        $current_path = "components/com_contushdvideoshare/videos/";
        if (count($midroll_video) > 0) {
            foreach ($midroll_video as $rows) {
                if ($rows->clickurl == '')
                    $clickpath = JURI::base() . '?option=com_contushdvideoshare&view=impressionclicks&click=click&id=' . $rows->id;
                else
                    $clickpath = $rows->clickurl;
                if ($rows->impressionurl == '')
                    $impressionpath = JURI::base() . '?option=com_contushdvideoshare&view=impressionclicks&click=impression&id=' . $rows->id;
                else
                    $impressionpath = $rows->impressionurl;
//echo '<midroll videoid="' . $rows->vid . '" targeturl="' . $rows->targeturl . '" clickurl="' . $clickpath . '" impressionurl="' . $impressionpath . '">';
                echo '<midroll targeturl="' . $rows->targeturl . '" clickurl="' . $clickpath . '" impressionurl="' . $impressionpath . '" >';
                echo '<![CDATA[';
                echo '<span class="heading">' . $rows->adsname;
                echo '</span><br><span class="midroll">' . $rows->adsdesc;
                echo '</span><br><span class="webaddress">' . $rows->targeturl;
                echo '</span>]]>';
                echo '</midroll>';
            }
        }
        echo '</midrollad>';
        exit();
    }

}