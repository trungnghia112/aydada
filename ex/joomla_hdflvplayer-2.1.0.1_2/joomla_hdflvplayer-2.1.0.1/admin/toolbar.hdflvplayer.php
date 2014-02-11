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
defined( '_JEXEC' ) or die( 'Restricted access' );
require_once( JApplicationHelper::getPath( 'toolbar_html' ) );

$controllerName = JRequest::getCmd( 'task', 'PlayerSettings ' );

if ($controllerName == "playersettings")
{
	$db = JFactory::getDBO();
	if($task != 'editplayersettings')
	{
		$query = "SELECT count(id) FROM #__hdflvplayersettings ";
		$db->setQuery( $query );
		$total = $db->loadResult();
		if($total>0)
		{
			$task='notnew';
		}
	}
}
switch($task)
{
	case "uploadvideos":
	case "savevideoupload":
	case "UPLOADVIDEOCANCEL":
		TOOLBAR_hdflvplayer::_DEFAULTVIDEO();
		break;
	case "addvideoupload" :
	case "editvideoupload":
		TOOLBAR_hdflvplayer::_NEWSETTINGS();
		break;
	case "playersettings":
	case "saveplayersettings":
		TOOLBAR_hdflvplayer::_NEWSETTINGS1();
		break;
	case "PLAYERSETTINGCANCEL":
		TOOLBAR_hdflvplayer::_NOTNEW();
		break;
	case "editplayersettings":
		TOOLBAR_hdflvplayer::_NEWSETTINGS1();
		break;
	case "notnew" :
		TOOLBAR_hdflvplayer::_NOTNEW();
		break;
	case "playlistname":
	case "saveplaylistname":
	case "PLAYLISTNAMECANCEL":
		TOOLBAR_hdflvplayer::_DEFAULTPLAYLISTNAME();
		break;
	case "addplaylistname" :
	case "editplaylistname":
		TOOLBAR_hdflvplayer::_NEWPLAYLISTNAME();
		break;
	case "languagesetup":
	case "savelanguagesetup":
	case "languagecancel":
		TOOLBAR_hdflvplayer::_DEFAULTLANGUAGESETUP();
		break;
	case "addlanguagesetup":
	case "editlanguagesetup":
		TOOLBAR_hdflvplayer::_NEWLANGUAGESETUP();
		break;

	case "checklist":
		TOOLBAR_hdflvplayer::_NEWCHECKLIST();
		break;
	case "ads":
	case "saveads":
	case "CANCELADS":
		TOOLBAR_hdflvplayer::_DEFAULTADS();
		break;
	case "addads":
	case "editads":
		TOOLBAR_hdflvplayer::_NEWADS();
		break;
	case "addgoogle":
		TOOLBAR_hdflvplayer::_GOOGLEADD();
		break;

	default:
		TOOLBAR_hdflvplayer::_DEFAULTVIDEO();
		break;
}
?>