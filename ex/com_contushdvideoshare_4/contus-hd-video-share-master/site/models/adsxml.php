<?php
/**
 * @name          : Joomla HD Video Share
 * @version	  : 3.4.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component Adsxml Model
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */

## No direct acesss
defined( '_JEXEC' ) or die( 'Restricted access' );
##  import Joomla model library
jimport('joomla.application.component.model');

## Contushdvideoshare Component Adsxml Model
class Modelcontushdvideoshareadsxml extends ContushdvideoshareModel {

    ## function to get ads
    function getads() {
        $db = JFactory::getDBO();
        $query_ads = "SELECT id,published,adsname,filepath,postvideopath,targeturl,clickurl,impressionurl,adsdesc,typeofadd 
                    FROM #__hdflv_ads 
                    WHERE published=1 AND typeofadd='prepost'";
        $db->setQuery($query_ads);
        $rs_ads = $db->loadObjectList();
        $this->showadsxml($rs_ads);
    }

    ## function to show ads
    function showadsxml($rs_ads) {
        ob_clean();
        header("content-type: text/xml");
        echo '<?xml version="1.0" encoding="utf-8"?>';
        echo '<ads random="false">';
        $current_path = "components/com_contushdvideoshare/videos/";
        $clickpath = JURI::base() . '?option=com_contushdvideoshare&view=impressionclicks&click=click';
        $impressionpath = JURI::base() . '?option=com_contushdvideoshare&view=impressionclicks&click=impression';

        if (count($rs_ads) > 0) {
            foreach ($rs_ads as $rows) {
                if ($rows->filepath == "File") {
                    $postvideo = JURI::base() . $current_path . $rows->postvideopath;
                } elseif ($rows->filepath == "Url") {
                    $postvideo = $rows->postvideopath;
                }
                echo '<ad id="' . $rows->id . '" url="' . $postvideo . '" targeturl="' . $rows->targeturl . '" clickurl="' . $clickpath . '" impressionurl="' . $impressionpath . '">';
                echo '<![CDATA[' . $rows->adsdesc . ']]>';
                echo '</ad>';
            }
        }
        echo '</ads>';
        exit();
    }

}