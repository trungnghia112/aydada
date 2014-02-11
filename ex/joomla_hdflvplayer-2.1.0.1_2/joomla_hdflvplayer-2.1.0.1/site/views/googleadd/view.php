<?php
/**
 * @name 	        hdflvplayer
 ** @version	        2.1.0.1
 * @package	        Apptha
 * @since	        Joomla 1.5
 * @subpackage	        hdflvplayer
 * @author      	Apptha - http://www.apptha.com/
 * @copyright 		Copyright (C) 2011 Powered by Apptha
 * @license 		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      	com_hdflvplayer installation file.
 ** @Creation Date	23 Feb 2011
 ** @modified Date	28 Aug 2013
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

//importing default components
jimport('joomla.application.component.view');

/*
 *HDFLV Player component view file for Google Ads
 */
class hdflvplayerViewgoogleadd extends HdflvplayerView {

    function googlescript() {

        $model = $this->getModel();
        $detail = $model->googlescript();
    }

}
?>   
