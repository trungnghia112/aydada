<?php
/**
 * @name          : Joomla HD Video Share
 * @version	  : 3.4.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component PlayerSettings Model
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */

##  No direct access to this file
defined( '_JEXEC' ) or die( 'Restricted access' );
##  import joomla model library
jimport('joomla.application.component.model');
## Import filesystem libraries.
jimport('joomla.filesystem.file');


## Contushdvideoshare Component Administrator Player Settings Model
class contushdvideoshareModelsettings extends ContushdvideoshareModel
{
	## function to get player settings
	function showplayersettings()
	{
		$db = JFactory::getDBO();
		## query to fetch player settings
		$query = "SELECT `id`, `player_colors`, `player_icons`, `player_values`,`logopath` FROM #__hdflv_player_settings";
		$db->setQuery( $query);
		$arrPlayerSettings = $db->loadObjectList();
		return $arrPlayerSettings;
	}

	## function to save player settings
	function saveplayersettings()
	{
		$option = JRequest::getCmd('option');
		$arrFormData = JRequest::get('post');
		$mainframe = JFactory::getApplication();
		## Get the object for settings
		$objPlayerSettingsTable = JTable::getInstance('settings', 'Table');		
		$id = 1;
                $objPlayerSettingsTable->load($id);
                
		## load a row from the database

                ## Get Player colors and serialize data
                $player_color               = array(
                    'sharepanel_up_BgColor'     => $arrFormData['sharepanel_up_BgColor'],
                    'sharepanel_down_BgColor'   => $arrFormData['sharepanel_down_BgColor'],
                    'sharepaneltextColor'       => $arrFormData['sharepaneltextColor'],
                    'sendButtonColor'           => $arrFormData['sendButtonColor'],
                    'sendButtonTextColor'       => $arrFormData['sendButtonTextColor'],
                    'textColor'                 => $arrFormData['textColor'],
                    'skinBgColor'               => $arrFormData['skinBgColor'],
                    'seek_barColor'             => $arrFormData['seek_barColor'],
                    'buffer_barColor'           => $arrFormData['buffer_barColor'],
                    'skinIconColor'             => $arrFormData['skinIconColor'],
                    'pro_BgColor'               => $arrFormData['pro_BgColor'],
                    'playButtonColor'           => $arrFormData['playButtonColor'],
                    'playButtonBgColor'         => $arrFormData['playButtonBgColor'],
                    'playerButtonColor'         => $arrFormData['playerButtonColor'],
                    'playerButtonBgColor'       => $arrFormData['playerButtonBgColor'],
                    'relatedVideoBgColor'       => $arrFormData['relatedVideoBgColor'],
                    'scroll_barColor'           => $arrFormData['scroll_barColor'],
                    'scroll_BgColor'            => $arrFormData['scroll_BgColor']
                );
                $arrFormData['player_colors'] = serialize($player_color);
                ## Get Player values and serialize data
                $player_values                  = array(
                    'buffer'                    => $arrFormData['buffer'],
                    'width'                     => $arrFormData['width'],
                    'height'                    => $arrFormData['height'],
                    'normalscale'               => $arrFormData['normalscale'],
                    'fullscreenscale'           => $arrFormData['fullscreenscale'],
                    'volume'                    => $arrFormData['volume'],
                    'nrelated'                  => 8,
                    'ffmpegpath'                => $arrFormData['ffmpegpath'],
                    'stagecolor'                => $arrFormData['stagecolor'],
                    'licensekey'                => $arrFormData['licensekey'],
                    'logourl'                   => $arrFormData['logourl'],
                    'logoalpha'                 => $arrFormData['logoalpha'],
                    'logoalign'                 => $arrFormData['logoalign'],
                    'adsSkipDuration'           => $arrFormData['adsSkipDuration'],
                    'googleanalyticsID'         => $arrFormData['googleanalyticsID'],
                    'midbegin'                  => $arrFormData['midbegin'],
                    'midinterval'               => $arrFormData['midinterval'],
                    'related_videos'            => $arrFormData['related_videos'],
                    'relatedVideoView'          => $arrFormData['relatedVideoView'],
                    'login_page_url'            => $arrFormData['login_page_url']
                );
                $arrFormData['player_values'] = serialize($player_values);

                ## Get player icon options and serialize data
                $player_icons                   = array(
                    'autoplay'                  => $arrFormData['autoplay'],
                    'playlist_autoplay'         => $arrFormData['playlist_autoplay'],
                    'playlist_open'             => $arrFormData['playlist_open'],
                    'skin_autohide'             => $arrFormData['skin_autohide'],
                    'fullscreen'                => $arrFormData['fullscreen'],
                    'zoom'                      => $arrFormData['zoom'],
                    'timer'                     => $arrFormData['timer'],
                    'showTag'                   => $arrFormData['showTag'],
                    'shareurl'                  => $arrFormData['shareurl'],
                    'emailenable'               => $arrFormData['emailenable'],
                    'login_page_url'            => $arrFormData['login_page_url'],
                    'volumevisible'             => $arrFormData['volumevisible'],
                    'embedVisible'              => $arrFormData['embedVisible'],
                    'progressControl'           => $arrFormData['progressControl'],
                    'hddefault'                 => $arrFormData['hddefault'],
                    'imageDefault'              => $arrFormData['imageDefault'],
                    'enabledownload'            => $arrFormData['enabledownload'],
                    'prerollads'                => $arrFormData['prerollads'],
                    'postrollads'               => $arrFormData['postrollads'],
                    'imaads'                    => $arrFormData['imaads'],
                    'volumecontrol'             => $arrFormData['volumecontrol'],
                    'adsSkip'                   => $arrFormData['adsSkip'],
                    'midrollads'                => $arrFormData['midrollads'],
                    'midbegin'                  => $arrFormData['midbegin'],
                    'midrandom'                 => $arrFormData['midrandom'],
                    'midadrotate'               => $arrFormData['midadrotate'],
                    'googleana_visible'         => $arrFormData['googleana_visible']
                );
                $arrFormData['player_icons'] = serialize($player_icons);
		
		##  for logo image
		$logo = JRequest::getVar('logopath', null, 'files', 'array');
		$strRes = $this->logoImageValidation($logo['name']);
		if($logo['name'] && $strRes)
		{
			$strTargetPath = VPATH.DS;
			## Clean up filename to get rid of strange characters like spaces etc
			$strLogoName = JFile::makeSafe($logo['name']);
			$strTargetLogoPath = $strTargetPath.$logo['name'];
			##  To store images to a directory called components/com_contushdvideoshare/videos
			JFile::upload($logo['tmp_name'],$strTargetLogoPath);
			$arrFormData['logopath'] = $strLogoName;
		}

		## bind data to the databse table object.
	
		if (!$objPlayerSettingsTable->bind($arrFormData))
		{
			JError::raiseWarning(500, JText::_($objPlayerSettingsTable->getError()));			
		}

		## store the data into the settings table.
		
		if (!$objPlayerSettingsTable->store()) {
			JError::raiseWarning(500, JText::_($objPlayerSettingsTable->getError()));
		}

		##  set to page redirect
		$link = 'index.php?option=' . $option.'&layout=settings';
		$mainframe->redirect($link, 'Saved Successfully');
	}

	## function to check image type
	function logoImageValidation($logoname)
	{
		##  Get file extension
		$ext = $this->getFileExt($logoname);
		if($ext)
		{
			##  To check file type
			if(($ext!="png") && ($ext!="gif") && ($ext!="jpeg") && ($ext!="jpg"))
			{
				JError::raiseWarning(500, JText::_('File Extensions : Allowed Extensions for image file [ jpg , jpeg , png ] only'));
				return false;
			}else{
				return true;
			}
				
		}
	}

	## function to get file extension
	function getFileExt($filename)
	{
		$filename = strtolower($filename) ;
		return JFile::getExt($filename);
	}
}
?>