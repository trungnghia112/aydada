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
 * @abstract      : Contus HD Video Share Component Category View
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */
/*
 ***********************************************************/
//No direct acesss
defined('_JEXEC') or die('Restricted access');
$ratearray = array("nopos1", "onepos1", "twopos1", "threepos1", "fourpos1", "fivepos1");
$user = JFactory::getUser();
$thumbview       = unserialize($this->categoryrowcol[0]->thumbview);
$dispenable      = unserialize($this->categoryrowcol[0]->dispenable);
$document = JFactory::getDocument();
$style = '#video-grid-container .ulvideo_thumb .video-item{margin-right:'.$thumbview['categorywidth'] . 'px; }';
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
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
<?php
$requestpage = JRequest::getVar('page', '', 'post', 'int');	
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
        { ?><span class="toprightmenu">
                <a href="index.php?option=com_users&view=registration"><?php echo JText::_('HDVS_REGISTER'); ?></a> |
                <a  href="index.php?option=com_users&view=login"> <?php echo JText::_('HDVS_LOGIN'); ?></a>
            </span>
           <?php }  else {      ?>
                    <span class="toprightmenu">
                            <a href="index.php?option=com_user&view=register"><?php echo JText::_('HDVS_REGISTER'); ?></a> |
                            <a  href="index.php?option=com_user&view=login"> <?php echo JText::_('HDVS_LOGIN'); ?></a>
                        </span>
        <?php
                } }
            }
?>
<div class="player clearfix" id="clsdetail">
<?php
$totalrecords = $thumbview['categorycol'] * $thumbview['categoryrow'];
if (count($this->categoryview) - 5 < $totalrecords) {
    $totalrecords = count($this->categoryview) - 5;
}
if ($totalrecords <= 0) { // If the count is 0 then this part will be executed
 ?>
    <h1 class="home-link hoverable"><?php echo $this->categoryview[0]->category; ?></h1>
          <?php
            echo '<div class="hd_norecords_found"> ' . JText::_('HDVS_NO_CATEGORY_VIDEOS_FOUND') . ' </div>';
        } else {
            ?>
                                 <div id="video-grid-container" class="clearfix">
                                    <?php
                                    $no_of_columns = $thumbview['categorycol']; // specifying the no of columns
                                    foreach($this->categoryList as $val){
                                    $current_column = 1;
                                    $l=0;
                                      for ($i = 0; $i < $totalrecords; $i++) {
                                          if($val->parent_id == $this->categoryview[$i]->parent_id && $val->category == $this->categoryview[$i]->category){
                                            $colcount = $current_column % $no_of_columns;
                                            if($colcount == 1 && $l==0){
                                            	echo  "<div class='clear'></div><h1 class='home-link hoverable'> $val->category </h1>
                                                ";
                                            	}
                                            if ($colcount == 1 || $no_of_columns==1) {
                                                echo "<ul class='ulvideo_thumb clearfix'>";
                                                   $l++;
                                            }

//For SEO settings

                $seoOption = $dispenable['seo_option'];

                if ($seoOption == 1) {
                    $categoryCategoryVal = "category=" . $this->categoryview[$i]->seo_category;
                    $categoryVideoVal = "video=" . $this->categoryview[$i]->seotitle;
                } else {
                    $categoryCategoryVal = "catid=" . $this->categoryview[$i]->catid;
                    $categoryVideoVal = "id=" . $this->categoryview[$i]->id;
                }

                if ($this->categoryview[$i]->filepath == "File" || $this->categoryview[$i]->filepath == "FFmpeg" || $this->categoryview[$i]->filepath == "Embed")
                    $src_path = "components/com_contushdvideoshare/videos/" . $this->categoryview[$i]->thumburl;
                if ($this->categoryview[$i]->filepath == "Url" || $this->categoryview[$i]->filepath == "Youtube")
                    $src_path = $this->categoryview[$i]->thumburl;
?>
                    <?php if ($this->categoryview[$i]->id != '')
                           {
 ?>
                                            <li class="video-item">
                                         <div class="home-thumb">
                                          <div class="list_video_thumb">
                                          <a class="featured_vidimg" rel="htmltooltip" href="<?php echo JRoute::_("index.php?option=com_contushdvideoshare&amp;view=player&amp;" . $categoryCategoryVal . "&amp;" . $categoryVideoVal); ?>" >
                                              <img class="yt-uix-hovercard-target" src="<?php echo $src_path; ?>" title="" alt="thumb_image" /></a>
                                          </div>
                                                                                                           
                                                    
                                              
                                                <div class="show-title-container">
                                                    <a href="index.php?option=com_contushdvideoshare&view=player&<?php echo $categoryCategoryVal; ?>&<?php echo $categoryVideoVal; ?>" class="show-title-gray info_hover"><?php if (strlen($this->categoryview[$i]->title) > 50) {
                                               // echo (substr($this->categoryview[$i]->title, 0, 18)) . "...";
                                                        echo JHTML::_('string.truncate', ($this->categoryview[$i]->title), 50);
                                            } else {
                                                echo $this->categoryview[$i]->title;
                                            } ?></a>
                                                </div>
<!--                                                <span class="video-info">
                                               <a href="index.php?option=com_contushdvideoshare&view=category&<?php echo $categoryCategoryVal; ?>"><?php echo $this->categoryview[$i]->category; ?></a>
                                                </span>-->
                                        <?php if ($dispenable['ratingscontrol'] == 1)
                                               { ?> <?php
                                                    if (isset($this->categoryview[$i]->ratecount) && $this->categoryview[$i]->ratecount != 0)
                                                    {
                                                        $ratestar = round($this->categoryview[$i]->rate / $this->categoryview[$i]->ratecount);
                                                    }
                                                    else
                                                    {
                                                        $ratestar = 0;
                                                    } ?>
                                                    <div class="ratethis1 <?php echo $ratearray[$ratestar]; ?> "></div>
                                                
                                          <?php } ?>

                                                <?php if ($dispenable['viewedconrtol'] == 1)
                                                       {
 ?>

                                                        <span class="floatright viewcolor"><?php echo $this->categoryview[$i]->times_viewed; ?> <?php echo JText::_('HDVS_VIEWS'); ?></span>
                                                        <?php } ?>
                                                   </div>
                                            </li>
                            <?php } ?>
                                        <!--First row-->
                                                <?php
                                                if ($colcount == 0)
                                                {
                                                    echo '</ul>';
                                                    $current_column = 0;
                                                }
                                                $current_column++;
					                           }
								            }
								            }
 ?>

                                        </div>
              <!--Tooltip Starts Here-->
                      <?php
                      for ($i = 0; $i < $totalrecords; $i++)
                                      { ?>
                                          <div class="htmltooltip">
                                              <?php if($this->categoryview[$i]->description) {?>
                                             <p class="tooltip_discrip"><?php echo JHTML::_('string.truncate', (strip_tags($this->categoryview[$i]->description)), 120); ?></p>
                                             <?php }?>
                                             <div class="tooltip_category_left">
                                                 <span class="title_category"><?php echo  JText::_('HDVS_CATEGORY');?>: </span>
                                                 <span class="show_category"><?php echo $this->categoryview[$i]->category; ?></span>
                                             </div>
                                             <?php if ($dispenable['viewedconrtol'] == 1) { ?>
                                            <div class="tooltip_views_right">
                                                 <span class="view_txt"><?php echo JText::_('HDVS_VIEWS'); ?>: </span>
                                                 <span class="view_count"><?php echo $this->categoryview[$i]->times_viewed; ?> </span>
                                             </div>
                                             <div id="htmltooltipwrapper<?php echo $i; ?>">
                                                 <div class="chat-bubble-arrow-border"></div>
                                               <div class="chat-bubble-arrow"></div>
                                             </div>
                                             <?php } ?>
                                           </div>
                                    <?php } ?>
             <!--Tooltip ends and PAGINATION STARTS HERE -->
                                            <ul class="hd_pagination">
                                            <?php
                                            if (isset($this->categoryview['pageno']))
                                              {
                                                $q = $this->categoryview['pageno'] - 1;
                                                if ($this->categoryview['pageno'] > 1)
                                                    echo("<li><a onclick='changepage($q);'>" . JText::_('HDVS_PREVIOUS') . "</a></li>");
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
                                                if($this->categoryview['pages']>1){
                                                for ($i = $page, $j = 1; $i <= $this->categoryview['pages']; $i++, $j++)
                                                 {
                                                    if ($this->categoryview['pageno'] != $i)
                                                        echo("<li><a onclick='changepage(" . $i . ")'>" . $i . "</a></li>");
                                                    else
                                                        echo("<li><a onclick='changepage($i);' class='activepage'>$i</a></li>");
                                                    if ($j > 3)
                                                        break;
                                                }
                                                if ($i < $this->categoryview['pages'])
                                                 {
                                                    if ($i + 1 != $this->categoryview['pages'])
                                                        echo ("<li>...</li>");
                                                    echo("<li><a onclick='changepage(" . $this->categoryview['pages'] . ")'>" . $this->categoryview['pages'] . "</a></li>");
                                                }
                                                $p = $this->categoryview['pageno'] + 1;
                                                if ($this->categoryview['pageno'] < $this->categoryview['pages'])
                                                    echo ("<li><a onclick='changepage($p);'>" . JText::_('HDVS_NEXT') . "</a></li>");}
                                            }
?>
                                        </ul>
                                     <!--  PAGINATION END HERE-->
                                <?php }
                                ?>
               </div>
         <?php if (JRequest::getVar('memberidvalue', '', 'post', 'int'))
                {
                      $memberidvalue = JRequest::getVar('memberidvalue', '', 'post', 'int');
                }
                $memberidvalue=isset($memberidvalue)?$memberidvalue:'';
          ?>
        <form name="memberidform" id="memberidform" action="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=membercollection'); ?>" method="post">
            <input type="hidden" id="memberidvalue" name="memberidvalue" value="<?php echo $memberidvalue; ?>" />
        </form>
        <?php
        $page = $_SERVER['REQUEST_URI'];
        $hiddensearchbox = $searchtextbox = $hidden_page = '';
        $searchtextbox = JRequest::getVar('searchtxtbox', '', 'post', 'string');
        $hiddensearchbox = JRequest::getVar('hidsearchtxtbox', '', 'post', 'string');
        if($requestpage)
        {
            $hidden_page = $requestpage;
        }
        else
        {
            $hidden_page = '';
        }
        if($searchtextbox)
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

        