<?php
/**
 * @name 	        playersettings.php
 ** @version	        2.1.0.1
 * @package	        Apptha
 * @since	        Joomla 1.5
 * @author      	Apptha - http://www.apptha.com/
 * @copyright 		Copyright (C) 2011 Powered by Apptha
 * @license 		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      	Contus HD FLV Player settings model file
 * @Creation Date	23 Feb 2011
 * @modified Date	28 Aug 2013
 */
## No direct acesss
defined('_JEXEC') or die();

## importing defalut joomla components
jimport('joomla.application.component.model');

## importing defalut joomla file system libraries
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

/*
 * HDFLV player Model class to change/show player settings
 */

class hdflvplayerModelplayersettings extends HdflvplayerModel {

    ## Fetch player settings
    function playersettingsmodel() {
        $db = JFactory::getDBO();

        ## Query to display player settings
        $query = 'SELECT `id`, `published`, `logopath`,`player_icons` , `player_colors`, `player_values` FROM `#__hdflvplayersettings`';
        $db->setQuery($query);
        $settingResult = $db->loadObject();

        ##  Get player settings from table
        return($settingResult);
    }

    ## Save player settings
    function saveplayersettings($task) {
        $option                     = 'com_hdflvplayer';
        $db                         = JFactory::getDBO();
        $rs_savesettings            = JTable::getInstance('hdflvplayer', 'Table');

        ## Loads record from table
        $cid                        = JRequest::getVar('cid', array(0), '', 'array');
        $id                         = $cid[0];
        $rs_savesettings->load($id);

        $settingsResult             = JRequest::get('post');

        ## Get Player colors and serialize data
        $player_color               = array(
            'sharepanel_up_BgColor'     => $settingsResult['sharepanel_up_BgColor'],
            'sharepanel_down_BgColor'   => $settingsResult['sharepanel_down_BgColor'],
            'sharepaneltextColor'       => $settingsResult['sharepaneltextColor'],
            'sendButtonColor'           => $settingsResult['sendButtonColor'],
            'sendButtonTextColor'       => $settingsResult['sendButtonTextColor'],
            'textColor'                 => $settingsResult['textColor'],
            'skinBgColor'               => $settingsResult['skinBgColor'],
            'seek_barColor'             => $settingsResult['seek_barColor'],
            'buffer_barColor'           => $settingsResult['buffer_barColor'],
            'skinIconColor'             => $settingsResult['skinIconColor'],
            'pro_BgColor'               => $settingsResult['pro_BgColor'],
            'playButtonColor'           => $settingsResult['playButtonColor'],
            'playButtonBgColor'         => $settingsResult['playButtonBgColor'],
            'playerButtonColor'         => $settingsResult['playerButtonColor'],
            'playerButtonBgColor'       => $settingsResult['playerButtonBgColor'],
            'relatedVideoBgColor'       => $settingsResult['relatedVideoBgColor'],
            'scroll_barColor'           => $settingsResult['scroll_barColor'],
            'scroll_BgColor'            => $settingsResult['scroll_BgColor']
        );
        $settingsResult['player_colors'] = serialize($player_color);
        
        ## Get Player values and serialize data
        $player_values                  = array(
            'buffer'                    => $settingsResult['buffer'],
            'width'                     => $settingsResult['playerwidth'],
            'height'                    => $settingsResult['playerheight'],
            'normalscale'               => $settingsResult['normalscale'],
            'fullscreenscale'           => $settingsResult['fullscreenscale'],
            'volume'                    => $settingsResult['volume'],
            'ffmpegpath'                => $settingsResult['ffmpegpath'],
            'stagecolor'                => $settingsResult['stagecolor'],
            'licensekey'                => $settingsResult['licensekey'],
            'logourl'                   => $settingsResult['logourl'],
            'logoalpha'                 => $settingsResult['logoalpha'],
            'logoalign'                 => $settingsResult['logoalign'],
            'adsSkipDuration'           => $settingsResult['adsSkipDuration'],
            'googleanalyticsID'         => $settingsResult['googleanalyticsID'],
            'midbegin'                  => $settingsResult['midbegin'],
            'midinterval'               => $settingsResult['midinterval'],
            'related_videos'            => $settingsResult['related_videos'],
            'relatedVideoView'          => $settingsResult['relatedVideoView'],
            'nrelated'                  => $settingsResult['nrelated'],
            'urllink'                   => $settingsResult['urllink']
        );
        $settingsResult['player_values'] = serialize($player_values);
        
        ## Get player icon options and serialize data
        $player_icons                   = array(
            'autoplay'                  => $settingsResult['autoplay'],
            'playlist_autoplay'         => $settingsResult['playlist_autoplay'],
            'playlist_open'             => $settingsResult['playlist_open'],
            'skin_autohide'             => $settingsResult['skin_autohide'],
            'fullscreen'                => $settingsResult['fullscreen'],
            'zoom'                      => $settingsResult['zoom'],
            'timer'                     => $settingsResult['timer'],
            'shareurl'                  => $settingsResult['shareurl'],
            'email'                     => $settingsResult['email'],
            'volumevisible'             => $settingsResult['volumevisible'],
            'progressbar'               => $settingsResult['progressbar'],
            'hddefault'                 => $settingsResult['hddefault'],
            'imageDefault'              => $settingsResult['imageDefault'],
            'download'                  => $settingsResult['download'],
            'prerollads'                => $settingsResult['prerollads'],
            'postrollads'               => $settingsResult['postrollads'],
            'imaAds'                    => $settingsResult['imaAds'],
            'adsSkip'                   => $settingsResult['adsSkip'],
            'midrollads'                => $settingsResult['midrollads'],
            'midadrotate'               => $settingsResult['midadrotate'],
            'midrandom'                 => $settingsResult['midrandom'],
            'title_ovisible'            => $settingsResult['title_ovisible'],
            'description_ovisible'      => $settingsResult['description_ovisible'],
            'showTag'                   => $settingsResult['showTag'],
            'viewed_visible'            => $settingsResult['viewed_visible'],
            'embedcode_visible'         => $settingsResult['embedcode_visible'],
            'playlist_dvisible'         => $settingsResult['playlist_dvisible'],
        );
        $settingsResult['player_icons'] = serialize($player_icons);
        
        ## Binds the given input fields with table columns
        if (!$rs_savesettings->bind($settingsResult)) {
            JError::raiseError(500, JText::_($rs_savesettings->getError()));
        }

        ## Stores the given input in appropriate fields in the table
        if (!$rs_savesettings->store()) {
            JError::raiseError(500, JText::_($rs_savesettings->getError()));
        }

        ## Uploads logo file
        $file                           = JRequest::getVar('logopath', null, 'files', 'array');
        $logo_name                      = JFile::makeSafe($file['name']);
        $src                            = $file['tmp_name'];            ## Getting source path to upload
        $exts                           = JFile::getExt($logo_name);    ## Getting extension of file to upload


        if ($logo_name != '') {
            $vpath                      = VPATH . '/';
            $target_path_logo           = $vpath . $logo_name;

            ##  Validation for logopath extensions
            if (($exts != "png") && ($exts != "gif") && ($exts != "jpeg") && ($exts != "jpg")) { ##  To check file type
                JError::raiseWarning(406, JText::_('File Extensions:Allowed Extensions for image file is .jpg,.jpeg,.png'));
            }

            ##  To store images to a directory called components/com_hdflvplayer/videos
            else if (JFile::upload($src, $target_path_logo)) {
                $query = 'UPDATE #__hdflvplayersettings SET logopath=\'' . $logo_name . '\'';
                $db->setQuery($query);
                $db->query();
            }
        }

        ## After changes, redirect based on task.
        switch ($task) {
            case 'applyplayersettings':
                $msg    = 'Changes Saved';
                $link   = 'index.php?option=' . $option . '&task=editplayersettings&cid[]=' . $rs_savesettings->id;
                break;
            case 'saveplayersettings':
            default:
                $msg    = 'Saved';
                $link   = 'index.php?option=' . $option . '&task=playersettings';
                break;
        }

        ##  page redirect
        JFactory::getApplication()->redirect($link, $msg);
    }

}
?>