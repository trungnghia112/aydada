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
 * @abstract      : Contus HD Video Share Component Hdvideoshare Search View
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */
/*
 ***********************************************************/
//No direct acesss
defined('_JEXEC') or die('Restricted access');
$session = JFactory::getSession();
//ratings array declaration
$ratearray = array("nopos1", "onepos1", "twopos1", "threepos1", "fourpos1", "fivepos1");
$user = JFactory::getUser();
//get current page
$requestpage = JRequest::getVar('page', '', 'post', 'int');
$thumbview       = unserialize($this->searchrowcol[0]->thumbview);
$dispenable      = unserialize($this->searchrowcol[0]->dispenable);
$serachVal=JRequest::getVar('searchtxtbox');
$serachVal=isset($serachVal)?$serachVal:$session->get('search');
$document = JFactory::getDocument();
$style = '#video-grid-container .ulvideo_thumb .video-item{margin-right:'.$thumbview['searchwidth'] . 'px; }';
$document->addStyleDeclaration($style);
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
<div class="player clearfix" id="clsdetail">
   <?php         
               if (USER_LOGIN == '1')
            {
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
           <?php  } }
                else
                {
                    if(version_compare(JVERSION,'1.6.0','ge'))
        { ?><span class="toprightmenu"><a href="index.php?option=com_users&view=registration"><?php ECHO JText::_('HDVS_REGISTER'); ?></a> |
                <a  href="index.php?option=com_users&view=login"> <?php echo JText::_('HDVS_LOGIN'); ?></a></span>
           <?php }  else {      ?>
                    <span class="toprightmenu"><a href="index.php?option=com_user&view=register"><?php ECHO JText::_('HDVS_REGISTER'); ?></a> |
                            <a  href="index.php?option=com_user&view=login"> <?php echo JText::_('HDVS_LOGIN'); ?></a></span>
        <?php
                } }
            }
            
            ?>
    <div class="standard clearfix" >
            <?php
            $totalRecords = $thumbview['searchcol'] * $thumbview['searchrow'];
            if (count($this->search) - 4 < $totalRecords) {
                $totalRecords = count($this->search) - 4;
            }
            $user = JFactory::getUser();
            if ($user->get('id') == '')
            {
                $addvideo_url = JRoute::_("index.php?option=com_users&view=login");
            }else{
            $addvideo_url=JRoute::_('index.php?option=com_contushdvideoshare&view=videoupload');
            }
            if ($totalRecords == -4) {
            ?>
               <h1><?php echo JText::_('HDVS_SEARCH_RESULT')." - $serachVal"; ?></h1>
               <?php
                echo '<div class="hd_norecords_found"> ' . JText::_('HDVS_NO_RECORDS_FOUND_SEARCH') .'"'.$serachVal.'"'. ' </div></div>';
           } else {
            ?>

                     <h1 class="home-link hoverable"><?php echo JText::_('HDVS_SEARCH_RESULT')." - $serachVal"; ?></h1>
        <div id="video-grid-container" class="clearfix">
           <?php
                $no_of_columns = $thumbview['searchcol'];
                $current_column = 1;
                for ($i = 0; $i < $totalRecords; $i++) {
                    $colcount = $current_column % $no_of_columns;
                    if ($colcount == 1 || $no_of_columns==1) {
                        echo '<ul class="clearfix ulvideo_thumb">';
                    }
                    $seoOption = $dispenable['seo_option'];
                    if ($seoOption == 1) {
                        $searchCategoryVal = "category=" . $this->search[$i]->seo_category;
                        $searchVideoVal = "video=" . $this->search[$i]->seotitle;
                    } else {
                        $searchCategoryVal = "catid=" . $this->search[$i]->catid;
                        $searchVideoVal = "id=" . $this->search[$i]->vid;
                    }

                    if ($this->search[$i]->filepath == "File" || $this->search[$i]->filepath == "FFmpeg" || $this->search[$i]->filepath == "Embed") {
                        $src_path = "components/com_contushdvideoshare/videos/" . $this->search[$i]->thumburl;
                    }elseif ($this->search[$i]->filepath == "Url" || $this->search[$i]->filepath == "Youtube") {
                        $src_path = $this->search[$i]->thumburl;
                    }else {
                    	$src_path = '';
                    }?>
                     <li class="video-item">
                                        <?php if ($this->search[$i]->vid != '') {
 ?>                                           <div class="home-thumb">
                                                    <div class="list_video_thumb">
                                                     <?php
                                                        if (isset($this->search[$i]->ratecount) && $this->search[$i]->ratecount != 0) {
                                                            $ratestar = round($this->search[$i]->rate / $this->search[$i]->ratecount);
                                                        } else {
                                                            $ratestar = 0;
                                                        }
                                                    ?>
                                          <a class="featured_vidimg" rel="htmltooltip" href="<?php echo JRoute::_("index.php?option=com_contushdvideoshare&amp;view=player&amp;" . $searchCategoryVal . "&amp;" . $searchVideoVal); ?>" ><img class="yt-uix-hovercard-target" src="<?php echo $src_path; ?>" title="" alt="thumb_image" /></a>
                                             
                                                    </div>
                                           <div class="show-title-container">
                                           <a href="index.php?option=com_contushdvideoshare&view=player&<?php echo $searchCategoryVal; ?>&<?php echo $searchVideoVal; ?>" class="show-title-gray info_hover"><?php
                                            if (strlen($this->search[$i]->title) > 50) {
                                                echo JHTML::_('string.truncate', ($this->search[$i]->title), 50);
                                            } else {
                                                echo $this->search[$i]->title;
                                            }
?></a>
                                                </div>

<?php
                                            if ($dispenable['ratingscontrol'] == 1) {
?>
                                               <?php
                                                        if (isset($this->search[$i]->ratecount) && $this->search[$i]->ratecount != 0) {
                                                            $ratestar = round($this->search[$i]->rate / $this->search[$i]->ratecount);
                                                        } else {
                                                            $ratestar = 0;
                                                        }
                                                        ?>
                                                  <div class="ratethis1 <?php echo $ratearray[$ratestar]; ?> "></div>
                                                
<?php } ?>

                                                <?php if ($dispenable['viewedconrtol'] == 1) {
 ?>
                                                 <span class="floatright viewcolor"><?php echo $this->search[$i]->times_viewed; ?>  <?PHP echo JText::_('HDVS_VIEWS'); ?></span>
                                             <?php } ?>
                                              </div>
                                                    <?php } ?>
                     </li>
                                            <!--First row-->
                                                    <?php
                                                    if ($colcount == 0) {
                                                        echo '</ul><div class="clear"></div>';
                                                        $current_column = 0;
                                                    }
                                                    $current_column++;
                                                }
                                                    ?>
                                    </div>
                                  </div>
   <!--Tooltip Starts Here-->
                      <?php
                      for ($i = 0; $i < $totalRecords; $i++)
                                      { ?>
                                          <div class="htmltooltip">
                                              <?php if($this->search[$i]->description) {?>
                                              <div class="tooltip_discrip"><?php echo JHTML::_('string.truncate', (strip_tags($this->search[$i]->description)), 120); ?></div>
                                             <?php }?>
                                             <div class="tooltip_category_left">
                                                 <span class="title_category"><?php echo  JText::_('HDVS_CATEGORY');?>: </span>
                                                 <span class="show_category"><?php echo $this->search[$i]->category; ?></span>
                                             </div>
                                             <?php if ($dispenable['viewedconrtol'] == 1) { ?>
                                            <div class="tooltip_views_right">
                                                 <span class="view_txt"><?php echo JText::_('HDVS_VIEWS'); ?>: </span>
                                                 <span class="view_count"><?php echo $this->search[$i]->times_viewed; ?> </span>
                                             </div>
                                             <div id="htmltooltipwrapper<?php echo $i; ?>">
                                                 <div class="chat-bubble-arrow-border"></div>
                                               <div class="chat-bubble-arrow"></div>
                                             </div>
                                              <?php } ?>
                                           </div>
                                    <?php } ?>
             <!--Tooltip ends and PAGINATION STARTS HERE-->
                                                <ul class="hd_pagination">
                                                <?php
                                                    $pages = $this->search['pages'];
                                                    $q = $this->search['pageno'];
                                                    $q1 = $this->search['pageno'] - 1;
                                                    if ($this->search['pageno'] > 1)
                                                        echo("<li><a onclick='changepage($q1);'>" . JText::_('HDVS_PREVIOUS') . "</a></li>");
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
                                                    if($pages >1){
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
                                                            echo ("<li>....</li>");
                                                        echo("<li><a onclick='changepage(" . $pages . ")'>" . $pages . "</a></li>");
                                                    }
                                                    $p = $q + 1;
                                                    if ($q < $pages)
                                                        echo ("<li><a onclick='changepage($p);'>" . JText::_('HDVS_NEXT') . "</a></li>");}
                        ?>
                                                </ul>
                                            
         <?php } ?>
                   
                </div>
        <?php
                             if (JRequest::getVar('memberidvalue', '', 'post', 'int'))
                                        {
                                              $memberidvalue = JRequest::getVar('memberidvalue', '', 'post', 'int');
                                        }
                                        else{$memberidvalue = '';}
                             ?>

                                        <form name="memberidform" id="memberidform" action="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=membercollection'); ?>" method="post">
                                            <input type="hidden" id="memberidvalue" name="memberidvalue" value="<?php echo $memberidvalue; ?>" />
                                        </form>
<?php
                                                    $page = $_SERVER['REQUEST_URI'];
                                                    $hiddensearchbox = $searchtextbox = $hidden_page = '';
                                                    $searchtextbox = JRequest::getVar('searchtxtbox', '', 'post', 'string');
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
                                                </script>
