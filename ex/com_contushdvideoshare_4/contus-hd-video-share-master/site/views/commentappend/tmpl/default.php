<?php
/*
 ***********************************************************/
/**
 * @name          : Joomla HD Video Share
 *** @version	  : 3.4.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component Commentappend View
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */
/*
 ***********************************************************/
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<?php
/* comment page coding */
?>


    <input type="hidden" name="id" id="id" value="<?php echo JRequest::getVar('id', '', 'get', 'int'); ?>">
<?php
$user = JFactory::getUser();
$cmdid = '';
$catid = '';
$cat_id = '';
$cmdid = JRequest::getvar('cmdid', '', 'get', 'int');
$id = JRequest::getVar('id', '', 'get', 'int');
$catid = JRequest::getVar('catid', '', 'get', 'int');
$requestpage = JRequest::getVar('page', '', 'post', 'int');
if ($cmdid == 4) {
?>
<link rel="stylesheet" href="<?php echo JURI::base(); ?>components/com_jcomments/tpl/default/style.css" type="text/css" />
<script type="text/javascript" src="<?php echo JURI::base(); ?>includes/js/joomla.javascript.js"></script>
<script type="text/javascript" src="<?php echo JURI::base(); ?>components/com_jcomments/js/jcomments-v2.1.js"></script>
<script type="text/javascript" src="<?php echo JURI::base(); ?>components/com_jcomments/libraries/joomlatune/ajax.js"></script>
<?php
    $comments = JPATH_ROOT . '/components/com_jcomments/jcomments.php';
    if (file_exists($comments)) {
        require_once($comments);
        echo JComments::showComments(JRequest::getVar('id', '', 'get', 'int'),
                'com_contushdvideoshare', $this->commenttitle[0]->title);
    }
}
if ($cmdid == 3) {
?>
<?php require_once( JPATH_PLUGINS . DS . 'content' . DS . 'jom_comment_bot.php' );
    echo jomcomment(JRequest::getVar('id', '', 'get', 'int'), "com_contushdvideoshare"); ?>
  <?php
}
if ($cmdid == 2) {
    if ($id) {
        $tot = count($this->commenttitle);
?>
<?php ?>
        
        <div class="comment_textcolumn">
            <script type="text/javascript" src="<?php echo JURI::base(); ?>components/com_contushdvideoshare/js/membervalidator.js"></script>
            <!-- FORM STARTS HERE -->
            <div class="commentstop clearfix" >
                <div class="leave floatleft"><span class="comment_txt"><?php echo JText::_('HDVS_COMMENTS'); ?></span> (<span id="commentcount"><?php echo $this->commenttitle['totalcomment']; ?></span>)</div>
<?php if ($user->get('id') != '') { ?>
                    <div class="commentpost floatright"><a  onclick="comments();" class="utility-link"><?php echo JText::_('HDVS_POST_COMMENT'); ?></a></div>

        <?php } else {

         if(version_compare(JVERSION,'1.6.0','ge')) { ?>
                    <div class="commentpost floatright"><a  href="index.php?option=com_users&view=login"  class="utility-link"><?php echo JText::_('HDVS_POST_COMMENT'); ?></a></div>
          <?php } else {?>       <!--<div class="commentpost"  style="float:right"><a  onclick="comments_login();" class="utility-link"><?php echo JText::_('HDVS_POST_COMMENT'); ?></a></div> -->
            <div class="commentpost floatright"><a  href="index.php?option=com_user&view=login" class="utility-link"><?php echo JText::_('HDVS_POST_COMMENT'); ?></a></div>
<?php } } ?>
    </div>
<?php
        if ($id && $catid) {
            $id = $id;
            $cat_id = $catid;
        } ?>
            <div id="success"></div>
            <div id="commentdisplay">
        <div id="initial"></div>
        <div id="al"></div>
        <!--FORM ends HERE -->
        <!-- Comments display starts here -->
<?php
        $sum = count($this->commenttitle1);
        if ($sum != 0) {
?>
            <div class="underline"></div>
    <?php } ?>
        <!--FIRST ROW HERE-->
    <?php $page = $_SERVER['REQUEST_URI']; ?>
<?php
        $j = 0;
        foreach ($this->commenttitle1 as $row) {
?>
    <?php if ($row->parentid == 0) {
    ?>
                <div class="clearfix" >
<div class="subhead changecomment" >
                        <span class="video_user_info">
                        <strong><?php echo $row->name; ?></strong>
                        <span class="user_says"> says </span>
                    </span>
                        <span class="video_user_comment"><?php echo $string = nl2br($row->message); ?></span>
                        <span  class="video_user_info">
                <span class="user_says"> Posted on: <?php echo date("m-d-Y", strtotime($row->created)); ?></span></span>
                    </div>
    <?php if ($user->get('id') != '') {
 ?>

                        <div class="reply changecomment1"><a class="cursor_pointer"onclick="textdisplay(<?php echo $row->id; ?>); parentvalue(<?php
                    if ($row->parentid != 0) {
                        echo $row->parentid;
                    } else {
                        echo $row->id;
                    } ?>)" title="Reply for this comment" value="1" id="hh">Reply</a></div>

            <?php } ?>
        </div>
<?php } else {
?>
           <div class="clsreply clearfix" >
                <span  class="video_user_info">
                    <strong>Re : <span><?php echo $row->name; ?></span></strong>
                    <span class="user_says"> says </span>
                </span>
                <span class="video_user_comment"><?php echo $string = nl2br($row->message); ?></span>
                <span  class="video_user_info">
                <span class="user_says"> Posted on: <?php echo date("m-d-Y", strtotime($row->created)); ?></span></span>
            </div>
<?php } ?>
            <div id="<?php
            if ($row->parentid != 0) {
                echo $row->parentid;
            } else {
                echo $row->id;
            }
?>" class="initial"></div>

    <?php
            if ($j < $sum - 1) {

                if ($this->commenttitle1[$j + 1]->parentid == 0) {
    ?>
                    <div class="underline"></div>
<?php }
            } $j++; ?>
    <?php } ?>
        <!-- Comments display ends here -->
        <br/>
        <!--  PAGINATION STARTS HERE-->
        <table cellpadding="0" cellspacing="0" border="0"   id="pagination" class="floatright">
            <tr align="right">
                <td align="right"  class="page_rightspace">
                    <table cellpadding="0" cellspacing="0"  border="0" align="right">
                        <tr>
<?php
                                                $pages = $this->commenttitle['pages'];
                                                $q = $this->commenttitle['pageno'];
                                                $q1 = $this->commenttitle['pageno'] - 1;
                                                if ($this->commenttitle['pageno'] > 1)
                                                    echo("<td><a onclick='changepage($q1);'>" . JText::_('HDVS_PREVIOUS') . "</a></td>");
                                                if ($requestpage)
                                                 {
                                                    if ($requestpage > 3)
                                                      {
                                                        $page = $requestpage - 1;
                                                        if ($requestpage > 3)
                                                        {
                                                            if ($requestpage >= 7)
                                                            {
                                                            $next_page=$requestpage/2;
                                                            $next_page=ceil($next_page);
                                                            echo("<li><a onclick='changepage(1)'>1</a></li>");
                                                            echo ("<li>...</li>");
                                                            echo("<li><a onclick='changepage(".$next_page.")'>$next_page</a></li>");
//                                                            echo("<li><a onclick='changepage(".$next_page1.")'>$next_page1</a></li>");
                                                             echo ("<li>...</li>");
                                                            }else{
                                                            echo("<li><a onclick='changepage(1)'>1</a></li>");
                                                            echo ("<li>...</li>");
                                                        }
                                                    }
                                                    }
                                                    else
                                                        $page=1;
                                                }
                                                else
                                                    $page=1;
                                                if($pages>1){
                                                for ($i = $page, $j = 1; $i <= $pages; $i++, $j++)
                                                {
                                                    if ($q != $i)
                                                        echo("<td><a onclick='changepage(" . $i . ")'>" . $i . "</a></td>");
                                                    else
                                                        echo("<td><a onclick='changepage($i);' class='activepage'>$i</a></td>");
                                                    if ($j > 3)
                                                        break;
                                                }
                                                if ($i < $pages)
                                                {
                                                    if ($i + 1 != $pages)
                                                        echo ("<td>....</td>");
                                                    echo("<td><a onclick='changepage(" . $pages . ")'>" . $pages . "</a></td>");
                                                }
                                                $p = $q + 1;
                                                if ($q < $pages)
                                                    echo ("<td><a onclick='changepage($p);'>" . JText::_('HDVS_NEXT') . "</a></td>");}
                        ?>


                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <!--  PAGINATION ENDS HERE-->

    <input type="hidden" value="" id="divnum">
                        <?php
                        $memberidvalue = '';
                        if (JRequest::getVar('memberidvalue', '', 'post', 'int')) {
                            $memberidvalue = JRequest::getVar('memberidvalue', '', 'post', 'int');
                        }
                        ?>
    <form name="memberidform" id="memberidform" action="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=membercollection'); ?>" method="post">
        <input type="hidden" id="memberidvalue" name="memberidvalue" value="<?php echo $memberidvalue; ?>" />
    </form>
<?php
                        $page = 'index.php?option=com_contushdvideoshare&view=commentappend&id=' . JRequest::getVar('id', '', 'get', 'int');
                        $hiddensearchbox = $searchtextbox = $hidden_page = '';
                        $searchtextbox = JRequest::getVar('searchtxtbox', '', 'post', 'string');
                        $hiddensearchbox = JRequest::getVar('hidsearchtxtbox', '', 'post', 'string');
                        if ($requestpage) {
                            $hidden_page = $requestpage;
                        } else {
                            $hidden_page = '';
                        }
                        if ($searchtextbox) {
                            $hidden_searchbox = $searchtextbox;
                        } else {
                            $hidden_searchbox = $hiddensearchbox;
                        }
?>
<form name="pagination_page" id="pagination_page" action="<?php echo $page; ?>" method="post">
                            <input type="hidden" id="page" name="page" value="<?php echo $hidden_page ?>" />
                            <input type="hidden" id="hidsearchtxtbox" name="hidsearchtxtbox" value="<?php echo $hidden_searchbox; ?>" />
                             </form>
    <div id="txt" >
                                    <form  id="form" name="commentsform" action="javascript:insert(<?php echo JRequest::getVar('id', '', 'get', 'int'); ?>)" method="post" onsubmit="return validation(this);hidebox();" >
                                   <div class="comment_input">
                                        <span class="label"> <?php echo JText::_('HDVS_NAME'); ?>  : </span>
                                         <input type="text" name="username" id="username" class="newinputbox commenttxtbox"  />
                                   </div>
                               
                                <div class="clear"></div>
                                <div class="comment_txtarea">
                                    <span class="label"><?php echo JText::_('HDVS_COMMENT'); ?>   : </span>
<textarea class="messagebox commenttxtarea" name="comment_message" id="comment_message"
                                                      onKeyDown="CountLeft(this.form.comment_message,this.form.left,500);"
                                                      onKeyUp="CountLeft(this.form.comment_message,this.form.left,500);" ></textarea>
                                <div   class="remaining_character"><div class="floatleft" >Remaining Characters:</div>
                                                <div class="commenttxt"><input readonly type="text" name="left" size=1 maxlength=8 value="500" style="border:none;background:none;width:70px;" /></div></div>

                                </div>
                                <div class="comment_bottom">
                                 <input type="hidden" name="videoid" value="<?php echo JRequest::getVar('id', '', 'get', 'int'); ?>" id="videoid"/>
                                <input type="hidden" name="category" value="<?php echo $cat_id; ?>" id="category"/>
                                <input type="hidden" name="parentid" value="0" id="parent"/>
                                <input type="submit" value="Post comment" class="button clsinputnew"  />
                                <input type="hidden" name="postcomment" id="postcomment" value="true">
                                <input type="hidden"  value="" id="parentvalue" name="parentvalue" />
                                </div><div align="center" id="prcimg"  style="display:none;"><img src="<?php echo JURI::base(); ?>components/com_contushdvideoshare/images/commentloading.gif" width="100px"></div>
                                </form><br/>
                            <div id="insert_response" class="msgsuccess"></div>
                            <script> document.getElementById('prcimg').style.display="none"; </script>
                            </div>


                        <div class="clear"></div></div></div>
<?php
                    }
                }
                
?>
</body>