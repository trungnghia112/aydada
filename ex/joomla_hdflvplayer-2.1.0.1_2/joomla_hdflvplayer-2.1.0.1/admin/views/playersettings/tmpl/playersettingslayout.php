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
defined('_JEXEC') or die('Restricted access');

//Includes for tooltip
JHTML::_('behavior.tooltip');

$options = array(
JHtml::_('select.option', '1', 'Enable'),
JHtml::_('select.option', '0', 'Disable'));

$videoqty = array(
JHtml::_('select.option', '1', 'Small'),
JHtml::_('select.option', '0', 'Medium'));

$rs_editsettings = $this->playersettings;
$player_colors   = unserialize($rs_editsettings->player_colors);
$player_icons    = unserialize($rs_editsettings->player_icons);
$player_values   = unserialize($rs_editsettings->player_values);

if (!empty($rs_editsettings)) {
	?>
	<script type="text/javascript">
  
	Joomla.submitbutton = function(pressbutton) {

		// do field validation
		if (pressbutton == "applyplayersettings") {

			var playerwidth = document.getElementById('playerwidth').value;
			var playerheight = document.getElementById('playerheight').value;
			var volume = document.getElementById('volume').value;
			var buffer = document.getElementById('buffer').value;
			var nrelated = document.getElementById('nrelated').value;
			var logoalpha = document.getElementById('logoalpha').value;
			var midbegin = document.getElementById('midbegin').value;
			var midinterval = document.getElementById('midinterval').value;
			if(isNaN(buffer))
			{
				alert('Enter Valid Buffer');
				document.getElementById('buffer').focus();
				return;
			}

                        else if (playerwidth == '' || playerwidth == 0 || (isNaN(playerwidth))) {
				alert('Enter Valid Width');
				document.getElementById('playerwidth').focus();
				return;
			}

			else if (playerheight == '' || playerheight == 0 || (isNaN(playerheight))) {
				alert('Enter Valid Height');
				document.getElementById('playerheight').focus();
				return;
			}
                        else if(isNaN(volume))
			{
				alert('Enter Valid Volume');
				document.getElementById('volume').focus();
				return;
			}


			else if(isNaN(nrelated))
			{
				alert('Enter Valid Number for related videos per page');
				document.getElementById('nrelated').focus();
				return;
			}
			else if(isNaN(logoalpha))
			{
				alert('Enter Valid logo alpha percentage');
				document.getElementById('logoalpha').focus();
				return;
			}
			else if(isNaN(midbegin))
			{
				alert('Enter Valid Mid-roll begin time');
				document.getElementById('midbegin').focus();
				return;
			}
			else if(isNaN(midinterval))
			{
				alert('Enter Valid Mid-roll interval time');
				document.getElementById('midinterval').focus();
				return;
			}

			submitform(pressbutton);
			return;
		} else {
			submitform(pressbutton);
			return;
		}
	}
	function submitbutton(pressbutton) {
		// do field validation
		if (pressbutton == "applyplayersettings") {

			var playerwidth = document.getElementById('playerwidth').value;
			var playerheight = document.getElementById('playerheight').value;
			var volume = document.getElementById('volume').value;
			var buffer = document.getElementById('buffer').value;
			var nrelated = document.getElementById('nrelated').value;
			var logoalpha = document.getElementById('logoalpha').value;
			var midbegin = document.getElementById('midbegin').value;
			var midinterval = document.getElementById('midinterval').value;
			if(isNaN(buffer))
			{
				alert('Enter Valid Buffer');
				document.getElementById('buffer').focus();
				return;
			}

                        else if (playerwidth == '' || playerwidth == 0 || (isNaN(playerwidth))) {
				alert('Enter Valid Width');
				document.getElementById('playerwidth').focus();
				return;
			}

			else if (playerheight == '' || playerheight == 0 || (isNaN(playerheight))) {
				alert('Enter Valid Height');
				document.getElementById('playerheight').focus();
				return;
			}
                        else if(isNaN(volume))
			{
				alert('Enter Valid Volume');
				document.getElementById('volume').focus();
				return;
			}


			else if(isNaN(nrelated))
			{
				alert('Enter Valid Number for related videos per page');
				document.getElementById('nrelated').focus();
				return;
			}
			else if(isNaN(logoalpha))
			{
				alert('Enter Valid logo alpha percentage');
				document.getElementById('logoalpha').focus();
				return;
			}
			else if(isNaN(midbegin))
			{
				alert('Enter Valid Mid-roll begin time');
				document.getElementById('midbegin').focus();
				return;
			}
			else if(isNaN(midinterval))
			{
				alert('Enter Valid Mid-roll interval time');
				document.getElementById('midinterval').focus();
				return;
			}

			submitform(pressbutton);
			return;
		} else {
			submitform(pressbutton);
			return;
		}
	}
function googleana_vis(postvalue)
{
    if(postvalue == 0)
    	{
        document.getElementById("googleana_id").style.display = 'none';
    	}
    if(postvalue == 1)
    	{
        document.getElementById("googleana_id").style.display = '';
    	}
}

	function getsettings()
    {
        var var_logo;
        var_logo='<input type="file" name="logopath" id="logopath" maxlength="100"  value="" /><label style="background-color:#D5E9EE; color:#333333;">Allowed Extensions :jpg/jpeg,gif,png </label>';
        document.getElementById('var_logo').innerHTML=var_logo;
    }

	</script>

<!-- Form content starts here -->
<form action="index.php?option=com_hdflvplayer&task=playersettings" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
    <div class="hdflv_player_settings_left">	
    <div class="width-50 fltlft">
		<fieldset class="adminform">
			<legend>HD FLV Player Settings</legend>
			<table class="adminlist">

				<!-- Column Titles here -->
				<thead>
					<tr>
						<th>Settings</th>
						<th>Value</th>
					</tr>
				</thead>

				<!-- Footer Part here -->
				<tfoot>
					<tr>
						<td colspan="2">&#160;</td>
					</tr>
				</tfoot>

				<!-- Content body here -->
				<tbody>

					<!-- Settings for Buffer Time -->
					<tr>
						<td>
						<?php echo JHTML::tooltip('Enter the Buffer Time to load Video<br>Recommend value for buffer time in 3 secs', 'Buffer Time','', 'Buffer Time');?>
						</td>
						<td>
							<input type="text" name="buffer" id="buffer" value="<?php echo $player_values['buffer']; ?>" /> secs

						</td>
					</tr>

					<!-- Settings for Width -->
					<tr>
						<td>
						<?php echo JHTML::tooltip('Enter the Width for player<br>Width
							of the video can be 300px with all the controls enabled. If you
							would like to have smaller than 300px then you have to disable
							couple of controls like Timer, Zoom..', 'Width','', 'Width');?>
						</td>
						<td><input type="text" name="playerwidth" id="playerwidth" value="<?php echo $player_values['width']; ?>" /> px</td>
					</tr>

					<!-- Settings for Height -->
					<tr>
						<td>
						<?php echo JHTML::tooltip('Enter the Height for player', 'Height','', 'Height');?>
						</td>
						<td><input type="text" name="playerheight" id="playerheight" value="<?php echo $player_values['height']; ?>" /> px
						</td>
					</tr>

					<!-- Settings for Normal Screen Scale -->
					<tr>
						<td><?php echo JHTML::tooltip('Choose the Normal Screen Scale', 'Normal Screen Scale','', 'Normal Screen Scale');?>
						</td>
						<td>
						<?php
						$screenoptions[] = JHTML::_('select.option','0','Aspect Ratio');
						$screenoptions[] = JHTML::_('select.option','1','Original Size');
						$screenoptions[] = JHTML::_('select.option','2','Fit to Screen');
						echo JHTML::_('select.genericlist', $screenoptions,'normalscale', 'class="inputbox"','value','text', $player_values['normalscale']);?>
						</td>
					</tr>

					<!-- Settings for Full Screen Scale -->
					<tr>
						<td><?php echo JHTML::tooltip('Choose the Full Screen Scale', 'Full Screen Scale','', 'Full Screen Scale');?></td>
						<td>
							<?php echo JHTML::_('select.genericlist', $screenoptions,'fullscreenscale', 'class="inputbox"','value','text', $player_values['fullscreenscale']);?>
						</td>
					</tr>

					<!-- Settings for Autoplay -->
					<tr>
						<td><?php echo JHTML::tooltip('Whether or not the Autoplay have to be enable', 'Autoplay','', 'Autoplay');?></td>
						<td>
                                                    <fieldset id="jform_type" class="radio inputbox">
							<?php echo JHtml::_( 'select.radiolist', $options, 'autoplay', '', 'value', 'text', $player_icons['autoplay']); ?>
		                                    </fieldset>
                                                 </td>
					</tr>

					<!-- Settings for Volume -->
					<tr>
						<td><?php echo JHTML::tooltip('Enter the Volume', 'Volume','', 'Volume');?></td>
						<td><input type="text" name="volume" id="volume" value="<?php echo $player_values['volume']; ?>" />%</td>
					</tr>

					<!-- Settings for FFMpeg Binary Path -->
					<tr>
						<td><?php echo JHTML::tooltip('Enter the FFMpeg Binary Path value to play FFMPEG videos', 'FFMpeg Binary Path','', 'FFMpeg Binary Path');?></td>
						<td><input style="width: 150px;" type="text" name="ffmpegpath" value="<?php echo $player_values['ffmpegpath']; ?>" />
						</td>
					</tr>

					<!-- Settings for Playlist Autoplay -->
					<tr>
						<td><?php echo JHTML::tooltip('Whether or not playlist have to be autoplay', 'Playlist Autoplay','', 'Playlist Autoplay');?></td>
                                                <td> <fieldset id="jform_type" class="radio inputbox">
							<?php echo JHtml::_( 'select.radiolist', $options, 'playlist_autoplay', '', 'value', 'text', $player_icons['playlist_autoplay']); ?>
						    </fieldset>
                                                </td>
					</tr>

					<!-- Settings for Playlist Open -->
					<tr>
						<td><?php echo JHTML::tooltip('Whether or not playlist have to be open', 'Playlist Open','', 'Playlist Open');?></td>
						<td>
                                                     <fieldset id="jform_type" class="radio inputbox">
						<?php echo JHtml::_( 'select.radiolist', $options, 'playlist_open', '', 'value', 'text', $player_icons['playlist_open']); ?>
                                                      </fieldset>
                                                     </td>
					</tr>
                                        
                                        

					<!-- Settings for Logo Alpha -->
					<tr>
						<td><?php echo JHTML::tooltip('Enter Logo Alpha Percentage.<br>Edit the value to have transparancy depth of logo. Recommended value is 50', 'Logo Alpha','', 'Logo Alpha');?></td>
						<td><input type="text" name="logoalpha" id="logoalpha" value="<?php echo $player_values['logoalpha']; ?>" /> %
						</td>
					</tr>

					<!-- Settings for Skin Auto Hide -->
					<tr>
						<td><?php echo JHTML::tooltip('Whether or not Skin Auto Hide have to be enable', 'Skin Auto Hide','', 'Skin Auto Hide');?></td>
						<td>
                                                    <fieldset id="jform_type" class="radio inputbox">
						<?php echo JHtml::_( 'select.radiolist', $options, 'skin_autohide', '', 'value', 'text', $player_icons['skin_autohide']); ?>
						</fieldset>
                                                    </td>
					</tr>

					<!-- Settings for Stage Color -->
					<tr>
						<td><?php echo JHTML::tooltip('Enter the Stage Color', 'Stage Color','', 'Stage Color');?></td>
						<td># <input type="text" name="stagecolor" value="<?php echo $player_values['stagecolor']; ?>" />
						</td>
					</tr>

					<!-- Settings for Full Screen -->
					<tr>
						<td><?php echo JHTML::tooltip('Whether or not Full Screen have to enable', 'Full Screen','', 'Full Screen');?></td>
						<td>
                                                    <fieldset id="jform_type" class="radio inputbox">
						<?php echo JHtml::_( 'select.radiolist', $options, 'fullscreen', '', 'value', 'text', $player_icons['fullscreen']); ?>
						</fieldset>
                                                    </td>
					</tr>

					<!-- Settings for Zoom -->
					<tr>
						<td><?php echo JHTML::tooltip('Whether or not Zoom option have to enable', 'Zoom','', 'Zoom');?></td>
						<td>
                                                      <fieldset id="jform_type" class="radio inputbox">
						<?php echo JHtml::_( 'select.radiolist', $options, 'zoom', '', 'value', 'text', $player_icons['zoom']); ?>
                                                      </fieldset>

						</td>
					</tr>

					<!-- Settings for Timer -->
					<tr>
						<td><?php echo JHTML::tooltip('Whether or not Timer option have to show while video play', 'Timer','', 'Timer');?></td>
						<td>
                                                    <fieldset id="jform_type" class="radio inputbox">
						<?php echo JHtml::_( 'select.radiolist', $options, 'timer', '', 'value', 'text', $player_icons['timer']); ?>
						</fieldset>
                                                    </td>
					</tr>

					<!-- Settings for Share -->
					<tr>
						<td><?php echo JHTML::tooltip('Whether or not Share have to enable', 'Share','', 'Share');?></td>
						<td>
                                                    <fieldset id="jform_type" class="radio inputbox">
						<?php echo JHtml::_( 'select.radiolist', $options, 'shareurl', '', 'value', 'text', $player_icons['shareurl']); ?>
						</fieldset>
                                                    </td>
					</tr>
					<!-- Settings for email -->
					<tr>
						<td><?php echo JHTML::tooltip('Enable/Disable Email option on the player', 'Email','', 'Email');?></td>
						<td>
                                                    <fieldset id="jform_type" class="radio inputbox">
						<?php echo JHtml::_( 'select.radiolist', $options, 'email', '', 'value', 'text', $player_icons['email']); ?>
						</fieldset>
                                                    </td>
					</tr>
					<!-- Settings for volume -->
					<tr>
						<td><?php echo JHTML::tooltip('Enable/Disable Volume option on the player', 'Volume','', 'Volume');?></td>
						<td>
                                                    <fieldset id="jform_type" class="radio inputbox">
						<?php echo JHtml::_( 'select.radiolist', $options, 'volumevisible', '', 'value', 'text', $player_icons['volumevisible']); ?>
						</fieldset>
                                                    </td>
					</tr>
					<!-- Settings for progress bar -->
					<tr>
						<td><?php echo JHTML::tooltip('Enable/Disable Progress Bar option on the player', 'Progress Bar','', 'Progress Bar');?></td>
						<td>
                                                    <fieldset id="jform_type" class="radio inputbox">
						<?php echo JHtml::_( 'select.radiolist', $options, 'progressbar', '', 'value', 'text', $player_icons['progressbar']); ?>
						</fieldset>
                                                    </td>
					</tr>

					<!-- Settings for HD Default -->
					<tr>
						<td><?php echo JHTML::tooltip('Whether or not HD Default have to enable', 'HD Default','', 'HD Default');?></td>
						<td>
                                                    <fieldset id="jform_type" class="radio inputbox">
						<?php echo JHtml::_( 'select.radiolist', $options, 'hddefault', '', 'value', 'text', $player_icons['hddefault']); ?>
						</fieldset>
                                                    </td>
					</tr>
					<!-- Settings for Default Preview Image -->
					<tr>
						<td><?php echo JHTML::tooltip('Use Default Preview Image when it is not avaliable or not', 'Default Image','', 'Default Image');?></td>
						<td>
                                                    <fieldset id="jform_type" class="radio inputbox">
						<?php echo JHtml::_( 'select.radiolist', $options, 'imageDefault', '', 'value', 'text', $player_icons['imageDefault']); ?>
						</fieldset>
                                                    </td>
					</tr>
					<!-- Settings for Download -->
					<tr>
						<td><?php echo JHTML::tooltip('Enable/Disable Download Option', 'Download','', 'Download');?></td>
						<td>
                                                    <fieldset id="jform_type" class="radio inputbox">
						<?php echo JHtml::_( 'select.radiolist', $options, 'download', '', 'value', 'text', $player_icons['download']); ?>
						</fieldset>
                                                    </td>
					</tr>

					

					
				</tbody>
			</table>
		</fieldset>
	</div>

        <div class="width-50 fltlft">
		<fieldset class="adminform">
			<legend>Player Colors Settings</legend>
			<table class="adminlist">

				<thead>
					<tr>
						<th>Settings</th>
						<th>Value</th>

					</tr>
				</thead>

				<tfoot>
					<tr>
						<td colspan="2">&#160;</td>
					</tr>
				</tfoot>

				<tbody>
                                        <tr>
						<td><?php echo JHTML::tooltip('Enter the color for Share Popup Header Color', 'Share Popup Header Color','', 'Share Popup Header Color');?></td>
						<td><input name="sharepanel_up_BgColor" id="sharepanel_up_BgColor" maxlength="100" value="<?php echo $player_colors['sharepanel_up_BgColor']; ?>">
						</td>
					</tr>
                                        <tr>
						<td><?php echo JHTML::tooltip('Enter the color for Share Popup Background Color', 'Share Popup Background Color','', 'Share Popup Background Color');?></td>
						<td><input name="sharepanel_down_BgColor" id="sharepanel_down_BgColor" maxlength="100" value="<?php echo $player_colors['sharepanel_down_BgColor']; ?>">
						</td>
					</tr>
                                        <tr>
						<td><?php echo JHTML::tooltip('Enter the color for Share Popup Text Color', 'Share Popup Text Color','', 'Share Popup Text Color');?></td>
						<td><input name="sharepaneltextColor" id="sharepaneltextColor" maxlength="100" value="<?php echo $player_colors['sharepaneltextColor']; ?>">
						</td>
					</tr>
                                        <tr>
						<td><?php echo JHTML::tooltip('Enter the color for Send Button Color', 'Send Button Color','', 'Send Button Color');?></td>
						<td><input name="sendButtonColor" id="sendButtonColor" maxlength="100" value="<?php echo $player_colors['sendButtonColor']; ?>">
						</td>
					</tr>
                                        <tr>
						<td><?php echo JHTML::tooltip('Enter the color for Send Button Text Color', 'Send Button Text Color','', 'Send Button Text Color');?></td>
						<td><input name="sendButtonTextColor" id="sendButtonTextColor" maxlength="100" value="<?php echo $player_colors['sendButtonTextColor']; ?>">
						</td>
					</tr>
                                        <tr>
						<td><?php echo JHTML::tooltip('Enter the color for Player Text Color', 'Player Text Color','', 'Player Text Color');?></td>
						<td><input name="textColor" id="textColor" maxlength="100" value="<?php echo $player_colors['textColor']; ?>">
						</td>
					</tr>
                                        <tr>
						<td><?php echo JHTML::tooltip('Enter the color for Skin Background Color', 'Skin Background Color','', 'Skin Background Color');?></td>
						<td><input name="skinBgColor" id="skinBgColor" maxlength="100" value="<?php echo $player_colors['skinBgColor']; ?>">
						</td>
					</tr>
                                        <tr>
						<td><?php echo JHTML::tooltip('Enter the color for Seek Bar Color', 'Seek Bar Color','', 'Seek Bar Color');?></td>
						<td><input name="seek_barColor" id="seek_barColor" maxlength="100" value="<?php echo $player_colors['seek_barColor']; ?>">
						</td>
					</tr>
                                        <tr>
						<td><?php echo JHTML::tooltip('Enter the color for Buffer Bar Color', 'Buffer Bar Color','', 'Buffer Bar Color');?></td>
						<td><input name="buffer_barColor" id="buffer_barColor" maxlength="100" value="<?php echo $player_colors['buffer_barColor']; ?>">
						</td>
					</tr>
                                        <tr>
						<td><?php echo JHTML::tooltip('Enter the color for Skin Icons Color', 'Skin Icons Color','', 'Skin Icons Color');?></td>
						<td><input name="skinIconColor" id="skinIconColor" maxlength="100" value="<?php echo $player_colors['skinIconColor']; ?>">
						</td>
					</tr>
                                        <tr>
						<td><?php echo JHTML::tooltip('Enter the color for Progress Bar Background Color', 'Progress Bar Background Color','', 'Progress Bar Background Color');?></td>
						<td><input name="pro_BgColor" id="pro_BgColor" maxlength="100" value="<?php echo $player_colors['pro_BgColor']; ?>">
						</td>
					</tr>
                                        <tr>
						<td><?php echo JHTML::tooltip('Enter the color for Play Button Color', 'Play Button Color','', 'Play Button Color');?></td>
						<td><input name="playButtonColor" id="playButtonColor" maxlength="100" value="<?php echo $player_colors['playButtonColor']; ?>">
						</td>
					</tr>
                                        <tr>
						<td><?php echo JHTML::tooltip('Enter the color for Play Button Background Color', 'Play Button Background Color','', 'Play Button Background Color');?></td>
						<td><input name="playButtonBgColor" id="playButtonBgColor" maxlength="100" value="<?php echo $player_colors['playButtonBgColor']; ?>">
						</td>
					</tr>
                                        <tr>
						<td><?php echo JHTML::tooltip('Enter the color for Player Buttons Color', 'Player Buttons Color','', 'Player Buttons Color');?></td>
						<td><input name="playerButtonColor" id="playerButtonColor" maxlength="100" value="<?php echo $player_colors['playerButtonColor']; ?>">
						</td>
					</tr>
                                        <!-- Player Buttons Background Color -->
                                        <tr>
						<td><?php echo JHTML::tooltip('Enter the color for Player Buttons Background Color', 'Player Buttons Background Color','', 'Player Buttons Background Color');?></td>
						<td><input name="playerButtonBgColor" id="playerButtonBgColor" maxlength="100" value="<?php echo $player_colors['playerButtonBgColor']; ?>">
						</td>
					</tr>
                                        <!-- Related Videos Background Color -->
                                        <tr>
						<td><?php echo JHTML::tooltip('Enter the color for Related Videos Background Color', 'Related Videos Background Color','', 'Related Videos Background Color');?></td>
						<td><input name="relatedVideoBgColor" id="relatedVideoBgColor" maxlength="100" value="<?php echo $player_colors['relatedVideoBgColor']; ?>">
						</td>
					</tr>
                                        <!-- Related Videos Scroll Bar Color -->
                                        <tr>
						<td><?php echo JHTML::tooltip('Enter the color for Related Videos Scroll Bar Color', 'Related Videos Scroll Bar','', 'Related Videos Scroll Bar');?></td>
						<td><input name="scroll_barColor" id="scroll_barColor" maxlength="100" value="<?php echo $player_colors['scroll_barColor']; ?>">
						</td>
					</tr>
                                        <!-- Related Videos Scroll Bar Background Color -->
                                        <tr>
						<td><?php echo JHTML::tooltip('Enter the color for Related Videos Scroll Bar Background Color', 'Related Videos Scroll Bar Background','', 'Related Videos Scroll Bar Background');?></td>
						<td><input name="scroll_BgColor" id="scroll_BgColor" maxlength="100" value="<?php echo $player_colors['scroll_BgColor']; ?>">
						</td>
					</tr>
                                        
					

				</tbody>
			</table>
		</fieldset>
	</div>
    </div>
    <div class="hdflv_player_settings_right">    
	<div class="width-50 fltlft">
		<fieldset class="adminform">
			<legend>Logo Settings</legend>
			<table class="adminlist">

				<!-- Column header shows here -->
				<thead>
					<tr>
						<th>Settings</th>
						<th>Value</th>

					</tr>
				</thead>

				<!-- Footer shows here -->
				<tfoot>
					<tr>
						<td colspan="2">&#160;</td>
					</tr>
				</tfoot>

				<!-- Body content here -->
				<tbody>
					<tr>
						<td class="key"><?php echo JHTML::tooltip('Enter the License Key or purchase the product', 'License Key','', 'License Key');?></td>
						<td>
						<input type="text" name="licensekey" id="licensekey" size="45" maxlength="200"
							value="<?php echo trim($player_values['licensekey']); ?>" /> <?php
							if ($player_values['licensekey'] == '') {
								?>
							<a href="http://www.apptha.com/checkout/cart/add/product/18" target="_blank">
							<img src="components/com_hdflvplayer/images/buynow.gif" width="77" height="23" /> </a>
							 <?php
							}
							?>
						</td>
					</tr>

					<!-- Settings for Logo -->
					<tr>
						<td><?php echo JHTML::tooltip('Upload the Logo to display in the player', 'Logo','', 'Logo');?></td>
						<td>
							<div id="var_logo">
								<input name="logopath" id="logopath" maxlength="100" readonly="readonly" value="<?php echo $rs_editsettings->logopath; ?>">
									<input type="button" name="change" value="Change" maxlength="100" onclick="getsettings()">
							</div>
						</td>
					</tr>

					<tr>
						<td style="background-color: #D5E9EE; color: #333333;" colspan="2">
							Allowed Extensions :jpg/jpeg,gif ,png</td>
					</tr>

					<tr>

						<td><?php echo JHTML::tooltip('Enter Logo URL to navigate when click on the logo', 'Logo URL','', 'Logo URL');?></td>
						<td><input style="width: 150px;" type="text" name="logourl"
							value="<?php echo $player_values['logourl']; ?>" />
						</td>
					</tr>

					<tr>
						<td><?php echo JHTML::tooltip('Select the Logo Position to display in the player', 'Logo Position','', 'Logo Position');?></td>
						<td>
						<?php
						$logooptions[] = JHTML::_('select.option','TR','Top Right');
						$logooptions[] = JHTML::_('select.option','TL','Top Left');
						$logooptions[] = JHTML::_('select.option','BL','Bottom Left');
						$logooptions[] = JHTML::_('select.option','BR','Bottom Right');
						echo JHTML::_('select.genericlist', $logooptions,'logoalign', 'class="inputbox"','value','text', $player_values['logoalign']);?>
						</td>
					</tr>
					<tr>
						<td colspan="2" style="background-color: #D5E9EE; color: #333333;">
							Disabled in Demo Version</td>
					</tr>
				</tbody>
			</table>
		</fieldset>
	</div>


	<div class="width-50 fltlft">

		<fieldset class="adminform">
			<legend>Pre/Post Roll Ads Settings</legend>
			<table class="adminlist">

				<!-- Column header shows here -->
				<thead>
					<tr>
						<th>Settings</th>
						<th>Value</th>

					</tr>
				</thead>

				<!-- Column footer shows here -->
				<tfoot>
					<tr>
						<td colspan="2">&#160;</td>
					</tr>
				</tfoot>

				<!-- Content body here -->
				<tbody>

					<!-- Settings for Pre roll ads -->
					<tr>
						<td class="key"><?php echo JHTML::tooltip('Whether or not Pre roll ads have to be enable', 'Pre-roll Ads','', 'Pre-roll Ads');?></td>
						<td>
                                                    <fieldset id="jform_type" class="radio inputbox">
						<?php echo JHtml::_( 'select.radiolist', $options, 'prerollads', '', 'value', 'text', $player_icons['prerollads']); ?>
						  </fieldset>
                                                    </td>
					</tr>

					<!-- Settings for Post roll ads -->
					<tr>
						<td><?php echo JHTML::tooltip('Whether or not Post-roll Ads have to be enable', 'Post-roll Ads','', 'Post-roll Ads');?></td>
						<td>
                                                     <fieldset id="jform_type" class="radio inputbox">
						<?php echo JHtml::_( 'select.radiolist', $options, 'postrollads', '', 'value', 'text', $player_icons['postrollads']); ?>
						    </fieldset>
                                                     </td>
					</tr>
					<!-- Settings for IMA ad -->
					<tr>
						<td><?php echo JHTML::tooltip('Enable/Disable IMA Ads', 'IMA Ads','', 'IMA Ads');?></td>
						<td>
                                                     <fieldset id="jform_type" class="radio inputbox">
						<?php echo JHtml::_( 'select.radiolist', $options, 'imaAds', '', 'value', 'text', $player_icons['imaAds']); ?>
						    </fieldset>
                                                     </td>
					</tr>
					<!-- Settings for AD skip option -->
					<tr>
						<td><?php echo JHTML::tooltip('Enable/Disable Ad Skip option', 'Ad Skip','', 'Ad Skip');?></td>
						<td>
                                                     <fieldset id="jform_type" class="radio inputbox">
						<?php echo JHtml::_( 'select.radiolist', $options, 'adsSkip', '', 'value', 'text', $player_icons['adsSkip']); ?>
						    </fieldset>
                                                     </td>
					</tr>
                                        <!-- Settings for AD skip duration -->
                                        <tr>
						<td><?php echo JHTML::tooltip('Enter Ad Skip Duration', 'Ad Skip Duration','', 'Ad Skip Duration');?></td>
						<td><input type="text" name="adsSkipDuration" id="adsSkipDuration" value="<?php echo $player_values['adsSkipDuration']; ?>" />
						</td>
					</tr>
                                        <!-- Settings for Google Track Code -->
                                        <tr>
						<td><?php echo JHTML::tooltip('Enter Google Track Code', 'Track Code','', 'Track Code');?></td>
						<td><input type="text" name="googleanalyticsID" id="googleanalyticsID" value="<?php echo $player_values['googleanalyticsID']; ?>" />
						</td>
					</tr>

				</tbody>
			</table>
		</fieldset>
	</div>


	<div class="width-50 fltlft">
		<!-- Settings for Mid Roll Ads -->

		<fieldset class="adminform">
			<legend>Mid-roll Ad Settings</legend>
			<table class="adminlist">

				<thead>
					<tr>
						<th>Settings</th>
						<th>Value</th>

					</tr>
				</thead>

				<tfoot>
					<tr>
						<td colspan="2">&#160;</td>
					</tr>
				</tfoot>

				<tbody>
					<tr>
						<td class="key"><?php echo JHTML::tooltip('Whether or not Mid-roll ads have to be enable', 'Mid-roll Ads','', 'Mid-roll Ads');?></td>
						<td>
                                                    <fieldset id="jform_type" class="radio inputbox">
						<?php echo JHtml::_( 'select.radiolist', $options, 'midrollads', '', 'value', 'text', $player_icons['midrollads']); ?>
						</fieldset>
                                                    </td>
					</tr>

					<tr>
						<td><?php echo JHTML::tooltip('Enter Begin time for Mid roll ads', 'Begin','', 'Begin');?></td>
						<td><input type="text" name="midbegin" id="midbegin" value="<?php echo $player_values['midbegin']; ?>" />
					</tr>

					<tr>
						<td><?php echo JHTML::tooltip('Whether or not Ad have to Rotate for Mid-roll', 'Ad Rotate','', 'Ad Rotate');?></td>
						<td>
                                                    <fieldset id="jform_type" class="radio inputbox">
						<?php echo JHtml::_( 'select.radiolist', $options, 'midadrotate', '', 'value', 'text', $player_icons['midadrotate']); ?>
						</fieldset>
                                                    </td>
					</tr>

					<tr>
						<td><?php echo JHTML::tooltip('Whether or not Random option have to Rotate for Mid-roll Ads', 'Mid-roll Ads Random','', 'Mid-roll Ads Random');?></td>
						<td>
                                                    <fieldset id="jform_type" class="radio inputbox">
						<?php echo JHtml::_( 'select.radiolist', $options, 'midrandom', '', 'value', 'text', $player_icons['midrandom']); ?>
						</fieldset>
                                                    </td>
					</tr>

					<tr>
						<td><?php echo JHTML::tooltip('Enter Ad Interval time', 'Ad Interval','', 'Ad Interval');?></td>
						<td><input type="text" name="midinterval" id="midinterval" value="<?php echo $player_values['midinterval']; ?>" />
						</td>
					</tr>

				</tbody>
			</table>
		</fieldset>
	</div>
    
<!-- Front page Settings here -->
	<div class="width-50 fltlft">
		<fieldset class="adminform">
			<legend>Front Page Settings</legend>
			<table class="adminlist">

				<thead>
					<tr>
						<th>Settings</th>
						<th>Value</th>

					</tr>
				</thead>

				<tfoot>
					<tr>
						<td colspan="2">&#160;</td>
					</tr>
				</tfoot>

				<tbody>
					<tr>
						<td class="key"><?php echo JHTML::tooltip('Whether or not Title above the Player have to be enable', 'Title above the Player','', 'Title above the Player');?></td>
						<td>
                                                    <fieldset id="jform_type" class="radio inputbox">
						<?php echo JHtml::_( 'select.radiolist', $options, 'title_ovisible', '', 'value', 'text', $player_icons['title_ovisible']); ?>
						</fieldset>
                                                    </td>
					</tr>

					<tr>
						<td style="width:110px;"><?php echo JHTML::tooltip('Whether or not Description below the Player have to be enable', 'Description below the Player','', 'Description below the Player');?></td>
						<td>
                                                     <fieldset id="jform_type" class="radio inputbox">
						<?php echo JHtml::_( 'select.radiolist', $options, 'description_ovisible', '', 'value', 'text', $player_icons['description_ovisible']); ?>
						</fieldset>
                                                     </td>

					</tr>
					<tr>
						<td style="width:110px;"><?php echo JHTML::tooltip('Enable/Disable Description on the player', 'Description on the Player','', 'Description on the Player');?></td>
						<td>
                                                     <fieldset id="jform_type" class="radio inputbox">
						<?php echo JHtml::_( 'select.radiolist', $options, 'showTag', '', 'value', 'text', $player_icons['showTag']); ?>
						</fieldset>
                                                     </td>

					</tr>

					<tr>
						<td><?php echo JHTML::tooltip('Whether or not Times Viewed option have to be enable', 'Times Viewed','', 'Times Viewed');?></td>
						<td>
                                                     <fieldset id="jform_type" class="radio inputbox">
						<?php echo JHtml::_( 'select.radiolist', $options, 'viewed_visible', '', 'value', 'text', $player_icons['viewed_visible']); ?>
						</fieldset>
                                                     </td>
					</tr>
                                        
					<!-- Settings for Embed Code -->
					<tr>
						<td><?php echo JHTML::tooltip('Whether or not Embed Code have to be enable', 'Embed Code','', 'Embed Code');?></td>
						<td>
                                                    <fieldset id="jform_type" class="radio inputbox">
						<?php echo JHtml::_( 'select.radiolist', $options, 'embedcode_visible', '', 'value', 'text', $player_icons['embedcode_visible']); ?>
						</fieldset>
                                                    </td>
					</tr>

					<tr>
						<td><?php echo JHTML::tooltip('Whether or not Playlist Drop Down option have to be enable', 'Playlist Drop Down','', 'Playlist Drop Down');?></td>
						<td>
                                                     <fieldset id="jform_type" class="radio inputbox">
						<?php echo JHtml::_( 'select.radiolist', $options, 'playlist_dvisible', '', 'value', 'text', $player_icons['playlist_dvisible']); ?>
						</fieldset>
                                                     </td>
					</tr>
                                        <!-- Settings for Related Videos -->
					<tr>
						<td><?php echo JHTML::tooltip('Choose where the related videos have to show', 'Related Videos','', 'Related Videos');?></td>
						<td>
						<?php
						$relatedoptions[] = JHTML::_('select.option','1','Enable Both');
						$relatedoptions[] = JHTML::_('select.option','2','Disable');
						$relatedoptions[] = JHTML::_('select.option','3','Within Player');
						$relatedoptions[] = JHTML::_('select.option','4','Outside Player');
						echo JHTML::_('select.genericlist', $relatedoptions,'related_videos', 'class="inputbox"','value','text', $player_values['related_videos']);
						?>
						</td>
					</tr>
                                        
                                        <!-- Select Related Video View -->
					<tr>
						<td><?php echo JHTML::tooltip('Select Related Video View', 'Select Related Video View','', 'Select Related Video View');?>
						</td>
						<td>
						<?php
						$relatedviewoptions[] = JHTML::_('select.option','side','side');
						$relatedviewoptions[] = JHTML::_('select.option','center','center');
						echo JHTML::_('select.genericlist', $relatedviewoptions,'relatedVideoView', 'class="inputbox"','value','text', $player_values['relatedVideoView']);?>
						</td>
					</tr>
                                        
                                        <tr>
						<td><?php echo JHTML::tooltip('Enter Number of related videos per page', 'Number of Related Videos','', 'Number of related videos per page');?></td>
						<td><input name="nrelated" id="nrelated" maxlength="100" value="<?php echo $player_values['nrelated']; ?>"/>
						</td>
					</tr>
                                        
					<!-- Settings for Login Page Link -->
					<tr>
						<td><?php echo JHTML::tooltip('Enter the Login Page Link for the video(s) have not Public access', 'Login Page Link','', 'Login Page Link');?></td>
						<td><input name="urllink" id="urllink" maxlength="100" value="<?php echo $player_values['urllink']; ?>">
						</td>
					</tr>

				</tbody>
			</table>
		</fieldset>
	</div>
<!--Player color settings-->

    
</div>
	<input type="hidden" name="id" value="<?php echo $rs_editsettings->id; ?>" />
	<input type="hidden" name="task" value="">
    <input type="hidden" name="submitted" value="true" id="submitted">
		<?php echo JHTML::_('form.token'); ?>
</form>
		<?php

} ?>
