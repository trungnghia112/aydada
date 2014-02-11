<?php
/**
 * @name          : Joomla HD Video Share
 ** @version	  : 2.1.0.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Install Script File
 * @Creation Date : March 2010
 * @Modified Date : May 2013
 * */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Script file of Contus HD Video Share component
 */
class com_hdflvplayerInstallerScript {

    /**
     * method to install the component
     *
     * @return void
     */
    function install($parent) {

    }

    /**
     * method to uninstall the component
     *
     * @return void
     */
    function uninstall($parent) {

    }

    /**
     * method to update the component
     *
     * @return void
     */
    function update($parent) {

    }

    /**
     * method to run before an install/update/uninstall method
     *
     * @return void
     */
    function preflight($type, $parent) {
        // $parent is the class calling this method
        // $type is the type of change (install, update or discover_install)
    }

    /**
     * method to run after an install/update/uninstall method
     *
     * @return void
     */
    function postflight($type, $parent) {

        $db = JFactory::getDBO();
        $columnExists_playercolors = $columnExists_playericons = $columnExists_playervalues = false;
        $columnExists_volume=$columnExists_login=$columnExists_imaads=$columnExists_googleplus=$columnExists_tumblr=$columnExists_not_permission=$columnExists_adindicator=$columnExists_youtube_video_removed=$columnExists_youtube_video_url_incorrect=$columnExists_youtube_video_notallow=$columnExists_download=$columnExists_skipadd=false;
        
        $query = 'SHOW COLUMNS FROM `#__hdflvplayerlanguage`';
        $db->setQuery($query);
        $db->query();
        $columnData_lang = $db->loadObjectList();
        foreach ($columnData_lang as $valueColumn) {
            if ($valueColumn->Field == 'player_lang') {
                $columnExists_volume = true;
            }
        }
           
        if (!$columnExists_volume) {
            $db->setQuery("ALTER TABLE  `#__hdflvplayerlanguage` ADD  `player_lang` longtext NOT NULL");
            $db->query();
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

        $query = 'SHOW COLUMNS FROM `#__hdflvplayerupload`';
        $db->setQuery($query);
        $db->query();
        $columnData_upload = $db->loadObjectList();
        foreach ($columnData_upload as $valueColumn) {
            if ($valueColumn->Field == 'imaads') {
                $columnExists_imaads = true;
            }
        }    
        if (!$columnExists_imaads) {
        $db->setQuery("ALTER TABLE  `#__hdflvplayerupload` ADD  `imaads` tinyint(4) NOT NULL");
        $db->query();
        }
        
        $query = 'SHOW COLUMNS FROM `#__hdflvplayerads`';
        $db->setQuery($query);
        $db->query();
        $columnData_imaaddet = $db->loadObjectList();
        foreach ($columnData_imaaddet as $valueColumn) {
            if ($valueColumn->Field == 'imaaddet') {
                $columnExists_imaaddet = true;
            }
        }    
        if (!$columnExists_imaaddet) {
        $db->setQuery("ALTER TABLE  `#__hdflvplayerads` ADD  `imaaddet` longtext NOT NULL");
        $db->query();
        }

        $query = 'SHOW COLUMNS FROM `#__hdflvplayersettings`';
        $db->setQuery($query);
        $db->query();
        $columnData = $db->loadObjectList();
        foreach ($columnData as $valueColumn) {
 
            if ($valueColumn->Field == 'player_colors') {
            $columnExists_playercolors = true;
            }
            if ($valueColumn->Field == 'player_icons') {
            $columnExists_playericons = true;
            }
            if ($valueColumn->Field == 'player_values') {
            $columnExists_playervalues = true;
            }
        }

        if (!$columnExists_playercolors) {
            $db->setQuery("ALTER TABLE  `#__hdflvplayersettings` ADD  `player_colors` longtext NOT NULL");
            $db->query();
            }
        if (!$columnExists_playericons) {
            $db->setQuery("ALTER TABLE  `#__hdflvplayersettings` ADD  `player_icons` longtext NOT NULL");
            $db->query();
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
        if (!$columnExists_playervalues) {
            $db->setQuery("ALTER TABLE  `#__hdflvplayersettings` ADD  `player_values` longtext NOT NULL");
            $db->query();
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



        $status = new stdClass;
        $status->modules = array();
        $src = $parent->getParent()->getPath('source');
        $manifest = $parent->getParent()->manifest;

        $modules = $manifest->xpath('modules/module');
        $root = JPATH_SITE;
        foreach ($modules as $module) {
            $name = (string) $module->attributes()->module;
            $client = (string) $module->attributes()->client;
            $path = $src . '/extensions/' . $name;
            $installer = new JInstaller;
            $result = $installer->install($path);
            if ($result) {

                if (JFile::exists($root . '/modules/' . $name . '/' . $name . '.xml')) {
                    JFile::delete($root . '/modules/' . $name . '/' . $name . '.xml');
                }

                JFile::move($root . '/modules/' . $name . '/' . $name . '.j3.xml', $root . '/modules/' . $name . '/' . $name . '.xml');
            }
            $query = 'UPDATE  #__modules SET published=1 WHERE module = "'.$name.'"';
            $db->setQuery($query);
            $db->query();


            $status->modules[] = array('name' => $name, 'client' => $client, 'result' => $result);
        }

         $plugins = $manifest->xpath('plugins/plugin');
        foreach ($plugins as $plugin) {
            $name = (string)$plugin->attributes()->plugin;
            $group = (string)$plugin->attributes()->group;
            $path = $src.'/extensions/'.$name;
            $installer = new JInstaller;
            $result = $installer->install($path);
            if ($result) {

                if (JFile::exists($root . '/plugins/'.$group.'/' . $name . '/' . $name . '.xml')) {
                    JFile::delete($root . '/plugins/'.$group.'/' . $name . '/' . $name . '.xml');
                }

                JFile::move($root . '/plugins/'.$group.'/' . $name . '/' . $name . '.j3.xml', $root . '/plugins/'.$group.'/' . $name . '/' . $name . '.xml');
            }
            $query = 'UPDATE  #__extensions SET enabled =1 WHERE element = "hdflvplayer"';
            $db->setQuery($query);
            $db->query();
            $status->plugins[] = array('name' => $name, 'group' => $group, 'result' => $result);
        }
                //show thanks message
?>
        <style  type="text/css">
            .row-fluid .span10{width: 84%;}
            table{width: 100%;}
            table.adminlist {
                width: 100%;
                border-spacing: 1px;
                background-color: #f3f3f3;
                color: #666;
            }

            table.adminlist td,
            table.adminlist th {
                padding: 4px;
            }

            table.adminlist td {padding-left: 8px;}

            table.adminlist thead th {
                text-align: center;
                background: #f7f7f7;
                color: #666;
                border-bottom: 1px solid #CCC;
                border-left: 1px solid #fff;
            }

            table.adminlist thead th.left {
                text-align: left;
            }

            table.adminlist thead a:hover {
                text-decoration: none;
            }

            table.adminlist thead th img {
                vertical-align: middle;
                padding-left: 3px;
            }

            table.adminlist tbody th {
                font-weight: bold;
            }

            table.adminlist tbody tr {
                background-color: #fff;
                text-align: left;
            }

            table.adminlist tbody tr.row0:hover td,
            table.adminlist tbody tr.row1:hover td	{
                background-color: #e8f6fe;
            }

            table.adminlist tbody tr td {
                background: #fff;
                border: 1px solid #fff;
            }

            table.adminlist tbody tr.row1 td {
                background: #f0f0f0;
                border-top: 1px solid #FFF;
            }

            table.adminlist tfoot tr {
                text-align: center;
                color: #333;
            }

            table.adminlist tfoot td,table.adminlist tfoot th {
                background-color: #f7f7f7;
                border-top: 1px solid #999;
                text-align: center;
            }

            table.adminlist td.order {
                text-align: center;
                white-space: nowrap;
                width: 200px;
            }

            table.adminlist td.order span {
                float: left;
                width: 20px;
                text-align: center;
                background-repeat: no-repeat;
                height: 13px;
            }

            table.adminlist .pagination {
                display: inline-block;
                padding: 0;
                margin: 0 auto;
            }
        </style>
        <div style="float: left;">
            <a href="http://www.apptha.com/category/extension/Joomla/HD-FLV-Player" target="_blank">
                <img src="components/com_hdflvplayer/assets/platoon.png" alt="Joomla! HDFLV Player" align="left" />
            </a>
            <br />
    <br />
    <p>Joomla HD FLV Player enhances the quality of your Joomla sites or blogs. Some of the most salient features like Lighttpd, RTMP streaming,
        Monetization, Native language support, Bookmarking etc makes the Player Unique!!
        HTML5 support in the Player facilitates the purpose of playing it in iPhone and iPads.
        </p>
        </div>
        <div style="float:right;">
            <a href="http://www.apptha.com/" target="_blank">
                <img src="components/com_hdflvplayer/assets/contus.jpg" alt="contus products" align="right" />
            </a>
        </div>
        <br><br>

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
                <tr class="row0">
                    <td class="key" colspan="2"><?php echo 'HD FLV Player -'.JText::_('Component'); ?></td>
                    <td style="text-align: center;">
<?php
//check installed components
        $db = JFactory::getDBO();
        $db->setQuery("SELECT id FROM #__hdflvplayersettings LIMIT 1");
        $id = $db->loadResult();
        if ($id) {
                    echo "<strong>" . JText::_('Installed successfully') . "</strong>";
                } else {
                    echo "<strong>" . JText::_('Not Installed successfully') . "</strong>";
                }
?>
            </td>
        </tr>
        <tr class="row1">
            <td class="key" colspan="2"><?php echo 'HD FLV Player - ' . JText::_('Module'); ?></td>
            <td style="text-align: center;">
<?php
                //check installed modules
                $db = JFactory::getDBO();
                if (!version_compare(JVERSION, '1.5.0', 'ge')) {
                    $db->setQuery("SELECT extension_id FROM #__extensions WHERE type = 'module' AND element = 'mod_hdflvplayer' LIMIT 1");
                }
                $id = $db->loadResult();
                if ($id) {
                    echo "<strong>" . JText::_('Installed successfully') . "</strong>";
                } else {
                    echo "<strong>" . JText::_('Not Installed successfully') . "</strong>";
                }
?>
            </td>
        </tr>

        <tr class="row0">
            <td class="key" colspan="2"><?php echo 'HD FLV Player - ' . JText::_('Plugin'); ?></td>
            <td style="text-align: center;">
<?php
                //check installed modules
                $db = JFactory::getDBO();
                if (!version_compare(JVERSION, '1.5.0', 'ge')) {
                    $db->setQuery("SELECT extension_id FROM #__extensions WHERE type = 'plugin' AND element = 'hdflvplayer' AND folder = 'content' LIMIT 1");
                }
                $id = $db->loadResult();
                if ($id) {
                    echo "<strong>" . JText::_('Installed successfully') . "</strong>";
                } else {
                    echo "<strong>" . JText::_('Not Installed successfully') . "</strong>";
                }
?>
            </td>
        </tr>

    </tbody>
</table>
<?php
            }

        }

