<?php
/**
 * @name          : Joomla HD Video Share
 * @version	  : 3.4.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component Settings View Page
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */

## No direct access
defined('_JEXEC') or die('Restricted access');

$rs_editsettings    = $rs_showsettings = $this->playersettings;
$player_colors      = unserialize($rs_editsettings[0]->player_colors);
$player_icons       = unserialize($rs_editsettings[0]->player_icons);
$player_values      = unserialize($rs_editsettings[0]->player_values);
JHTML::_('behavior.tooltip');

## Include style for joomla other than 3.0 version
if (!version_compare(JVERSION, '3.0.0', 'ge')) { ?>
    <style>
        fieldset input,fieldset textarea,fieldset select,fieldset img,fieldset button
        {
            float: none;
        }

        table.admintable td.key {
            background-color: #F6F6F6;
            text-align: left;
            width: auto;
            color: #666;
            font-weight: bold;
            border-bottom: 1px solid #E9E9E9;
            border-right: 1px solid #E9E9E9;

        }

        fieldset label,fieldset span.faux-label {
            float: none;
            clear: left;
            display: block;
            margin: 5px 0;
        }
    </style>
<?php } else { ## Include style for joomla 3.0 version ?>
    <style type="text/css">
        fieldset input,fieldset textarea,fieldset select,fieldset img,fieldset button	{float: none;}
        table.admintable td.key {}
        table.adminlist .radio_algin input[type="radio"]{margin:0 5px 0 0;}
        fieldset label,fieldset span.faux-label {float: none;clear: left;display: block;margin: 5px 0;}
    </style>
<?php } ?>
<script type="text/javascript">

//function to hide and show Google Analytics ID
    function Toggle(theDiv) {
        if (theDiv == "shows")
        {
            document.getElementById("show").style.display = '';
            document.getElementById("show1").style.display = '';
        }
        else
        {
            document.getElementById("show").style.display = "none";
            document.getElementById("show1").style.display = "none";
        }
    }

//function to hide and show Intermediate Ad

    function Toggle1(theDiv) {
        if (theDiv == "showss")
        {
            document.getElementById("imashow").style.display = '';
            document.getElementById("imashow1").style.display = '';
        }
        else
        {
            document.getElementById("imashow").style.display = "none";
            document.getElementById("imashow1").style.display = "none";
        }
    }

//validation for player width and height
<?php if (version_compare(JVERSION, '1.6.0', 'ge')) { ?>
        Joomla.submitbutton = function(pressbutton) {       // For Joomla versions 1.6, 1.7, 2.5 
    <?php
} else {
    ?>
        function submitbutton(pressbutton){                 // For Joomla versions 1.5
    <?php }
?>
            if (pressbutton){
                    var playerWidth         = document.getElementById('player_width').value;
                    playerWidth             = parseInt(playerWidth);
                    var playerHeight        = document.getElementById('player_height').value;
                    playerHeight            = parseInt(playerHeight);
                    var googleana_visible   = document.getElementById('googleana_visible').checked;
                    var googleanalyticsID   = document.getElementById('googleanalyticsID').value;
                    if (!playerWidth || !playerHeight) {
                    alert('Please enter minimum width and height value for player');
                    return false;
                    }
                    if (googleana_visible == 1 && googleanalyticsID == '') {
                    alert('Please Enter Google Analytics ID');
                    return false;
                    }
            }
            submitform(pressbutton);
            return;
        }
</script>
<!-- Form For Edit Player Settings Start Here -->
<form action="index.php?option=com_contushdvideoshare&layout=settings" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
    <div style="position: relative;">
        <fieldset class="adminform">
            <?php if (!version_compare(JVERSION, '3.0.0', 'ge')) { ?>
                <legend>Player Settings</legend>
            <?php } else { ?>
                <h2>Player Settings</h2>
            <?php } ?>
            <table <?php if (version_compare(JVERSION, '3.0.0', 'ge')){ echo 'class="adminlist table table-striped"'; } else { echo 'class="admintable adminlist" '; } ?>>
                <tr>
                    <td class="key" ><?php echo JHTML::tooltip('Recommended value is 3', 'Buffer Time', '', 'Buffer Time'); ?></td>
                    <td><input type="text" name="buffer" value="<?php if (isset($player_values['buffer'])){ echo $player_values['buffer']; } ?>" /> secs </td>
                    <td class="key"><?php echo JHTML::tooltip('Select Enable to auto hide skin', 'Skin Auto Hide', '', 'Skin Auto Hide'); ?></td>
                    <td <?php if (version_compare(JVERSION, '3.0.0', 'ge')){ echo 'class="radio_algin"'; } ?>>
                        <input type="radio" name="skin_autohide" 
                        <?php
                        if (isset($player_icons['skin_autohide']) && $player_icons['skin_autohide'] == 1) {
                            echo 'checked="checked" ';
                        }
                        ?> value="1" />Enable 
                        <input type="radio" name="skin_autohide"
                        <?php
                        if (isset($player_icons['skin_autohide']) && $player_icons['skin_autohide'] == 0) {
                            echo 'checked="checked" ';
                        }
                        ?> value="0" />Disable</td>
                </tr>
                <tr>
                    <td class="key" ><?php echo JHTML::tooltip('Width of the video can be 300px with all the controls enabled. If you would like to have smaller than 300px then you have to disable couple of controls like Timer, Zoom.', 'Width', '', 'Width'); ?></td>
                    <td ><input type="text" id="player_width" name="width" value="<?php if (isset($player_values['width'])){ echo $player_values['width']; } ?>" /> px </td>
                    <td class="key" ><?php echo JHTML::tooltip('Recommended value is 400', 'Height', '', 'Height'); ?></td>
                    <td><input type="text" name="height" value="<?php if (isset($player_values['height'])){ echo $player_values['height']; } ?>" id="player_height" /> px</td>

                </tr>
                <tr>
                    <td class="key"><?php echo JHTML::tooltip('Set the background color for the player in the format ffffff', 'Stage Color', '', 'Stage Color'); ?></td>
                    <td>#<input type="text" name="stagecolor" value="<?php if (isset($player_values['stagecolor'])){ echo $player_values['stagecolor']; } ?>" />
                    </td>
                    <td class="key"><?php echo JHTML::tooltip('Enter FFMpeg Binary Path', 'FFMpeg Binary Path', '', 'FFMpeg Binary Path'); ?></td>
                    <td><input style="width: 150px;" type="text" name="ffmpegpath" value="<?php if (isset($player_values['ffmpegpath'])){ echo $player_values['ffmpegpath']; } ?>" /> </td>

                </tr>
                <tr>
                    <td class="key"><?php echo JHTML::tooltip('Select Normal Screen Scale', 'Normal Screen Scale', '', 'Normal Screen Scale'); ?></td>
                    <td><select name="normalscale">
                            <option value="0" id="20">Aspect Ratio</option>
                            <option value="1" id="21">Original Size</option>
                            <option value="2" id="22">Fit to Screen</option>
                        </select> 
                        <?php
                        if (isset($player_values['normalscale']) && $player_values['normalscale']) {
                            echo '<script>document.getElementById("2' . $player_values['normalscale'] . '").selected="selected"; </script>';
                        }
                        ?>
                    </td>
                    <td class="key"><?php echo JHTML::tooltip('Select Full Screen Scale', 'Full Screen Scale', '', 'Full Screen Scale'); ?></td>
                    <td><select name="fullscreenscale">
                            <option value="0" id="10" name=0>Aspect Ratio</option>
                            <option value="1" id="11" name=1>Original Size</option>
                            <option value="2" id="12" name=2>Fit to Screen</option>
                        </select> 
                        <?php
                        if (isset($player_values['fullscreenscale']) && $player_values['fullscreenscale']) {
                            echo '<script>document.getElementById("1' . $player_values['fullscreenscale'] . '").selected="selected"; </script>';
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td class="key"><?php echo JHTML::tooltip('Fullscreen button can be enable/disabled from here', 'Full Screen', '', 'Full Screen'); ?></td>
                    <td <?php if (version_compare(JVERSION, '3.0.0', 'ge')){ echo 'class="radio_algin"'; } ?>>
                        <input type="radio" name="fullscreen"
                        <?php
                        if (isset($player_icons['fullscreen']) && $player_icons['fullscreen'] == 1) {
                            echo 'checked="checked" ';
                        }
                        ?>
                        value="1" />Enable <input type="radio" name="fullscreen"
                        <?php
                        if (isset($player_icons['fullscreen']) && $player_icons['fullscreen'] == 0) {
                            echo 'checked="checked" ';
                        }
                        ?>
                        value="0" />Disable</td>
                    <td class="key"><?php echo JHTML::tooltip('Option to play the videos one by one continuously without clicking on next video', 'Autoplay', '', 'Autoplay'); ?></td>
                    <td <?php if (version_compare(JVERSION, '3.0.0', 'ge')){ echo 'class="radio_algin"'; } ?>>
                        <input type="radio" name="autoplay"
                        <?php
                        if (isset($player_icons['autoplay']) && $player_icons['autoplay'] == 1) {
                            echo 'checked="checked" ';
                        }
                        ?>
                        value="1" />Enable <input type="radio" name="autoplay"
                        <?php
                        if (isset($player_icons['autoplay']) && $player_icons['autoplay'] == 0) {
                            echo 'checked="checked" ';
                        }
                        ?>
                        value="0" />Disable</td>
                </tr>
                <tr>
                    <td class="key"><?php echo JHTML::tooltip('Zoom button on the player control can be disable / enable here', 'Zoom', '', 'Zoom'); ?></td>
                    <td <?php if (version_compare(JVERSION, '3.0.0', 'ge')) echo 'class="radio_algin"'; ?>>
                        <input type="radio" name="zoom"
                        <?php
                        if (isset($player_icons['zoom']) && $player_icons['zoom'] == 1) {
                            echo 'checked="checked" ';
                        }
                        ?>
                        value="1" />Enable 
                        <input type="radio" name="zoom"
                        <?php
                        if (isset($player_icons['zoom']) && $player_icons['zoom'] == 0) {
                            echo 'checked="checked" ';
                        }
                        ?>
                        value="0" />Disable</td>
                    <td class="key"><?php echo JHTML::tooltip('Option to set enable / disable timer control on player', 'Timer', '', 'Timer'); ?></td>
                    <td <?php if (version_compare(JVERSION, '3.0.0', 'ge')) echo 'class="radio_algin"'; ?>>
                        <input type="radio" name="timer"
                        <?php
                        if (isset($player_icons['timer']) && $player_icons['timer'] == 1) {
                            echo 'checked="checked" ';
                        }
                        ?>
                        value="1" />Enable 
                        <input type="radio" name="timer"
                        <?php
                        if (isset($player_icons['timer']) && $player_icons['timer'] == 0) {
                            echo 'checked="checked" ';
                        }
                        ?>
                        value="0" />Disable</td>
                </tr>
                <tr>
                    <td class="key"><?php echo JHTML::tooltip('Recommended value is 50', 'Volume', '', 'Volume'); ?></td>
                    <td>
                        <input type="text" name="volume" value="<?php if (isset($player_values['volume'])){ echo $player_values['volume']; } ?>" /> %
                    </td>
                    <td class="key"><?php echo JHTML::tooltip('Enter Login Page URL', 'Login Page URL', '', 'Login Page URL'); ?></td>
                    <td <?php if (version_compare(JVERSION, '3.0.0', 'ge')){ echo 'class="radio_algin"'; } ?>>
                        <input type="text" name="login_page_url" value="<?php if (isset($player_icons['login_page_url'])){ echo $player_icons['login_page_url']; } ?>" />
                    </td>

                    </tr>
                    <tr>
                    <td class="key"><?php echo JHTML::tooltip('Share button on the player can be enabled/disabled from here', 'Share Button', '', 'Share Button'); ?></td>
                    <td <?php if (version_compare(JVERSION, '3.0.0', 'ge')){ echo 'class="radio_algin"'; } ?>>
                        <input type="radio" name="shareurl"
                        <?php
                        if (isset($player_icons['shareurl']) && $player_icons['shareurl'] == 1) {
                            echo 'checked="checked" ';
                        }
                        ?>
                        value="1" />Enable <input type="radio" name="shareurl"
                        <?php
                        if (isset($player_icons['shareurl']) && $player_icons['shareurl'] == 0) {
                            echo 'checked="checked" ';
                        }
                        ?>
                        value="0" />Disable</td>
                    <td class="key"><?php echo JHTML::tooltip('Option to select related videos view', 'Related Videos View', '', 'Related Videos View'); ?></td>
                    <td><select name="relatedVideoView">
                            <option value="side" id="side">side</option>
                            <option value="center" id="center">center</option>
                        </select> 
                            <?php
                            if (isset($player_values['relatedVideoView']) && $player_values['relatedVideoView']) {
                                echo '<script>document.getElementById("' . $player_values['relatedVideoView'] . '").selected="selected"; </script>';
                            }
                            ?>
                    </td>
                    </tr>
                    <tr>
                    <td class="key"><?php echo JHTML::tooltip('Option to play all the videos from playlist continuously', 'Playlist Autoplay', '', 'Playlist Autoplay'); ?></td>
                    <td <?php if (version_compare(JVERSION, '3.0.0', 'ge')) echo 'class="radio_algin"'; ?>><input type="radio" name="playlist_autoplay"
                        <?php
                        if (isset($player_icons['playlist_autoplay']) && $player_icons['playlist_autoplay'] == 1) {
                            echo 'checked="checked" ';
                        }
                        ?>
                        value="1" />Enable <input type="radio" name="playlist_autoplay"
                        <?php
                        if (isset($player_icons['playlist_autoplay']) && $player_icons['playlist_autoplay'] == 0) {
                            echo 'checked="checked" ';
                        }
                        ?>
                        value="0" />Disable</td>
                    <td class="key"><?php echo JHTML::tooltip('Option to set the HD videos to play by default', 'HD Default', '', 'HD Default'); ?></td>
                    <td <?php if (version_compare(JVERSION, '3.0.0', 'ge')){ echo 'class="radio_algin"'; } ?>>
                        <input type="radio" name="hddefault"
                        <?php
                        if (isset($player_icons['hddefault']) && $player_icons['hddefault'] == 1) {
                            echo 'checked="checked" ';
                        }
                        ?>
                        value="1" />Enable <input type="radio" name="hddefault"
                        <?php
                        if (isset($player_icons['hddefault']) && $player_icons['hddefault'] == 0) {
                            echo 'checked="checked" ';
                        }
                        ?>
                        value="0" />Disable</td>
                    </tr>
                    <tr>
                    <td class="key"><?php echo JHTML::tooltip('Set playlist to open / close always by enable / disable this option', 'Playlist Open', '', 'Playlist Open'); ?></td>
                    <td <?php if (version_compare(JVERSION, '3.0.0', 'ge')) echo 'class="radio_algin"'; ?>><input type="radio" name="playlist_open"
                        <?php
                        if (isset($player_icons['playlist_open']) && $player_icons['playlist_open'] == 1) {
                            echo 'checked="checked" ';
                        }
                        ?>
                        value="1" />Enable <input type="radio" name="playlist_open"
                        <?php
                        if (isset($player_icons['playlist_open']) && $player_icons['playlist_open'] == 0) {
                            echo 'checked="checked" ';
                        }
                        ?>
                        value="0" />Disable</td>
                    <td class="key"><?php echo JHTML::tooltip('Option to set enable/disable related videos display within player', 'Related Videos', '', 'Related Videos'); ?></td>
                    <td><select name="related_videos">
                            <option value="1" id="1">Enable</option>
                            <option value="2" id="2">Disable</option>
                        </select> <?php
                        if (isset($player_values['related_videos']) && $player_values['related_videos']) {
                            echo '<script>document.getElementById("' . $player_values['related_videos'] . '").selected="selected"; </script>';
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td class="key"><?php echo JHTML::tooltip('Option to enable/disable default preview image when it is not available', 'Display Default Image', '', 'Display Default Image'); ?></td>
                    <td <?php if (version_compare(JVERSION, '3.0.0', 'ge')){ echo 'class="radio_algin"'; } ?>>
                        <input type="radio" name="imageDefault"
                        <?php
                        if (isset($player_icons['imageDefault']) && $player_icons['imageDefault'] == 1) {
                            echo 'checked="checked" ';
                        }
                        ?>
                        value="1" />Enable <input type="radio" name="imageDefault"
                        <?php
                        if (isset($player_icons['imageDefault']) && $player_icons['imageDefault'] == 0) {
                            echo 'checked="checked" ';
                        }
                        ?>
                        value="0" />Disable</td>
                    <td class="key"><?php echo JHTML::tooltip('Option to enable/disable Embed option on player', 'Embed visible', '', 'Embed visible'); ?></td>
                    <td <?php if (version_compare(JVERSION, '3.0.0', 'ge')){ echo 'class="radio_algin"'; } ?>>
                        <input type="radio" name="embedVisible"
                        <?php
                        if (isset($player_icons['embedVisible']) && $player_icons['embedVisible'] == 1) {
                            echo 'checked="checked" ';
                        }
                        ?>
                        value="1" />Enable <input type="radio" name="embedVisible"
                        <?php
                        if (isset($player_icons['embedVisible']) && $player_icons['embedVisible'] == 0) {
                            echo 'checked="checked" ';
                        }
                        ?>
                        value="0" />Disable</td>
                </tr>
                <tr>
                    
                    <td class="key"><?php echo JHTML::tooltip('Option to enable/disable Download option on player', 'Enable Download', '', 'Enable Download'); ?></td>
                    <td <?php if (version_compare(JVERSION, '3.0.0', 'ge')){ echo 'class="radio_algin"'; } ?>>
                        <input type="radio" name="enabledownload"
                        <?php
                        if (isset($player_icons['enabledownload']) && $player_icons['enabledownload'] == 1) {
                            echo 'checked="checked" ';
                        }
                        ?>
                        value="1" />Enable <input type="radio" name="enabledownload"
                        <?php
                        if (isset($player_icons['enabledownload']) && $player_icons['enabledownload'] == 0) {
                            echo 'checked="checked" ';
                        }
                        ?>
                        value="0" />Disable</td>
                    <td class="key"><?php echo JHTML::tooltip('Option to enable/disable email option to be displayed on player', 'Display Email', '', 'Display Email'); ?></td>
                    <td <?php if (version_compare(JVERSION, '3.0.0', 'ge')){ echo 'class="radio_algin"'; } ?>>
                        <input type="radio" name="emailenable"
                        <?php
                        if (isset($player_icons['emailenable']) && $player_icons['emailenable'] == 1) {
                            echo 'checked="checked" ';
                        }
                        ?>
                        value="1" />Enable <input type="radio" name="emailenable"
                        <?php
                        if (isset($player_icons['emailenable']) && $player_icons['emailenable'] == 0) {
                            echo 'checked="checked" ';
                        }
                        ?>
                        value="0" />Disable</td>
                </tr>
                <tr>
                    <td class="key"><?php echo JHTML::tooltip('Option to enable/disable Description to be displayed on player', 'Description visible', '', 'Description visible'); ?></td>
                    <td <?php if (version_compare(JVERSION, '3.0.0', 'ge')){ echo 'class="radio_algin"'; } ?>>
                        <input type="radio" name="showTag"
                        <?php
                        if (isset($player_icons['showTag']) && $player_icons['showTag'] == 1) {
                            echo 'checked="checked" ';
                        }
                        ?>
                        value="1" />Enable <input type="radio" name="showTag"
                        <?php
                        if (isset($player_icons['showTag']) && $player_icons['showTag'] == 0) {
                            echo 'checked="checked" ';
                        }
                        ?>
                        value="0" />Disable</td>
                    <td class="key"><?php echo JHTML::tooltip('Option to enable/disable Volume control to be displayed on player', 'Volume visible', '', 'Volume visible'); ?></td>
                    <td <?php if (version_compare(JVERSION, '3.0.0', 'ge')){ echo 'class="radio_algin"'; } ?>>
                        <input type="radio" name="volumecontrol"
                        <?php
                        if (isset($player_icons['volumecontrol']) && $player_icons['volumecontrol'] == 1) {
                            echo 'checked="checked" ';
                        }
                        ?>
                       value="1" />Enable <input type="radio" name="volumecontrol"
                        <?php
                        if (isset($player_icons['volumecontrol']) && $player_icons['volumecontrol'] == 0) {
                            echo 'checked="checked" ';
                        }
                        ?>
                        value="0" />Disable</td>
                </tr>
                <tr>
                    <td class="key"><?php echo JHTML::tooltip('Option to enable/disable Progress bar to be displayed on player', 'Display Progress bar', '', 'Display Progress bar'); ?></td>
                    <td <?php if (version_compare(JVERSION, '3.0.0', 'ge')){ echo 'class="radio_algin"'; } ?>>
                        <input type="radio" name="progressControl"
                        <?php
                        if (isset($player_icons['progressControl']) && $player_icons['progressControl'] == 1) {
                            echo 'checked="checked" ';
                        }
                        ?>
                        value="1" />Enable <input type="radio" name="progressControl"
                        <?php
                        if (isset($player_icons['progressControl']) && $player_icons['progressControl'] == 0) {
                            echo 'checked="checked" ';
                        }
                        ?>
                        value="0" />Disable</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </fieldset>
    </div>
    <!-- Player Settings Fields End -->

    <!-- Player color Settings Start Here -->
    <div style="position: relative;">
        <fieldset class="adminform">
<?php if (!version_compare(JVERSION, '3.0.0', 'ge')) { ?>
                <legend>Player Color Settings</legend>
<?php } else { ?>
                <h2>Player Settings</h2>
<?php } ?>
            <table <?php if (version_compare(JVERSION, '3.0.0', 'ge')){ echo 'class="adminlist table table-striped"'; } else { echo 'class="admintable adminlist"'; } ?>>
                <tr>
                    <td><?php echo JHTML::tooltip('Enter the color for Share Popup Header Color', 'Share Popup Header Color', '', 'Share Popup Header Color'); ?></td>
                    <td><input name="sharepanel_up_BgColor" id="sharepanel_up_BgColor" maxlength="100" value="<?php echo $player_colors['sharepanel_up_BgColor']; ?>">
                    </td>
                </tr>
                <tr>
                    <td><?php echo JHTML::tooltip('Enter the color for Share Popup Background Color', 'Share Popup Background Color', '', 'Share Popup Background Color'); ?></td>
                    <td><input name="sharepanel_down_BgColor" id="sharepanel_down_BgColor" maxlength="100" value="<?php echo $player_colors['sharepanel_down_BgColor']; ?>">
                    </td>
                </tr>
                <tr>
                    <td><?php echo JHTML::tooltip('Enter the color for Share Popup Text Color', 'Share Popup Text Color', '', 'Share Popup Text Color'); ?></td>
                    <td><input name="sharepaneltextColor" id="sharepaneltextColor" maxlength="100" value="<?php echo $player_colors['sharepaneltextColor']; ?>">
                    </td>
                </tr>
                <tr>
                    <td><?php echo JHTML::tooltip('Enter the color for Send Button Color', 'Send Button Color', '', 'Send Button Color'); ?></td>
                    <td><input name="sendButtonColor" id="sendButtonColor" maxlength="100" value="<?php echo $player_colors['sendButtonColor']; ?>">
                    </td>
                </tr>
                <tr>
                    <td><?php echo JHTML::tooltip('Enter the color for Send Button Text Color', 'Send Button Text Color', '', 'Send Button Text Color'); ?></td>
                    <td><input name="sendButtonTextColor" id="sendButtonTextColor" maxlength="100" value="<?php echo $player_colors['sendButtonTextColor']; ?>">
                    </td>
                </tr>
                <tr>
                    <td><?php echo JHTML::tooltip('Enter the color for Player Text Color', 'Player Text Color', '', 'Player Text Color'); ?></td>
                    <td><input name="textColor" id="textColor" maxlength="100" value="<?php echo $player_colors['textColor']; ?>">
                    </td>
                </tr>
                <tr>
                    <td><?php echo JHTML::tooltip('Enter the color for Skin Background Color', 'Skin Background Color', '', 'Skin Background Color'); ?></td>
                    <td><input name="skinBgColor" id="skinBgColor" maxlength="100" value="<?php echo $player_colors['skinBgColor']; ?>">
                    </td>
                </tr>
                <tr>
                    <td><?php echo JHTML::tooltip('Enter the color for Seek Bar Color', 'Seek Bar Color', '', 'Seek Bar Color'); ?></td>
                    <td><input name="seek_barColor" id="seek_barColor" maxlength="100" value="<?php echo $player_colors['seek_barColor']; ?>">
                    </td>
                </tr>
                <tr>
                    <td><?php echo JHTML::tooltip('Enter the color for Buffer Bar Color', 'Buffer Bar Color', '', 'Buffer Bar Color'); ?></td>
                    <td><input name="buffer_barColor" id="buffer_barColor" maxlength="100" value="<?php echo $player_colors['buffer_barColor']; ?>">
                    </td>
                </tr>
                <tr>
                    <td><?php echo JHTML::tooltip('Enter the color for Skin Icons Color', 'Skin Icons Color', '', 'Skin Icons Color'); ?></td>
                    <td><input name="skinIconColor" id="skinIconColor" maxlength="100" value="<?php echo $player_colors['skinIconColor']; ?>">
                    </td>
                </tr>
                <tr>
                    <td><?php echo JHTML::tooltip('Enter the color for Progress Bar Background Color', 'Progress Bar Background Color', '', 'Progress Bar Background Color'); ?></td>
                    <td><input name="pro_BgColor" id="pro_BgColor" maxlength="100" value="<?php echo $player_colors['pro_BgColor']; ?>">
                    </td>
                </tr>
                <tr>
                    <td><?php echo JHTML::tooltip('Enter the color for Play Button Color', 'Play Button Color', '', 'Play Button Color'); ?></td>
                    <td><input name="playButtonColor" id="playButtonColor" maxlength="100" value="<?php echo $player_colors['playButtonColor']; ?>">
                    </td>
                </tr>
                <tr>
                    <td><?php echo JHTML::tooltip('Enter the color for Play Button Background Color', 'Play Button Background Color', '', 'Play Button Background Color'); ?></td>
                    <td><input name="playButtonBgColor" id="playButtonBgColor" maxlength="100" value="<?php echo $player_colors['playButtonBgColor']; ?>">
                    </td>
                </tr>
                <tr>
                    <td><?php echo JHTML::tooltip('Enter the color for Player Buttons Color', 'Player Buttons Color', '', 'Player Buttons Color'); ?></td>
                    <td><input name="playerButtonColor" id="playerButtonColor" maxlength="100" value="<?php echo $player_colors['playerButtonColor']; ?>">
                    </td>
                </tr>
                <!-- Player Buttons Background Color -->
                <tr>
                    <td><?php echo JHTML::tooltip('Enter the color for Player Buttons Background Color', 'Player Buttons Background Color', '', 'Player Buttons Background Color'); ?></td>
                    <td><input name="playerButtonBgColor" id="playerButtonBgColor" maxlength="100" value="<?php echo $player_colors['playerButtonBgColor']; ?>">
                    </td>
                </tr>
                <!-- Related Videos Background Color -->
                <tr>
                    <td><?php echo JHTML::tooltip('Enter the color for Related Videos Background Color', 'Related Videos Background Color', '', 'Related Videos Background Color'); ?></td>
                    <td><input name="relatedVideoBgColor" id="relatedVideoBgColor" maxlength="100" value="<?php echo $player_colors['relatedVideoBgColor']; ?>">
                    </td>
                </tr>
                <!-- Related Videos Scroll Bar Color -->
                <tr>
                    <td><?php echo JHTML::tooltip('Enter the color for Related Videos Scroll Bar Color', 'Related Videos Scroll Bar', '', 'Related Videos Scroll Bar'); ?></td>
                    <td><input name="scroll_barColor" id="scroll_barColor" maxlength="100" value="<?php echo $player_colors['scroll_barColor']; ?>">
                    </td>
                </tr>
                <!-- Related Videos Scroll Bar Background Color -->
                <tr>
                    <td><?php echo JHTML::tooltip('Enter the color for Related Videos Scroll Bar Background Color', 'Related Videos Scroll Bar Background', '', 'Related Videos Scroll Bar Background'); ?></td>
                    <td><input name="scroll_BgColor" id="scroll_BgColor" maxlength="100" value="<?php echo $player_colors['scroll_BgColor']; ?>">
                    </td>
                </tr>
            </table>
        </fieldset>
    </div>
    <!-- Player Settings Fields End -->

    <!-- Pre/Post-Roll Ads Settings Fields Start Here -->
    <div style="position: relative;">
        <fieldset class="adminform">
                 <?php if (!version_compare(JVERSION, '3.0.0', 'ge')) { ?>
                <legend>Pre/Post-Roll Ad Settings</legend>
                 <?php } else { ?>
                <h2>Pre/Post-Roll Ad Settings</h2>
                 <?php } ?>
            <table class="<?php if (version_compare(JVERSION, '3.0.0', 'ge')){ echo 'adminlist table table-striped'; } else { echo " admintable adminlist"; } ?>">
                <tr>
                    <td class="key" ><?php echo JHTML::tooltip('Option to enable/disable post-roll ads', 'Post-roll Ad', '', 'Post-roll Ad'); ?> </td>
                    <td  <?php if (version_compare(JVERSION, '3.0.0', 'ge')){ echo 'colspan="3"'; } ?> <?php if (version_compare(JVERSION, '3.0.0', 'ge')) { echo 'class="radio_algin" '; }?> ><input type="radio" name="postrollads"
                    <?php
                    if (isset($player_icons['postrollads']) && $player_icons['postrollads'] == 1) {
                        echo 'checked="checked" ';
                    }
                    ?>
                    value="1" />Enable <input type="radio" name="postrollads"
                    <?php
                    if (isset($player_icons['postrollads']) && $player_icons['postrollads'] == 0) {
                        echo 'checked="checked" ';
                    }
                    ?>
                    value="0" />Disable</td>
                    <?php if (version_compare(JVERSION, '3.0.0', 'ge')){ echo "</tr> <tr>"; } ?>
                    <td class="key" ><?php echo JHTML::tooltip('Option to enable/disable pre-roll ads', 'Pre-roll Ad', '', 'Pre-roll Ad'); ?></td>
                    <td <?php if (version_compare(JVERSION, '3.0.0', 'ge')){ echo 'colspan="3"'; } ?> <?php if (version_compare(JVERSION, '3.0.0', 'ge')) { echo 'class="radio_algin" '; } ?>>
                        <input type="radio" name="prerollads"
                        <?php
                        if (isset($player_icons['prerollads']) && $player_icons['prerollads'] == 1) {
                            echo 'checked="checked" ';
                        }
                        ?>
                        value="1" />Enable <input type="radio" name="prerollads"
                        <?php
                        if (isset($player_icons['prerollads']) && $player_icons['prerollads'] == 0) {
                            echo 'checked="checked" ';
                        }
                        ?>
                        value="0" />Disable</td>
<?php if (version_compare(JVERSION, '3.0.0', 'ge')) { echo "</tr> <tr>"; } ?>
                    <td class="key" ><?php echo JHTML::tooltip('Option to enable/disable IMA ads', 'IMA Ad', '', 'IMA Ad'); ?></td>
                    <td <?php if (version_compare(JVERSION, '3.0.0', 'ge')){ echo 'colspan="3"'; } ?> <?php if (version_compare(JVERSION, '3.0.0', 'ge')) { echo 'class="radio_algin" '; } ?>>
                        <input type="radio" name="imaads"
                        <?php
                        if (isset($player_icons['imaads']) && $player_icons['imaads'] == 1) {
                            echo 'checked="checked" ';
                        }
                        ?>
                        value="1" />Enable <input type="radio" name="imaads"
                        <?php
                        if (isset($player_icons['imaads']) && $player_icons['imaads'] == 0) {
                            echo 'checked="checked" ';
                        }
                        ?>
                        value="0" />Disable</td>
                </tr>
                <tr>
                    <td class="key"  ><?php echo JHTML::tooltip('Option to enable/disable Ad Skip', 'Ad Skip', '', 'Ad Skip'); ?></td>
                    <td <?php if (version_compare(JVERSION, '3.0.0', 'ge')){ echo 'class="radio_algin"'; } ?> >
                        <input type="radio" name="adsSkip"
                        <?php
                        if (isset($player_icons['adsSkip']) && $player_icons['adsSkip'] == 1) {
                            echo 'checked="checked" ';
                        }
                        ?>
                        value="1" />Enable <input type="radio" name="adsSkip"
                        <?php
                        if (isset($player_icons['adsSkip']) && $player_icons['adsSkip'] == 0) {
                            echo 'checked="checked" ';
                        }
                        ?>
                        value="0" />Disable</td>
                    <td class="key"><?php echo JHTML::tooltip('Enter the time interval for Ad Skip Duration', 'Ad Skip Duration', '', 'Ad Skip Duration'); ?></td>
                    <td colspan="3"><input type="text" name="adsSkipDuration"  value="<?php if (isset($player_values['adsSkipDuration'])){ echo $player_values['adsSkipDuration']; } ?>" style="margin-bottom: 0;"/> </td>
                </tr>
                <tr>
                        <?php if (!version_compare(JVERSION, '3.0.0', 'ge')) { ?>
                        <td class="key"><?php echo JHTML::tooltip('Option to enable/disable Google Analytics', 'Google Analytics', '', 'Google Analytics'); ?></td>
                        <td <?php if (version_compare(JVERSION, '3.0.0', 'ge')){ echo 'colspan="3"'; } ?> <?php if (version_compare(JVERSION, '3.0.0', 'ge')){ echo 'class="radio_algin"'; } else { echo 'colspan="5"'; } ?>  >
                        <?php if (!version_compare(JVERSION, '3.0.0', 'ge')) { echo '<div style="float: left">'; } ?>
                            <input type="radio" style="float: none;" onclick="Toggle('shows')" name="googleana_visible" id="googleana_visible" 
                                    <?php if (isset($player_icons['googleana_visible']) && $player_icons['googleana_visible'] == 1) {
                                        echo 'checked="checked" ';
                                    } ?>
                                   value="1" />Enable <input type="radio" style="float: none;" onclick="Toggle('unshow')" name="googleana_visible" id="googleana_visible"
                                    <?php if (isset($player_icons['googleana_visible']) && $player_icons['googleana_visible'] == 0) {
                                        echo 'checked="checked" ';
                                    } ?>
                                   value="0" />Disable
                        <?php if (!version_compare(JVERSION, '3.0.0', 'ge')){ echo '</div>'; } ?>
                            <div id="show" class="google_analytics" style="display: none;">
                                <?php echo JHTML::tooltip('Enter Google Analytics ID', 'Google Analytics ID', '', 'Google Analytics ID'); ?>
                                <input style="margin: 0;" name="googleanalyticsID" id="googleanalyticsID" maxlength="100" value="<?php if (isset($player_values['googleanalyticsID'])) echo $player_values['googleanalyticsID']; ?>">
                            </div>
                        </td>
                    </tr>
                        <?php } else { ?>
                    <td class="key"><?php echo JHTML::tooltip('Option to enable/disable Google Analytics', 'Google Analytics', '', 'Google Analytics'); ?></td>
                    <td class="radio_algin" <?php if (version_compare(JVERSION, '3.0.0', 'ge')){ echo 'colspan="3"'; } ?> ><input type="radio" style="float: none;" onclick="Toggle('shows')" name="googleana_visible" id="googleana_visible" 
                        <?php if (isset($player_icons['googleana_visible']) && $player_icons['googleana_visible'] == 1) {
                            echo 'checked="checked" ';
                        } ?>
                        value="1" />Enable <input type="radio" style="float: none;" onclick="Toggle('unshow')" name="googleana_visible" id="googleana_visible" 
                            <?php if (isset($player_icons['googleana_visible']) && $player_icons['googleana_visible'] == 0) {
                                echo 'checked="checked" ';
                            } ?>
                        value="0" />Disable</td>
                    
                    </tr>
                    <tr>
                        <td class="key">
                            <div id="show" style="display: none;"><?php echo JHTML::tooltip('Enter Google Analytics ID', 'Google Analytics ID', '', 'Google Analytics ID'); ?></div>
                        </td>
                        <td>
                            <div id="show1" style="display: none;">
                                <input name="googleanalyticsID" id="googleanalyticsID" maxlength="100" value="<?php if (isset($player_values['googleanalyticsID'])) echo $player_values['googleanalyticsID']; ?>">
                            </div>
                        </td>
                         
                    </tr>
                    <?php } ?>
            </table>
        </fieldset>
    </div>
    <!-- Pre/Post-Roll Ads Settings Fields End -->

    <!-- Mid Roll Ads Settings Fields Start Here -->
    <div style="position: relative;">
        <fieldset class="adminform">
<?php if (!version_compare(JVERSION, '3.0.0', 'ge')) { ?>
                <legend>Mid Roll Ad Settings</legend>
<?php } else { ?>
                <h2>Mid Roll Ad Settings</h2>
<?php } ?>
            <table class="<?php if (version_compare(JVERSION, '3.0.0', 'ge')){ echo 'adminlist table table-striped'; } else { echo 'admintable adminlist'; } ?> ">
                <tr>
                    <td  class="key"><?php echo JHTML::tooltip('Option to enable/disable Mid-roll ads', 'Mid-roll Ad', '', 'Mid-roll Ad'); ?></td>
                    <td <?php if (version_compare(JVERSION, '3.0.0', 'ge')){ echo 'class="radio_algin"'; } ?>><input type="radio" name="midrollads"
                        <?php
                        if (isset($player_icons['midrollads']) && $player_icons['midrollads'] == 1) {
                            echo 'checked="checked" ';
                        }
                        ?>
                        value="1" />Enable <input type="radio" name="midrollads"
                        <?php
                        if (isset($player_icons['midrollads']) && $player_icons['midrollads'] == 0) {
                            echo 'checked="checked" ';
                        }
                        ?>
                        value="0" />Disable</td>
                    <td class="key"  ><?php echo JHTML::tooltip('Enter begin time for mid roll ad', 'Begin', '', 'Begin'); ?></td>
                    <td ><input type="text" name="midbegin" value="<?php if (isset($player_values['midbegin'])){ echo $player_values['midbegin']; } ?>" />
                    </td>
                    <td class="key" ><?php echo JHTML::tooltip('Option to enable/disable rotation of ads', 'Ad Rotate', '', 'Ad Rotate'); ?></td>
                    <td <?php if (version_compare(JVERSION, '3.0.0', 'ge')){ echo 'class="radio_algin"'; } ?> ><input type="radio" name="midadrotate"
                    <?php
                    if (isset($player_icons['midadrotate']) && $player_icons['midadrotate'] == 1) {
                        echo 'checked="checked" ';
                    }
                    ?>
                    value="1" />Enable <input type="radio" name="midadrotate"
                    <?php
                    if (isset($player_icons['midadrotate']) && $player_icons['midadrotate'] == 0) {
                        echo 'checked="checked" ';
                    }
                    ?>
                    value="0" />Disable</td>
                </tr>
                <tr>
                    <td class="key"><?php echo JHTML::tooltip('Option to enable/disable random display of ads', 'Mid-roll Ads Random', '', 'Mid-roll Ads Random'); ?></td>
                    <td <?php if (version_compare(JVERSION, '3.0.0', 'ge')){ echo 'class="radio_algin"'; } ?> ><input type="radio" name="midrandom"
                        <?php
                        if (isset($player_icons['midrandom']) && $player_icons['midrandom'] == 1) {
                            echo 'checked="checked" ';
                        }
                        ?>
                        value="1" />Enable <input type="radio" name="midrandom"
                    <?php
                    if (isset($player_icons['midrandom']) && $player_icons['midrandom'] == 0) {
                        echo 'checked="checked" ';
                    }
                    ?>
                    value="0" />Disable</td>
                    <td class="key"><?php echo JHTML::tooltip('Enter the time interval between ads', 'Ad Interval', '', 'Ad Interval');
                    ?></td>
                    <td colspan="3"><input type="text" name="midinterval" value="<?php if (isset($player_values['midinterval'])){ echo $player_values['midinterval']; } ?>" />
                    </td>

                </tr>
              
            </table>
        </fieldset>
    </div>
    <!-- Mid Roll Ads Settings Fields End -->

    <!-- Logo Settings Fields Start Here -->
    <div style="position: relative;">
        <fieldset class="adminform">
            <legend>Logo Settings</legend>
            <table class="<?php if (version_compare(JVERSION, '3.0.0', 'ge')){ echo 'adminlist table table-striped'; } else { echo 'admintable adminlist'; } ?> ">
                <tr>
                    <td class="key"><?php echo JHTML::tooltip('Enter Licence Key', 'Licence Key', '', 'Licence Key'); ?></td>
                    <td><input type="text" name="licensekey" id="licensekey" style="float: left;" size="60" maxlength="200" value="<?php if (isset($player_values['licensekey'])) echo $player_values['licensekey']; ?>" />
                    <?php
                    if (isset($player_values['licensekey']) && $player_values['licensekey'] == '') {
                    ?> 
                        <a style="float: left;" href="http://www.apptha.com/category/extension/Joomla/HD-Video-Share" target="_blank"><img alt="" src="components/com_contushdvideoshare/images/buynow.gif" width="77" height="23" style="margin: 3px 0 0 0;" /> </a> 
                    <?php
                    }
                    ?>
                    </td>
                </tr>
                <tr>
                    <td class="key"><?php echo JHTML::tooltip('Allowed Extensions : jpg/jpeg, gif, png', 'Logo', '', 'Logo'); ?></td>
                    <td>
                        <div id="var_logo">
                            <input name="logopath" id="logopath" maxlength="100"
                                   readonly="readonly"
                                   value="<?php if (isset($rs_editsettings[0]->logopath)) echo $rs_editsettings[0]->logopath; ?>"> <input
                                   type="button" name="change1" value="Change" maxlength="100"
                                   onclick="getFileUpload()">
                        </div>
                    </td>
                    <?php if (version_compare(JVERSION, '3.0.0', 'ge')){ ?><td>&nbsp;</td> <?php } ?>
                </tr>
                <tr>
                    <td class="key"><?php echo JHTML::tooltip('Enter Logo Target URL', 'Logo Target URL', '', 'Logo Target URL'); ?></td>
                    <td><input style="width: 150px;" type="text" name="logourl" value="<?php if (isset($player_values['logourl'])){ echo $player_values['logourl']; } ?>" />
                    </td>
                    <?php if (version_compare(JVERSION, '3.0.0', 'ge')) { ?><td>&nbsp;</td> <?php } ?>
                </tr>
                <tr>
                <td class="key" ><?php echo JHTML::tooltip('Edit the value to have transparency depth of logo', 'Logo Alpha', '', 'Logo Alpha'); ?></td>
                    <td ><input type="text" name="logoalpha" value="<?php if (isset($player_values['logoalpha'])){ echo $player_values['logoalpha']; } ?>" /> %</td>
                </tr>
                <tr>
                    <td class="key"><?php echo JHTML::tooltip('Select the Logo Position.Disabled in Demo Version.', 'Logo Position', '', 'Logo Position'); ?></td>
                    <td><select name="logoalign">
                            <option value="TR" id="TR">Top Right</option>
                            <option value="TL" id="TL">Top Left</option>
                            <option value="BL" id="BL">Bottom Left</option>
                            <option value="BR" id="BR">Bottom Right</option>
                        </select> 
                        <?php
                        if (isset($player_values['logoalign']) && $player_values['logoalign']) {
                            echo '<script>document.getElementById("' . $player_values['logoalign'] . '").selected="selected"</script>';
                        }
                        ?>
                    </td>
                <?php if (version_compare(JVERSION, '3.0.0', 'ge')) { ?><td>&nbsp;</td> <?php } ?>
                </tr>
            </table>
        </fieldset>
    </div>
    <!-- Logo Settings Fields End -->

    <input type="hidden" name="id" value="<?php if (isset($rs_editsettings[0]->id)){ echo $rs_editsettings[0]->id; } ?>" /> 
    <input type="hidden" name="task" value="" /> 
    <input type="hidden" name="submitted" value="true" id="submitted">
</form>
<!-- script for get file upload-->
<script language="javascript">
    function getFileUpload(){
    var var_logo = '<input type="file" name="logopath" id="logopath" maxlength="100"  value="" />';
            document.getElementById('var_logo').innerHTML = var_logo;
    }
    window.onload = function(){
    var googleAnalyticsId = "<?php if (isset($player_values['googleanalyticsID'])) echo $player_values['googleanalyticsID']; ?>";
            if (googleAnalyticsId){
                document.getElementById("show").style.display = '';
            }
    }
</script>
<!-- Form For Edit Player Settings End -->