<?php
/**
 * @name          : Joomla HD Video Share
 * @version	  : 3.4.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Install Script File
 * @Creation Date : March 2010
 * @Modified Date : May 2013
 * */
## No direct access to this file
defined('_JEXEC') or die('Restricted access');

## Script file of Contus HD Video Share component
class com_contushdvideoshareInstallerScript {

    ## method to install the component 
    function install($parent) {
        $user = JFactory::getUser();
        $userid = $user->get('id');
        $db = JFactory::getDBO();
        $groupname = 8;
        $db->setQuery("INSERT INTO `#__hdflv_upload` (`id`, `memberid`, `published`, `title`,`seotitle`, `featured`, `type`, `rate`, `ratecount`, `times_viewed`, `videos`, `filepath`, `videourl`, `thumburl`, `previewurl`, `hdurl`, `home`, `playlistid`, `duration`, `ordering`, `streamerpath`, `streameroption`, `postrollads`, `prerollads`, `description`, `targeturl`, `download`, `prerollid`, `postrollid`, `created_date`, `addedon`, `usergroupid`,`useraccess`,`islive`,`imaads`,`embedcode`) VALUES
                    (1, $userid, 1, 'The Hobbit: The Desolation of Smaug International Trailer','The-Hobbit-The-Desolation-of-Smaug-International-Trailer', 1, 0, 9, 2, 3, '', 'Youtube', 'http://www.youtube.com/watch?v=TeGb5XGk2U0', 'http://img.youtube.com/vi/TeGb5XGk2U0/mqdefault.jpg', 'http://img.youtube.com/vi/TeGb5XGk2U0/mqdefault.jpg', '', 0, 9, '', 0, '', '', 0, 0, '', '', 0, 0, 0, '2010-06-05 01:06:06', '2010-06-28 16:26:39',$groupname,0,0,0,''),
                    (2, $userid, 1, 'Iron Man 3', 'Iron-Man-3',1, 0, 0, 0, 95, '', 'Youtube', 'http://www.youtube.com/watch?v=Ke1Y3P9D0Bc', 'http://img.youtube.com/vi/Ke1Y3P9D0Bc/mqdefault.jpg', 'http://img.youtube.com/vi/Ke1Y3P9D0Bc/mqdefault.jpg', '', 0, 14, '', 0, '', '', 0, 0, '', '', 0, 0, 0, '2010-06-05 01:06:28', '2010-06-28 16:45:59',$groupname,0,0,0,''),
                    (3, $userid, 1, 'GI JOE 2 Retaliation Trailer 2','GI-JOE-2-Retaliation-Trailer-2', 1, 0, 5, 1, 9, '', 'Youtube', 'http://www.youtube.com/watch?v=mKNpy-tGwxE', 'http://img.youtube.com/vi/mKNpy-tGwxE/mqdefault.jpg', 'http://img.youtube.com/vi/mKNpy-tGwxE/mqdefault.jpg', '', 0, 5, '', 0, '', '', 0, 0, '', '', 0, 0, 0, '2010-06-05 01:06:25', '2010-06-28 16:29:39',$groupname,0,0,0,''),
                    (4, $userid, 1, 'UP HD 1080p Trailer','UP-HD-1080p-Trailer', 1, 0, 0, 0, 29, '', 'Youtube', 'http://www.youtube.com/watch?v=1cRuA64m_lY', 'http://img.youtube.com/vi/1cRuA64m_lY/mqdefault.jpg', 'http://img.youtube.com/vi/1cRuA64m_lY/mqdefault.jpg', '', 0, 5, '', 0, '', '', 0, 0, '', '', 0, 0, 0, '2010-06-05 01:06:57', '2010-06-28 17:09:46',$groupname,0,0,0,''),
                    (5, $userid, 1, 'Chipwrecked: Survival Tips', 'Chipwrecked-Survival-Tips',1, 0, 0, 0, 8, '', 'Youtube', 'http://www.youtube.com/watch?v=dLIEKGNYbVU', 'http://img.youtube.com/vi/dLIEKGNYbVU/mqdefault.jpg', 'http://img.youtube.com/vi/dLIEKGNYbVU/mqdefault.jpg', '', 0, 5, '', 0, '', '', 0, 0, '', '', 0, 0, 0, '2010-06-05 01:06:46', '2010-06-28 16:16:11',$groupname,0,0,0,''),
                    (6, $userid, 1, 'THE TWILIGHT SAGA: BREAKING DAWN PART 2','THE-TWILIGHT-SAGA-BREAKING-DAWN-PART-2', 1, 0, 0, 0, 8, '', 'Youtube', 'http://www.youtube.com/watch?v=ey0aA3YY0Mo', 'http://img.youtube.com/vi/ey0aA3YY0Mo/mqdefault.jpg', 'http://img.youtube.com/vi/ey0aA3YY0Mo/mqdefault.jpg', '', 0, 11, '', 0, '', '', 0, 0, '', '', 0, 0, 0, '2011-01-24 06:01:26', '2011-01-24 11:31:26',$groupname,0,0,0,'');
                    ");
        $db->query();
    }

    ## method to uninstall the component
    function uninstall($parent) {

    }

    ## method to update the component
    function update($parent) {

    }

    ## method to run before an install/update/uninstall method
    function preflight($type, $parent) {
        ## $parent is the class calling this method
        ## $type is the type of change (install, update or discover_install)
    }

    ## method to run after an install/update/uninstall method
    function postflight($type, $parent) {

        $db = JFactory::getDBO();
        $player_colorscolumnExists = $player_valuescolumnExists = $imaadscolumnExists = $embedcodecolumnExists = $subtitle1codecolumnExists = $subtitle2codecolumnExists = $subtile_lang2codecolumnExists = $subtile_lang1codecolumnExists = $imaaddetcolumnExists = $dispenablecolumnExists = $sidethumbviewcolumnExists = $homethumbviewcolumnExists = $player_iconscolumnExists = $thumbviewcolumnExists = 'false';
        $query = 'SELECT id FROM #__hdflv_player_settings LIMIT 1;';
        $db->setQuery($query);
        $result = $db->loadResult();

        if (!empty($result)) {
        
        $playersettingsquery = 'SHOW COLUMNS FROM `#__hdflv_player_settings`';
        $db->setQuery($playersettingsquery);
        $db->query();
        $columnData = $db->loadObjectList();
        foreach ($columnData as $valueColumn) {
            if ($valueColumn->Field == 'player_colors') {
                $player_colorscolumnExists = 'true';
            }
            if ($valueColumn->Field == 'player_icons') {
                $player_iconscolumnExists = 'true';
            }
            if ($valueColumn->Field == 'player_values') {
                $player_valuescolumnExists = 'true';
            }
        }

        $playerquery = 'SELECT * FROM `#__hdflv_player_settings`';
        $db->setQuery($playerquery);
        $playersettingstabeResult = $db->loadObject();
        
        if ($player_colorscolumnExists == 'false') {
            $db->setQuery("ALTER TABLE  `#__hdflv_player_settings` ADD  `player_colors` longtext NOT NULL");
            $db->query();
        }
        if ($player_iconscolumnExists == 'false') {
            $db->setQuery("ALTER TABLE  `#__hdflv_player_settings` ADD  `player_icons` longtext NOT NULL");
            $db->query();
            ## Get player icon options and serialize data
                $updateplayer_icons                   = array(
                    'autoplay'                  => $playersettingstabeResult->autoplay,
                    'playlist_autoplay'         => $playersettingstabeResult->playlist_autoplay,
                    'playlist_open'             => $playersettingstabeResult->playlist_open,
                    'skin_autohide'             => $playersettingstabeResult->skin_autohide,
                    'fullscreen'                => $playersettingstabeResult->fullscreen,
                    'zoom'                      => $playersettingstabeResult->zoom,
                    'timer'                     => $playersettingstabeResult->timer,
                    'showTag'                   => 0,
                    'shareurl'                  => $playersettingstabeResult->shareurl,
                    'emailenable'               => 1,
                    'login_page_url'            => $playersettingstabeResult->login_page_url,
                    'volumevisible'             => 1,
                    'embedVisible'              => 1,
                    'progressControl'           => 1,
                    'hddefault'                 => $playersettingstabeResult->hddefault,
                    'imageDefault'              => 1,
                    'enabledownload'            => 0,
                    'prerollads'                => $playersettingstabeResult->prerollads,
                    'postrollads'               => $playersettingstabeResult->postrollads,
                    'imaads'                    => 0,
                    'volumecontrol'             => 1,
                    'adsSkip'                   => 0,
                    'midrollads'                => $playersettingstabeResult->midrollads,
                    'midbegin'                  => $playersettingstabeResult->midbegin,
                    'midrandom'                 => $playersettingstabeResult->midrandom,
                    'midadrotate'               => $playersettingstabeResult->midadrotate,
                    'googleana_visible'         => $playersettingstabeResult->googleana_visible
                );
                $arrplayer_icons = serialize($updateplayer_icons);
                $query = 'UPDATE #__hdflv_player_settings SET player_icons=\'' .$arrplayer_icons . '\'';
                $db->setQuery($query);
                $db->query();
        }
        if ($player_valuescolumnExists == 'false') {
            $db->setQuery("ALTER TABLE  `#__hdflv_player_settings` ADD  `player_values` longtext NOT NULL");
            $db->query();
            ## Get Player values and serialize data
                $updateplayer_values                  = array(
                    'buffer'                    => $playersettingstabeResult->buffer,
                    'width'                     => $playersettingstabeResult->width,
                    'height'                    => $playersettingstabeResult->height,
                    'normalscale'               => $playersettingstabeResult->normalscale,
                    'fullscreenscale'           => $playersettingstabeResult->fullscreenscale,
                    'volume'                    => $playersettingstabeResult->volume,
                    'nrelated'                  => $playersettingstabeResult->nrelated,
                    'ffmpegpath'                => $playersettingstabeResult->ffmpegpath,
                    'stagecolor'                => $playersettingstabeResult->stagecolor,
                    'licensekey'                => $playersettingstabeResult->licensekey,
                    'logourl'                   => $playersettingstabeResult->logourl,
                    'logoalpha'                 => $playersettingstabeResult->logoalpha,
                    'logoalign'                 => $playersettingstabeResult->logoalign,
                    'adsSkipDuration'           => 5,
                    'googleanalyticsID'         => $playersettingstabeResult->googleanalyticsID,
                    'midbegin'                  => $playersettingstabeResult->midbegin,
                    'midinterval'               => $playersettingstabeResult->midinterval,
                    'related_videos'            => $playersettingstabeResult->related_videos,
                    'relatedVideoView'          => 'side',
                    'login_page_url'            => $playersettingstabeResult->login_page_url
                );
                $arrplayer_values = serialize($updateplayer_values);
                $query = 'UPDATE #__hdflv_player_settings SET player_values=\'' .$arrplayer_values . '\'';
                $db->setQuery($query);
                $db->query();
        }

        $sitesettingsquery = 'SHOW COLUMNS FROM `#__hdflv_site_settings`';
        $db->setQuery($sitesettingsquery);
        $db->query();
        $sitesettingscolumnData = $db->loadObjectList();
        foreach ($sitesettingscolumnData as $valueColumn) {
            if ($valueColumn->Field == 'thumbview') {
                $thumbviewcolumnExists = 'true';
            }
            if ($valueColumn->Field == 'homethumbview') {
                $homethumbviewcolumnExists = 'true';
            }
            if ($valueColumn->Field == 'sidethumbview') {
                $sidethumbviewcolumnExists = 'true';
            }
            if ($valueColumn->Field == 'dispenable') {
                $dispenablecolumnExists = 'true';
            }
        }

        $query = 'SELECT * FROM `#__hdflv_site_settings`';
        $db->setQuery($query);
        $settingstabeResult = $db->loadObject();
            
        if ($thumbviewcolumnExists == 'false') {
            $db->setQuery("ALTER TABLE  `#__hdflv_site_settings` ADD  `thumbview` longtext NOT NULL");
            $db->query();
            ## Get thumbview details and serialize data
                $sitethumbview               = array(
                    'featurrow'             => $settingstabeResult->featurrow,
                    'featurcol'             => $settingstabeResult->featurcol,
                    'recentrow'             => $settingstabeResult->recentrow,
                    'recentcol'             => $settingstabeResult->recentcol,
                    'categoryrow'           => $settingstabeResult->categoryrow,
                    'categorycol'           => $settingstabeResult->categorycol,
                    'popularrow'            => $settingstabeResult->popularrow,
                    'popularcol'            => $settingstabeResult->popularcol,
                    'searchrow'             => $settingstabeResult->searchrow,
                    'searchcol'             => $settingstabeResult->searchcol,
                    'relatedrow'            => $settingstabeResult->relatedrow,
                    'relatedcol'            => $settingstabeResult->relatedcol,
                    'featurwidth'           => $settingstabeResult->featurwidth,
                    'recentwidth'           => $settingstabeResult->recentwidth,
                    'categorywidth'         => $settingstabeResult->categorywidth,
                    'popularwidth'          => $settingstabeResult->popularwidth,
                    'searchwidth'           => $settingstabeResult->searchwidth,
                    'relatedwidth'          => $settingstabeResult->relatedwidth,
                    'memberpagewidth'       => $settingstabeResult->memberpagewidth,
                    'memberpagerow'         => $settingstabeResult->memberpagerow,
                    'memberpagecol'         => $settingstabeResult->memberpagecol,
                    'myvideorow'            => $settingstabeResult->myvideorow,
                    'myvideocol'            => $settingstabeResult->myvideocol,
                    'myvideowidth'          => $settingstabeResult->myvideowidth
                 );
                $arrthumbview = serialize($sitethumbview);
                $query = 'UPDATE #__hdflv_site_settings SET thumbview=\'' .$arrthumbview . '\'';
                $db->setQuery($query);
                $db->query();
        }
        if ($homethumbviewcolumnExists == 'false') {
            $db->setQuery("ALTER TABLE  `#__hdflv_site_settings` ADD  `homethumbview` longtext NOT NULL");
            $db->query();
            ## Get home page thumb details and serialize data
                $sitehomethumbview               = array(
                    'homepopularvideo'      => $settingstabeResult->homepopularvideo,
                    'homepopularvideorow'   => $settingstabeResult->homepopularvideorow,
                    'homepopularvideocol'   => $settingstabeResult->homepopularvideocol,
                    'homefeaturedvideo'     => $settingstabeResult->homefeaturedvideo,
                    'homefeaturedvideorow'  => $settingstabeResult->homefeaturedvideorow,
                    'homefeaturedvideocol'  => $settingstabeResult->homefeaturedvideocol,
                    'homerecentvideo'       => $settingstabeResult->homerecentvideo,
                    'homerecentvideorow'    => $settingstabeResult->homerecentvideorow,
                    'homerecentvideocol'    => $settingstabeResult->homerecentvideocol,
                    'homepopularvideoorder' => $settingstabeResult->homepopularvideoorder,
                    'homefeaturedvideoorder'=> $settingstabeResult->homefeaturedvideoorder,
                    'homerecentvideoorder'  => $settingstabeResult->homerecentvideoorder,
                    'homefeaturedvideoorder'=> $settingstabeResult->homefeaturedvideoorder,
                    'homepopularvideowidth' => $settingstabeResult->homepopularvideowidth,
                    'homefeaturedvideowidth'=> $settingstabeResult->homefeaturedvideowidth,
                    'homerecentvideowidth'  => $settingstabeResult->homerecentvideowidth
                 );
                $arrhomethumbview = serialize($sitehomethumbview);
                $query = 'UPDATE #__hdflv_site_settings SET homethumbview=\'' .$arrhomethumbview . '\'';
                $db->setQuery($query);
                $db->query();
        }
        if ($sidethumbviewcolumnExists == 'false') {
            $db->setQuery("ALTER TABLE  `#__hdflv_site_settings` ADD  `sidethumbview` longtext NOT NULL");
            $db->query();
             ## Get home page thumb details and serialize data
                $sitesidethumbview               = array(
                    'sidepopularvideorow'   => $settingstabeResult->sidepopularvideorow,
                    'sidepopularvideocol'   => $settingstabeResult->sidepopularvideocol,
                    'sidefeaturedvideorow'  => $settingstabeResult->sidefeaturedvideorow,
                    'sidefeaturedvideocol'  => $settingstabeResult->sidefeaturedvideocol,
                    'siderelatedvideorow'   => $settingstabeResult->siderelatedvideorow,
                    'siderelatedvideocol'   => $settingstabeResult->siderelatedvideocol,
                    'siderecentvideorow'    => $settingstabeResult->siderecentvideorow,
                    'siderecentvideocol'    => $settingstabeResult->siderecentvideocol
                 );
                $arrsidethumbview = serialize($sitesidethumbview);
                $query = 'UPDATE #__hdflv_site_settings SET sidethumbview=\'' .$arrsidethumbview . '\'';
                $db->setQuery($query);
                $db->query();
        }
        if ($dispenablecolumnExists == 'false') {
            $db->setQuery("ALTER TABLE  `#__hdflv_site_settings` ADD  `dispenable` longtext NOT NULL");
            $db->query();
            ## Get thumbview details and serialize data
                $sitedispenable               = array(
                    'allowupload'         => $settingstabeResult->allowupload,
                    'user_login'          => $settingstabeResult->user_login,
                    'ratingscontrol'      => $settingstabeResult->ratingscontrol,
                    'viewedconrtol'       => $settingstabeResult->viewedconrtol,
                    'seo_option'          => $settingstabeResult->seo_option,
                    'language_settings'   => 'English.php',
                    'disqusapi'           => '',
                    'facebookapi'         => $settingstabeResult->facebookapi,
                    'comment'             => $settingstabeResult->comment,
                    'facebooklike'        => $settingstabeResult->facebooklike
                 );
                $arrdispenable = serialize($sitedispenable);
                $query = 'UPDATE #__hdflv_site_settings SET dispenable=\'' .$arrdispenable . '\'';
                $db->setQuery($query);
                $db->query();
        }
        
        $googleadquery = 'SHOW COLUMNS FROM `#__hdflv_googlead`';
        $db->setQuery($googleadquery);
        $db->query();
        $googleadcolumnData = $db->loadObjectList();
        foreach ($googleadcolumnData as $valueColumn) {
            if ($valueColumn->Field == 'imaaddet') {
                $imaaddetcolumnExists = 'true';
                break;
            }
         }

        if ($imaaddetcolumnExists == 'false') {
            $db->setQuery("ALTER TABLE  `#__hdflv_googlead` ADD  `imaaddet` longtext NOT NULL");
            $db->query();
        }
        
        $uploadquery = 'SHOW COLUMNS FROM `#__hdflv_upload`';
        $db->setQuery($uploadquery);
        $db->query();
        $uploadcolumnData = $db->loadObjectList();
        foreach ($uploadcolumnData as $valueColumn) {
            if ($valueColumn->Field == 'imaads') {
                $imaadscolumnExists = 'true';
            }
            if ($valueColumn->Field == 'embedcode') {
                $embedcodecolumnExists = 'true';
            }
            if ($valueColumn->Field == 'subtitle1') {
                $subtitle1codecolumnExists = 'true';
            }
            if ($valueColumn->Field == 'subtitle2') {
                $subtitle2codecolumnExists = 'true';
            }
            if ($valueColumn->Field == 'subtile_lang2') {
                $subtile_lang2codecolumnExists = 'true';
            }
            if ($valueColumn->Field == 'subtile_lang1') {
                $subtile_lang1codecolumnExists = 'true';
            }
         }

        if ($imaadscolumnExists == 'false') {
            $db->setQuery("ALTER TABLE  `#__hdflv_upload` ADD  `imaads` TINYINT( 1 ) NOT NULL DEFAULT '0'");
            $db->query();
        }
        if ($embedcodecolumnExists == 'false') {
            $db->setQuery("ALTER TABLE  `#__hdflv_upload` ADD  `embedcode` longtext NOT NULL ");
            $db->query();
        }
        if ($subtitle1codecolumnExists == 'false') {
            $db->setQuery("ALTER TABLE  `#__hdflv_upload` ADD  `subtitle1` varchar(255) CHARACTER SET utf8 NOT NULL ");
            $db->query();
        }
        if ($subtitle2codecolumnExists == 'false') {
            $db->setQuery("ALTER TABLE  `#__hdflv_upload` ADD  `subtitle2` varchar(255) CHARACTER SET utf8 NOT NULL ");
            $db->query();
        }
        if ($subtile_lang2codecolumnExists == 'false') {
            $db->setQuery("ALTER TABLE  `#__hdflv_upload` ADD  `subtile_lang2` text CHARACTER SET utf8 NOT NULL");
            $db->query();
        }
        if ($subtile_lang1codecolumnExists == 'false') {
            $db->setQuery("ALTER TABLE  `#__hdflv_upload` ADD  `subtile_lang1` text CHARACTER SET utf8 NOT NULL");
            $db->query();
        }
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
            $status->modules[] = array('name' => $name, 'client' => $client, 'result' => $result);
        }
        if (JFile::exists($root . '/components/com_contushdvideoshare/views/category/tmpl/default.xml')) {
            JFile::delete($root . '/components/com_contushdvideoshare/views/category/tmpl/default.xml');
        }
        JFile::move($root . '/components/com_contushdvideoshare/views/category/tmpl/default.j3.xml', $root . '/components/com_contushdvideoshare/views/category/tmpl/default.xml');

        $plugins = $manifest->xpath('plugins/plugin');
        foreach ($plugins as $plugin) {
            $name = (string)$plugin->attributes()->plugin;
            $group = (string)$plugin->attributes()->group;
            $path = $src.'/extensions/'.$name;
            $installer = new JInstaller;
            $result = $installer->install($path);
            $query = "UPDATE #__extensions SET enabled=1 WHERE type='plugin' AND element=".$db->Quote($name)." AND folder=".$db->Quote($group);
            $db->setQuery($query);
            $db->query();
            $status->plugins[] = array('name' => $name, 'group' => $group, 'result' => $result);
        }
         JFile::move($root . '/plugins/content/hvsarticle/hvsarticle.j3.xml', $root . '/plugins/content/hvsarticle/hvsarticle.xml');
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
            <a href="http://www.apptha.com/category/extension/Joomla/HD-Video-Share" target="_blank">
                <img src="components/com_contushdvideoshare/assets/contushdvideoshare-logo.png" alt="Joomla! HDVideoShare" align="left" />
            </a>
        </div>
        <div style="float:right;">
            <a href="http://www.apptha.com/" target="_blank">
                <img src="components/com_contushdvideoshare/assets/contus.jpg" alt="contus products" align="right" />
            </a>
        </div>
        <br><br>

        <h2 align="center">HD Video Share Installation Status</h2>
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
                    <td class="key" colspan="2"><?php echo JText::_('HDVideoShare - Component'); ?></td>
                    <td style="text-align: center;">
<?php
//check installed components
        $db->setQuery("SELECT id FROM #__hdflv_player_settings LIMIT 1");
        $id = $db->loadResult();
?>
            </td>
        </tr>
        <tr class="row1">
            <td class="key" colspan="2"><?php echo 'HD Video Share Categories - ' . JText::_('Module'); ?></td>
            <td style="text-align: center;">
<?php
                //check installed modules
                if (!version_compare(JVERSION, '1.5.0', 'ge')) {
                    $db->setQuery("SELECT extension_id FROM #__extensions WHERE type = 'module' AND element = 'mod_HDVideoShareCategories' LIMIT 1");
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
            <td class="key" colspan="2"><?php echo 'HD Video Share Featured - ' . JText::_('Module'); ?></td>
            <td style="text-align: center;">
<?php
                //check installed modules
                if (!version_compare(JVERSION, '1.5.0', 'ge')) {
                    $db->setQuery("SELECT extension_id FROM #__extensions WHERE type = 'module' AND element = 'mod_HDVideoShareFeatured' LIMIT 1");
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

        <tr class="row1">
            <td class="key" colspan="2"><?php echo 'HD Video Share Related - ' . JText::_('Module'); ?></td>
            <td style="text-align: center;">
<?php
                //check installed modules
                if (!version_compare(JVERSION, '1.5.0', 'ge')) {
                    $db->setQuery("SELECT extension_id FROM #__extensions WHERE type = 'module' AND element = 'mod_HDVideoShareRelated' LIMIT 1");
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
            <td class="key" colspan="2"><?php echo 'HD Video Share Popular - ' . JText::_('Module'); ?></td>
            <td style="text-align: center;">
<?php
                //check installed modules
                if (!version_compare(JVERSION, '1.5.0', 'ge')) {
                    $db->setQuery("SELECT extension_id FROM #__extensions WHERE type = 'module' AND element = 'mod_HDVideoSharePopular' LIMIT 1");
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

        <tr class="row1">
            <td class="key" colspan="2"><?php echo 'HD Video Share Recent - ' . JText::_('Module'); ?></td>
            <td style="text-align: center;">
<?php
                //check installed modules
                if (!version_compare(JVERSION, '1.5.0', 'ge')) {
                    $db->setQuery("SELECT extension_id FROM #__extensions WHERE type = 'module' AND element = 'mod_HDVideoShareRecent' LIMIT 1");
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
            <td class="key" colspan="2"><?php echo 'HD Video Share Search - ' . JText::_('Module'); ?></td>
            <td style="text-align: center;">
<?php
                //check installed modules
                if (!version_compare(JVERSION, '1.5.0', 'ge')) {
                    $db->setQuery("SELECT extension_id FROM #__extensions WHERE type = 'module' AND element = 'mod_HDVideoShareSearch' LIMIT 1");
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
            <td class="key" colspan="2"><?php echo 'HVS Article Plugin - ' . JText::_('Plugin'); ?></td>
            <td style="text-align: center;">
<?php
                //check installed modules
                if (!version_compare(JVERSION, '1.5.0', 'ge')) {
                    $db->setQuery("SELECT extension_id FROM #__extensions WHERE type = 'plugin' AND element = 'hvsarticle' AND folder = 'content' LIMIT 1");
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

