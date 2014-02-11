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

class Tablehdflvplayer extends JTable
{
    var $id             = null;
    var $published      = null;
    var $uploadmaxsize  = null;
    var $logopath       = null;
    var $player_colors  = null;
    var $player_icons   = null;
    var $player_values  = null;



    function __construct(&$db)
    {
        parent::__construct( '#__hdflvplayersettings', 'id', $db );

    }
}

?>