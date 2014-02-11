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

$rs_roll = $this->adslist;
$imaaddetail = unserialize($rs_roll['rs_ads']->imaaddet);
$document = JFactory::getDocument();
$document->addScript( 'components/com_hdflvplayer/js/upload_script.js' );
$document->addScript( 'components/com_hdflvplayer/js/adslayout.js' );
?>

<!-- Content here -->
<div class="width-60 fltlft" style="width: 100%;">
	<fieldset class="adminform">
		<legend>Select Ad Settings</legend>
		<table class="adminlist">

			<!-- Header shows here -->
			<thead>
				<tr>
					<th style="width: 20%;">Settings</th>
					<th style="text-align: left;">Value</th>
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

				<!-- Choose the setting here -->
				<tr>
					<td class="key" width="200px;"><?php echo JHTML::tooltip('Choose type of Ad', 'Ad Type','', 'Ad Type');?>
					</td>
					<td>
					<?php
					$preAds = $midAds = '';
					if ($rs_roll['rs_ads']->typeofadd == "prepost" || $rs_roll['rs_ads']->typeofadd == '') {
						$preAds = 'checked';
					}
					else if ($rs_roll['rs_ads']->typeofadd == "mid") {
						$midAds = 'checked';
					}
					else if ($rs_roll['rs_ads']->typeofadd == "ima") {
						$imaAds = 'checked';
					}
					?>
					<input type="radio" style="float: none; margin-right: 3px;" name="selectadd" id="selectadd" value="prepost" onclick="checkadd('prepost');" <?php echo $preAds; ?> />Pre-roll/Post-roll Ad
					<input type="radio" style="float: none; margin-right: 3px; margin-left: 10px;" name="selectadd" id="selectaddmid" value="mid" onclick="checkadd('mid');" <?php echo $midAds;?> />Mid-roll Ad
					<input type="radio" style="float: none; margin-right: 3px; margin-left: 10px;" name="selectadd" id="selectaddima" value="ima" onclick="checkadd('ima');" <?php echo $imaAds;?> />IMA Ad
					</td>
				</tr>

			</tbody>

		</table>
	</fieldset>
</div>

<?php
$styleVar = '';
if (isset($rs_roll['rs_ads']->typeofadd) && $rs_roll['rs_ads']->typeofadd == "mid") {
	$styleVar = 'style="display: none;"';
}
?>
<div class="width-60 fltlft"  style="width: 100%;">

	<fieldset class="adminform" id="videodet" <?php echo $styleVar; ?>>
		<legend>Video Details</legend>
		<table class="adminlist">

			<!-- Header shows here -->
			<thead>
				<tr>
					<th style="width: 20%;">Settings</th>
					<th style="text-align: left;">Value</th>
				</tr>
			</thead>

			<!-- Footer shows here -->
			<tfoot>
				<tr>
					<td colspan="2">&#160;</td>
				</tr>
			</tfoot>

			<!-- Body content shows here -->
			<tbody>

				<!-- Choose the File Path option, either file or By URL -->
				<tr>
					<td class="key" width="200px;"><?php echo JHTML::tooltip('Choose the File option', 'File Option','', 'File Option');?>
					</td>
					<td>
					<?php
					$fileChecked = $urlChecked = '';
					if ($rs_roll['rs_ads']->filepath == "File" || $rs_roll['rs_ads']->filepath == '') {
							$fileChecked = 'checked="checked" ';
						}
						else if($rs_roll['rs_ads']->filepath == "Url")
						{
							$urlChecked = 'checked="checked" ';
						}
					?>
					<input type="radio" style="float: none; margin-right: 3px;" name="filepath" id="filepath" <?php echo $fileChecked; ?> value="File" onclick="fileads('File');" />File
					<input type="radio" style="float: none; margin-right: 3px; margin-left: 10px;" name="filepath" id="filepathurl" <?php echo $urlChecked; ?> value="Url" onclick="fileads('Url');" />URL
					</td>
				</tr>

				<!-- If File menas, File upload option here -->
				<tr id="postrollnf" name="postrollnf">
					<td class="key"><?php echo JHTML::tooltip('Upload Video for Pre-roll/Post-roll', 'Upload Pre-roll/Post-roll','', 'Upload Pre-roll/Post-roll');?>
					</td>
					<td>
						<div id="f1-upload-form">
							<form name="normalvideoform" method="post" enctype="multipart/form-data">
								<input type="file" name="myfile" id="myfile" onchange="enableUpload(this.form.name);" />
								<input type="button" name="uploadBtn" value="Upload Video" disabled="disabled" onclick="addQueue(this.form.name);" />
								<label id="filepaths"><?php echo $rs_roll['rs_ads']->postvideopath; ?></label>
								<input type="hidden" name="mode" value="video" />
							</form>
						</div>
						<div id="f1-upload-progress" style="display: none">
							<table>
								<tr>
									<td><img id="f1-upload-image" style="float: left;" src="components/com_hdflvplayer/images/empty.gif" alt="Uploading" />
									</td>
									<td><span style="float: left; clear: none; font-weight: bold;" id="f1-upload-filename">&nbsp;</span>
									</td>
									<td><span id="f1-upload-message" style="float: left;width:300px;"> </span>
										<label id="f1-upload-status" style="float: left;"> &nbsp; </label>
									</td>
									<td><span id="f1-upload-cancel">
										<a style="float: left; font-weight: bold" href="javascript:cancelUpload('normalvideoform');" name="submitcancel">Cancel</a>
										</span>
									</td>
								</tr>
							</table>
						</div>

						<div id="nor">
							<iframe id="uploadvideo_target" name="uploadvideo_target" src="#" style="width: 0; height: 0; border: 0px solid #fff;"></iframe>
						</div>
					</td>

				</tr>

				<!-- If URL, means enter video here -->
				<tr id="postrollurl">
					<td class="key"><?php echo JHTML::tooltip('Enter Pre-roll/Post-roll Video URL', 'Pre-roll/Post-roll URL','', 'Pre-roll/Post-roll URL');?>

					</td>
					<td><input type="text" name="posturl" id="posturl" style="width: 300px" maxlength="250" value="<?php echo $rs_roll['rs_ads']->postvideopath; ?>" />
					</td>

				</tr>

			</tbody>

		</table>
	</fieldset>
    	
</div>


<form action="index.php?option=com_hdflvplayer&task=ads" method="post" name="adminForm" onsubmit="" id="adminForm" enctype="multipart/form-data">
	<div class="width-60 fltlft"  style="width: 100%;">

            <fieldset class="adminform" id="videodetima" <?php echo $styleVar; ?>>
		<legend>IMA Ad Details</legend>
		<table class="adminlist">

			<!-- Header shows here -->
			<thead>
				<tr>
					<th style="width: 20%;">Settings</th>
					<th style="text-align: left;">Value</th>
				</tr>
			</thead>

			<!-- Footer shows here -->
			<tfoot>
				<tr>
					<td colspan="2">&#160;</td>
				</tr>
			</tfoot>

			<!-- Body content shows here -->
			<tbody>

				<!-- Choose the File Path option, either file or By URL -->
				<tr>
					<td class="key" width="200px;"><?php echo JHTML::tooltip('Choose the IMA Ad option', 'IMA Ad type','', 'IMA Ad type');?>
					</td>
					<td>
					<?php
//					$fileChecked = $urlChecked = '';
//					if ($rs_roll['rs_ads']->filepath == "File" || $rs_roll['rs_ads']->filepath == '') {
//							$fileChecked = 'checked="checked" ';
//						}
//						else if($rs_roll['rs_ads']->filepath == "Url")
//						{
//							$urlChecked = 'checked="checked" ';
//						}
					?>
					<input type="radio" style="float: none; margin-right: 3px;" name="imaadtype" id="textad" checked="checked" value="textad" onclick="imaads('textad');" />Text/Overlay
					<input type="radio" style="float: none; margin-right: 3px; margin-left: 10px;" name="imaadtype" id="videoad" value="videoad" onclick="imaads('videoad');" />Video
					</td>
				</tr>

				<!-- If File menas, File upload option here -->
				<tr id="imaadwidth" name="imaadwidth">
					<td class="key"><?php echo JHTML::tooltip('Enter IMA Ad Slot Width', 'IMA Ad Slot Width','', 'Ad Slot Width');?>
					</td>
					<td>
					<input type="text" name="videoimaadwidth" id="videoimaadwidth" style="width: 300px" maxlength="250" value="<?php if(isset($imaaddetail['videoimaadwidth'])) echo $imaaddetail['videoimaadwidth']; ?>" />	
					</td>

				</tr>
				<tr id="imaadheight" name="imaadheight">
					<td class="key"><?php echo JHTML::tooltip('Enter IMA Ad Slot Height', 'IMA Ad Slot Height','', 'Ad Slot Height');?>
					</td>
					<td>
					<input type="text" name="videoimaadheight" id="videoimaadheight" style="width: 300px" maxlength="250" value="<?php if(isset($imaaddetail['videoimaadheight'])) echo $imaaddetail['videoimaadheight']; ?>" />	
					</td>

				</tr>
				<tr id="adimapublisher" name="adimapublisher">
					<td class="key"><?php echo JHTML::tooltip('Enter IMA Ad Publisher Id', 'IMA Ad Publisher Id','', 'Publisher Id');?>
					</td>
					<td>
					<input type="text" name="publisherId" id="publisherId" style="width: 300px" maxlength="250" value="<?php if(isset($imaaddetail['publisherId'])) echo $imaaddetail['publisherId']; ?>" />	
					</td>

				</tr>
				<tr id="adimacontentid" name="adimacontentid">
					<td class="key"><?php echo JHTML::tooltip('Enter IMA Ad Content Id', 'IMA Ad Content Id','', 'Content Id');?>
					</td>
					<td>
					<input type="text" name="contentId" id="contentId" style="width: 300px" maxlength="250" value="<?php if(isset($imaaddetail['contentId'])) echo $imaaddetail['contentId']; ?>" />	
					</td>

				</tr>
				<tr id="adimachannels" name="adimachannels">
					<td class="key"><?php echo JHTML::tooltip('Enter IMA Ad Channel', 'Ad Channel','', 'Channel');?>
					</td>
					<td>
					<input type="text" name="channels" id="channels" style="width: 300px" maxlength="250" value="<?php if(isset($imaaddetail['channels'])) echo $imaaddetail['channels']; ?>" />	
					</td>

				</tr>

				<!-- If URL, means enter video here -->
				<tr id="imavideoad">
					<td class="key"><?php echo JHTML::tooltip('Enter IMA Ad Path', 'IMA Ad Path','', 'IMA Ad Path');?>

					</td>
					<td><input type="text" name="imaadpath" id="imaadpath" style="width: 300px" maxlength="250" value="<?php if(isset($imaaddetail['imaadpath'])) echo $imaaddetail['imaadpath']; ?>" />
					</td>

				</tr>

			</tbody>

		</table>
	</fieldset>
		<fieldset class="adminform">
			<legend>Ad Details</legend>
			<table class="adminlist">

				<!-- Header shows here -->
				<thead>
					<tr>
						<th style="width: 20%;">Settings</th>
						<th style="text-align: left;">Value</th>
					</tr>
				</thead>

				<!-- Footer shows here -->
				<tfoot>
					<tr>
						<td colspan="2">&#160;</td>
					</tr>
				</tfoot>

				<!-- Body content shows here -->
				<tbody>

					<!-- Enter Ad Name here -->
					<tr id="namead">
						<td class="key"><?php echo JHTML::tooltip('Enter Ad Name', 'Ad Name','', 'Ad Name');?>
						</td>
						<td><input type="text" name="adsname" id="adsname" style="width: 300px" maxlength="250" value="<?php echo $rs_roll['rs_ads']->adsname; ?>" />
						</td>
					</tr>

					<!-- Enter Ad Description here -->
					<tr id="descriptionad">
						<td class="key"><?php echo JHTML::tooltip('Enter Ad Description', 'Ad Description','', 'Ad Description');?>
						</td>
						<td><textarea rows="4" cols="40" style="width: auto;" name="adsdesc" id="adsdesc"><?php echo trim($rs_roll['rs_ads']->adsdesc); ?></textarea>
						</td>
					</tr>

					<!-- Enter Target URL here -->
					<tr id="urltarget">
						<td class="key"><?php echo JHTML::tooltip('Enter URL redirects when click on Ad', 'Target URL','', 'Target URL');?>
						</td>
						<td><input type="text" name="targeturl" id="targeturl" style="width: 300px" maxlength="250" value="<?php echo $rs_roll['rs_ads']->targeturl; ?>" /></td>
					</tr>

					<!-- Enter Ad Visits URL here -->
					<tr id="urlclick">
						<td class="key"><?php echo JHTML::tooltip('Enter Ad Visits URL', 'Ad Visits URL','', 'Ad Visits URL');?>
						</td>
						<td><input type="text" name="clickurl" id="clickurl" style="width: 300px" maxlength="250" value="<?php echo $rs_roll['rs_ads']->clickurl; ?>" /></td>
					</tr>

					<!-- Enter Impression Hits URL here -->
					<tr id="impress">
						<td class="key"><?php echo JHTML::tooltip('Enter Impression Hits URL', 'Impression Hits URL','', 'Impression Hits URL');?>
						</td>
						<td><input type="text" name="impressionurl" id="impressionurl" style="width: 300px" maxlength="250" value="<?php echo $rs_roll['rs_ads']->impressionurl; ?>" /></td>
					</tr>

					<!-- Enter Publication status here -->
					<tr>
						<td class="key"><?php echo JHTML::tooltip('Choose Publication Status', 'Status','', 'Status');?>
						</td>
						<td><?php
						$publish = '1';

						$publish = '1';$publishEnable = $publishDisable = '';
						if ($rs_roll['rs_ads']->published != '') {
							$publish = $rs_roll['rs_ads']->published;
						}
						if($publish == '1'){
							$publishEnable = 'checked="checked"';
						}
						else{
							$publishDisable = 'checked="checked"';
						}
						?>
						<select name="published" id="published">
								<option value="1" <?php if(isset($rs_roll['rs_ads']->published) && $rs_roll['rs_ads']->published == 1) echo 'selected';?>>Published</option>
								<option value="0" <?php if(isset($rs_roll['rs_ads']->published) && $rs_roll['rs_ads']->published == 0) echo 'selected';?>>Unpublished</option>
								<option value="-2" <?php if(isset($rs_roll['rs_ads']->published) && $rs_roll['rs_ads']->published == -2) echo 'selected';?>>Trashed</option>
							</select>

						</td>
					</tr>
				</tbody>
			</table>
		</fieldset>
	</div>

	<input type="hidden" name="id" id="id" value="<?php echo $rs_roll['rs_ads']->id; ?>" />
	<input type="hidden" name="typeofadd" id="typeofadd" value="<?php if($rs_roll['rs_ads']->typeofadd != ''){ echo $rs_roll['rs_ads']->typeofadd; } else { echo 'prepost'; }?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="1">
	<input type="hidden" name="submitted" value="true" id="submitted">
	<input type="hidden" name="fileoption" id="fileoption" value="<?php echo $rs_roll['rs_ads']->filepath; ?>" />
	<input type="hidden" name="imaadoption" id="imaadoption" value="<?php echo $rs_roll['rs_ads']->imaadoption; ?>" />
	<input type="hidden" name="normalvideoform-value" id="normalvideoform-value" value="" />
	<input type="hidden" name="posturl-value" id="posturl-value" value="" />

	<!-- form validation error variables -->

	<input type="hidden" name="upload_error" id="upload_error" value="<?php echo JText::_('You must Upload a file', true); ?>">
	<input type="hidden" name="title_error" id="title_error" value="<?php echo JText::_('You must provide a Title', true); ?>">
	<input type="hidden" name="progress_error" id="progress_error" value="<?php echo JText::_('Upload in Progress', true); ?>">
	<input type="hidden" name="url_error" id="url_error" value="<?php echo JText::_('You must provide a Video Url', true); ?>">
	<?php echo JHTML::_('form.token'); ?>
</form>
<script type="text/javascript">
if((document.getElementById('fileoption').value == 'File') || (document.getElementById('fileoption').value == ''))
{
    adsflashdisable();

}
if(document.getElementById('fileoption').value == 'Url')
{
    urlenable();

}
window.onload=function(){
    <?php if ($rs_roll['rs_ads']->typeofadd == "prepost" || $rs_roll['rs_ads']->typeofadd == '') { ?>
    checkadd('prepost');    
<?php } else if ($rs_roll['rs_ads']->typeofadd == "mid") {
            ?> checkadd('mid');  <?php
    }
    else if ($rs_roll['rs_ads']->typeofadd == "ima") {
            ?> checkadd('ima');  <?php
    }
    if(!empty($imaaddetail['imaadpath'])){
       ?> imaads('videoad'); <?php
    } else {
        ?> imaads('textad'); <?php
    }
    ?>
    };

</script>
