<?php
/**
 * @name 	        editaddlayout.php
 ** @version	        2.1.0.1
 * @package	        Apptha
 * @since	        Joomla 1.5
 * @author      	Apptha - http://www.apptha.com/
 * @copyright 		Copyright (C) 2011 Powered by Apptha
 * @license 		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      	Contus HD FLV Player Video Upload view file
 * @Creation Date	23 Feb 2011
 * @modified Date	28 Aug 2013
 */

## No direct acesss
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.tooltip');
$editvideo      = $this->editvideo;
$editor         = JFactory::getEditor();

$document       = JFactory::getDocument();
$document->addScript('components/com_hdflvplayer/js/upload_script.js');
$document->addScript('components/com_hdflvplayer/js/videoformvalid.js');

$isfilepathchk = $filepathurl = $ffmpegchk = $prerollchk = $midrollnochk = $midrollyeschk = $downloadnochk = $publishnochk = $youtubefilepathchk = '';
?>

<script type="text/javascript">
        var user                    = new Array(<?php echo count($editvideo['rs_play']); ?>);
<?php
for ($i = 0; $i < count($editvideo['rs_play']); $i++) {
    $playlistnames = $editvideo['rs_play'][$i];
    ?>
        user[<?php echo $i; ?>]     = new Array(2);
        user[<?php echo $i; ?>][1]  = "<?php echo $playlistnames->id; ?>";
        user[<?php echo $i; ?>][0]  = "<?php echo $playlistnames->name; ?>";
    <?php
}
?>
</script>
<?php if (version_compare(JVERSION, '2.5.0', 'ge') && !version_compare(JVERSION, '3.0', 'ge')) { ?>
    <style type="text/css">
        #adminForm .toggle-editor {margin: auto;}
    </style>
<?php } ?>
<!--  Add video info here -->
<div class="width-60 fltlft">
    <fieldset class="adminform">
        <legend>Video </legend>
        <table class="adminlist">

            <!-- Header here -->
            <thead>
                <tr>
                    <th>Settings</th>
                    <th>Value</th>
                </tr>
            </thead>

            <!-- Footer here -->
            <tfoot>
                <tr>
                    <td colspan="2">&#160;</td>
                </tr>
            </tfoot>

            <tbody>

                <!--  Select the streamer Option -->
                <tr>
                    <td><?php echo JHTML::tooltip('Select the Streamer option', 'Streamer option', '', 'Streamer option'); ?></td>
                    <td><?php
                        $streamernonechk = $lighttpdchk = $rtmpchk = '';

                        if ($editvideo['rs_editupload']->streameroption == "None" || $editvideo['rs_editupload']->streameroption == '') {
                            $streamernonechk    = 'checked="checked" ';
                        } else if ($editvideo['rs_editupload']->streameroption == "lighttpd") {
                            $lighttpdchk        = 'checked="checked" ';
                        } else if ($editvideo['rs_editupload']->streameroption == "rtmp") {
                            $rtmpchk            = 'checked="checked" ';
                        }
                        ?>
                        <input type="radio" style="float: none; margin-right: 3px;" name="streameroption[]" id="streameroption1" <?php echo $streamernonechk; ?> value="None"  onclick="streamer('None');" />None
                        <input type="radio" style="float: none; margin-right: 3px; margin-left: 10px;" name="streameroption[]" id="streameroption2" <?php echo $lighttpdchk; ?> value="lighttpd" onclick="streamer('lighttpd');" />Lighttpd
                        <input type="radio" style="float: none; margin-right: 3px; margin-left: 10px;" name="streameroption[]" id="streameroption3" <?php echo $rtmpchk; ?> value="rtmp" onclick="streamer('rtmp');" />RTMP
                    </td>
                </tr>

                <!-- Enter Sreamer path for RTMP -->
                <tr id="stream1">
                    <td><?php echo JHTML::tooltip('Enter the Streamer path', 'Streamer Path', '', 'Streamer Path'); ?></td>
                    <td><input type="text" name="streamname" id="streamname" style="width: 300px" maxlength="250" value="<?php echo $editvideo['rs_editupload']->streamerpath; ?>" />
                    </td>
                </tr>

                <!-- Choose whether Video live or not for RTMP videos -->
                <tr id="islive_visible">
                    <td><?php echo JHTML::tooltip('Whether or not the video is live', 'Is Live', '', 'Is Live'); ?></td>
<?php
$islivechk = $islivechkno = '';
if ($editvideo['rs_editupload']->islive == '0' || $editvideo['rs_editupload']->islive == '') {
    $islivechk      = 'checked="checked" ';
} else if ($editvideo['rs_editupload']->islive == '1') {
    $islivechkno    = 'checked="checked" ';
}
?>
                    <td><input type="radio" style="float: none;" name="islive[]" id="islive1" <?php echo $islivechk; ?> value="0" />No
                        <input type="radio" style="float: none;" name="islive[]" id="islive2" <?php echo $islivechkno; ?> value="1" />Yes
                    </td>
                </tr>

                <!-- Select the file option for videos -->
                <tr>
                    <td width="200px;"><?php echo JHTML::tooltip('Select the file option', 'File Option', '', 'File Option'); ?></td>
<?php
if ($editvideo['rs_editupload']->filepath == "File" || $editvideo['rs_editupload']->filepath == '') {
    $isfilepathchk              = 'checked="checked" ';
} else if ($editvideo['rs_editupload']->filepath == "Url") {
    if ($editvideo['rs_editupload']->streameroption == "lighttpd" || $editvideo['rs_editupload']->streameroption == "rtmp") {
        $youtubefilepathchk     = 'disabled';
        $isfilepathchk          = 'disabled';
        $ffmpegchk              = 'disabled';
    }
    $filepathurl                = 'checked="checked" ';
} else if ($editvideo['rs_editupload']->filepath == "Youtube") {
    $youtubefilepathchk         = 'checked="checked" ';
} else if ($editvideo['rs_editupload']->filepath == "FFmpeg") {
    $ffmpegchk                  = 'checked="checked"';
}
?>
                    <td><input type="radio" style="float: none; margin-right: 3px;" name="filepath" id="filepath1" <?php echo $isfilepathchk; ?> value="File" onclick="fileedit('File');" />File
                        <input type="radio" style="float: none; margin-right: 3px; margin-left: 10px;" name="filepath" id="filepath2" <?php echo $filepathurl; ?> 	value="Url" onclick="fileedit('Url');" />URL
                        <input type="radio" style="float: none; margin-right: 3px; margin-left: 10px;" name="filepath" id="filepath4" <?php echo $youtubefilepathchk; ?> value="Youtube" onclick="fileedit('Youtube');" />You Tube / Vimeo
                        <input type="radio" style="float: none; margin-right: 3px; margin-left: 10px;" name="filepath" id="filepath3" <?php echo $ffmpegchk; ?> value="FFmpeg" onclick="fileedit('FFmpeg');" />FFmpeg
                    </td>
                </tr>

                <!-- Upload a Video -->
                <tr id="ffmpeg_disable_new1">
                    <td><?php echo JHTML::tooltip('Upload Video', 'Upload Video', '', 'Upload Video'); ?></td>
                    <td>
                        <div id="f1-upload-form">
                            <form action="" name="normalvideoform" method="post" enctype="multipart/form-data">
                                <input type="file" name="myfile" id="myfile" onchange="enableUpload(this.form.name);" />
                                <input type="button" name="uploadBtn" value="Upload Video" disabled="disabled" onclick="addQueue(this.form.name);" />
                                <label id="lbl_normal"><?php if ($editvideo['rs_editupload']->filepath == "File" || $editvideo['rs_editupload']->filepath == "FFmpeg") {
                        echo $editvideo['rs_editupload']->videourl;
                    } ?></label>
                                <input type="hidden" name="mode" value="video" />
                            </form>
                        </div>
                        <div id="f1-upload-progress" style="display: none">
                            <table>
                                <tr>
                                    <td><img id="f1-upload-image" style="float: left;"
                                             src="components/com_hdflvplayer/images/empty.gif"
                                             alt="Uploading" /></td>
                                    <td><span style="float: left; clear: none; font-weight: bold;"
                                              id="f1-upload-filename">&nbsp;</span>
                                    </td>
                                    <td><span id="f1-upload-message" style="float: left;width:300px"> </span>
                                        <label id="f1-upload-status" style="float: left;"> &nbsp; </label>
                                    </td>
                                    <td><span id="f1-upload-cancel"> <a
                                                style="float: left; font-weight: bold"
                                                href="javascript:cancelUpload('normalvideoform');"
                                                name="submitcancel">Cancel</a> </span></td>
                                </tr>
                            </table>
                        </div>

                    </td>
                </tr>

                <!-- Upload a HD Video -->
                <tr id="ffmpeg_disable_new2">
                    <td><?php echo JHTML::tooltip('Upload a HD Video', 'Upload HD Video', '', 'Upload HD Video (optional)'); ?></td>
                    <td>
                        <div id="f2-upload-form">
                            <form name="hdvideoform" method="post" action="" enctype="multipart/form-data">
                                <input type="file" name="myfile" onchange="enableUpload(this.form.name);" />
                                <input type="button" name="uploadBtn" value="Upload HD Video" disabled="disabled" onclick="addQueue(this.form.name);" />
                                <label><?php if ($editvideo['rs_editupload']->filepath == "File" || $editvideo['rs_editupload']->filepath == "FFmpeg") {
                        echo $editvideo['rs_editupload']->hdurl;
                    } ?></label>
                                <input type="hidden" name="mode" value="video" />
                            </form>
                        </div>
                        <div id="f2-upload-progress" style="display: none">
                            <table>
                                <tr>
                                    <td><img id="f2-upload-image" style="float: left;"
                                             src="components/com_hdflvplayer/images/empty.gif"
                                             alt="Uploading" /></td>
                                    <td><span style="float: left; clear: none; font-weight: bold;"
                                              id="f2-upload-filename">&nbsp;</span>
                                    </td>
                                    <td><span id="f2-upload-message" style="float: left;width:300px;"> </span>
                                        <label id="f2-upload-status" style="float: left;"> &nbsp; </label>
                                    </td>
                                    <td><span id="f2-upload-cancel"> <a
                                                style="float: left; font-weight: bold"
                                                href="javascript:cancelUpload('hdvideoform');"
                                                name="submitcancel">Cancel</a> </span></td>
                                </tr>
                            </table>
                        </div></td>
                </tr>

                <!-- Upload thumb image for uploaded video -->
                <tr id="ffmpeg_disable_new3">
                    <td><?php echo JHTML::tooltip('Upload thumb image for uploaded video', 'Upload Thumb Image', '', 'Upload Thumb Image'); ?></td>
                    <td>
                        <div id="f3-upload-form">
                            <form name="thumbimageform" method="post" action="" enctype="multipart/form-data">
                                <input type="file" name="myfile" id="myfile" onchange="enableUpload(this.form.name);" />
                                <input type="button" name="uploadBtn" value="Upload Thumb Image" disabled="disabled" onclick="addQueue(this.form.name);" />
                                <label><?php if ($editvideo['rs_editupload']->filepath == "File" || $editvideo['rs_editupload']->filepath == "FFmpeg") {
                        echo $editvideo['rs_editupload']->thumburl;
                    } ?></label>
                                <input type="hidden" name="mode" value="image" />
                            </form>
                        </div>
                        <div id="f3-upload-progress" style="display: none">
                            <table>
                                <tr>
                                    <td><img id="f3-upload-image" style="float: left;"
                                             src="components/com_hdflvplayer/images/empty.gif"
                                             alt="Uploading" /></td>
                                    <td><span style="float: left; clear: none; font-weight: bold;"
                                              id="f3-upload-filename">&nbsp;</span>
                                    </td>
                                    <td><span id="f3-upload-message" style="float: left;"> </span>
                                        <label id="f3-upload-status" style="float: left;"> &nbsp; </label>
                                    </td>
                                    <td><span id="f3-upload-cancel"> <a
                                                style="float: left; font-weight: bold"
                                                href="javascript:cancelUpload('thumbimageform');"
                                                name="submitcancel">Cancel</a> </span></td>
                                </tr>
                            </table>
                        </div></td>
                </tr>

                <!-- Upload Preview Image for uploaded video -->
                <tr id="ffmpeg_disable_new4">
                    <td><?php echo JHTML::tooltip('Upload Preview Image for uploaded video', 'Upload Preview Image', '', 'Upload Preview Image (optional)'); ?></td>
                    <td>
                        <div id="f4-upload-form">
                            <form name="previewimageform" method="post" action="" enctype="multipart/form-data">
                                <input type="file" name="myfile" onchange="enableUpload(this.form.name);" />
                                <input type="button" name="uploadBtn" value="Upload Preview Image" disabled="disabled" onclick="addQueue(this.form.name);" />
                                <label><?php if ($editvideo['rs_editupload']->filepath == "File" || $editvideo['rs_editupload']->filepath == "FFmpeg") {
                        echo $editvideo['rs_editupload']->previewurl;
                    } ?>	</label>
                                <input type="hidden" name="mode" value="image" />
                            </form>
                        </div>

                        <div id="f4-upload-progress" style="display: none">
                            <table>
                                <tr>
                                    <td><img id="f4-upload-image" style="float: left;"
                                             src="components/com_hdflvplayer/images/empty.gif"
                                             alt="Uploading" /></td>
                                    <td><span style="float: left; clear: none; font-weight: bold;"
                                              id="f4-upload-filename">&nbsp;</span>
                                    </td>
                                    <td><span id="f4-upload-message" style="float: left;"> </span>
                                        <label id="f4-upload-status" style="float: left;"> &nbsp; </label>
                                    </td>
                                    <td><span id="f4-upload-cancel"> <a
                                                style="float: left; font-weight: bold"
                                                href="javascript:cancelUpload('previewimageform');"
                                                name="submitcancel">Cancel</a> </span></td>
                                </tr>
                            </table>
                        </div>

                        <div id="nor">
                            <iframe id="uploadvideo_target" name="uploadvideo_target" src="#" style="width: 0; height: 0; border: 0px solid #fff;"></iframe>
                        </div>
                    </td>
                </tr>

                <!-- Video URL here -->
                <tr id="ffmpeg_disable_new5" style="width: 200px;">
                    <td><?php echo JHTML::tooltip('Enter the video URL. Example: http://www.yourdomain.com/video.mp4', 'Video URL', '', 'Video URL'); ?></td>
                    <td><input type="text" name="videourl" id="videourl" size="100" maxlength="250" value="<?php if ($editvideo['rs_editupload']->filepath == "Url" || $editvideo['rs_editupload']->filepath == "Youtube") {
                        echo $editvideo['rs_editupload']->videourl;
                    } ?>" />
                    </td>
                </tr>

                <!-- Enter the Thumb URL -->
                <tr id="ffmpeg_disable_new6">
                    <td><?php echo JHTML::tooltip('Enter the Thumb URL Example: http://www.yourdomain.com/thumb.jpg', 'Thumb URL', '', 'Thumb URL'); ?></td>
                    <td><input type="text" name="thumburl" id="thumburl" size="100" maxlength="250" value="<?php if ($editvideo['rs_editupload']->filepath == "Url" || $editvideo['rs_editupload']->filepath == "Youtube") {
                        echo $editvideo['rs_editupload']->thumburl;
                    } ?>" />
                    </td>
                </tr>

                <!-- Enter the Preview URL -->
                <tr id="ffmpeg_disable_new7">
                    <td><?php echo JHTML::tooltip('Enter the Preview URL Example: http://www.yourdomain.com/preview.jpg', 'Preview URL', '', 'Preview URL'); ?></td>
                    <td><input type="text" name="previewurl" id="previewurl" size="100" maxlength="250" value="<?php if ($editvideo['rs_editupload']->filepath == "Url" || $editvideo['rs_editupload']->filepath == "Youtube") {
                        echo $editvideo['rs_editupload']->previewurl;
                    } ?>" />
                    </td>
                </tr>

                <!-- Enter the HD URL -->
                <tr id="ffmpeg_disable_new8">
                    <td><?php echo JHTML::tooltip('Enter the HD URL Example: http://www.yourdomain.com/video.mp4', 'HD URL', '', 'HD URL'); ?></td>
                    <td><input type="text" name="hdurl" id="hdurl" size="100"
                               maxlength="250"
                               value="<?php if ($editvideo['rs_editupload']->filepath == "Url" || $editvideo['rs_editupload']->filepath == "Youtube") {
                        echo $editvideo['rs_editupload']->hdurl;
                    } ?>" />
                    </td>
                </tr>

                <!-- Upload a Video -->
                <tr id="fvideos">
                    <td><?php echo JHTML::tooltip('Upload a Video', 'Upload a Video', '', 'Upload a Video'); ?></td>
                    <td>
                        <div id="f5-upload-form">
                            <form name="ffmpegform" method="post" action="" enctype="multipart/form-data">
                                <input type="file" name="myfile" onchange="enableUpload(this.form.name);" />
                                <input type="button" name="uploadBtn" value="Upload Video" disabled="disabled" onclick="addQueue(this.form.name);" />
                                <label><?php if ($editvideo['rs_editupload']->filepath == "FFmpeg") {
                        echo $editvideo['rs_editupload']->videourl;
                    } ?></label>
                                <input type="hidden" name="mode" value="video_ffmpeg" />
                            </form>
                        </div>
                        <div id="f5-upload-progress" style="display: none">
                            <table>
                                <tr>
                                    <td><img id="f5-upload-image" style="float: left;"
                                             src="components/com_hdflvplayer/images/empty.gif"
                                             alt="Uploading" /></td>
                                    <td><span style="float: left; clear: none; font-weight: bold;"
                                              id="f5-upload-filename">&nbsp;</span>
                                    </td>
                                    <td><span id="f5-upload-message" style="float: left;width:300px"> </span>
                                        <label id="f5-upload-status" style="float: left;"> &nbsp; </label>
                                    </td>
                                    <td><span id="f5-upload-cancel"> <a
                                                style="float: left; font-weight: bold"
                                                href="javascript:cancelUpload('ffmpegvideoform');"
                                                name="submitcancel">Cancel</a> </span></td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>

            </tbody>
        </table>
    </fieldset>
</div>

<!-- General Video content form here -->
<form action="index.php?option=com_hdflvplayer&task=uploadvideos" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
    <div class="width-60 fltlft">
        <fieldset class="adminform">
            <legend>Video Info</legend>
            <table class="adminlist">

                <!-- Table header here -->
                <thead>
                    <tr>
                        <th>Settings</th>
                        <th>Value</th>
                    </tr>
                </thead>

                <!-- Table footer here -->
                <tfoot>
                    <tr>
                        <td colspan="2">&#160;</td>
                    </tr>
                </tfoot>

                <!-- Table body here -->
                <tbody>

                    <!-- Enter Video Title -->
                    <tr>
                        <td><?php echo JHTML::tooltip('Enter Video Title', 'Title', '', 'Title'); ?></td>
                        <td><input type="text" name="title" id="title" style="width: 300px" maxlength="250" value="<?php echo $editvideo['rs_editupload']->title; ?>" /></td>
                    </tr>

                    <!-- Enter Video Description -->
                    <tr>
                        <td><?php echo JHTML::tooltip('Enter Video Description', 'Description', '', 'Description'); ?></td>
                        <td><?php echo $editor->display('description', $editvideo['rs_editupload']->description, '450px', '250px', '0', '0'); ?>
                        </td>
                    </tr>

                    <!-- Playlist Filter here -->

                    <tr>
                        <td><?php echo JHTML::tooltip('Select whether All or Most recently added playlist, alphabets to Filter playlist', 'Playlist Filter', '', 'Playlist Filter'); ?></td>

                        <td>
                            <input type="radio" style="float: none; margin-right: 3px;" name="playliststart" id='playliststart0' value="0z"  <?php echo 'checked'; ?> onchange="select_alphabet('0z')" />All&nbsp;&nbsp;
                            <input type="radio" style="float: none; margin-right: 3px; margin-left: 10px;" name="playliststart" id="playliststart1" value="AF" onchange="select_alphabet('AF')" />A-F
                            <input type="radio" style="float: none; margin-right: 3px; margin-left: 10px; " name="playliststart" id='playliststart2' value="GL" onchange="select_alphabet('GL')" />G-L
                            <input type="radio" style="float: none; margin-right: 3px; margin-left: 10px;" name="playliststart" id='playliststart3' value="MR" onchange="select_alphabet('MR')" />M-R
                            <input type="radio" style="float: none; margin-right: 3px; margin-left: 10px;" name="playliststart" id='playliststart4' value="SV" onchange="select_alphabet('SV')" />S-V
                            <input type="radio" style="float: none; margin-right: 3px; margin-left: 10px;" name="playliststart" id='playliststart5' value="WZ" onchange="select_alphabet('WZ')" />W-Z
                            <input type="radio" style="float: none; margin-right: 3px; margin-left: 10px;" name="playliststart" id='playliststart6' value="09"  onchange="select_alphabet('09')" />0-9&nbsp;&nbsp;
                        </td>
                    </tr>

                    <!-- Select playlist here -->
                    <tr>
                        <td><?php echo JHTML::tooltip('Select the Playlist', 'Playlist Name', '', 'Playlist Name'); ?></td>
                        <td><select name="playlistid" id="playlistid">

                                <?php
                                $count = count($editvideo['rs_play']);
                                if ($count >= 1) {
                                    for ($j = 0; $j < $count; $j++) {
                                        $row_play = &$editvideo['rs_play'][$j];
                                        ?>
                                        <option value="<?php echo $row_play->id; ?>" <?php if ($editvideo['rs_editupload']->playlistid == $row_play->id) {
                                            echo 'selected';
                                        } ?>> <?php echo $row_play->name ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </td>
                    </tr>

                    <!-- Choose Access level here -->
                    <tr id="access1">
                        <td><?php echo JHTML::tooltip('Acces level group that is allowed to view this item', 'Access', '', 'Access'); ?></td>
                        <td><select name="access" id="access" size="3">

<?php
for ($i = 0; $i < count($editvideo['rs_access']); $i++) {
    $selected = '';
    if ($editvideo['rs_editupload']->access) {
        if ($editvideo['rs_editupload']->access == $editvideo['rs_access'][$i]->id) {
            $selected = 'selected="selected"';
        }
    }
    echo '<option value=' . $editvideo['rs_access'][$i]->id . ' ' . $selected . ' >' . $editvideo['rs_access'][$i]->title . '</option>';
}
?>
                            </select>
                        </td>
                    </tr>

                    <!-- Enter the sorting order here -->
                    <tr>
                        <td><?php echo JHTML::tooltip('Enter the sorting order', 'Ordering', '', 'Ordering'); ?></td>
                        <td><input type="text" name="ordering" id="ordering" style="width: 50px" maxlength="250" value="<?php echo $editvideo['rs_editupload']->ordering; ?>" /></td>
                    </tr>

                    <!-- Post-roll ADs selection here -->
                    <tr>
                        <td><?php echo JHTML::tooltip('Whether or not the post-roll Ads have to be enable', 'Post-roll Ads', '', 'Post-roll Ads'); ?></td>

                        <td><?php
                            $postrollchkyes = $postrollchkno = '';
                            if ($editvideo['rs_editupload']->postrollads == '1') { {
                                    $postrollchkyes     = 'checked="checked" ';
                                }
                            } else if ($editvideo['rs_editupload']->postrollads == '0' || $editvideo['rs_editupload']->postrollads == '') {
                                $postrollchkno          = 'checked="checked" ';
                            }
                            ?>
                            <input type="radio" style="float: none; margin-right: 3px;" name="postrollads" id="postrollads" <?php echo $postrollchkyes; ?> value="1" onclick="postroll('1');" />Enable
                            <input type="radio" style="float: none; margin-right: 3px; margin-left: 10px;" name="postrollads" id="postrollads" <?php echo $postrollchkno; ?> value="0" onclick="postroll('0');" />Disable
                        </td>
                    </tr>

                    <tr id="postroll">
                        <td><?php echo JHTML::tooltip('Select the Post-roll AD to play after Video', 'Post-roll Name', '', 'Post-roll Name'); ?></td>
                        <td><select name="postrollid" id="postrollid">
                                <option value="0">None</option>
                                    <?php
                                    $count = count($editvideo['rs_ads']);
                                    if ($count >= 1) {
                                        for ($n = 0; $n < $count; $n++) {
                                            $row_ads = &$editvideo['rs_ads'][$n];
                                            ?>
                                        <option value="<?php echo $row_ads->id; ?>" <?php if ($editvideo['rs_editupload']->postrollid == $row_ads->id) {
                                    echo 'selected';
                                } ?>>
        <?php echo $row_ads->adsname; ?>
                                        </option>
        <?php
    }
}
?>
                            </select>
                        </td>
                    </tr>

                    <!-- Pre-roll ADs selection here -->
                    <tr>
                        <td><?php echo JHTML::tooltip('Whether or not the Pre-roll Ads have to be enable', 'Pre-roll Ads', '', 'Pre-roll Ads'); ?></td>
                        <?php
                        $prerollyeschk = $prerollnochk = '';

                        if ($editvideo['rs_editupload']->prerollads == '1') {
                            $prerollyeschk  = 'checked="checked" ';
                        } else if ($editvideo['rs_editupload']->prerollads == '0' || $editvideo['rs_editupload']->prerollads == '') {
                            $prerollnochk   = 'checked="checked" ';
                        }
                        ?>
                        <td><input type="radio" style="float: none; margin-right: 3px;" name="prerollads" id="prerolladsyes" <?php echo $prerollyeschk; ?> value="1" onclick="preroll('1');" />Enable
                            <input type="radio" style="float: none; margin-right: 3px; margin-left: 10px;" name="prerollads" id="prerolladsno" 	<?php echo $prerollnochk; ?> value="0" onclick="preroll('0');" />Disable
                        </td>
                    </tr>

                    <tr id="preroll">
                        <td><?php echo JHTML::tooltip('Select the Pre-roll AD to play before Video', 'Pre-roll Name', '', 'Pre-roll Name'); ?></td>
                        <td><select name="prerollid" id="prerollid">
                                <option value="0">None</option>
                                <?php
                                $ads_count = count($editvideo['rs_ads']);
                                if ($ads_count >= 1) {
                                    for ($v = 0; $v < $ads_count; $v++) {
                                        $row_ads = &$editvideo['rs_ads'][$v];
                                        ?>
                                        <option value="<?php echo $row_ads->id; ?>" <?php if ($editvideo['rs_editupload']->prerollid == $row_ads->id) {
                                            echo 'selected';
                                        } ?>><?php echo $row_ads->adsname; ?></option>
                                <?php
                            }
                        }
                        ?>
                            </select>
                        </td>
                    </tr>

                    <!-- mid-roll ADs selection here -->
                    <tr>
                        <td><?php echo JHTML::tooltip('Whether or not the Mid-roll Ads have to be enable', 'Mid-roll Ads', '', 'Mid-roll Ads'); ?></td>
<?php
if ($editvideo['rs_editupload']->midrollads == '1') {
    $midrollyeschk = 'checked="checked" ';
} else {
    $midrollnochk = 'checked="checked" ';
}
?>

                        <td><input type="radio" style="float: none; margin-right: 3px; " name="midrollads" id="midrollads" <?php echo $midrollyeschk; ?> value="1" />Enable
                            <input type="radio" style="float: none; margin-right: 3px; margin-left: 10px;" name="midrollads" id="midrollads" <?php echo $midrollnochk; ?> value="0" />Disable
                        </td>
                    </tr>
                    <!--IMA Ad Section Here-->
                    <tr>
                        <td><?php echo JHTML::tooltip('Enable/Disable IMA Ad', 'IMA Ads', '', 'IMA Ads'); ?></td>
<?php
if ($editvideo['rs_editupload']->imaads == '1') {
    $imayeschk = 'checked="checked" ';
} else {
    $imanochk = 'checked="checked" ';
}
?>

                        <td><input type="radio" style="float: none; margin-right: 3px; " name="imaads" id="imaadyes" <?php echo $imayeschk; ?> value="1" />Enable
                            <input type="radio" style="float: none; margin-right: 3px; margin-left: 10px;" name="imaads" id="imaadno" <?php echo $imanochk; ?> value="0" />Disable
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo JHTML::tooltip('Note:Not supported for YouTube and streamer videos', 'Download Video', '', 'Download Video'); ?></td>
<?php
$downloadyeschk = '';
if ($editvideo['rs_editupload']->download == '1' || $editvideo['rs_editupload']->download == '') {
    $downloadyeschk = 'checked="checked" ';
} else {
    $downloadnochk = 'checked="checked" ';
}
?>
                        <td><input type="radio" style="float: none; margin-right: 3px;" name="download" id="download" <?php echo $downloadyeschk; ?> value="1" />Enable
                            <input type="radio" style="float: none; margin-right: 3px; margin-left: 10px;" name="download" id="download" <?php echo $downloadnochk; ?> value="0" />Disable
                        </td>
                    </tr>

                    <!-- Set status here -->
                    <tr>
                        <td><?php echo JHTML::tooltip('Set publication status', 'Status', '', 'Status'); ?></td>

                        <td>
                            <select name="published" id="published">
                                <option value="1" <?php if (isset($editvideo['rs_editupload']->published) && $editvideo['rs_editupload']->published == 1) echo 'selected'; ?>>Published</option>
                                <option value="0" <?php if (isset($editvideo['rs_editupload']->published) && $editvideo['rs_editupload']->published == 0) echo 'selected'; ?>>Unpublished</option>
                                <option value="-2" <?php if (isset($editvideo['rs_editupload']->published) && $editvideo['rs_editupload']->published == -2) echo 'selected'; ?>>Trashed</option>
                            </select>
                        </td>
                    </tr>


                </tbody>
            </table>
        </fieldset>
    </div>
    <input type="hidden" name="id" id="id" value="<?php echo $editvideo['rs_editupload']->id; ?>" />
    <input type="hidden" name="task" value="" />

    <!-- The below code is to check wether the particular video ,thumbimages,previewimages & HD is edited or not -->
    <input type="hidden" name="newupload" id="newupload" value="1">
    <input type="hidden" name="fileoption" id="fileoption" value="<?php echo $editvideo['rs_editupload']->filepath; ?>" />
    <input type="hidden" name="normalvideoform-value" id="normalvideoform-value" value="" />
    <input type="hidden" name="hdvideoform-value" id="hdvideoform-value" value="" />
    <input type="hidden" name="thumbimageform-value" id="thumbimageform-value" value="<?php echo $editvideo['rs_editupload']->thumburl; ?>" />
    <input type="hidden" name="previewimageform-value" id="previewimageform-value" value="<?php echo $editvideo['rs_editupload']->previewurl; ?>" />
    <input type="hidden" name="ffmpegform-value" id="ffmpegform-value" value="" />
    <input type="hidden" name="videourl-value" id="videourl-value" value="" />
    <input type="hidden" name="thumburl-value" id="thumburl-value" value="" />
    <input type="hidden" name="previewurl-value" id="previewurl-value" value="" />
    <input type="hidden" name="hdurl-value" id="hdurl-value" value="" />
    <input type="hidden" name="midrollid" id="hid-midrollid" value="" />
    <input type="hidden" name="streameroption-value" id="streameroption-value" value="<?php echo $editvideo['rs_editupload']->streameroption; ?>" />
    <input type="hidden" name="streamerpath-value" id="streamerpath-value" value="" />
    <input type="hidden" name="islive-value" id="islive-value" value="" />

    <!-- form validation error variables -->

    <input type="hidden" name="upload_error" id="upload_error" value="<?php echo JText::_('You must Upload a file', true); ?>">
    <input type="hidden" name="title_error" id="title_error" value="<?php echo JText::_('You must provide a Title', true); ?>">
    <input type="hidden" name="progress_error" id="progress_error" value="<?php echo JText::_('Upload in Progress', true); ?>">
    <input type="hidden" name="url_error" id="url_error" value="<?php echo JText::_('You must provide a Video Url', true); ?>">
    <input type="hidden" name="mode1" id="mode1" value="<?php echo $editvideo['rs_editupload']->filepath; ?>" />

    <!-- Ends -->
    <input type="hidden" name="submitted" value="true" id="submitted">
</form>
<script type="text/javascript" src="components/com_hdflvplayer/js/videoformvalid_1.js"></script>