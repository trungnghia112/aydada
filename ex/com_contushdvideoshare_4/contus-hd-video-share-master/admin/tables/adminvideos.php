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
 * @abstract      : Contus HD Video Share Component Adminvideos Table
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */
/*
 ***********************************************************/
// no direct access to this file
defined('_JEXEC') or die('Restricted Access');
// table for adminvideos
class Tableadminvideos extends JTable {
    var $id = null;
    var $published = null;
    var $title = null;
    var $times_viewed = null;
    var $videos = null;
    var $filepath = null;
    var $videourl = null;
    var $thumburl = null;
    var $previewurl = null;
    var $hdurl = null;
    var $playlistid = null;
    var $duration = null;
    var $ordering = null;
    var $home = null;
    var $streameroption = null;
    var $streamerpath = null;
    var $postrollads = null;
    var $prerollads = null;
    var $midrollads = null;
    var $imaads = null;
    var $description = null;
    var $targeturl = null;
    var $download = null;
    var $prerollid = null;
    var $postrollid = null;
    var $memberid = null;
    var $type = null;
    var $featured = null;
    var $rate = null;
    var $ratecount = null;
    var $addedon = null;
    var $usergroupid = null;
    var $created_date = null;
    var $scaletologo = null;
    var $tags=null;
    var $seotitle=null;
    var $useraccess = null;
    var $islive = null;
    var $embedcode = null;
    var $subtitle1 = null;
    var $subtitle2 = null;
    var $subtile_lang1 = null;
    var $subtile_lang2 = null;
    function Tableadminvideos(&$db) {
        parent::__construct('#__hdflv_upload', 'id', $db);
    }
}
?>
