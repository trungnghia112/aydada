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

class Tablehdflvplayerads extends JTable
{
    var $id = null;
    var $published=null;
    var $adsname=null;
    var $filepath=null;
    var $postvideopath=null;
    var $prevideopath=null;
    var $home=null;
    var $targeturl=null;
    var $clickurl=null;
    var $impressionurl=null;
    var $adsdesc=null;
    var $typeofadd=null;
    var $imaaddet=null;

    function __construct(&$db)
    {
        parent::__construct( '#__hdflvplayerads', 'id', $db );

    }
}

?>