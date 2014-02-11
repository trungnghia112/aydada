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
 * @Creation Date	23-2-2011
 * @modified Date	15-11-2012
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
error_reporting(0);
// Imports
jimport('joomla.installer.installer');
$installer =  new JInstaller();
$upgra = '';

function AddColumnIfNotExists(&$errorMsg, $table, $column, $attributes = "INT( 11 ) NOT NULL DEFAULT '0'", $after = '') {
	$db = & JFactory::getDBO();
	$columnExists = false;
	$upgra = 'upgrade';
	$query = 'SHOW COLUMNS FROM ' . $table;

	$db->setQuery($query);
	if (!$result = $db->query()) {
		return false;
	}
	$columnData = $db->loadObjectList();
	foreach ($columnData as $valueColumn) {
		if ($valueColumn->Field == $column) {
			$columnExists = true;
			break;
		}
	}

	if (!$columnExists) {
		if ($after != '') {
			$query = 'ALTER TABLE ' . $db->nameQuote($table) . ' ADD ' . $db->nameQuote($column) . ' ' . $attributes . ' AFTER ' . $db->nameQuote($after) . ';';
		} else {
			$query = 'ALTER TABLE ' . $db->nameQuote($table) . ' ADD ' . $db->nameQuote($column) . ' ' . $attributes . ';';
		}
		$db->setQuery($query);
		if (!$result = $db->query()) {
			return false;
		}
		$errorMsg = 'notexistcreated';
	}


	return true;
}

//Function to remove columns from table. 
function RemoveColumnIfExists(&$errorMsg, $table, $column) {
	$db = & JFactory::getDBO();
	$columnExists = false;
	$upgra = 'upgrade';
	$query = 'SHOW COLUMNS FROM ' . $table;

	$db->setQuery($query);
	if (!$result = $db->query()) {
		return false;
	}
	$columnData = $db->loadObjectList();
	foreach ($columnData as $valueColumn) {
		if ($valueColumn->Field == $column) {
			$columnExists = true;
			break;
		}
	}

	if ($columnExists) {

		$query = 'ALTER TABLE ' . $db->nameQuote($table) . ' DROP ' . $db->nameQuote($column).';';

		$db->setQuery($query);
		if (!$result = $db->query()) {
			return false;
		}
		$errorMsg = 'notexistcreated';
	}

	return true;
	 
}


function check_column($table, $newcolumn, $newcolumnafter, $newcolumntype = "int(11) NOT NULL default '0'") {
	$upgra = 'upgrade';
	$db = & JFactory::getDBO();
	$msg = '';
	$foundcolumn = false;

	$query = " SHOW COLUMNS FROM `#__" . $table . "`; "
	;

	$db->setQuery($query);

	if (!$db->query()) {
		return false;
	}

	$columns = $db->loadObjectList();

	foreach ($columns as $column) {
		if ($column->Field == $newcolumn) {
			$foundcolumn = true;
			break;
		}
	}

	if (!$foundcolumn) {
		$query = " ALTER TABLE `#__" . $table . "`
                                ADD `" . $newcolumn . "` " . $newcolumntype
		;

		if (strlen(trim($newcolumnafter)) > 0) {
			$query .= " AFTER `" . $newcolumnafter . "`";
		}

		$query .= ";";



		$db->setQuery($query);

		if (!$db->query()) {
			return false;
		}
	}

	return true;
}
//$installer->install($this->parent->getPath('source') . '/extensions/mod_hdflvplayer');
$db = JFactory::getDBO();
if (version_compare(JVERSION, '1.6.0', 'ge')) {
	$query_ext = ' SELECT * FROM ' . $db->nameQuote('#__extensions') . 'where type="component" and element="com_hdflvplayer" LIMIT 1;';
} else {
	$query_ext = "SELECT id FROM #__components WHERE parent = 0 and admin_menu_link='option=com_hdflvplayer'   LIMIT 1";
	  $query = 'UPDATE  #__components '.
                 'SET name = "Videos" '.
                 'WHERE name = "COM_HDFLVPLAYER_SUBMENU_VIDEOS"';
	$db->setQuery($query);
	$db->query();

	$query = 'UPDATE  #__components '.
                 'SET name = "HD FLV Player" '.
                 'WHERE name = "COM_HDFLVPLAYER"';
	$db->setQuery($query);
	$db->query();

	$query = 'UPDATE  #__components '.
                 'SET name = "Player Settings" '.
                 'WHERE name = "COM_HDFLVPLAYER_SUBMENU_SETTINGS"';
	$db->setQuery($query);
	$db->query();

	$query = 'UPDATE  #__components '.
                 'SET name = "Playlist" '.
                 'WHERE name = "COM_HDFLVPLAYER_SUBMENU_PLAYLIST"';
	$db->setQuery($query);
	$db->query();

	$query = 'UPDATE  #__components '.
                 'SET name = "Checklist" '.
                 'WHERE name = "COM_HDFLVPLAYER_SUBMENU_CHECKLIST"';
	$db->setQuery($query);
	$db->query();

	$query = 'UPDATE  #__components '.
                 'SET name = "Language Settings" '.
                 'WHERE name = "COM_HDFLVPLAYER_SUBMENU_LANGUAGE"';
	$db->setQuery($query);
	$db->query();

	$query = 'UPDATE  #__components '.
                 'SET name = "Video Ads" '.
                 'WHERE name = "COM_HDFLVPLAYER_SUBMENU_ADS"';
	$db->setQuery($query);
	$db->query();

	$query = 'UPDATE  #__components '.
                 'SET name = "Google Adsense" '.
                 'WHERE name = "COM_HDFLVPLAYER_SUBMENU_GOOGLEADSENSE"';
	$db->setQuery($query);
	$db->query();
	
}
$query = 'SELECT id FROM #__hdflvplayersettings LIMIT 1;';
$db->setQuery($query);
$result = $db->loadResult();

if (empty($result)) {
	$db->setQuery("CREATE TABLE IF NOT EXISTS `#__hdflvaddgoogle` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `code` text NOT NULL,
  `showoption` tinyint(1) NOT NULL,
  `closeadd` int(6) NOT NULL,
  `reopenadd` tinytext NOT NULL,
  `publish` int(1) NOT NULL,
  `ropen` int(6) NOT NULL,
  `showaddc` tinyint(1) NOT NULL,
  `showaddm` tinytext NOT NULL,
  `showaddp` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
	$db->query();


	$db->setQuery("INSERT INTO `#__hdflvaddgoogle` (`id`, `code`, `showoption`, `closeadd`, `reopenadd`, `publish`, `ropen`, `showaddc`, `showaddm`, `showaddp`) VALUES
    (1, '', 1, 5, '0', 0, 5, 0, '0', '0');");
	$db->query();


	$db->setQuery("CREATE TABLE IF NOT EXISTS `#__hdflvplayerads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `published` tinyint(4) NOT NULL,
  `adsname` varchar(255) NOT NULL,
  `filepath` varchar(255) NOT NULL,
  `postvideopath` varchar(255) NOT NULL,
  `home` int(11) NOT NULL,
  `targeturl` varchar(255) NOT NULL,
  `clickurl` varchar(255) NOT NULL,
  `impressionurl` varchar(255) NOT NULL,
  `impressioncounts` int(11) NOT NULL DEFAULT '0',
  `clickcounts` int(11) NOT NULL DEFAULT '0',
  `adsdesc` varchar(500) NOT NULL,
  `typeofadd` varchar(50) NOT NULL,
  `imaaddet` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
	$db->query();

	$db->setQuery("CREATE TABLE IF NOT EXISTS `#__hdflvplayerlanguage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `player_lang` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
	$db->query();
$player_lang = 'a:50:{s:5:"pause";s:5:"Pause";s:4:"play";s:4:"Play";s:6:"replay";s:6:"Replay";s:13:"changequality";s:14:"Change Quality";s:4:"zoom";s:4:"Zoom";s:6:"zoomin";s:7:"Zoom In";s:7:"zoomout";s:8:"Zoom out";s:5:"share";s:5:"Share";s:10:"fullscreen";s:10:"Fullscreen";s:14:"exitfullScreen";s:16:"Exit Full Screen";s:12:"playlisthide";s:19:"Hide Related Videos";s:12:"playlistview";s:19:"Show Related Videos";s:12:"sharetheword";s:16:"Share This Video";s:11:"sendanemail";s:13:"Send an email";s:5:"email";s:5:"Email";s:2:"to";s:8:"To Email";s:4:"from";s:10:"From Email";s:4:"note";s:7:"Message";s:4:"send";s:4:"Send";s:4:"copy";s:4:"Copy";s:8:"copylink";s:4:"link";s:9:"copyembed";s:5:"Embed";s:6:"social";s:6:"Social";s:7:"quality";s:7:"Quality";s:8:"facebook";s:17:"Share on Facebook";s:10:"googleplus";s:16:"Share on Google+";s:6:"tumblr";s:15:"Share on Tumblr";s:5:"tweet";s:16:"Share on Twitter";s:23:"turnoffplaylistautoplay";s:26:"Turn Off Playlist Autoplay";s:22:"turnonplaylistautoplay";s:25:"Turn On Playlist Autoplay";s:11:"adindicator";s:61:"Your selection will follow this sponsors message in - seconds";s:7:"skipadd";s:19:"Skip this ad now >>";s:9:"skipvideo";s:24:"You can skip to video in";s:8:"download";s:8:"Download";s:6:"volume";s:6:"Volume";s:3:"mid";s:3:"mid";s:11:"nothumbnail";s:22:"No Thumbnail Available";s:4:"live";s:4:"LIVE";s:18:"fillrequiredfields";s:35:"Please fill in all required fields.";s:10:"wrongemail";s:30:"Missing field Or Invalid email";s:9:"emailwait";s:6:"Wait..";s:9:"emailsent";s:31:"Thank you! Video has been sent.";s:14:"notallow_embed";s:68:"The requested video does not allow playback in the embedded players.";s:18:"youtube_ID_Invalid";s:94:"The video ID that does not have 11 characters, or if the video ID contains invalid characters.";s:24:"video_Removed_or_private";s:127:"The requested video is not found. This occurs when a video has been removed (for any reason), or it has been marked as private.";s:27:"streaming_connection_failed";s:46:"Requested streaming provider connection failed";s:15:"audio_not_found";s:49:"The requested audio is not found or access denied";s:19:"video_access_denied";s:49:"The requested video is not found or access denied";s:20:"FileStructureInvalid";s:138:"Flash Player detects an invalid file structure and will not try to play this type of file. Supported by Flash Player 9 Update 3 and later.";s:21:"NoSupportedTrackFound";s:155:"Flash Player does not detect any supported tracks (video, audio or data) and will not try to play the file. Supported by Flash Player 9 Update 3 and later.";}';
	$db->setQuery("INSERT INTO `#__hdflvplayerlanguage` (`player_lang`) VALUES ('$player_lang');");
	$db->query();

	$db->setQuery("CREATE TABLE IF NOT EXISTS `#__hdflvplayername` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `published` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");
	$db->query();

    // insert category
	$db->setQuery("INSERT INTO `#__hdflvplayername` (`id`, `name`, `published`)
            VALUES (1,'Uncategorized','1');");
	$db->query();

        $db->setQuery("CREATE TABLE IF NOT EXISTS `#__hdflvplayersettings` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `published` tinyint(4) NOT NULL,
  `uploadmaxsize` int(10) NOT NULL,
  `logopath` varchar(255) NOT NULL,
  `player_colors` longtext NOT NULL,
  `player_icons` longtext NOT NULL,
  `player_values` longtext NOT NULL,
   PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
	$db->query();
$player_icons = 'a:27:{s:8:"autoplay";s:1:"1";s:17:"playlist_autoplay";s:1:"1";s:13:"playlist_open";s:1:"0";s:13:"skin_autohide";s:1:"1";s:10:"fullscreen";s:1:"1";s:4:"zoom";s:1:"1";s:5:"timer";s:1:"1";s:8:"shareurl";s:1:"1";s:5:"email";s:1:"1";s:13:"volumevisible";s:1:"1";s:11:"progressbar";s:1:"1";s:9:"hddefault";s:1:"1";s:12:"imageDefault";s:1:"1";s:8:"download";s:1:"1";s:10:"prerollads";s:1:"0";s:11:"postrollads";s:1:"0";s:6:"imaAds";s:1:"1";s:7:"adsSkip";s:1:"0";s:10:"midrollads";s:1:"0";s:11:"midadrotate";s:1:"0";s:9:"midrandom";s:1:"0";s:14:"title_ovisible";s:1:"1";s:20:"description_ovisible";s:1:"1";s:7:"showTag";s:1:"1";s:14:"viewed_visible";s:1:"1";s:17:"embedcode_visible";s:1:"1";s:17:"playlist_dvisible";s:1:"0";}';
$player_values = 'a:20:{s:6:"buffer";s:1:"3";s:5:"width";s:3:"700";s:6:"height";s:3:"400";s:11:"normalscale";s:1:"2";s:15:"fullscreenscale";s:1:"2";s:6:"volume";s:2:"50";s:10:"ffmpegpath";s:15:"/usr/bin/ffmpeg";s:10:"stagecolor";s:0:"";s:10:"licensekey";s:0:"";s:7:"logourl";s:0:"";s:9:"logoalpha";s:3:"100";s:9:"logoalign";s:2:"BL";s:15:"adsSkipDuration";s:1:"5";s:17:"googleanalyticsID";s:0:"";s:8:"midbegin";s:0:"";s:11:"midinterval";s:0:"";s:14:"related_videos";s:1:"1";s:16:"relatedVideoView";s:6:"center";s:8:"nrelated";s:1:"8";s:7:"urllink";s:0:"";}';  
	$db->setQuery("INSERT INTO `#__hdflvplayersettings` (`published`, `uploadmaxsize`,`logopath`, `player_colors`, `player_icons`, `player_values`) VALUES
(1, 100, '','','$player_icons','$player_values');");
	$db->query();

	$db->setQuery("CREATE TABLE IF NOT EXISTS `#__hdflvplayerupload` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `published` tinyint(1) NOT NULL,
  `title` varchar(100) NOT NULL,
  `times_viewed` int(11) NOT NULL,
  `filepath` varchar(10) NOT NULL,
  `videourl` varchar(255) NOT NULL,
  `thumburl` varchar(255) NOT NULL,
  `previewurl` varchar(255) NOT NULL,
  `hdurl` varchar(255) NOT NULL,
  `home` int(11) NOT NULL,
  `playlistid` int(11) NOT NULL,
  `duration` varchar(20) NOT NULL,
  `ordering` int(11) NOT NULL,
  `streamerpath` varchar(255) NOT NULL,
  `streameroption` varchar(255) NOT NULL,
  `postrollads` tinyint(4) NOT NULL,
  `prerollads` tinyint(4) NOT NULL,
  `midrollads` tinyint(4) NOT NULL,
  `imaads` tinyint(4) NOT NULL,
  `description` text NOT NULL,
  `targeturl` varchar(255) NOT NULL,
  `download` tinyint(4) NOT NULL,
  `prerollid` int(11) NOT NULL,
  `postrollid` int(11) NOT NULL,
  `access` int(11) NOT NULL,
  `islive` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");
	$db->query();

  
///insert data to video table

    $db->setQuery("INSERT INTO `#__hdflvplayerupload`
(`id`,`published`, `title`,`times_viewed`, `filepath`, `videourl`, `thumburl`, `previewurl`, `hdurl`, `home`, `playlistid`, `duration`, `ordering`, `streamerpath`, `streameroption`, `postrollads`, `prerollads`, `description`, `targeturl`, `download`, `prerollid`, `postrollid` ,`access`,`imaads`) VALUES
(1, 1, 'Avatar Movie Trailer [HD]', 0 , 'Youtube', 'http://www.youtube.com/watch?v=d1_JBMrrYw8', 'http://img.youtube.com/vi/d1_JBMrrYw8/1.jpg', 'http://img.youtube.com/vi/d1_JBMrrYw8/0.jpg', '', 0 ,'1',9, '', 0, '', '', 0, 'Avatar Movie Trailer [HD]', '', '', 0, 0, 0,0),
(2, 1, 'HD: Super Slo-mo Surfer! - South Pacific - BBC Two',0, 'Youtube', 'http://www.youtube.com/watch?v=7BOhDaJH0m4', 'http://img.youtube.com/vi/7BOhDaJH0m4/1.jpg', 'http://img.youtube.com/vi/7BOhDaJH0m4/0.jpg', '', 0, '1', 14, '', 0, '', '', 0, '', '', '', 0, 0, 0,0),
(3, 1, 'Fatehpur Sikri, Taj Mahal - India (in HD)',0, 'Youtube', 'http://www.youtube.com/watch?v=UNWROFjIwvQ', 'http://img.youtube.com/vi/UNWROFjIwvQ/1.jpg', 'http://img.youtube.com/vi/UNWROFjIwvQ/0.jpg', '', 0, '1', 5, '', 0, '', '', 0, '', '', '', 0, 0, 0,0)
");
        $db->query();
} else {
	$upgra = 'upgrade';
	$updateDid = $updatecolor = $updateicon = $updatevalues = $updatelang = false;
	$updateDid = AddColumnIfNotExists($errorMsg, "#__hdflvplayerads", "imaaddet", "longtext NOT NULL", "");
	if (!$updateDid) {
		$msgSQL .= "error adding 'imaaddet' column to 'hdflvplayerads' table <br />";
	}
	$updatecolor = AddColumnIfNotExists($errorMsg, "#__hdflvplayersettings", "player_colors", "longtext NOT NULL", "");
	if (!$updatecolor) {
		$msgSQL .= "error adding 'player_colors' column to 'hdflvplayersettings' table <br />";
	}

	$updateicon = AddColumnIfNotExists($errorMsg, "#__hdflvplayersettings", "player_icons", "longtext NOT NULL", "");
	if (!$updateicon) {
		$msgSQL .= "error adding 'player_icons' column to 'hdflvplayersettings' table <br />";
	} else{
        $query = 'SELECT `autoplay`,`viewed_visible`,`embedcode_visible`,`playlist_dvisible`, `playlist_autoplay`,`playlist_open`,`skin_autohide`,`fullscreen`,`zoom`,`shareurl`,`timer`, `hddefault`,`prerollads`,`postrollads`, `midrollads`,`midrandom` , `midadrotate`, `title_ovisible`,`description_ovisible` FROM `#__hdflvplayersettings`';
            $db->setQuery($query);
            $settingsResult = $db->loadObject();
             $player_icons                   = array(
            'autoplay'                  => $settingsResult->autoplay,
            'playlist_autoplay'         => $settingsResult->playlist_autoplay,
            'playlist_open'             => $settingsResult->playlist_open,
            'skin_autohide'             => $settingsResult->skin_autohide,
            'fullscreen'                => $settingsResult->fullscreen,
            'zoom'                      => $settingsResult->zoom,
            'timer'                     => $settingsResult->timer,
            'shareurl'                  => $settingsResult->shareurl,
            'email'                     => $settingsResult->email,
            'volumevisible'             => 1,
            'progressbar'               => 1,
            'hddefault'                 => $settingsResult->hddefault,
            'imageDefault'              => 1,
            'download'                  => $settingsResult->download,
            'prerollads'                => $settingsResult->prerollads,
            'postrollads'               => $settingsResult->postrollads,
            'imaAds'                    => 0,
            'adsSkip'                   => 1,
            'midrollads'                => $settingsResult->midrollads,
            'midadrotate'               => $settingsResult->midadrotate,
            'midrandom'                 => $settingsResult->midrandom,
            'title_ovisible'            => $settingsResult->title_ovisible,
            'description_ovisible'      => $settingsResult->description_ovisible,
            'showTag'                   => 1,
            'viewed_visible'            => $settingsResult->viewed_visible,
            'embedcode_visible'         => $settingsResult->embedcode_visible,
            'playlist_dvisible'         => $settingsResult->playlist_dvisible
        );
        $player_icons = serialize($player_icons);
        $query = 'UPDATE #__hdflvplayersettings SET player_icons=\'' .$player_icons . '\'';
                $db->setQuery($query);
                $db->query();
    }

	$updatevalues = AddColumnIfNotExists($errorMsg, "#__hdflvplayersettings", "player_values", "longtext NOT NULL", "");
	if (!$updatevalues) {
		$msgSQL .= "error adding 'player_values' column to 'hdflvplayersettings' table <br />";
	} else {
        $query = 'SELECT `buffer`, `width`,`stagecolor`,`midbegin`,`midinterval`,`related_videos`,`nrelated`,`urllink`, `licensekey`,`logourl`,`logoalpha`,`logoalign`, `height`,`normalscale` , `fullscreenscale`, `volume`,`ffmpegpath` FROM `#__hdflvplayersettings`';
            $db->setQuery($query);
            $settingsResult = $db->loadObject();

             $player_values                  = array(
            'buffer'                    => $settingsResult->buffer,
            'width'                     => $settingsResult->width,
            'height'                    => $settingsResult->height,
            'normalscale'               => $settingsResult->normalscale,
            'fullscreenscale'           => $settingsResult->fullscreenscale,
            'volume'                    => $settingsResult->volume,
            'ffmpegpath'                => $settingsResult->ffmpegpath,
            'stagecolor'                => $settingsResult->stagecolor,
            'licensekey'                => $settingsResult->licensekey,
            'logourl'                   => $settingsResult->logourl,
            'logoalpha'                 => $settingsResult->logoalpha,
            'logoalign'                 => $settingsResult->logoalign,
            'adsSkipDuration'           => 5,
            'googleanalyticsID'         => '',
            'midbegin'                  => $settingsResult->midbegin,
            'midinterval'               => $settingsResult->midinterval,
            'related_videos'            => $settingsResult->related_videos,
            'relatedVideoView'          => 'center',
            'nrelated'                  => $settingsResult->nrelated,
            'urllink'                   => $settingsResult->urllink
        );
        $player_values = serialize($player_values);
        $query = 'UPDATE #__hdflvplayersettings SET player_values=\'' .$player_values . '\'';
                $db->setQuery($query);
                $db->query();
    }
	$updateDid = AddColumnIfNotExists($errorMsg, "#__hdflvplayerupload", "imaads", "tinyint(4) NOT NULL", "");
	if (!$updateDid) {
		$msgSQL .= "error adding 'imaads' column to 'hdflvplayerupload' table <br />";
	}
	$updatelang = AddColumnIfNotExists($errorMsg, "#__hdflvplayerlanguage", "player_lang", "longtext NOT NULL", "");
	if (!$updatelang) {
		$msgSQL .= "error adding 'player_lang' column to 'hdflvplayerlanguage' table <br />";
	} else {
        $query = 'SELECT * FROM `#__hdflvplayerlanguage`';
            $db->setQuery($query);
            $settingsResult = $db->loadObject();

             $player_lang                  = array(
                'pause'                      => $settingsResult->pause,
                'play'                      => $settingsResult->play,
                'replay'                    => '',
                'changequality'             => '',
                'zoom'                      => $settingsResult->zoom,
                'zoomin'                    => '',
                'zoomout'                   => '',
                'share'                     => $settingsResult->share,
                'fullscreen'                => $settingsResult->fullscreen,
                'exitfullScreen'            => '',
                'playlisthide'              => '',
                'playlistview'              => '',
                'sharetheword'              => $settingsResult->sharetheword,
                'sendanemail'               => $settingsResult->sendanemail,
                'email'                     => '',
                'to'                        => $settingsResult->to,
                'from'                      => $settingsResult->from,
                'note'                      => '',
                'send'                      => $settingsResult->send,
                'copy'                      => '',
                'copylink'                  => $settingsResult->copylink,
                'copyembed'                 => $settingsResult->copyembed,
                'social'                    => '',
                'quality'                   => '',
                'facebook'                  => $settingsResult->facebook,
                'googleplus'                => '',
                'tumblr'                    => '',
                'tweet'                     => $settingsResult->tweet,
                'turnoffplaylistautoplay'   => '',
                'turnonplaylistautoplay'    => '',
                'adindicator'               => $settingsResult->adindicator,
                'skipadd'                   => $settingsResult->skipadd,
                'skipvideo'                 => '',
                'download'                  => $settingsResult->download,
                'volume'                    => $settingsResult->volume,
                'mid'                       => '',
                'nothumbnail'               => '',
                'live'                      => '',
                'fillrequiredfields'        => '',
                'wrongemail'                => '',
                'emailwait'                 => '',
                'emailsent'                 => '',
                'notallow_embed'            => '',
                'youtube_ID_Invalid'        => '',
                'video_Removed_or_private'  => '',
                'streaming_connection_failed' => '',
                'audio_not_found'           => '',
                'video_access_denied'       => '',
                'FileStructureInvalid'      => '',
                'NoSupportedTrackFound'     => '',
        );
        $player_lang = serialize($player_lang);
        $query = 'UPDATE #__hdflvplayerlanguage SET player_lang=\'' .$player_lang . '\'';
                $db->setQuery($query);
                $db->query();
    }

	$updateDid = RemoveColumnIfExists($errorMsg, "#__hdflvplayerupload", "videos");
	if (!$updateDid) {
		$msgSQL .= "error removing 'videos' column to 'hdflvplayerupload' table <br />";
	}

	$updateDid = RemoveColumnIfExists($errorMsg, "#__hdflvplayerupload", "ffmpeg");
	if (!$updateDid) {
		$msgSQL .= "error removing 'ffmpeg' column to 'hdflvplayerupload' table <br />";
	}

	$updateDid = RemoveColumnIfExists($errorMsg, "#__hdflvplayerupload", "ffmpeg_videos");
	if (!$updateDid) {
		$msgSQL .= "error removing 'ffmpeg_videos' column to 'hdflvplayerupload' table <br />";
	}

	$updateDid = RemoveColumnIfExists($errorMsg, "#__hdflvplayerupload", "ffmpeg_thumbimages");
	if (!$updateDid) {
		$msgSQL .= "error removing 'ffmpeg_thumbimages' column to 'hdflvplayerupload' table <br />";
	}

	$updateDid = RemoveColumnIfExists($errorMsg, "#__hdflvplayerupload", "ffmpeg_previewimages");
	if (!$updateDid) {
		$msgSQL .= "error removing 'ffmpeg_previewimages' column to 'hdflvplayerupload' table <br />";
	}

	$updateDid = RemoveColumnIfExists($errorMsg, "#__hdflvplayerupload", "ffmpeg_hd");
	if (!$updateDid) {
		$msgSQL .= "error removing 'ffmpeg_hd' column to 'hdflvplayerupload' table <br />";
	}
	// upgrade hdflv player ads:


	$query = ' SELECT * FROM ' . $db->nameQuote('#__hdflvplayerads') . ' LIMIT 1;';
	$db->setQuery($query);
	$result = $db->loadResult();
	if ($db->getErrorNum()) {
		$msgSQL .= $db->getErrorMsg() . '<br />';
	} else {

		if (!check_column('hdflvplayerads', 'targeturl', '','longtext NOT NULL')) {
			$msgSQL .= "error adding 'targeturl' column to 'hdflvplayerads' table <br />";
		}
		if (!check_column('hdflvplayerads', 'imaaddet', '')) {
			$msgSQL .= "error adding 'imaaddet' column to 'hdflvplayerads' table <br />";
		}
		if (!check_column('hdflvplayerads', 'clickurl', '')) {
			$msgSQL .= "error adding 'clickurl' column to 'hdflvplayerads' table <br />";
		}
		if (!check_column('hdflvplayerads', 'impressionurl', '')) {
			$msgSQL .= "error adding 'impressionurl' column to 'hdflvplayerads' table <br />";
		}
		if (!check_column('hdflvplayerads', 'impressioncounts', 'impressionurl', "INT NOT NULL DEFAULT '0' ")) {
			$msgSQL .= "error adding 'impressioncounts' column to 'hdflvplayerads' table <br />";
		}
		if (!check_column('hdflvplayerads', 'clickcounts', 'impressioncounts', "INT NOT NULL DEFAULT '0' ")) {
			$msgSQL .= "error adding 'clickcounts' column to 'hdflvplayerads' table <br />";
		}

		if (!check_column('hdflvplayerads', 'adsdesc', '', 'VARCHAR(500) NOT NULL')) {
			$msgSQL .= "error adding 'adsdesc' column to 'hdflvplayerads' table <br />";
		}

		if (!check_column('hdflvplayerads', 'typeofadd', '', 'VARCHAR(50) NOT NULL')) {
			$msgSQL .= "error adding 'typeofadd' column to 'hdflvplayerads' table <br />";
		}
	}

	$query = ' SELECT * FROM ' . $db->nameQuote('#__hdflvplayerupload') . ' LIMIT 1;';
	$db->setQuery($query);
	$result = $db->loadResult();
	if ($db->getErrorNum()) {
		$msgSQL .= $db->getErrorMsg() . '<br />';
	} else {
		if (!check_column('hdflvplayerupload', 'description', '')) {
			$msgSQL .= "error adding 'playlist_autoplay' column to 'hdflvplayerupload' table <br />";
		}
		if (!check_column('hdflvplayerupload', 'targeturl', '')) {
			$msgSQL .= "error adding 'hddefault' column to 'hdflvplayerupload' table <br />";
		}
		if (!check_column('hdflvplayerupload', 'download', '')) {
			$msgSQL .= "error adding 'ads' column to 'hdflvplayerupload' table <br />";
		}
		if (!check_column('hdflvplayerupload', 'prerollid', '')) {
			$msgSQL .= "error adding 'ads' column to 'hdflvplayerupload' table <br />";
		}
		if (!check_column('hdflvplayerupload', 'postrollid', '')) {
			$msgSQL .= "error adding 'ads' column to 'hdflvplayerupload' table <br />";
		}
		if (!check_column('hdflvplayerupload', 'access', '')) {
			$msgSQL .= "error adding 'ads' column to 'hdflvplayerupload' table <br />";
		}
		if (!check_column('hdflvplayerupload', 'islive', '')) {
			$msgSQL .= "error adding 'ads' column to 'hdflvplayerupload' table <br />";
		}
		if (!check_column('hdflvplayerupload', 'midrollads', 'prerollads', 'TINYINT NOT NULL')) {
			$msgSQL .= "error adding 'midrollads' column to 'hdflvplayerupload' table <br />";
		}
	}

}

/* * *********************************************************************************************
 * ---------------------------------------------------------------------------------------------
 * MODULE INSTALLATION SECTION
 * ---------------------------------------------------------------------------------------------
 * ********************************************************************************************* */

$installer->install($this->parent->getPath('source') . '/extensions/mod_hdflvplayer');
$db =  JFactory::getDBO();
$query = 'UPDATE  #__modules ' .
        'SET published=1, ordering=0 ' .
        'WHERE module = "mod_hdflvplayer"';
$db->setQuery($query);
$db->query();

/* * *********************************************************************************************
 * ---------------------------------------------------------------------------------------------
 * PLUGIN INSTALLATION SECTION
 * ---------------------------------------------------------------------------------------------
 * ********************************************************************************************* */

$installer->install($this->parent->getPath('source') . '/extensions/hdflvplayer');
if (version_compare(JVERSION, '1.6.0', 'ge')) {
	$query = 'UPDATE  #__extensions ' .
        'SET enabled =1' .
        'WHERE element = "hdflvplayer"';
	$db->setQuery($query);
	$db->query();
}
else {
	$query = 'UPDATE  #__plugins ' .
        'SET published=1,folder="content"' .
        'WHERE element = "hdflvplayer"';
	$db->setQuery($query);
	$db->query();
}

if (version_compare(JVERSION, '1.5.0', 'ge')) {
    $componentPath = str_replace("com_installer", "com_hdflvplayer", JPATH_COMPONENT_ADMINISTRATOR);
    if (file_exists($componentPath . '/admin.hdflvplayer.php')) {
        unlink($componentPath . '/admin.hdflvplayer.php');
    }
}

if (version_compare(JVERSION, '2.5', 'ge') || version_compare(JVERSION, '1.6', 'ge') || version_compare(JVERSION, '1.7', 'ge')) {
$root = JPATH_SITE;
 if (file_exists($componentPath . '/hdflvplayer.xml')) {
        unlink($componentPath . '/hdflvplayer.xml');
    }
 if (file_exists($componentPath . '/manifest.xml')) {
        unlink($componentPath . '/manifest.xml');
    }
                if (JFile::exists($root . '/modules/mod_hdflvplayer/mod_hdflvplayer.xml')) {
                    JFile::delete($root . '/modules/mod_hdflvplayer/mod_hdflvplayer.xml');
                }
                JFile::move($root . '/modules/mod_hdflvplayer/mod_hdflvplayer.j3.xml', $root . '/modules/mod_hdflvplayer/mod_hdflvplayer.xml');

                if (JFile::exists($root . '/plugins/content/hdflvplayer/hdflvplayer.xml')) {
                    JFile::delete($root . '/plugins/content/hdflvplayer/hdflvplayer.xml');
                }

                JFile::move($root . '/plugins/content/hdflvplayer/hdflvplayer.j3.xml', $root . '/plugins/content/hdflvplayer/hdflvplayer.xml');

}
?>

<div style="float: left; width: 1000px;">
	<a href="http://www.apptha.com/category/extension/Joomla/HD-FLV-Player"
		target="_blank"> <img
		src="components/com_hdflvplayer/assets/platoon.png"
		alt="Joomla! HDFLV Player" align="left" /> </a>
    <br />
    <br />
    <p>Joomla HD FLV Player enhances the quality of your Joomla sites or blogs. Some of the most salient features like Lighttpd, RTMP streaming,
        Monetization, Native language support, Bookmarking etc makes the Player Unique!! 
        HTML5 support in the Player facilitates the purpose of playing it in iPhone and iPads.
        </p>
</div>
<div style="float: right;">
	<a href="http://www.apptha.com" target="_blank"> <img
		src="components/com_hdflvplayer/assets/contus.jpg"
		alt="contus products" align="right"
		style="padding-right: 10px; width: 110px;" /> </a>
</div>

<br clear="all">
<h2 align="center">HD FLV Player Installation Status</h2>
<table class="adminlist">
	<thead>
		<tr>
			<th class="title" colspan="2"><?php echo JText::_('Extension'); ?></th>
			<th><?php echo JText::_('Status'); ?></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="3"></td>
		</tr>
	</tfoot>
	<tbody>
		<tr>
			<th colspan="3"><?php echo JText::_('Core'); ?></th>
		</tr>
		<tr class="row0">
			<td class="key" colspan="2"><?php echo 'HD FLV Player -' .JText::_('Component'); ?></td>
			<td style="text-align: center;"><?php
			//check installed components
			$db = &JFactory::getDBO();
			$db->setQuery("SELECT id FROM #__hdflvplayersettings LIMIT 1");
			$id = $db->loadResult();
			if ($id) {
				if ($upgra == 'upgrade') {
					echo "<strong>" . JText::_('Upgrade successfully') . "</strong>";
				} else {
					echo "<strong>" . JText::_('Installed successfully') . "</strong>";
				}
			} else {
				echo "<strong>" . JText::_('Not Installed successfully') . "</strong>";
			}
			?>
			</td>
		</tr>
		<tr class="row1">
			<td class="key" colspan="2"><?php echo 'HD FLV Player -' . JText::_('Module'); ?>
			</td>
			<td style="text-align: center;"><?php
			//check installed modules
			$db = &JFactory::getDBO();
			//                $db->setQuery("SELECT extension_id FROM #__extensions WHERE type = 'module' AND element = 'mod_hdflvplayer' LIMIT 1");
			if (version_compare(JVERSION, '1.6.0', 'ge')) {
				$db->setQuery("SELECT extension_id FROM #__extensions WHERE type = 'module' AND element = 'mod_hdflvplayer' LIMIT 1");
			} else {
				$db->setQuery("SELECT id FROM #__modules WHERE module = 'mod_hdflvplayer' LIMIT 1");
			}
			$id = $db->loadResult();
			if ($id) {
				if ($upgra == 'upgrade') {
					echo "<strong>" . JText::_('Upgrade successfully') . "</strong>";
				} else {
					echo "<strong>" . JText::_('Installed successfully') . "</strong>";
				}
			} else {
				echo "<strong>" . JText::_('Not Installed successfully') . "</strong>";
			}
			?>
			</td>
		</tr>
		<tr>

			<th colspan="3"><?php echo JText::_('Plugins'); ?></th>
		</tr>
		<tr class="row0">
			<td class="key" colspan="2"><?php echo 'HD FLV Player -' . JText::_('Plugin'); ?>
			</td>

			<td style="text-align: center;"><?php
			//check installed plugin
			$db = &JFactory::getDBO();
			if (version_compare(JVERSION, '1.6.0', 'ge')) {
				$db->setQuery("SELECT extension_id FROM #__extensions WHERE type = 'plugin' AND element = 'hdflvplayer' AND folder = 'content' LIMIT 1");
			} else {
				$db->setQuery("SELECT id FROM #__plugins WHERE element = 'hdflvplayer' LIMIT 1");
			}
			//                $db->setQuery("SELECT extension_id FROM #__extensions WHERE type = 'plugin' AND element = 'hdflvplayer' AND folder = 'content' LIMIT 1");
			$id = $db->loadResult();
			if ($id) {
				if ($upgra == 'upgrade') {
					echo "<strong>" . JText::_('Upgrade successfully') . "</strong>";
				} else {
					echo "<strong>" . JText::_('Installed successfully') . "</strong>";
				}
			} else {
				echo "<strong>" . JText::_('Not Installed successfully') . "</strong>";
			}
			?>
			</td>
		</tr>
	</tbody>
</table>
