<?php
/**
 * @name 	        impressionclicks.php
 ** @version	        2.1.0.1
 * @package	        Apptha
 * @since	        Joomla 1.5
 * @author      	Apptha - http://www.apptha.com/
 * @copyright 		Copyright (C) 2011 Powered by Apptha
 * @license 		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      	Contus HD FLV Player Ad thumb impression clicks file
 * @Creation Date	23 Feb 2011
 * @modified Date	28 Aug 2013
 */
## No direct acesss
defined('_JEXEC') or die();

## implementing default component libraries
jimport('joomla.application.component.model');

/*
 * HDFLV player component class for Update Impression and clicks count 
 */

class hdflvplayerModelimpressionclicks extends HdflvplayerModel {
    ## Function to update impression and click count for video

    function impressionclicks() {

        $db         = JFactory::getDBO();
        $click      = JRequest::getVar('click', 'get', '', 'string');
        $id         = JRequest::getVar('id', 'get', '', 'int');

        ## Update Clicks count here
        if ($click != 'click') {
            $query = "UPDATE #__hdflvplayerads SET clickcounts = clickcounts+1  WHERE `id` = $id";
        }
        ## Update Impression count here
        else {
            $query = "UPDATE #__hdflvplayerads SET impressioncounts= impressioncounts+1 WHERE `id` = $id";
        }

        $db->setQuery($query);
        $db->query();
        exit();
    }
}
?>