<?php
/**
 * @name          : Joomla HD Video Share
 * @version	  : 3.4.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component IMA Ad xml Model
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */

## No direct acesss
defined( '_JEXEC' ) or die( 'Restricted access' );
##  import Joomla model library
jimport('joomla.application.component.model');

## Contushdvideoshare Component Adsxml Model
class Modelcontushdvideoshareimaadxml extends ContushdvideoshareModel {

    ## function to get ads
    function getads() {
        $db = JFactory::getDBO();
        $query_ads      = "SELECT id,published,adsname,imaaddet,typeofadd 
                        FROM #__hdflv_ads 
                        WHERE published=1 AND typeofadd='ima' ORDER BY id DESC LIMIT 1";
        $db->setQuery($query_ads);
        $rs_ads         = $db->loadObject();
        $rows           = unserialize($rs_ads->imaaddet);
        $query          = "SELECT `player_values` FROM #__hdflv_player_settings";
        $db->setQuery($query);
        $settingResult  = $db->loadResult();
        $settings       = unserialize($settingResult);
        $this->showadsxml($rows,$settings);
    }

    ## function to show ads
    function showadsxml($rows,$settings) {
        ob_clean();
        header("content-type: text/xml");
        echo '<?xml version="1.0" encoding="utf-8"?>';
        echo '<ima>';
        if (count($rows) > 0) {
            $imaadwidth         = $settings['width'] - 30;
            $imaadheight        = $settings['height'] - 60;
            $imaadpath          = $rows['imaadpath'];
            $publisherId        = $rows['publisherId'];
            $contentId          = $rows['contentId'];
            $imaadType          = $rows['imaadtype'];
            if ($imaadType == 'videoad'){
                $imaadType      = '';
            } else {
                $imaadType      = 'Text';
            $channels           = $rows['channels'];
            }
            ## video ads
            echo '
                <adSlotWidth>' . $imaadwidth . '</adSlotWidth>
                <adSlotHeight>' . $imaadheight . '</adSlotHeight>
                <adTagUrl>' . $imaadpath . '</adTagUrl>';
            ## text ads size(468,60)
            echo '<publisherId>' . $publisherId . '</publisherId>
                  <contentId>' . $contentId . '</contentId>';
            ## Text or Overlay
            echo '<adType>' . $imaadType . '</adType>
                  <channels>' . $channels . '</channels>';
        } else {
            ## video ads
            echo '
                <adSlotWidth>400</adSlotWidth>
                <adSlotHeight>250</adSlotHeight>
                <adTagUrl>http://ad.doubleclick.net/pfadx/N270.126913.6102203221521/B3876671.22;dcadv=2215309;sz=0x0;ord=%5btimestamp%5d;dcmt=text/xml</adTagUrl>';

            ## text ads size(468,60)
            echo '<publisherId></publisherId>
                <contentId>1</contentId>';
            ## Text or Overlay
            echo ' <adType>Text</adType>
                <channels>poker</channels>';
        }
        echo '</ima>';
        exit();
    }

}