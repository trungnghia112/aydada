<?php
/*
 ***********************************************************/
/**
 * @name          : Joomla HD Video Share
 *** @version	  : 3.4.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component Impressionclicks Model
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */
/*
 ***********************************************************/
//No direct acesss
defined( '_JEXEC' ) or die( 'Restricted access' );
// import Joomla model library
jimport('joomla.application.component.model');
/**
 * Contushdvideoshare Component Impressionclicks Model
 */
class Modelcontushdvideoshareimpressionclicks extends ContushdvideoshareModel {

	/* function to get & update the impression clicks to the Ads*/
    function impressionclicks() {
        global $mainframe;
        $db = JFactory::getDBO();
        $click = JRequest::getVar('click', 'get', '', 'string');
        $id = JRequest::getVar('id', 'get', '', 'int');
        if ($click != 'click') {
            $query = "UPDATE #__hdflv_ads SET clickcounts = clickcounts+1  WHERE `id` = $id";
        }
        else {
            $query = "UPDATE #__hdflv_ads SET impressioncounts= impressioncounts+1 WHERE `id` = $id";
        }
        $db->setQuery($query);
        $db->query();
        exit();
    }
}
?>
