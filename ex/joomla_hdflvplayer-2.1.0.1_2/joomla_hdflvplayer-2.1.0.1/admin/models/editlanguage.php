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
//No direct acesss
defined('_JEXEC') or die();

//importing default joomla components
jimport('joomla.application.component.model');

/*
 * HDFLV player Model class to save functions,fetch language settings while edit.
 */
class hdflvplayerModeleditlanguage extends HdflvplayerModel {

	//Function to fetch language details
	function editlanguagemodel()
	{
		$db = JFactory::getDBO();
		$showlanguage = array();
		
		//Fetch language settings details
		$query = 'SELECT id,player_lang FROM `#__hdflvplayerlanguage`';
		$db->setQuery( $query);
		$showlanguage = $db->loadObject();
		return $showlanguage;
	}

	//Function to store language details
	function savelanguagesetup($task)
	{
		global $option;
		$option 	= 'com_hdflvplayer';
		$langsettings 	= JTable::getInstance('hdflvplayerlanguage', 'Table');
		$langsettings->load();//to load the the record from table
                $settingsResult             = JRequest::get('post');
                $player_lang                = array(
                'pause'                      => $settingsResult['pause'],
                'play'                      => $settingsResult['play'],
                'replay'                    => $settingsResult['replay'],
                'changequality'             => $settingsResult['changequality'],
                'zoom'                      => $settingsResult['zoom'],
                'zoomin'                    => $settingsResult['zoomin'],
                'zoomout'                   => $settingsResult['zoomout'],
                'share'                     => $settingsResult['share'],
                'fullscreen'                => $settingsResult['fullscreen'],
                'exitfullScreen'            => $settingsResult['exitfullScreen'],
                'playlisthide'              => $settingsResult['playlisthide'],
                'playlistview'              => $settingsResult['playlistview'],
                'sharetheword'              => $settingsResult['sharetheword'],
                'sendanemail'               => $settingsResult['sendanemail'],
                'email'                     => $settingsResult['email'],
                'to'                        => $settingsResult['to'],
                'from'                      => $settingsResult['from'],
                'note'                      => $settingsResult['note'],
                'send'                      => $settingsResult['send'],
                'copy'                      => $settingsResult['copy'],
                'copylink'                  => $settingsResult['copylink'],
                'copyembed'                 => $settingsResult['copyembed'],
                'social'                    => $settingsResult['social'],
                'quality'                   => $settingsResult['quality'],
                'facebook'                  => $settingsResult['facebook'],
                'googleplus'                => $settingsResult['googleplus'],
                'tumblr'                    => $settingsResult['tumblr'],
                'tweet'                     => $settingsResult['tweet'],
                'turnoffplaylistautoplay'   => $settingsResult['turnoffplaylistautoplay'],
                'turnonplaylistautoplay'    => $settingsResult['turnonplaylistautoplay'],
                'adindicator'               => $settingsResult['adindicator'],
                'skipadd'                   => $settingsResult['skipadd'],
                'skipvideo'                 => $settingsResult['skipvideo'],
                'download'                  => $settingsResult['download'],
                'volume'                    => $settingsResult['volume'],
                'mid'                       => $settingsResult['mid'],
                'nothumbnail'               => $settingsResult['nothumbnail'],
                'live'                      => $settingsResult['live'],
                'fillrequiredfields'        => $settingsResult['fillrequiredfields'],
                'wrongemail'                => $settingsResult['wrongemail'],
                'emailwait'                 => $settingsResult['emailwait'],
                'emailsent'                 => $settingsResult['emailsent'],
                'notallow_embed'            => $settingsResult['notallow_embed'],
                'youtube_ID_Invalid'        => $settingsResult['youtube_ID_Invalid'],
                'video_Removed_or_private'  => $settingsResult['video_Removed_or_private'],
                'streaming_connection_failed' => $settingsResult['streaming_connection_failed'],
                'audio_not_found'           => $settingsResult['audio_not_found'],
                'video_access_denied'       => $settingsResult['video_access_denied'],
                'FileStructureInvalid'      => $settingsResult['FileStructureInvalid'],
                'NoSupportedTrackFound'     => $settingsResult['NoSupportedTrackFound'],
            );
        $settingsResult['player_lang'] = serialize($player_lang);

        if (!$langsettings->bind($settingsResult))
		{
			JError::raiseError(500, JText::_($langsettings->getError()));
		}
		
		//Save language settings into table.
		if (!$langsettings->store()) {
			JError::raiseError(500, JText::_($langsettings->getError()));
		}
		
		//set message with redirect link
		switch ($task)
		{
			case 'applylanguagesetup':
				$msg = 'Changes Saved';
				$link = 'index.php?option=' . $option .'&task=editlanguagesetup';
				break;
			case 'savelanguagesetup':
			default:
				$msg = 'Saved';
				$link = 'index.php?option=' . $option.'&task=languagesetup';
				break;
		}
		
		// page redirect
		JFactory::getApplication()->redirect($link, $msg);
	}
}
?>
