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

$language = $this->editlanguage;
$language_rs = unserialize($language->player_lang);
if (!empty($language_rs)) {
?>

    <form action="index.php?option=com_hdflvplayer&task=languagesetup" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
          <div class="width-60 fltlft">
                <fieldset class="adminform">
                    <legend>Language Settings</legend>
                    <table class="adminlist">
                        <thead>
                            <tr>
                                <th>Settings</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <td colspan="2">&#160;
                                </td>
                            </tr>
                        </tfoot>
                        <tbody>
			                <tr><td class="key"><?php echo JHTML::tooltip('Enter the text for Play', 'Play','', 'Play');?></td><td><input type="text" name="play"  id="play" style="width:300px" maxlength="250" value="<?php echo $language_rs['play']; ?>"/></td></tr>
			                <tr><td class="key"><?php echo JHTML::tooltip('Enter the text for Pause', 'Pause','', 'Pause');?></td><td><input type="text" name="pause"  id="pause" style="width:300px" maxlength="250" value="<?php echo $language_rs['pause']; ?>"/></td></tr>
			                <tr><td class="key"><?php echo JHTML::tooltip('Enter the text for Replay', 'Replay','', 'Replay');?></td><td><input type="text" name="replay"  id="replay" style="width:300px" maxlength="250" value="<?php echo $language_rs['replay']; ?>"/></td></tr>
			                <tr><td class="key"><?php echo JHTML::tooltip('Enter the text for Changequality', 'Changequality','', 'Changequality');?></td><td><input type="text" name="changequality"  id="changequality" style="width:300px" maxlength="250" value="<?php echo $language_rs['changequality']; ?>"/></td></tr>
			                <tr><td class="key"><?php echo JHTML::tooltip('Enter the text for Zoom', 'Zoom','', 'Zoom');?></td><td><input type="text" name="zoom"  id="zoom" style="width:300px" maxlength="250" value="<?php echo $language_rs['zoom']; ?>" /></td></tr>
			                <tr><td class="key"><?php echo JHTML::tooltip('Enter the text for Zoom In', 'Zoom In','', 'Zoom In');?></td><td><input type="text" name="zoomin"  id="zoomin" style="width:300px" maxlength="250" value="<?php echo $language_rs['zoomin']; ?>" /></td></tr>
			                <tr><td class="key"><?php echo JHTML::tooltip('Enter the text for Zoom Out', 'Zoom Out','', 'Zoom Out');?></td><td><input type="text" name="zoomout"  id="zoomout" style="width:300px" maxlength="250" value="<?php echo $language_rs['zoomout']; ?>" /></td></tr>
			                <tr><td class="key"><?php echo JHTML::tooltip('Enter the text for Share', 'Share','', 'Share');?></td><td><input type="text" name="share"  id="share" style="width:300px" maxlength="250" value="<?php echo $language_rs['share']; ?>" /></td></tr>
			                <tr><td class="key"><?php echo JHTML::tooltip('Enter the text for Fullscreen', 'Fullscreen','', 'Fullscreen');?></td><td><input type="text" name="fullscreen"  id="fullscreen" style="width:300px" maxlength="250" value="<?php echo $language_rs['fullscreen']; ?>" /></td></tr>
			                <tr><td class="key"><?php echo JHTML::tooltip('Enter the text for Exit FullScreen', 'Exit FullScreen','', 'Exit FullScreen');?></td><td><input type="text" name="exitfullScreen"  id="exitfullScreen" style="width:300px" maxlength="250" value="<?php echo $language_rs['exitfullScreen']; ?>" /></td></tr>
                                        <tr><td class="key"><?php echo JHTML::tooltip('Enter the text for Playlist Hide', 'Playlist Hide','', 'Playlist Hide');?></td><td><input type="text" name="playlisthide"  id="playlisthide" style="width:300px" maxlength="250" value="<?php echo $language_rs['playlisthide']; ?>" /></td></tr>
                                        <tr><td class="key"><?php echo JHTML::tooltip('Enter the text for Playlist View', 'Playlist View','', 'Playlist View');?></td><td><input type="text" name="playlistview"  id="playlistview" style="width:300px" maxlength="250" value="<?php echo $language_rs['playlistview']; ?>" /></td></tr>
                                        <tr><td class="key"><?php echo JHTML::tooltip('Enter the text for Share the word', 'Share the word','', 'Share the word');?></td><td><input type="text" name="sharetheword"  id="sharetheword" style="width:300px" maxlength="250" value="<?php echo $language_rs['sharetheword']; ?>" /></td></tr>
			                <tr><td class="key"><?php echo JHTML::tooltip('Enter the text for Send an email', 'Send an email','', 'Send an email');?></td><td><input type="text" name="sendanemail"  id="sendanemail" style="width:300px" maxlength="250" value="<?php echo $language_rs['sendanemail']; ?>" /></td></tr>
			                <tr><td class="key"><?php echo JHTML::tooltip('Enter the text for Email', 'Email','', 'Email');?></td><td><input type="text" name="email"  id="email" style="width:300px" maxlength="250" value="<?php echo $language_rs['email']; ?>" /></td></tr>
			                <tr><td class="key"><?php echo JHTML::tooltip('Enter the text for To', 'To','', 'To');?></td><td><input type="text" name="to"  id="to" style="width:300px" maxlength="250" value="<?php echo $language_rs['to']; ?>" /></td></tr>
			                <tr><td class="key"><?php echo JHTML::tooltip('Enter the text for From', 'From','', 'From');?></td><td><input type="text" name="from"  id="from" style="width:300px" maxlength="250" value="<?php echo $language_rs['from']; ?>" /></td></tr>
			                <tr><td class="key"><?php echo JHTML::tooltip('Enter the text for Note', 'Note','', 'Note');?></td><td><input type="text" name="note"  id="note" style="width:300px" maxlength="250" value="<?php echo $language_rs['note']; ?>"/></td></tr>
			                <tr><td class="key"><?php echo JHTML::tooltip('Enter the text for Send', 'Send','', 'Send');?></td><td><input type="text" name="send"  id="send" style="width:300px" maxlength="250" value="<?php echo $language_rs['send']; ?>" /></td></tr>
			                <tr><td class="key"><?php echo JHTML::tooltip('Enter the text for Copy', 'Copy','', 'Copy');?></td><td><input type="text" name="copy"  id="copy" style="width:300px" maxlength="250" value="<?php echo $language_rs['copy']; ?>" /></td></tr>
			                <tr><td class="key"><?php echo JHTML::tooltip('Enter the text for Link', 'Link','', 'Link');?></td><td><input type="text" name="copylink"  id="copylink" style="width:300px" maxlength="250" value="<?php echo $language_rs['copylink']; ?>" /></td></tr>
			                <tr><td class="key"><?php echo JHTML::tooltip('Enter the text for Embed', 'Embed','', 'Embed');?></td><td><input type="text" name="copyembed"  id="copyembed" style="width:300px" maxlength="250" value="<?php echo $language_rs['copyembed']; ?>" /></td></tr>
                                        <tr><td class="key"><?php echo JHTML::tooltip('Enter the text for Social', 'Social','', 'Social');?></td><td><input type="text" name="social"  id="social" style="width:300px" maxlength="250" value="<?php echo $language_rs['social']; ?>" /></td></tr>
                                        <tr><td class="key"><?php echo JHTML::tooltip('Enter the text for Quality', 'Quality','', 'Quality');?></td><td><input type="text" name="quality"  id="quality" style="width:300px" maxlength="250" value="<?php echo $language_rs['quality']; ?>" /></td></tr>
			                <tr><td class="key"><?php echo JHTML::tooltip('Enter the text for Share on Facebook', 'Share on Facebook','', 'Share on Facebook');?></td><td><input type="text" name="facebook"  id="facebook" style="width:300px" maxlength="250" value="<?php echo $language_rs['facebook']; ?>" /></td></tr>
			                <tr><td class="key"><?php echo JHTML::tooltip('Enter the text for Share on Google+', 'Share on Google+','', 'Share on Google+');?></td><td><input type="text" name="googleplus"  id="googleplus" style="width:300px" maxlength="250" value="<?php echo $language_rs['googleplus']; ?>" /></td></tr>
			                <tr><td class="key"><?php echo JHTML::tooltip('Enter the text for Share on Tumblr', 'Share on Tumblr','', 'Share on Tumblr');?></td><td><input type="text" name="tumblr"  id="tumblr" style="width:300px" maxlength="250" value="<?php echo $language_rs['tumblr']; ?>" /></td></tr>
			                <tr><td class="key"><?php echo JHTML::tooltip('Enter the text for Share on Twitter', 'Share on Twitter','', 'Share on Twitter');?></td><td><input type="text" name="tweet"  id="tweet" style="width:300px" maxlength="250" value="<?php echo $language_rs['tweet']; ?>" /></td></tr>
                                        <tr><td class="key"><?php echo JHTML::tooltip('Enter the text for Turn Off Playlist Autoplay', 'Turn Off Playlist Autoplay','', 'Turn Off Playlist Autoplay');?></td><td><input type="text" name="turnoffplaylistautoplay"  id="turnoffplaylistautoplay" style="width:300px" maxlength="250" value="<?php echo $language_rs['turnoffplaylistautoplay']; ?>" /></td></tr>
                                        <tr><td class="key"><?php echo JHTML::tooltip('Enter the text for Turn On Playlist Autoplay', 'Turn On Playlist Autoplay','', 'Turn On Playlist Autoplay');?></td><td><input type="text" name="turnonplaylistautoplay"  id="turnonplaylistautoplay" style="width:300px" maxlength="250" value="<?php echo $language_rs['turnonplaylistautoplay']; ?>" /></td></tr>
                                        <tr><td class="key"><?php echo JHTML::tooltip('Enter the text for Ad Indicator', 'Ad Indicator','', 'Ad Indicator');?></td><td><input type="text" name="adindicator"  id="adindicator" style="width:300px" maxlength="250" value="<?php echo $language_rs['adindicator']; ?>" /></td></tr>
			                <tr><td class="key"><?php echo JHTML::tooltip('Enter the text for Ad Skip Message', 'Ad Skip Message','', 'Ad Skip Message');?></td><td><input type="text" name="skipadd"  id="skipadd" style="width:300px" maxlength="250" value="<?php echo $language_rs['skipadd']; ?>" /></td></tr>
			                <tr><td class="key"><?php echo JHTML::tooltip('Enter the text for Skip Video', 'Skip Video','', 'Skip Video');?></td><td><input type="text" name="skipvideo"  id="skipvideo" style="width:300px" maxlength="250" value="<?php echo $language_rs['skipvideo']; ?>" /></td></tr>
			                <tr><td class="key"><?php echo JHTML::tooltip('Enter the text for Download', 'Download','', 'Download');?></td><td><input type="text" name="download"  id="download" style="width:300px" maxlength="250" value="<?php echo $language_rs['download']; ?>" /></td></tr>
                                        <tr><td class="key"><?php echo JHTML::tooltip('Enter the text for Volume', 'Volume','', 'Volume');?></td><td><input type="text" name="volume"  id="volume" style="width:300px" maxlength="250" value="<?php echo $language_rs['volume']; ?>" /></td></tr>
			                <tr><td class="key"><?php echo JHTML::tooltip('Enter the text for Midroll Ad', 'Midroll Ad','', 'Midroll Ad');?></td><td><input type="text" name="mid"  id="mid" style="width:300px" maxlength="300" value="<?php echo $language_rs['mid']; ?>" /></td></tr>
			                <tr><td class="key"><?php echo JHTML::tooltip('Enter the text for No Thumbnail', 'No Thumbnail','', 'No Thumbnail');?></td><td><input type="text" name="nothumbnail"  id="nothumbnail" style="width:300px" maxlength="300" value="<?php echo $language_rs['nothumbnail']; ?>" /></td></tr>
			                <tr><td class="key"><?php echo JHTML::tooltip('Enter the text for Live', 'Live','', 'Live');?></td><td><input type="text" name="live"  id="live" style="width:300px" maxlength="300" value="<?php echo $language_rs['live']; ?>" /></td></tr>
			                <tr><td class="key"><?php echo JHTML::tooltip('Enter the text for Fill Required Fields', 'Fill Required Fields','', 'Fill Required Fields');?></td><td><input type="text" name="fillrequiredfields"  id="fillrequiredfields" style="width:300px" maxlength="300" value="<?php echo $language_rs['fillrequiredfields']; ?>" /></td></tr>
			                <tr><td class="key"><?php echo JHTML::tooltip('Enter the text for Wrong Email', 'Wrong Email','', 'Wrong Email');?></td><td><input type="text" name="wrongemail"  id="wrongemail" style="width:300px" maxlength="300" value="<?php echo $language_rs['wrongemail']; ?>" /></td></tr>
			                <tr><td class="key"><?php echo JHTML::tooltip('Enter the text for Wait', 'Wait','', 'Wait');?></td><td><input type="text" name="emailwait"  id="emailwait" style="width:300px" maxlength="300" value="<?php echo $language_rs['emailwait']; ?>" /></td></tr>
			                <tr><td class="key"><?php echo JHTML::tooltip('Enter the text for Email Sent', 'Email Sent','', 'Email Sent');?></td><td><input type="text" name="emailsent"  id="emailsent" style="width:300px" maxlength="300" value="<?php echo $language_rs['emailsent']; ?>" /></td></tr>
			                <tr><td class="key"><?php echo JHTML::tooltip('Enter the text for Not allowed in embed player', 'Not allowed in embed player','', 'Not allowed in embed player');?></td><td><input type="text" name="notallow_embed"  id="notallow_embed" style="width:300px" maxlength="300" value="<?php echo $language_rs['notallow_embed']; ?>" /></td></tr>
			                <tr><td class="key"><?php echo JHTML::tooltip('Enter the text for Youtube ID Invalid', 'Youtube ID Invalid','', 'Youtube ID Invalid');?></td><td><input type="text" name="youtube_ID_Invalid"  id="youtube_ID_Invalid" style="width:300px" maxlength="300" value="<?php echo $language_rs['youtube_ID_Invalid']; ?>" /></td></tr>
			                <tr><td class="key"><?php echo JHTML::tooltip('Enter the text for Removed or private', 'Removed or private','', 'Removed or private');?></td><td><input type="text" name="video_Removed_or_private"  id="video_Removed_or_private" style="width:300px" maxlength="300" value="<?php echo $language_rs['video_Removed_or_private']; ?>" /></td></tr>
			                <tr><td class="key"><?php echo JHTML::tooltip('Enter the text for Streaming Connection Failed', 'Streaming Connection Failed','', 'Streaming Connection Failed');?></td><td><input type="text" name="streaming_connection_failed"  id="streaming_connection_failed" style="width:300px" maxlength="300" value="<?php echo $language_rs['streaming_connection_failed']; ?>" /></td></tr>
                                        <tr><td class="key"><?php echo JHTML::tooltip('Enter the text for Audio not found', 'Audio not found','', 'Audio not found');?></td><td><input type="text" name="audio_not_found"  id="audio_not_found" style="width:300px" maxlength="300" value="<?php echo $language_rs['audio_not_found']; ?>" /></td></tr>
			                <tr><td class="key"><?php echo JHTML::tooltip('Enter the text for Video access denied', 'Video access denied','', 'Video access denied');?></td><td><input type="text" name="video_access_denied"  id="video_access_denied" style="width:300px" maxlength="300" value="<?php echo $language_rs['video_access_denied']; ?>" /></td></tr>
			                <tr><td class="key"><?php echo JHTML::tooltip('Enter the text for File structure invalid', 'File structure invalid','', 'File structure invalid');?></td><td><input type="text" name="FileStructureInvalid"  id="FileStructureInvalid" style="width:300px" maxlength="300" value="<?php echo $language_rs['FileStructureInvalid']; ?>" /></td></tr>
			                <tr><td class="key"><?php echo JHTML::tooltip('Enter the text for No supported track found', 'No supported track found','', 'No supported track found');?></td><td><input type="text" name="NoSupportedTrackFound"  id="NoSupportedTrackFound" style="width:300px" maxlength="300" value="<?php echo $language_rs['NoSupportedTrackFound']; ?>" /></td></tr>
                   </tbody>
           </table>
        </fieldset>
     	</div>
        <input type="hidden" name="id" value="<?php echo $language->id; ?>" />
        <input type="hidden" name="task" value="" />
        <input type="hidden" name="submitted" value="true" id="submitted">
<?php echo JHTML::_('form.token'); ?>
    </form>
<?php
} 
?>

<script type="text/javascript">
Joomla.submitbutton = function(pressbutton) {

	// do field validation
	if (pressbutton == "applylanguagesetup") {
		var fields = document['adminForm'].getElementsByTagName("input");
		
		//var fields = document.getElementsByTagName('input');	
		var flag = 0;
		for(i=0;i<fields.length;i++)
		{
			
			if(fields[i].name != 'task' && fields[i].value == '')
			{
				
				flag++;
			}
			
	}
		
		if(flag>0)
		{
			alert('Kindly make sure you have entered all inputs');
			return false;
		}
		else{
			submitform(pressbutton);
			return true;
		}
}
}
function submitbutton(pressbutton) {

	// do field validation
	if (pressbutton == "applylanguagesetup") {
		var fields = document['adminForm'].getElementsByTagName("input");
		
		//var fields = document.getElementsByTagName('input');	
		var flag = 0;
		for(i=0;i<fields.length;i++)
		{
			
			if(fields[i].name != 'task' && fields[i].value == '')
			{
				
				flag++;
			}
			
	}
		
		if(flag>0)
		{
			alert('Kindly make sure you have entered all inputs');
			return false;
		}
		else{
			submitform(pressbutton);
			return true;
		}
}}

</script>