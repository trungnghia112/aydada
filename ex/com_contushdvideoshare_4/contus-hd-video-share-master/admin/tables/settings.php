<?php
/*
 ***********************************************************/
/**
 * @name          : Joomla HD Video Share
 ****@version	  : 3.4.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component Settings Table
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */
/*
 ***********************************************************/
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
// table for settings
class Tablesettings extends JTable {
    var $id = null;
    var $published = null;
    var $player_colors = null;
    var $player_icons = null;
    var $player_values = null;
    var $uploadmaxsize = null;
    var $logopath = null;

    function __construct(&$db) {
        parent::__construct('#__hdflv_player_settings', 'id', $db);
    }
}
?>