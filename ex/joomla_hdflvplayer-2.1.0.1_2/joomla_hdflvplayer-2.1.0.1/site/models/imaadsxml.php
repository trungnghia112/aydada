<?php
/**
 * @name 	        imaadsxml.php
 ** @version	        2.1.0.1
 * @package	        Apptha
 * @since	        Joomla 1.5
 * @author      	Apptha - http://www.apptha.com/
 * @copyright 		Copyright (C) 2011 Powered by Apptha
 * @license 		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      	Contus HD FLV Player IMA Ads XML file
 * @Creation Date	23 Feb 2011
 * @modified Date	28 Aug 2013
 */
## No direct acesss
defined('_JEXEC') or die();

## Importing Default Joomla Component
jimport('joomla.application.component.model');

/*
 * Model class for generating adsxml
 */

class hdflvplayerModelimaadsxml extends HdflvplayerModel {

    function getads() {
        $db             = JFactory::getDBO();
        $query          = 'SELECT `imaaddet` FROM `#__hdflvplayerads`
                        WHERE published=1 AND typeofadd=\'ima\' ORDER BY id DESC LIMIT 1';
        $db->setQuery($query);

        $rs_imaresult   = $db->loadObjectList();
        $this->showimaadsxml($rs_imaresult);
    }

    function showimaadsxml($rs_imaresult) {
        ob_clean();
        header("content-type: text/xml");
        echo '<?xml version="1.0" encoding="utf-8"?>';
        echo '<ima>';

        if (count($rs_imaresult) > 0) {
            foreach ($rs_imaresult as $rows) {
                $imaaddetail = unserialize($rows->imaaddet);
                ## video ads
                echo '
                <adSlotWidth>' . $imaaddetail['videoimaadwidth'] . '</adSlotWidth>
                <adSlotHeight>' . $imaaddetail['videoimaadheight'] . '</adSlotHeight>
                <adTagUrl>' . $imaaddetail['imaadpath'] . '</adTagUrl>';

                ## text ads size(468,60)
                echo '<publisherId>' . $imaaddetail['publisherId'] . '</publisherId>
                <contentId>' . $imaaddetail['contentId'] . '</contentId>';
                ## Text or Overlay
                echo ' <adType>' . $imaaddetail['imaadtype'] . '</adType>
                <channels>' . $imaaddetail['channels'] . '</channels>';
            }
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
?>