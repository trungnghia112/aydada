<?php
/**
 * @name          : Joomla HD Video Share
 * @version	  : 3.4.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component Configxml Model
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */

## No direct acesss
defined('_JEXEC') or die('Restricted access');
##  import Joomla model library
jimport('joomla.application.component.model');

## Contushdvideoshare Component Configxml Model

class Modelcontushdvideoshareconfigxml extends ContushdvideoshareModel {
    ## function to get player settings

    function configgetrecords() {
        $base           = JURI::base();
        $db             = JFactory::getDBO();
        $query          = "SELECT `id`, `published`, `player_colors`, `player_icons`, `player_values`, `logopath` FROM #__hdflv_player_settings";
        $db->setQuery($query);
        $settingsrows   = $db->loadObjectList();
        $this->configxml($settingsrows, $base);
    }

    ## function to generate config xml

    function configxml($settingsrows, $base) {
        $googleanalyticsID = $IMAAds_path = $login_page_url = $player_colors = $player_icons = $player_values = $license = $playlistxml = '';
        $playlist_open = $postrollads = $prerollads = $IMAAds = $zoom = $volumecontrol = $imageDefault = $progressControl = $showTag = 
        $adsSkip = $emailenable = $enabledownload = $autoplay = $embedVisible = $midrollads = $googleana_visible = $hddefault = 
        $playlist_autoplay = $timer = $share = $playlist = $fullscreen = $skin_autohide = "false";
        
        ## Get player settings and unserialize data
        $player_colors              = unserialize($settingsrows[0]->player_colors);
        $player_icons               = unserialize($settingsrows[0]->player_icons);
        $player_values              = unserialize($settingsrows[0]->player_values);
        
        $buffer                     = $player_values['buffer'];                     ## Get video buffer duration
        $normalscale                = $player_values['normalscale'];                ## Get normal screen scale ratio
        $fullscreenscale            = $player_values['fullscreenscale'];            ## Get full screen scale ratio
        $volume                     = $player_values['volume'];                     ## Get player volume
        $logoalpha                  = $player_values['logoalpha'];                  ## Get logo alpha

        ## Get skin path
        $skin                       = $base . "components/com_contushdvideoshare/hdflvplayer/skin/skin_hdflv_white.swf";
        $stagecolor                 = "0x" . $player_values['stagecolor'];          ## Get stage color
        
        ## Enable/Disable video autoplay
        if ($player_icons['autoplay'] == 1) {
            $autoplay               = "true";
        } 
        ## Enable/Disable video autoplay
        if ($player_icons['emailenable'] == 1) {
            $emailenable            = "true";
        } 
        ## Enable/Disable zoom option
        if ($player_icons['zoom'] == 1) {
            $zoom                   = "true";
        } 
        ## Get login url for player login button
        if (!empty($player_icons['login_page_url'])) {
            $login_page_url         = $player_icons['login_page_url'];
        } 
        ## Enable/Disable fullscreen option
        if ($player_icons['fullscreen'] == 1) {
            $fullscreen             = "true";
        } 
        ## Enable/Disable embed option
        if ($player_icons['embedVisible'] == 1) {
            $embedVisible           = "true";
        } 
        ## Enable/Disable download option
        if ($player_icons['enabledownload'] == 1) {
            $enabledownload         = "true";
        } 
        ## Enable/Disable volume control
        if ($player_icons['volumecontrol'] == 1) {
            $volumecontrol          = "true";
        } 
        ## Enable/Disable Progress control
        if ($player_icons['progressControl'] == 1) {
            $progressControl        = "true";
        } 
        ## Enable/Disable default preview image option
        if ($player_icons['imageDefault'] == 1) {
            $imageDefault           = "true";
        } 
        ## Enable/Disable skin auto hide option
        if ($player_icons['skin_autohide'] == 1) {
            $skin_autohide          = "true";
        } 
//        echo "<pre>";print_r($player_icons);exit;
        ## Enable/Disable timer option
        if ($player_icons['timer'] == 1) {
            $timer                  = "true";
        }
        ## Enable/Disable description on the player
        if ($player_icons['showTag'] == 1) {
            $showTag                = "true";
        }
        ## Enable/Disable share option
        if ($player_icons['shareurl'] == 1) {
            $share                  = "true";
        } 
        ## Enable/Disable playlist autoplay option
        if ($player_icons['playlist_autoplay'] == 1) {
            $playlist_autoplay      = "true";
        }
        ## Enable/Disable hddefault option
        if ($player_icons['hddefault'] == 1) {
            $hddefault              = "true";
        }
        ## Enable/Disable google tracker option
        if ($player_icons['googleana_visible'] == 1) {
            $googleana_visible      = "true";
        } 
        ## Get tracker code
        if ($googleana_visible == "true") {
            $googleanalyticsID      = $player_values['googleanalyticsID'];
        }
        ## Enable/Disable related videos on the player
        if ($player_values['related_videos'] == "1") {
            $playlist               = "true";
        }
        ## Get license key
        if ($player_values['licensekey'] != '') {
            $license                = $player_values['licensekey'];
        }
        ## Enable/Disable playlist open option
        if ($player_icons['playlist_open'] == 1) {
            $playlist_open          = "true";
        } 
        ## Enable/Disable postroll ad option
        if ($player_icons['postrollads'] == 1) {
            $postrollads            = "true";
        } 
        ## Enable/Disable preroll ad option
        if ($player_icons['prerollads'] == 1) {
            $prerollads             = "true";
        }
        ## Enable/Disable ad skip option
        if ($player_icons['adsSkip'] == 1) {
            $adsSkip                = "true";
        }
        ## Enable/Disable modroll ad option
        if ($player_icons['midrollads'] == 1) {
            $midrollads             = "true";
        } 
        ## Enable/Disable ima ad option
        if ($player_icons['imaads'] == 1) {
            $IMAAds                 = "true";
        } 
        ## Get IMA ad path
        if ($IMAAds == "true") {
            $IMAAds_path            = JURI::base() . "index.php?option=com_contushdvideoshare&view=imaadxml";
        }

        ## Playlist xml path
         if (JRequest::getString('mid')=='playerModule') {
            $playlistxml            = $base . "index.php?option=com_contushdvideoshare&view=playxml&mid=playerModule&id=" . JRequest::getVar('id', '', 'get', 'int') . "&catid=" . JRequest::getVar('catid', '', 'get', 'int');
        } else if (JRequest::getVar('catid', '', 'get', 'int')) {
            $playlistxml            = $base . "index.php?option=com_contushdvideoshare&view=playxml&id=" . JRequest::getVar('id', '', 'get', 'int') . "&catid=" . JRequest::getVar('catid', '', 'get', 'int');
        } elseif (JRequest::getVar('id', '', 'get', 'int')) {
            $adminview = JRequest::getString('adminview');
            if($adminview==true){
                $adminviewbase= '&adminview=true';
            } else {
                $adminviewbase= '';
            }
            $playlistxml            = $base . "index.php?option=com_contushdvideoshare&view=playxml&id=" . JRequest::getVar('id', '', 'get', 'int').$adminviewbase;
        } else {
            $playlistxml            = $base . "index.php?option=com_contushdvideoshare&view=playxml&featured=true";
        }
        
        $adsxml                     = JURI::base() . "index.php?option=com_contushdvideoshare&view=adsxml";             ## Ad xml path
        $emailpath                  = $base . "components/com_contushdvideoshare/hdflvplayer/email.php";                ## Send email in player
        $logopath                   = $base . "components/com_contushdvideoshare/videos/" . $settingsrows[0]->logopath; ## Logo path for purchased user
        $languagexml                = $base . "index.php?option=com_contushdvideoshare&view=languagexml";               ## Language xml path
        $midrollxml                 = $base . "index.php?option=com_contushdvideoshare&view=midrollxml";                ## Mid roll xml path
        $baseUrl                    = JURI::base();
        $baseUrl1                   = parse_url($baseUrl);
        $baseUrl1                   = $baseUrl1['scheme'] . '://' . $baseUrl1['host'];          ## Generate base url
        ## Video download file path
        $downloadpath               = $baseUrl1 . JRoute::_('index.php?option=com_contushdvideoshare&task=downloadfile&f=FILE');
        ## Generate config xml here
        ob_clean();
        
        header("content-type: text/xml");
        echo '<?xml version="1.0" encoding="utf-8"?>';
        echo '<config>
        <stagecolor>' . $stagecolor . '</stagecolor>
        <autoplay>' . $autoplay . '</autoplay>
        <buffer>' . $buffer . '</buffer>
        <volume>' . $volume . '</volume>
        <normalscale>' . $normalscale . '</normalscale>
        <fullscreenscale>' . $fullscreenscale . '</fullscreenscale>
        <license>' . $license . '</license>
        <logopath>' . $logopath . '</logopath>
        <logoalpha>' . $logoalpha . '</logoalpha>
        <logoalign>' . $player_values['logoalign'] . '</logoalign>
        <logo_target>' . $player_values['logourl'] . '</logo_target>
        <sharepanel_up_BgColor>' . $player_colors['sharepanel_up_BgColor'] . '</sharepanel_up_BgColor>
        <sharepanel_down_BgColor>' . $player_colors['sharepanel_down_BgColor'] . '</sharepanel_down_BgColor>
        <sharepaneltextColor>' . $player_colors['sharepaneltextColor'] . '</sharepaneltextColor>
        <sendButtonColor>' . $player_colors['sendButtonColor'] . '</sendButtonColor>
        <sendButtonTextColor>' . $player_colors['sendButtonTextColor'] . '</sendButtonTextColor>
        <textColor>' . $player_colors['textColor'] . '</textColor>
        <skinBgColor>' . $player_colors['skinBgColor'] . '</skinBgColor>
        <seek_barColor>' . $player_colors['seek_barColor'] . '</seek_barColor>
        <buffer_barColor>' . $player_colors['buffer_barColor'] . '</buffer_barColor>
        <skinIconColor>' . $player_colors['skinIconColor'] . '</skinIconColor>
        <pro_BgColor>' . $player_colors['pro_BgColor'] . '</pro_BgColor>
        <playButtonColor>' . $player_colors['playButtonColor'] . '</playButtonColor>
        <playButtonBgColor>' . $player_colors['playButtonBgColor'] . '</playButtonBgColor>
        <playerButtonColor>' . $player_colors['playerButtonColor'] . '</playerButtonColor>
        <playerButtonBgColor>' . $player_colors['playerButtonBgColor'] . '</playerButtonBgColor>
        <relatedVideoBgColor>' . $player_colors['relatedVideoBgColor'] . '</relatedVideoBgColor>
        <scroll_barColor>' . $player_colors['scroll_barColor'] . '</scroll_barColor>
        <scroll_BgColor>' . $player_colors['scroll_BgColor'] . '</scroll_BgColor>
        <skin>' . $skin . '</skin>
        <skin_autohide>' . $skin_autohide . '</skin_autohide>
        <languageXML>' . $languagexml . '</languageXML>
        <registerpage>' . $login_page_url . '</registerpage>
        <playlistXML>' . $playlistxml . '</playlistXML>
        <adXML>' . $adsxml . '</adXML>
        <preroll_ads>' . $prerollads . '</preroll_ads>
        <postroll_ads>' . $postrollads . '</postroll_ads>
        <midrollXML>' . $midrollxml . '</midrollXML>
        <midroll_ads>' . $midrollads . '</midroll_ads>
        <playlist_open>' . $playlist_open . '</playlist_open>
        <showPlaylist>' . $playlist . '</showPlaylist>
        <HD_default>' . $hddefault . '</HD_default>
        <shareURL>' . $emailpath . '</shareURL>
        <embed_visible>' . $embedVisible . '</embed_visible>
        <Download>' . $enabledownload . '</Download>
        <downloadUrl>' . $downloadpath . '</downloadUrl>
        <adsSkip>' . $adsSkip . '</adsSkip>
        <adsSkipDuration>' . $player_values['adsSkipDuration'] . '</adsSkipDuration>
        <relatedVideoView>' . $player_values['relatedVideoView'] . '</relatedVideoView>
        <imaAds>' . $IMAAds . '</imaAds>
        <imaAdsXML>' . $IMAAds_path . '</imaAdsXML>
        <trackCode>' . $googleanalyticsID . '</trackCode>
        <showTag>' . $showTag . '</showTag>
        <timer>' . $timer . '</timer>
        <zoomIcon>' . $zoom . '</zoomIcon>
        <email>' . $emailenable . '</email>
        <shareIcon>' . $share . '</shareIcon>
        <fullscreen>' . $fullscreen . '</fullscreen>
        <volumecontrol>' . $volumecontrol . '</volumecontrol>
        <playlist_auto>' . $playlist_autoplay . '</playlist_auto>
        <progressControl>' . $progressControl . '</progressControl>
        <imageDefault>' . $imageDefault . '</imageDefault>
        </config>';
        exit();
    }
}