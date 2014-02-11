<?php
/**
 * @name          : Joomla HD Video Share
 * @version	  : 3.4.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component MyVideos View
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */
//No direct acesss
defined('_JEXEC') or die('Restricted access');
$session = JFactory::getSession();
$user = JFactory::getUser();
$thumbview       = unserialize($this->myvideorowcol[0]->thumbview);
$dispenable      = unserialize($this->myvideorowcol[0]->dispenable);
$requestpage = JRequest::getVar('page', '', 'post', 'int');
$baseurl = JURI::base();
$src_path="";
if ($user->get('id') == '')
{
    if(version_compare(JVERSION,'1.6.0','ge'))
      {
	$url = $baseurl . "index.php?option=com_users&view=login";
	header("Location: $url");
      }else {
        $url = $baseurl . "index.php?option=com_user&view=login";
	header("Location: $url");
      }
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
<!--		<input type="hidden" name="return" value="<?php echo $logoutval_2; ?>" />-->
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
<?php
	if ($user->get('id') != '')
	{
		     if(version_compare(JVERSION,'1.6.0','ge'))
                        {
                       ?>
                    <div class="toprightmenu">
                    <a href="index.php?option=com_contushdvideoshare&view=myvideos"><?php echo JText::_('HDVS_MY_VIDEOS'); ?></a> |
                    <a href="javascript: submitform();"><?php echo JText::_('HDVS_LOGOUT'); ?></a>
                    </div>
            <?php }else { ?>
                <div class="toprightmenu">
                <a href="index.php?option=com_contushdvideoshare&view=myvideos"><?php echo JText::_('HDVS_MY_VIDEOS'); ?></a> |
                <a href="index.php?option=com_user&task=logout"><?php echo JText::_('HDVS_LOGOUT'); ?></a>
                </div>
           <?php  }?>



		<?php } else
		{if(version_compare(JVERSION,'1.6.0','ge'))
        { ?><div class="toprightmenu">
        <a href="index.php?option=com_users&view=registration"><?php echo JText::_('HDVS_REGISTER'); ?></a> |
        <a  href="index.php?option=com_users&view=login"> <?php echo JText::_('HDVS_LOGIN'); ?></a>
        </div>
           <?php }  else {      ?>
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

            <h1> <?php echo JText::_('HDVS_MY_VIDEOS'); ?></h1>
            <div class="myvideospage_topitem">
                <div id="myvideos_topsearch">
<?php
        $searchtxtbox =JRequest::getVar('searchtxtboxmember','','post');
        $searchval = JRequest::getVar('searchval','','post');
        $hidsearchtxtbox=JRequest::getVar('hidsearchtxtbox','','post');
        if (isset($searchtxtbox)) {
            $searchboxval =  $searchtxtbox;
             } else if(isset($searchval)){
                 $searchboxval =  isset($searchval)?$searchval:'';
                 }else{
                    $searchboxval =  $hidsearchtxtbox;
                 }?>
                    <style type="text/css">
                        .search_snipt{float: left; position:relative;height: 50px;}
                        .search_snipt #searcherrormessage{color: red; clear: both; position: absolute; bottom: 0;}
                    </style>
                <form name="hsearch" id="hsearch" method="post" action='<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=myvideos',true); ?>' onsubmit="return searchValidation();">
                    
                    <div class="search_snipt">
                    <input type="text" value="<?php
       echo $searchboxval;
?>" name="searchtxtboxmember" id="searchtxtboxmember" class="clstextfield clscolor"  onkeypress="validateenterkey(event,'hsearch');"/>
                    <div id="searcherrormessage"></div>
                    </div>
                    
                    <input type="submit" name="search_btn" id="search_btn" class="button myvideos_search" value="<?php echo JText::_('HDVS_SEARCH'); ?>"/>
                    <input type="hidden" name="searchval" id="searchval" value=" <?php
       echo $searchboxval;
?>" />
                    <?php
                    if ($this->allowupload['allowupload'] == 1)
                            {
                   ?>
                               <input type="button" class="button" value="<?php echo JText::_('HDVS_ADD_VIDEO'); ?>" onclick="window.open('<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=videoupload'); ?>','_self');">
<?php                       }
?>
                </form>
                <script type="text/javascript">
                function searchValidation() {
                    if(document.getElementById('searchtxtboxmember').value == '') {
                        document.getElementById('searcherrormessage').innerHTML = 'Enter Keyword to search videos';         
                        return false;
                    }
                }
                </script>
            </div>
            </div>

            <div class="clear"></div>

                <?php
                $totalrecords = $thumbview['myvideorow'] * $thumbview['myvideocol'];
                if (count($this->deletevideos) - 4 < $totalrecords)
                {
                    $totalrecords = count($this->deletevideos) - 4;
                }
                if ($totalrecords == -4) {
                	?>
               <h3><?php echo JText::_('HDVS_SEARCH_RESULT')." - $searchboxval"; ?></h3>
               <?php
                echo '<div class="hd_norecords_found"> ' . JText::_('HDVS_NO_RECORDS_FOUND_SEARCH') .'"'.$searchboxval.'"'. ' </div>';
           		 } else  {
                         if(!empty($searchboxval)){
                         ?>
                <h3 class="home-link hoverable"><?php echo JText::_('HDVS_SEARCH_RESULT')." - $searchboxval"; ?></h3>
                         <?php } ?>
            <ul  class="myvideos_tab">
                <?php
                for ($i = 0; $i < $totalrecords; $i++)
                {
                        if ((($i) % $thumbview['myvideocol']) == 0)
                         {
                echo '</ul><ul  class="myvideos_tab">';
                            } ?>
                            <li class="rightrate">
                        <?php
                        if ($this->deletevideos[$i]->filepath == "File" || $this->deletevideos[$i]->filepath == "FFmpeg" || $this->deletevideos[$i]->filepath == "Embed")
                        {
                            if ($this->deletevideos[$i]->thumburl != "")
                            {
                                $src_path = "components/com_contushdvideoshare/videos/" . $this->deletevideos[$i]->thumburl;
                            }
                            }
                        if ($this->deletevideos[$i]->filepath == "Url" || $this->deletevideos[$i]->filepath == "Youtube")
                        {
                            $src_path = $this->deletevideos[$i]->thumburl;
                        }
                        ?>
                        <?php if ($this->deletevideos[$i]->vid != '') { ?>
                            <div id="imiddlecontent1" class="clearfix" >
                                    <div class="middleleftcontent clearfix">

                                        <?php
                                        $img_path = "components/com_contushdvideoshare/images/default_thumb.jpg";
                                        ?>
                                        <?php
                                        $seoOption = $dispenable['seo_option'];
                                         if ($seoOption == 1)
                                        {

                                         $myCategoryVal = "category=" . $this->deletevideos[$i]->seo_category;
                                            $myVideoVal = "video=" . $this->deletevideos[$i]->seotitle;
                                        }
                                        else
                                         {
                                            $myCategoryVal = "catid=" . $this->deletevideos[$i]->catid;
                                            $myVideoVal = "id=" . $this->deletevideos[$i]->vid;
                                         }

                                        ?>
                                        <a class="featured_vidimg" href="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=player&'.$myCategoryVal.'&'.$myVideoVal,true); ?>" >
                                           <img class="yt-uix-hovercard-target" src="<?php echo $src_path; ?>"  border="0"  width="145" height="80" title="" alt="thumb_image" /></a>

                                        <div class="clear"></div>

                                                 <?php
                                                 if ($dispenable['comment'] == 2) {
                                                 $db = JFactory::getDBO();
                                                 $comment_count="SELECT count(message)
        					 FROM #__hdflv_comments
        					 WHERE videoid=".$this->deletevideos[$i]->vid;
                                                $db->setQuery($comment_count);
                                                $comment_count_row=$db->loadResult();
?>
                                        <span class="floatleft viewcolor view">  <a href="<?php echo JRoute::_("index.php?option=com_contushdvideoshare&view=player&" . $myCategoryVal . "&" . $myVideoVal); ?>">
                                        <?php
                                                 if (isset($comment_count_row)) { echo $comment_count_row; } ?></a>
                                                    <?php if($comment_count_row>1) echo JText::_('HDVS_COMMENTS');
                                                    else if($comment_count_row<=1) echo "Comment";
                                                 ?>
                                            </span>
                                            <?php
                                                 }
                                                    ?>

                                                        <?php if ($dispenable['viewedconrtol'] == 1) { ?>

                                                        <span class="floatright viewcolor"> <?php echo $this->deletevideos[$i]->times_viewed. ' '. JText::_('HDVS_VIEWS') ; ?></span>
                                                         <?php } ?>
                                            </div>
                                        <div class="featureright">
                                            <p class="myview myvideopage_title"><a href="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=player&'.$myCategoryVal .'&'.$myVideoVal); ?>" title="<?php echo $this->deletevideos[$i]->title; ?>">
                                            <?php if (strlen($this->deletevideos[$i]->title) > 50) {
                                                echo JHTML::_('string.truncate', ($this->deletevideos[$i]->title), 50);
                                                //echo (substr($this->deletevideos[$i]->title, 0, 15)) . '...';
                                            } else
                                              {
                                                echo $this->deletevideos[$i]->title;
                                              } ?></a></p>
                                    <?php
                                                    $addeddate = $this->deletevideos[$i]->addedon;
                                                    $addedon = date('j-M-Y', strtotime($addeddate));
                                    ?>
                                                    <p class="myview"> <?php echo JText::_('HDVS_UPDATEDON').' : '.$addedon; ?></p>
                                    <?php
                                                    if ($this->deletevideos[$i]->type == 0)
                                                    {
                                                        $vtype = JText::_('HDVS_PUBLIC');
                                                    }
                                                    else
                                                    {
                                                        $vtype = JText::_('HDVS_PRIVATE');
                                                    }
                                    ?>
                                                    <p class="myview viewcolor"> <?php echo JText::_('HDVS_VIDEO'). " : " . ' ' . $vtype; ?>
                                                    <?php 
$playvideo = JRoute::_('index.php?option=com_contushdvideoshare&view=player&'.$myCategoryVal.'&'.$myVideoVal,true);
$editvideo = JRoute::_('index.php?option=com_contushdvideoshare&view=videoupload&id=' . $this->deletevideos[$i]->vid . '&type=edit');

                                                    ?></p>
                                                    <div class="myvideosbtns">
                                                        <input type="button" name="playvideo" id="playvideo" onclick="window.open('<?php echo $playvideo; ?>','_self')" value="<?php echo JText::_('HDVS_PLAY'); ?>" class="button"  />
                                                        <input type="button" name="videoedit" id="videoedit" onclick="window.open('<?php echo $editvideo; ?>','_self')" value="<?php echo JText::_('HDVS_EDIT'); ?>" class="button" />
                                                        <input type="button" name="videodelete" id="videodelete" value="<?php echo JText::_('HDVS_DELETE'); ?>" class="button" onclick="var flg=my_message(<?php echo $this->deletevideos[$i]->vid; ?>); return flg;" />
                                                                    </div>
                                      </div>
                                <div class="clear"></div>
                                                        </div>
                                                    </li>
<?php } ?>
                                                <!----------First row---------->
<?php
                                        }
?>
                                </ul>

                                <!--  PAGINATION STARTS HERE-->

                               <ul class="hd_pagination">
                                <?php
                                        $pages = $this->deletevideos['pages'];
                                        $q = $this->deletevideos['pageno'];
                                        $q1 = $this->deletevideos['pageno'] - 1;
                                        if ($this->deletevideos['pageno'] > 1)
                                            echo("<li align='right'><a onclick='changepage($q1);'>" . JText::_('HDVS_PREVIOUS') . "</a></li>");
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
                                                echo("<li><a onclick='changepage(" . $i . ")'>" . $i . "</a></li>");
                                            else
                                                echo("<li><a onclick='changepage($i);' class='activepage'>$i</a></li>");
                                            if ($j > 3)
                                                break;
                                        }
                                        if ($i < $pages)
                                        {
                                            if ($i + 1 != $pages)
                                                echo ("<li>...</li>");
                                            echo("<li><a onclick='changepage(" . $pages . ")'>" . $pages . "</a></li>");
                                        }
                                        $p = $q + 1;
                                        if ($q < $pages)
                                            echo ("<li><a onclick='changepage($p);'>" . JText::_('HDVS_NEXT') . "</a></li>");}
                                ?>
                                    </ul>
                    <?php  }?>

                </div>

                             <?php $page = $_SERVER['REQUEST_URI'];
                                   $deleteVideo = '';
                                   $memberIdValue = '';
                                   $sorting = '';
                                    if (JRequest::getVar('deletevideo', '', 'post', 'int'))
                                     {
                                        $deleteVideo = JRequest::getVar('deletevideo', '', 'post', 'int');
                                     }
                                    if (JRequest::getVar('memberidvalue', '', 'post', 'int'))
                                    {
                                        $memberIdValue = JRequest::getVar('memberidvalue', '', 'post', 'int');
                                    }
                                    if (JRequest::getVar('sorting', '', 'post', 'string'))
                                    {
                                        $sorting = JRequest::getVar('sorting', '', 'post', 'string');
                                    }

                             ?>
                             <form name="deletemyvideo"  action="<?php echo $page; ?>" method="post">
                                 <input type="hidden" name="deletevideo" id="deletevideo" value="<?php echo $deleteVideo; ?>">
                                        </form>
                                        <form name="memberidform" id="memberidform" action="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=membercollection'); ?>" method="post">
                                            <input type="hidden" id="memberidvalue" name="memberidvalue" value="<?php echo $memberIdValue;  ?>" />
                                        </form>
<?php
                                        $hiddensearchbox = $searchtextbox = $hidden_page = '';
                                        $searchtextbox = JRequest::getVar('searchtxtboxmember', '', 'post', 'string');
                                        $hiddensearchbox = JRequest::getVar('hidsearchtxtbox', '', 'post', 'string');
                                        if ($requestpage)
                                        {
                                            $hidden_page = $requestpage;
                                        }
                                        else
                                        {
                                            $hidden_page = '';
                                        }
                                        if ($searchtextbox)
                                        {
                                            $hidden_searchbox = $searchtextbox;
                                        }
                                        else
                                        {
                                            $hidden_searchbox = $hiddensearchbox;
                                        }
?>
                                        <form name="pagination" id="pagination" action="<?php echo $page; ?>" method="post">
                                            <input type="hidden" id="page" name="page" value="<?php echo $hidden_page ?>" />
                                            <input type="hidden" id="hidsearchtxtbox" name="hidsearchtxtbox" value="<?php echo $hidden_searchbox; ?>" />
                                        </form>
                                         <form name="sortform"  action="<?php echo $page; ?>" method="post">
                                            <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
                                         </form>
<?php
              $lang = JFactory::getLanguage();
              $langDirection = (bool) $lang->isRTL();
                    if ($langDirection == 1) {
                         $rtlLang = 1;
                    } else {
                        $rtlLang = 0;
                    }
             ?>
                                <script type="text/javascript">
jQuery.noConflict();
                                jQuery(document).ready(function($){
                                    jQuery(".ulvideo_thumb").mouseover(function(){
                                         htmltooltipCallback("htmltooltip","",<?php echo $rtlLang;?>);
                                    });
                                });
                                jQuery(document).ready(function($){
                                     htmltooltipCallback("htmltooltip","",<?php echo $rtlLang;?>);
                                })
                                jQuery(document).click(function(){
                                    htmltooltipCallback("htmltooltip","",<?php echo $rtlLang;?>);
                                })
                                function membervalue(memid)
                                {
                                    document.getElementById('memberidvalue').value=memid;
                                    document.memberidform.submit();
                                }
                                    function changepage(pageno)
                                    {
                                        document.getElementById("page").value=pageno;
                                        document.pagination.submit();
                                    }

                                    function my_message(vid)
                                    {
                                        var flg=confirm('Do you Really Want To Delete This Video? \n\nClick OK to continue. Otherwise click Cancel.\n');
                                        if (flg)
                                        {
                                            var r=document.getElementById('deletevideo').value=vid;
                                            document.deletemyvideo.submit();
                                            return true;
                                        }
                                        else
                                        {
                                            return false;
                                        }
                                    }
                                    function videoplay(vid,cat)
                                    {
                                        window.open('index.php?option=com_contushdvideoshare&view=player&id='+vid+'&catid='+cat,'_self');
                                    }
                                    function editvideo(evid)
                                    {

                                        window.open(evid,'_self');
                                    }
                                    function sortvalue(sortvalue)
                                    {
                                        document.getElementById("sorting").value=sortvalue;
                                        document.sortform.submit();
                                    }

                                </script>
