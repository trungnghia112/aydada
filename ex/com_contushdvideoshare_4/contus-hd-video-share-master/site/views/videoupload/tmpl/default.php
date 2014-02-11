<?php
/*
 * ********************************************************* */
/**
 * @name          : Joomla HD Video Share
 *** @version	  : 3.4.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2012 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component Videoupload View Page
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */
/*
 * ********************************************************* */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
$user = JFactory::getUser();
//$session = JFactory::getSession();
//
$editing = '';
$baseurl = JURI::base();
if ($user->get('id') == '') {
    if (version_compare(JVERSION, '1.6.0', 'ge')) {
        $url = $baseurl . "index.php?option=com_users&view=login";
        header("Location: $url");
    } else {
        $url = $baseurl . "index.php?option=com_user&view=login";
        header("Location: $url");
    }
}
if(!version_compare(JVERSION, '3.0.0', 'ge')){
        $type=JRequest::getVar('type', '', 'get', 'string');
       $id=JRequest::getVar('id', '', 'get', 'int');
}else{
    $type=JRequest::getVar('type');
     $id=JRequest::getVar('id');

}
if ($type == 'edit') {
    $videoedit1 = $this->videodetails;
    if (isset($videoedit1[0]))
        $videoedit = $videoedit1[0];
    if (isset($videoedit->filepath))
        $editing = $videoedit->filepath;
}

// add js file
$document = JFactory::getDocument();
$document->addScript(JURI::base() . 'components/com_contushdvideoshare/js/upload_script.js');
$document->addScript(JURI::base() . 'components/com_contushdvideoshare/js/membervalidator.js');
?>
<?php
if (JRequest::getVar('url', '', 'post', 'string')) {
    $video = new videourl();
    $vurl = JRequest::getVar('url', '', 'post', 'string');
    $video->getVideoType($vurl);
    $description = $video->catchData($vurl);
    $imgurl = $video->imgURL($vurl);
}
?>
<script type="text/javascript">
    function submitform()
    {
        document.myform.submit();
    }
</script>
<form name="myform" action="" method="post" id="login-form">

    <div class="logout-button">

        <input type="hidden" name="option" value="com_users" />
        <input type="hidden" name="task" value="user.logout" />
<!--        <input type="hidden" name="return" value="<?php echo $logoutval_2; ?>" />-->
<?php echo JHtml::_('form.token'); ?>
    </div>
</form>
<?php
if ($user->get('id') != '') {
    if (version_compare(JVERSION, '1.6.0', 'ge')) {
?>
<div class="toprightmenu">
    <a href="index.php?option=com_contushdvideoshare&view=myvideos"><?php echo JText::_('HDVS_MY_VIDEOS'); ?></a> |
            <a href="javascript: submitform();"><?php echo JText::_('HDVS_LOGOUT'); ?></a>
        </div>
<?php } else {
 ?>
        <div class="toprightmenu">
            <a href="index.php?option=com_contushdvideoshare&view=myvideos"><?php echo JText::_('HDVS_MY_VIDEOS'); ?></a> |
            <a href="index.php?option=com_user&task=logout"><?php echo JText::_('HDVS_LOGOUT'); ?></a>
        </div>
<?php } ?>



<?php
} else {
    if (version_compare(JVERSION, '1.6.0', 'ge')) {
 ?><div class="toprightmenu">
            <a href="index.php?option=com_users&view=registration"><?php echo JText::_('HDVS_REGISTER'); ?></a> |
            <a  href="index.php?option=com_users&view=login"> <?php echo JText::_('HDVS_LOGIN'); ?></a>
        </div>
<?php } else {
 ?>
        <div class="toprightmenu">
            <a href="index.php?option=com_user&view=register"><?php echo JText::_('HDVS_REGISTER'); ?></a> |
            <a  href="index.php?option=com_user&view=login"> <?php echo JText::_('HDVS_LOGIN'); ?></a>
        </div>
<?php
    }
?>

<?php
}
?>

<div class="player clearfix" id="clsdetail">
    <input type="hidden" name="editmode" id="editmode" value="<?php echo $editing; ?>" />
    <h1 class="uploadtitle">
<?php
if (JRequest::getVar('type', '', 'get', 'string') != 'edit')
    echo JText::_('HDVS_VIDEO_UPLOAD');
else
    echo JText::_('HDVS_EDIT_VIDEO');
?>
    </h1>
    <div class="addvideo_top_select">
        <div class="floatleft allform_left">
            <label><?php echo JText::_('HDVS_VIDEO_TYPE'); ?>:</label>
            <ul id="upload_thread">
                <li>
            <input type="radio" class="butnmargin" name="filetype" id="filetype3" value="2"
                   onclick="filetypeshow(this);" />
            <span class="select_videotype"> <?php echo JText::_('HDVS_URL'); ?> </span>
</li>
<li><input type="radio" class="butnmargin" name="filetype" id="filetype2" value="0"
                   onclick="filetypeshow(this);" /><span class="select_videotype"> <?php echo JText::_('HDVS_YOUTUBE'); ?> / <?php echo JText::_('HDVS_VIMEO'); ?> / <?php echo JText::_('HDVS_DAILYMOTION'); ?> / <?php echo JText::_('HDVS_VIDDLER'); ?></span></li>

            <li><input type="radio"  class="butnmargin" name="filetype" id="filetype1" value="1" onclick="filetypeshow(this);"/> <span class="select_upload"><?php echo JText::_('HDVS_UPLOAD'); ?></span></li>
               <li>     <input type="radio"  class="butnmargin" name="filetype" id="filetype4" value="3" onclick="filetypeshow(this);"/> <span class="select_upload">RTMP</span></li>
                    </ul>
        </div>
        <span class="floatright">
            <input type="button"  value="<?php echo JText::_('HDVS_BACK_TO_MY_VIDEOS'); ?>" class="button cursor_pointer"  onclick="window.open('index.php?option=com_contushdvideoshare&view=myvideos','_self');"  />
        </span>
    </div>
    <div id="typeff">
        <div class="allform" >
            <table  class="table_upload">
                <tr id="ffmpeg_disable_new1" name="ffmpeg_disable_new1"><td class="form-label"><?php echo JText::_('HDVS_UPLOAD_VIDEO'); ?><span class="star">*</span></td>
                    <td>
                        <div id="f11-upload-form" >
                            <form name="ffmpeg" method="post" enctype="multipart/form-data" >
                                <input type="file" name="myfile" id="myfile" onchange="enableUpload(this.form.name);" />
                                <input  type="button cursor_pointer" name="uploadBtn" value="<?php echo JText::_('HDVS_UPLOAD_VIDEO'); ?>" disabled="disabled" class="button" onclick="return addQueue(this.form.name,this.form.myfile.value);" />
                                <input type="hidden" name="mode" value="video" />
                            </form>
                        </div>
                        <div id="f11-upload-progress" >
                            <div class="floatleft"><img id="f11-upload-image" src="components/com_contushdvideoshare/images/empty.gif'" alt="Uploading"   class="clsempty"/>
                                <label  class="postroll"  id="f11-upload-filename">PostRoll.flv</label></div>
                            <div class="floatright"> <span id="f11-upload-cancel">
                                    <a  class="clscnl" href="javascript:cancelUpload('normalvideoform');" name="submitcancel"><?php echo JText::_('HDVS_CANCEL'); ?></a>
                                </span>
                                <label id="f11-upload-status"  class="clsupl"><?php echo JText::_('HDVS_UPLOADING'); ?></label>
                                <span id="f11-upload-message" class="clsupl_fail" >
                                    <b><?php echo JText::_('HDVS_UPLOAD_FAILED'); ?>:</b> <?php echo JText::_('HDVS_USER_CANCELLED_THE_UPLOAD'); ?>
                                </span></div>
                        </div>
                    </td></tr>
            </table>
        </div>
    </div>
    <div name="typefile" id="typefile" >
        <div class="allform">
            <table cellpadding="0" cellspacing="0" width="100%">
                <tr id="ffmpeg_disable_new1" name="ffmpeg_disable_new1"><td class="form-label"><?php echo JText::_('HDVS_UPLOAD_VIDEO'); ?><span class="star">*</span></td>
                    <td>
                        <div id="f1-upload-form" >
                            <form name="normalvideoform" method="post" enctype="multipart/form-data" >
                                <input type="file" name="myfile" id="myfile" onchange="enableUpload(this.form.name);" />
                                <input class="button cursor_pointer upload_video" type="button" name="uploadBtn" value="<?php echo JText::_('HDVS_UPLOAD'); ?>" disabled="disabled" onclick="return addQueue(this.form.name,this.form.myfile.value);" />
                                <label id="lbl_normal"><?php
        if (isset($videoedit->filepath)) {
            if ($videoedit->filepath == 'File'){
                if (strlen($videoedit->videourl) > 50) {
                    echo JHTML::_('string.truncate', ($videoedit->videourl), 50);
                } else {
                    echo $videoedit->videourl;
                }
            }
        }
?></label>
                                <input type="hidden" name="mode" value="video" />
                            </form>
                        </div>
                        <div id="f1-upload-progress" >
                            <div class="floatleft"><img id="f1-upload-image" src="components/com_contushdvideoshare/images/empty.gif'" alt="Uploading"  class="clsempty" />
                                <label class="postroll"  id="f1-upload-filename">PostRoll.flv</label></div>
                            <div class="floatright"> <span id="f1-upload-cancel">
                                    <a class="clscnl" href="javascript:cancelUpload('normalvideoform');" name="submitcancel"><?php echo JText::_('HDVS_CANCEL'); ?></a>
                                </span>
                                <label id="f1-upload-status" class="clsupl"><?php echo JText::_('HDVS_UPLOADING'); ?></label>
                                <span id="f1-upload-message" class="clsupl_fail">
                                    <b><?php echo JText::_('HDVS_UPLOAD_FAILED'); ?>:</b> <?php echo JText::_('HDVS_USER_CANCELLED_THE_UPLOAD'); ?>
                                </span></div>
                        </div>
                    </td></tr>
                <tr id="ffmpeg_disable_new2" name="ffmpeg_disable_new1"> <td class="form-label"><?php echo JText::_('HDVS_UPLOAD_HD_VIDEO'); ?></td>
                    <td>
                        <div id="f2-upload-form" >
                            <form name="hdvideoform" method="post" enctype="multipart/form-data" >
                                <input type="file" name="myfile" onchange="enableUpload(this.form.name);" />
                                <input  class="button upload_video cursor_pointer" type="button" name="uploadBtn" value="<?php echo JText::_('HDVS_UPLOAD'); ?>" disabled="disabled" onclick="return addQueue(this.form.name,this.form.myfile.value);" />
                                <label id="lbl_normal"><?php
                                    if (isset($videoedit->filepath)) {
                                        if ($videoedit->filepath == 'File'){
                                         if (strlen($videoedit->hdurl) > 50) {
                    echo JHTML::_('string.truncate', ($videoedit->hdurl), 50);
                } else {
                    echo $videoedit->hdurl;
                }
                                        }
                                    }
?></label>
                                <input type="hidden" name="mode" value="video" />
                            </form>
                        </div>
                        <div id="f2-upload-progress" >
                            <div class="floatleft"><img id="f2-upload-image" src="images/empty.gif'" alt="Uploading"  class="clsempty" />
                                <label class="postroll"  id="f2-upload-filename">PostRoll.flv</label></div>
                            <div class="floatright"><span id="f2-upload-cancel">
                                    <a class="clscnl" href="javascript:cancelUpload('hdvideoform');" name="submitcancel"><?php echo JText::_('HDVS_CANCEL'); ?></a>

                                </span>
                                <label id="f2-upload-status" class="clsupl"><?php echo JText::_('HDVS_UPLOADING'); ?></label>
                                <span id="f2-upload-message" class="clsupl_fail">
                                    <b><?php echo JText::_('HDVS_UPLOAD_FAILED'); ?>:</b> <?php echo JText::_('HDVS_USER_CANCELLED_THE_UPLOAD'); ?>
                                </span></div>
                        </div>
                    </td></tr>
                <tr id="ffmpeg_disable_new3" name="ffmpeg_disable_new1"><td class="form-label"><?php echo JText::_('HDVS_UPLOAD_THUMB_IMAGE'); ?><span class="star">*</span></td><td>
                        <div id="f3-upload-form" >
                            <form name="thumbimageform" method="post" enctype="multipart/form-data" >
                                <input type="file" name="myfile"  onchange="enableUpload(this.form.name);" />
                                <input class="button upload_video cursor_pointer" type="button" name="uploadBtn" value="<?php echo JText::_('HDVS_UPLOAD'); ?>" disabled="disabled" onclick="return addQueue(this.form.name,this.form.myfile.value);" />
                                <label id="lbl_normal"><?php
                                    if (isset($videoedit->filepath)) {
                                        if ($videoedit->filepath == 'File'){
                                          if (strlen($videoedit->thumburl) > 50) {
                    echo JHTML::_('string.truncate', ($videoedit->thumburl), 50);
                } else {
                    echo $videoedit->thumburl;
                }
                                        }
                                    }
?></label>
                                <input type="hidden" name="mode" value="image" />
                            </form>
                        </div>
                        <div id="f3-upload-progress" >
                            <div class="floatleft"><img id="f3-upload-image" src="images/empty.gif' " alt="Uploading" class="clsempty" />
                                <label class="postroll"  id="f3-upload-filename">PostRoll.flv</label></div>
                            <div class="floatright"> <span id="f3-upload-cancel">
                                    <a class="clscnl" href="javascript:cancelUpload('thumbimageform');" name="submitcancel"><?php echo JText::_('HDVS_CANCEL'); ?></a>
                                </span>
                                <label id="f3-upload-status" class="clsupl"><?php echo JText::_('HDVS_UPLOADING'); ?></label>
                                <span id="f3-upload-message" class="clsupl_fail">
                                    <b><?php echo JText::_('HDVS_UPLOAD_FAILED'); ?>:</b> <?php echo JText::_('HDVS_USER_CANCELLED_THE_UPLOAD'); ?>
                                </span></div>
                        </div>
                    </td></tr>
                <tr id="ffmpeg_disable_new4" name="ffmpeg_disable_new1">
                    <td class="form-label"><?php echo JText::_('HDVS_UPLOAD_PREVIEW_IMAGE'); ?></td><td>
                        <div id="f4-upload-form" >
                            <form name="previewimageform" method="post" enctype="multipart/form-data" >
                                <input type="file" name="myfile" onchange="enableUpload(this.form.name);" />
                                <input  class="button upload_video cursor_pointer" type="button" name="uploadBtn" value="<?php echo JText::_('HDVS_UPLOAD'); ?>" disabled="disabled" onclick="return addQueue(this.form.name,this.form.myfile.value);" />
                                <label id="lbl_normal"><?php
                                    if (isset($videoedit->filepath)) {
                                        if ($videoedit->filepath == 'File'){
                                                if (strlen($videoedit->previewurl) > 50) {
                    echo JHTML::_('string.truncate', ($videoedit->previewurl), 50);
                } else {
                    echo $videoedit->previewurl;
                }
                                        }
                                    }
?></label>
                                <input type="hidden" name="mode" value="image" />
                            </form>
                        </div>
                        <div id="f4-upload-progress" >
                            <div class="floatleft"><img id="f4-upload-image" src="/images/empty.gif'" alt="Uploading" class="clsempty" />
                                <label class="postroll"  id="f4-upload-filename">PostRoll.flv</label></div>
                            <div class="floatright"><span id="f4-upload-cancel">
                                    <a class="clscnl" href="javascript:cancelUpload('previewimageform');" name="submitcancel"><?php echo JText::_('HDVS_CANCEL'); ?></a>
                                </span>
                                <label id="f4-upload-status" class="clsupl"><?php echo JText::_('HDVS_UPLOADING'); ?></label>
                                <span id="f4-upload-message" class="clsupl_fail">
                                    <b><?php echo JText::_('HDVS_UPLOAD_FAILED'); ?>:</b> <?php echo JText::_('HDVS_USER_CANCELLED_THE_UPLOAD'); ?>
                                </span></div>
                        </div>
                        <div id="nor"><iframe id="uploadvideo_target" name="uploadvideo_target" src="#"  ></iframe></div>
                    </td></tr>
            </table>
        </div>
    </div>
<?php
                                    if (JRequest::getVar('type', '', 'get', 'string') == 'edit')
                                        $javascript = ''; else
                                        $javascript = 'onsubmit="return videoupload();"';
?>
    <form name="upload1111" action="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=videoupload'); ?>" method="post" enctype="multipart/form-data" <?php echo $javascript ?>  id="hupload">
       <div id="rtmpcontainer" class="allform">
                                            <ul id="stream1" name="stream1"><li class="videotype_url_list">
                                                    <label>Streamer Path<span class="star">*</span></label>
                                                    <input class="text" type="text" name="streamname"  id="streamname" style="width:300px" maxlength="250" value="<?php if (isset($videoedit->streamerpath)) echo $videoedit->streamerpath ;?>" />
                                                </li>
                                            </ul>
                                            <ul id="islive_visible" name="islive_visible">
                                                <li><label>Is Live<span class="star">*</span></label>
                                                    <input type="radio" style="float:none;" name="islive[]"  id="islive2" <?php
                                    if (isset($videoedit->islive)){
                                        if ($videoedit->islive == '1') {
                                            echo 'checked="checked" ';
                                        }
                                    }
    ?>  value="1" />Yes
                             <input type="radio" style="float:none;" name="islive[]"  id="islive1"  <?php
                                    if (isset($videoedit->islive)){
                                        if ($videoedit->islive == '0' || $videoedit->islive == '') {
                                            echo 'checked="checked" ';
                                        }
                                    }
    ?>  value="0" />No
                         </li>
                     </ul>
                 </div>

        <div id="typeurl" class="allform">
            <div  class="uplcolor" align="center"><?php
                                    if (($this->upload)) {
                                        echo $this->upload . '<br/><br/>';
                                    }
?>                                </div>

                                            <ul id="videotype_url">
                                                <li class="videotype_url_list">
                                                    <label><?php echo JText::_('HDVS_UPLOAD_URL'); ?><span class="star">*</span></label>
                                                    <input type="text" name="Youtubeurl" value="<?php
                                    if (isset($videoedit->filepath)

                                        )if ($videoedit->filepath == 'Youtube' || $videoedit->filepath == 'Url')
                                            echo $videoedit->videourl ?>" class="text" size="20" id="Youtubeurl" onchange="bindvideo();"  />
                                            </li>
                                            <li class="videotype_url_list">
                                                <div id="hd_url">
                                                    <label><?php echo JText::_('HDVS_UPLOAD_HDURL'); ?></label>
                                                    <input type="text" name="hdurl" value="<?php
                                            if (isset($videoedit->filepath)

                                                )if ($videoedit->filepath == 'Youtube' || $videoedit->filepath == 'Url')
                                                    echo $videoedit->hdurl ?>" class="text" size="20" id="hdurl" onchange="bindvideo();"  />
                                                    </div>
                                                </li>
                                                <li class="videotype_url_list">
                                                    <div id="image_path">
                                                        <label><?php echo JText::_('HDVS_UPLOAD_IMAGEURL'); ?></label>
<?php
                                                    if (isset($videoedit->thumburl)) {
                                                        preg_match('@(https?://([-\w\.]+)+(:\d+)?(/([\w/_\.]*(\?\S+)?)?)?)@', $videoedit->thumburl, $imgresult);
                                                    }
?>

                                                    <input class="img_ulrpath" type="radio" name="imagepath" id="imagepath" value="1" <?php
                                                    if (isset($imgresult[0])) {
                                                        echo "checked='checked'";
                                                    }
?>                                                     onclick="changeimageurltype(this);">
                                             <span class="select_viedoupload_type"> <?php echo JText::_('HDVS_UPLOAD_IMAGEURL'); ?></span>

                                             <input type="radio" name="imagepath" id="imagepath" value="0" <?php
                                                    if (!isset($imgresult[0])) {
                                                        echo "checked='checked'";
                                                    } ?>  onclick="changeimageurltype(this);">
                                                    <span> <?php echo JText::_('HDVS_IMAGE_UPLOAD'); ?></span>
                                                    <div id="imageurltype"></div>
<?php
                                                    if (isset($imgresult[0])) {
?>
                                                        <script type="text/javascript">
                                                            document.getElementById('imageurltype').innerHTML='<input type="text" name="thumburl" value="<?php if (isset($videoedit->thumburl) && $videoedit->filepath != 'Youtube'

                                                            )echo $videoedit->thumburl; ?>" class="text" size="20" id="thumburl"/>';
                                                 </script>
<?php
                                                    }
                                                    else {
?>
                                                        <script type="text/javascript">
                                                            document.getElementById('imageurltype').innerHTML='<input type="file" name="thumburl" id="thumburl" onchange="fileformate_check(this);"/><lable><?php if (isset($videoedit->thumburl)

                                                            )echo $videoedit->thumburl; ?></lable>';

                                                        </script>
                        <?php } ?>                                             </div> </li>
                                        </ul>
             <style type="text/css" >
.text_tool_cont{position: relative;}
.text_tool_cont:hover .text_tool{display: block;
left: 285px;
bottom: 0;
background: #000;
padding: 3px;
color: #fff;}
.text_tool{display: none;position: absolute;}


</style>
                                    </div>
                                    <div class="allform">
                                        <ul id="videoupload_pageform">
                                            <li class="videoupload_list">
                                                <label><?php echo JText::_('HDVS_TITLE'); ?><span class="star">*</span></label>
                                                <input type="text" name="title" value="<?php if (isset($videoedit->title)
                                                        )echo $videoedit->title; ?>" class="text" size="20" id="videotitle"/>
                                            </li>
                                            <li class="videoupload_list">
                                                <label><?php echo JText::_('HDVS_DESCRIPTION'); ?></label>
                                                <textarea name="description" id="description" style="height: 80px;"><?php if (isset($videoedit->description)) {
                                                        echo $videoedit->description;
                                                    } ?></textarea>
                                            </li>
                                            <li class="videoupload_list">
                                                <label>Tags</label>
                                                <div class="text_tool_cont">
                                                <textarea name="tags1" class="info" id="tags1"><?php if (isset($videoedit->tags)) {
                                                        echo $videoedit->tags;
                                                    } ?></textarea>
                                        <span><?php echo JText::_('HDVS_TAG_SEPARATE'); ?></span>
                                                 <p class="text_tool"><?php echo JText::_('HDVS_TAG_TOOLTIP'); ?></p>
                                                 </div>

                                            </li>
                                            <li class="videoupload_list">
                                                <label><?php echo JText::_('HDVS_SELECT_CATEGORY'); ?></label>
                                                <div class="catclass floatleft" align="left" id="selcat"> <?php $n = count($this->videocategory);
                                                    foreach ($this->videocategory as $cat) { ?> <a class="cursor_pointer" title="<?php echo $cat->category; ?>" onclick="catselect('<?php echo $cat->category; ?>');"><?php echo $cat->category . ","; ?></a>  <?php } ?></div>
                                            </li>
                                            <li class="videoupload_list">
                                                <label><?php echo JText::_('HDVS_CATEGORY'); ?><span class="star">*</span></label>
                                                <input type="text"  readonly name="tagname" value="<?php if (isset($videoedit->category)) {
                                                        echo $videoedit->category;
                                                    } ?>" class="text" size="20" id="tagname" />
                                                <input type="button" value="<?php echo JText::_('HDVS_RESET_CATEGORY'); ?>" class="button" onclick="resetcategory();" >
                                            </li>
                                            <li class="videoupload_list">
                                                <label><?php echo JText::_('HDVS_TYPE'); ?></label>
                                                <input type="radio" class="butnmargin addvideo_radio_option" name="type" value=0  <?php if (isset($videoedit->type) && $videoedit->type == '0') {
                                                        echo 'checked="checked"';
                                                    } ?> checked="checked"  />
                                                <span class="hd_select_public"><?php echo JText::_('HDVS_PUBLIC'); ?></span>
                                                <input type="radio" class="butnmargin addvideo_radio_option" name="type" value=1 <?php if (isset($videoedit->type) && $videoedit->type == '1') {
                                                        echo 'checked="checked"';
                                                    } ?>  />
                                                <span class="hd_select_private"><?php echo JText::_('HDVS_PRIVATE'); ?></span>
                                            </li>
                                            <li class="videoupload_list">
                                                <div id="down_load">
                                                    <label><?php echo JText::_('HDVS_DOWNLOAD'); ?></label>
                                                    <input type="radio" class="butnmargin addvideo_radio_option" name="download" value=1  <?php if (isset($videoedit->download) && $videoedit->download == '1') {
                                                        echo 'checked="checked"';
                                                    } ?>   />
                                                    <span class="hd_select_enable"><?php echo JText::_('HDVS_ENABLE'); ?></span>
                                                    <input type="radio" class="butnmargin addvideo_radio_option" name="download" value=0 <?php if (isset($videoedit->download) && ($videoedit->download == '0' || $videoedit->download == '')) {
                                                        echo 'checked="checked"';
                                                    } ?>  />
                                                    <span class="hd_select_disable"><?php echo JText::_('HDVS_DISABLE'); ?></span>
                                                </div>
                                            </li>
                                        </ul>

            <?php
                                                    if ($type == 'edit') {
                                                        $editbutton = JText::_('HDVS_UPDATE');
                                                    } else {
                                                        $editbutton = JText::_('HDVS_SAVE');
                                                    }
            ?>
                                                    <div ><input  type="submit" name="uploadbtn" value="<?php echo $editbutton; ?>" class="button cursor_pointer" />
                                                        <input type="button" onclick="window.open('<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=myvideos'); ?>','_self');"  value="<?php echo JText::_('HDVS_CANCEL'); ?>" class="button cursor_pointer" />
                                                    </div>
                                                </div>
                                                <br/><br/>
                                                <input type="hidden" id="videouploadformurl" name="videouploadformurl" value="<?php echo JURI::base(); ?>" />
                                                <input type="hidden" name="videourl" value="1" class="text" size="20" id="videourl" />
                                                <input type="hidden" name="thump" value="<?php if (isset($imgurl)

                                                        )echo $imgurl; ?>">
                                                <input type="hidden" name="flv" value="<?php if (JRequest::getVar('url', '', 'post', 'string')

                                                        )echo JRequest::getVar('url', '', 'post', 'string'); ?>">
                                             <input type="hidden" name="hd" value="">
                                             <input type="hidden" name="hq" value="">
                                             <input type="hidden" name="ffmpeg" id="ffmpeg" value="">
                                             <input type="hidden" name="normalvideoformval" id="normalvideoformval" value="<?php
                                                    if (isset($videoedit->filepath)) {
                                                        if ($videoedit->filepath == 'File')
                                                            echo JPATH_COMPONENT . '/videos/' . $videoedit->videourl;
                                                    }
            ?>">
                                             <input type="hidden" name="video_filetype" id="video_filetype" value="<?php
                                                    if (isset($videoedit->filepath)) {
                                                        if ($videoedit->filepath == 'File')
                                                            echo $videoedit->filepath;
                                                    }
            ?>">
                                                    <input type="hidden" name="hdvideoformval"  id="hdvideoformval" value="">
                                                    <input type="hidden" name="thumbimageformval" id="thumbimageformval" value="<?php
                                                    if (isset($videoedit->filepath)) {
                                                        if ($videoedit->filepath == 'File')
                                                            echo JPATH_COMPONENT . '/videos/' . $videoedit->thumburl;
                                                    }
            ?>">
                                                               <input type="hidden" name="streamerpath-value" id="streamerpath-value" value="">
                                             <input type="hidden" name="islive-value" id="islive-value" value="">                                     
                                                                                     <input type="hidden" name="previewimageformval" id="previewimageformval" value="<?php if (isset($imgurl)

                                                        )echo $imgurl; ?>">
                                             <input type="hidden" name="seltype" id="seltype" value="0">
                                             <input type="hidden" name="videotype" id="videotype" value="<?php echo $type; ?>">
                                             <input type="hidden" name="videoid" id="videoid" value="<?php echo $id; ?>">
                                         </form>

                                     </div>
                                     <form name="memberidform" id="memberidform" action="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=membercollection'); ?>" method="post">
                                         <input type="hidden" id="memberidvalue" name="memberidvalue" value="<?php
                                                    if (JRequest::getVar('memberidvalue', '', 'post', 'int')) {
                                                        echo JRequest::getVar('memberidvalue', '', 'post', 'int');
                                                    };
            ?>" />
                                         </form>
                                         <script type="text/javascript">

                                             function resetcategory()
                                             {
                                                 document.getElementById('tagname').value='';
                                             }
                                             function catselect(categ)
                                             {
                                                 var r=document.getElementById('selcat').value=categ;
                                                 if(document.getElementById('tagname').value=='')
                                                 {
                                                     document.getElementById('tagname').value=r;
                                                 }
                                                 else
                                                 {

                                                     document.getElementById('tagname').value=  r;
                                                 }
                                             }

                                             //change upload link page when i select option btn
                                             function filetypeshow(obj)
                                             {
                                                 if(obj.value==0 || obj==0)
                                                 {
                                                     document.getElementById("typefile").style.display="none";
                                                     document.getElementById("typeff").style.display="none";
                                                     document.getElementById("typeurl").style.display="block";
                                                     document.getElementById("rtmpcontainer").style.display="none";
                                                     document.getElementById("down_load").style.display="none";
                                                     document.getElementById("hd_url").style.display="none";
                                                     document.getElementById("image_path").style.display="none";
                                                     document.getElementById('seltype').value=0;
                                                     document.getElementById("ffmpeg").style.display="none";
                                                     document.getElementById("normalvideoformval").style.display="none";

                                                 }
                                                 if(obj.value==1 || obj==1)
                                                 {
                                                     document.getElementById("typefile").style.display="block";
                                                     document.getElementById("typeurl").style.display="none";
                                                     document.getElementById("typeff").style.display="none";
                                                     document.getElementById("down_load").style.display="block";
                                                     document.getElementById("rtmpcontainer").style.display="none";
                                                     document.getElementById('seltype').value=1;
                                                     document.getElementById("ffmpeg").style.display="none";
                                                     document.getElementById("normalvideoformval").style.display="block";

                                                 }
                                                 if(obj.value==2 || obj==2)
                                                 {
                                                     document.getElementById("typefile").style.display="none";
                                                     document.getElementById("typeurl").style.display="block";
                                                     document.getElementById("hd_url").style.display="block";
                                                     document.getElementById("down_load").style.display="block";
                                                     document.getElementById("image_path").style.display="block";
                                                     document.getElementById("typeff").style.display="none";
                                                     document.getElementById("ffmpeg").style.display="none";
                                                     document.getElementById('seltype').value=2;
                                                     document.getElementById("normalvideoformval").style.display="block";
                                                     document.getElementById("rtmpcontainer").style.display="none";

                                                 }
                                                 if(obj.value==3 || obj==3)
                                                 {
                                                     document.getElementById("rtmpcontainer").style.display="block";
                                                     document.getElementById("typeurl").style.display="block";
                                                     document.getElementById("typefile").style.display="none";
                                                     document.getElementById("hd_url").style.display="none";
                                                     document.getElementById('islive1').checked=true;
                                                     document.getElementById("down_load").style.display="none";
                                                     document.getElementById("image_path").style.display="block";
                                                     document.getElementById("typeff").style.display="none";
                                                     document.getElementById("ffmpeg").style.display="none";
                                                     document.getElementById('seltype').value=3;
                                                     document.getElementById("normalvideoformval").style.display="block";

                                                 }

                                             }
                                             document.getElementById("rtmpcontainer").style.display="none";
                                             document.getElementById("ffmpeg").style.display="none";
                                             document.getElementById("typefile").style.display="none";
                                             document.getElementById("typeurl").style.display="block";
                                             document.getElementById("down_load").style.display="none";
                                             document.getElementById("hd_url").style.display="none";
                                             document.getElementById("image_path").style.display="none";
                                             document.getElementById("filetype2").checked = true;


                                             document.getElementById("typeff").style.display="none";

                                             function bindvideo()
                                             {
                                                 if(document.getElementById('Youtubeurl').value!='')
                                                 {
                                                     document.getElementById('videourl').value=0;
                                                 }
                                             }


                                             function assignurl(str)
                                             {
                                                 if(str=="")
                                                     return false;
                                                 //    match_exp = new RegExp('regex = /http\:\/\/www\.youtube\.com\/watch\?v=(\w{11})/');
                                                 var match_exp = /http\:\/\/www\.youtube\.com\/watch\?v=[^&]+/;

                                                 if(str.match(match_exp)==null){

                                                     var metacafe=/http:\/\/www\.metacafe\.com\/watch\/(.*?)\/(.*?)\//;

                                                     if(str.match(metacafe)!=null)
                                                     {
                                                         document.upload1111.url1.value=document.getElementById('url').value;
                                                         document.getElementById('generate').style.display="block";
                                                         return false;

                                                     }
                                                     else
                                                     {
                                                         alert("Enter Video URL");
                                                         document.getElementById('url').focus();
                                                         document.upload1111.url.value="1";
                                                         return false;
                                                     }


                                                 }
                                                 else
                                                 {
                                                     document.getElementById('generate').style.display="block";
                                                     document.upload1111.flv.value=document.getElementById('url').value;
                                                     document.upload1111.url1.value="1";
                                                     return false;
                                                 }

                                             }


                                             function changeimageurltype(urltype)
                                             {


                                                 if(urltype.value==1)
                                                 {
                                                     document.getElementById('imageurltype').innerHTML='<input type="text" name="thumburl" value="<?php if (isset($videoedit->thumburl) && $videoedit->filepath != 'Youtube'

                                                        )echo $videoedit->thumburl; ?>" class="text" size="20" id="thumburl"/>';
                                                                }
                                                                else
                                                                {
                                                                    document.getElementById('imageurltype').innerHTML='<input type="file" name="thumburl" value="<?php if (isset($videoedit->thumburl)

                                                        )echo $videoedit->thumburl; ?>" class="text" size="20" id="thumburl"/>';
                                                                }
                                                            }
                                                            function membervalue(memid)
                                                            {
                                                                document.getElementById('memberidvalue').value=memid;
                                                                document.memberidform.submit();
                                                            }

                                                            function fileformate_check(thumburl)
                                                            {


                                                                //var athumburl=thumb.value;
                                                                //alert(o.value);
                                                                if((thumburl.value.length > 0))
                                                                {

                                                                    if(thumburl.value.substring(thumburl.value.length-3) == 'gif' || thumburl.value.substring(thumburl.value.length-3) == 'GIF' || thumburl.value.substring(thumburl.value.length-3) == 'JPG' || thumburl.value.substring(thumburl.value.length-3) == 'jpg' || thumburl.value.substring(thumburl.value.length-3) == 'PNG' || thumburl.value.substring(thumburl.value.length-3) == 'png' )
                                                                    {}
                                                                    else {
                                                                        alert("Invalid file formate select only jpg/gif/png");
                                                                    }
                                                                }
                                                            }

                                         </script>
                                         <script type="text/javascript">
<?php
                                                    if (isset($videoedit->streameroption) && $videoedit->streameroption == 'rtmp') {
?>
                                                 filetypeshow("3");
                                                 document.getElementById("filetype4").checked = true;
<?php
                                                    } 
                                                    elseif (isset($videoedit->filepath) && $videoedit->filepath == 'File') {
?>
                                                 filetypeshow("1");
                                                 document.getElementById("filetype1").checked = true;
<?php
                                                    } elseif (isset($videoedit->filepath) && $videoedit->filepath == 'Url') {
?>
                                                 filetypeshow("2");
                                                 document.getElementById("filetype3").checked = true;
<?php
                                                    } elseif (isset($videoedit->filepath) && $videoedit->filepath == 'Youtube') {
?>
                                                 filetypeshow("0");
                                                 document.getElementById("filetype2").checked = true;
<?php
                                                    }
                                                    if ($videoedit->filepath == 'Youtube' || $videoedit->filepath == 'Url') {
?>
                                                 bindvideo();
<?php
                                                    }
?>
</script>