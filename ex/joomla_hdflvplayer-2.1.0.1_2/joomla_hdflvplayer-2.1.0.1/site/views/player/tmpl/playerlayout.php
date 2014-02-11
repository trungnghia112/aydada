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

// No Direct Access
defined('_JEXEC') or die('Restricted access');
//Add player.css stylesheet
$doc = JFactory::getDocument();
$this->language = $doc->language;
$this->direction = $doc->direction;
if ($this->direction == 'rtl') {
    $doc->addStyleSheet(JURI::base() . 'components/com_hdflvplayer/css/player_rtl.css');
}
$doc->addStyleSheet(JURI::base() . 'components/com_hdflvplayer/css/player.css');

if ((!version_compare(JVERSION, '1.6.0', 'ge')) && !(version_compare(JVERSION, '1.7.0', 'ge'))) {
     $doc->addScript(JURI::base() . 'components/com_hdflvplayer/js/mootools-core.js');
     $doc->addScript(JURI::base() . 'components/com_hdflvplayer/js/mootools-more.js');
}
$compid = $id = $comp_videoid = 0;
 $id = JRequest::getvar('id', '', 'get', 'int');
 if (version_compare(JVERSION, '3.0.0', 'ge')){
     $id = JRequest::getvar('id');
 }
 $languages = '';
$basepath = JURI::base();

//source path
$src_path=null;

//Get Video details
$details = $this->detail;

//Get Settings
$settings = $this->settings;
$player_values = unserialize($settings->player_values );
$player_icons = unserialize($settings->player_icons );
$player_width = $player_values['width'];
$player_height = $player_values['height'];
//echo "<pre>";print_r($player_values);exit;
$width = $player_width - 2;
$height = $player_height - 2;

// language filter option:
$language = JRequest::getVar('lang');
if ($language != '') {
    $language = '&lang=' . $language;
    $languages = '&jlang=' . JRequest::getVar('lang');
}
$app = JFactory::getApplication();
$router = $app->getRouter();
$sefURL = $router->getMode();
if ($sefURL == 1) {
    $language = JRequest::getVar('lang');
    if ($language != '') {
        $languages = '&slang=' . JRequest::getVar('lang');
    }
}
if($details['rs_title'])
{
$doc->addCustomTag('<meta property="og:title" content="'.$details['rs_title']->title.'"/>');
$doc->addCustomTag('<meta property="og:type" content="article"/>');
$doc->addCustomTag('<meta property="og:url" content="'.$_SERVER['REQUEST_URI'].'"/>');
$doc->addCustomTag('<meta property="og:image" content="'.$details['rs_title']->thumburl.'"/>');
$doc->addCustomTag('<meta property="og:site_name" content="'.$details['rs_title']->title.'"/>');
$doc->addCustomTag('<meta property="og:description" content="'.strip_tags($details['rs_title']->description).'"/>');
}
?>
<?php
//Script for Google Analytics
if ($player_values['googleanalyticsID'] == 1) {
?>

    <script type="text/javascript">
        var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
        document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));

        var pageTracker = _gat._getTracker("<?php echo $player_values['googleanalyticsID']; ?>");
        pageTracker._trackPageview();
        pageTracker._trackEvent();
    </script>

<?php } ?>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.2.min.js"></script>
<script type="text/javascript">

    var baseURL='<?php echo JURI::base() ?>';
    var playlistid;
   function playlistname()
    {

        var itemid= <?php $Itemid = JRequest::getInt('Itemid','', 'get'); if(isset($Itemid)) echo $Itemid; else echo '0'; ?>;
        playlistid = document.getElementById("playlistid").value;
       var xmlhttp;
if (window.XMLHttpRequest) {  xmlhttp=new XMLHttpRequest();  }
else { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
xmlhttp.onreadystatechange=function()
  { if (xmlhttp.readyState==4 && xmlhttp.status==200) { window.location.href = xmlhttp.responseText;  } }
  if(playlistid!=''){
xmlhttp.open("GET",baseURL+"index.php?option=com_hdflvplayer&view=player&format=ajax&task=ajaxredirects&Itemid="+itemid+"&compid="+playlistid,true);
        }
        else{
   xmlhttp.open("GET",baseURL+"index.php?option=com_hdflvplayer&view=player&format=ajax&task=ajaxredirects&Itemid="+itemid,true);
        }
xmlhttp.send();
    }
    function getvideoData(id,title,descr){
<?php if(empty($id)){  ?>
       var xmlhttp;
if (window.XMLHttpRequest) {  xmlhttp=new XMLHttpRequest();  }
else { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
xmlhttp.onreadystatechange=function()
  { if (xmlhttp.readyState==4 && xmlhttp.status==200) { } }
xmlhttp.open("GET","index.php?option=com_hdflvplayer&task=addview&thumbid="+id,true);
xmlhttp.send();
<?php } ?>
           if(document.getElementById('titletxt')!=null)
    	      document.getElementById('titletxt').innerHTML=title;
               if(document.getElementById('descriptiontxt') != null)
                        {
                           if (descr !='' && descr != undefined )
                                document.getElementById('descriptiontxt').innerHTML = descr;
                            else if(descr == undefined)
                                document.getElementById('descriptiontxt').innerHTML = "";
                        }
    }
</script>
<?php
$params = JComponentHelper::getParams('com_hdflvplayer');
$playlistnameid = $params->get('playlistnameid');
if (isset($playlistnameid)) {
	if ($playlistnameid != 0)
	$compid = $playlistnameid;
}

 $compid = JRequest::getvar('compid', '', 'get', 'int');
  if (version_compare(JVERSION, '3.0.0', 'ge')){
       $compid = JRequest::getvar('compid');
  }
 if($compid == '')
 {
     if($details['rs_title'])
     $comp_videoid = $details['rs_title']->playlistid;
 }
$n = count($details['rs_playlistname']);
if ($player_icons['playlist_dvisible'] == 1) {
	if ($n >= 1) {
		?>

<div style="float: right; margin-bottom: 10px;">

	<b> <?php echo JText::_('HDFLV_PLAYLISTNAME'); ?> </b>

        <select name="playlistid" id="playlistid" onchange="playlistname()" >

<option value="" id="" <?php if($compid != $row_play->id){ echo 'selected="selected"'; }?>>
			Select
		</option>
		<?php
		for ($i = 0; $i < $n; $i++) {
			$row_play = $details['rs_playlistname'][$i];
			?>
		<option value="<?php echo $row_play->id; ?>" id="<?php echo $row_play->id; ?>" <?php if($compid == $row_play->id){ echo 'selected="selected"'; }?>>
			<?php echo $row_play->name; ?>
		</option>
		<?php
		}
		?>
	</select>


</div>
<div style="clear: both;"></div>
	<?php
	}
}


//$playerpath = JRoute::_("index.php?option=com_hdflvplayer&task=player");
$playerpath=JURI::base()."components/com_hdflvplayer/hdflvplayer/hdplayer.swf";
if ($details['publish'] == '1' && $details['showaddc'] == '1') {
	$addheight = (int) $player_height - 30;
	if ($player_icons['title_ovisible'] == 1) {
		$height = $height + 27;
	}
       ?>
<script type="text/javascript" src="components/com_hdflvplayer/hdflvplayer/googleadds.js"></script>
        <div style="position:relative">
            <div id="lightm"  style="top:<?php echo $height - 88; ?>px; height:60px;position:absolute;display:none;left:0px!important; margin:0px 150px 0px;background:none !important;">
                <span id="divimgm" ><img alt="" id="closeimgm"  src="components/com_hdflvplayer/images/close.png" style="z-index: 10000000;width:48px;height:12px;cursor:pointer;position:absolute;top:-12px; " onclick="googleclose();"  /> </span>
                <iframe  height="60" width="234" scrolling="no" align="middle" id="IFrameName" src="" name="IFrameName" marginheight="0" marginwidth="0" frameborder="0"  ></iframe>
            </div>
        </div>
            <?php
                    $closeadd = $details['closeadd'];
                    $ropen = $details['ropen'];
?>

            <script language="javascript" type="text/javascript">
                var closeadd =  <?php echo $closeadd * 1000; ?>;
                var ropen = <?php echo $ropen * 1000; ?>;
            </script>

                <?php }
    if ($player_icons['title_ovisible'] == 1) {?>
    <h3 id="titletxt"></h3>
 <?php }
 $videoUrl = '';

if(!empty($details['rs_title']))
{
$videoUrl = $details['rs_title']->videourl;
}
 ?>
          <!-- HTML5 PLAYER START -->
<?php
function detect_mobile()
{
    $_SERVER['ALL_HTTP'] = isset($_SERVER['ALL_HTTP']) ? $_SERVER['ALL_HTTP'] : '';

    $mobile_browser = '0';

    $agent = strtolower($_SERVER['HTTP_USER_AGENT']);

    if(preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|iphone|ipad|ipod|android|xoom)/i', $agent))
        $mobile_browser++;

    if((isset($_SERVER['HTTP_ACCEPT'])) and (strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') !== false))
        $mobile_browser++;

    if(isset($_SERVER['HTTP_X_WAP_PROFILE']))
        $mobile_browser++;

    if(isset($_SERVER['HTTP_PROFILE']))
        $mobile_browser++;

    $mobile_ua = substr($agent,0,4);
    $mobile_agents = array(
                        'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
                        'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
                        'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
                        'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
                        'newt','noki','oper','palm','pana','pant','phil','play','port','prox',
                        'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
                        'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
                        'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
                        'wapr','webc','winw','xda','xda-'
                        );

    if(in_array($mobile_ua, $mobile_agents))
        $mobile_browser++;

    if(strpos(strtolower($_SERVER['ALL_HTTP']), 'operamini') !== false)
        $mobile_browser++;

    // Pre-final check to reset everything if the user is on Windows
    if(strpos($agent, 'windows') !== false)
        $mobile_browser=0;

    // But WP7 is also Windows, with a slightly different characteristic
    if(strpos($agent, 'windows phone') !== false)
        $mobile_browser++;

    if($mobile_browser>0)
        return true;
    else
        return false;
}
$mobile = detect_mobile();
   if($mobile === true){
        if(!empty($details['rs_title'])){
if ($this->homepageaccess == 'true') {
    if ($details['rs_title']->filepath == "File" || $details['rs_title']->filepath == "FFmpeg" || $details['rs_title']->filepath == "Url") {
        if ($details['rs_title']->filepath == "Url") {
            $video = $details['rs_title']->videourl;
        } else {
            $current_path = "components/com_hdflvplayer/videos/";
            $video = JURI::base() . $current_path . $details['rs_title']->videourl;
        }
    ?>

        <video id="video" src="<?php echo $video; ?>" width="<?php echo $player_width; ?>" height="<?php echo $player_height; ?>" autobuffer controls onerror="failed(event)">
            Html5 Not support This video Format.
        </video>
    <?php
    } elseif ($details['rs_title']->filepath == "Youtube") {

        if (preg_match('/www\.youtube\.com\/watch\?v=[^&]+/', $details['rs_title']->videourl, $vresult)) {

            $urlArray = explode("=", $vresult[0]);

            $videoid = trim($urlArray[1]);
        }
    ?>
<iframe width="<?php echo $player_width; ?>" height="<?php echo $player_height; ?>" src="http://www.youtube.com/embed/<?php echo $videoid; ?>" frameborder="0" allowfullscreen></iframe>
   <?php } 
   } else {
            ?>
                <div id="video" style="background-color:#000000;" >
                    <h3 style="color:#e65c00;vertical-align: middle;height:<?php echo $player_height; ?>px;display: table-cell;width:<?php echo $player_width; ?>px; ">Please login to watch this video.</h3>
                </div>
<?php }
   } else {
            ?>
                <div id="video" style="background-color:#000000;" >
                    <h3 style="color:#e65c00;vertical-align: middle;height:<?php echo $player_height; ?>px;display: table-cell;width:<?php echo $player_width; ?>px; ">There are no videos in this playlist</h3>
                </div>
<?php }
   
        } else {
       if (preg_match('/vimeo/', $videoUrl, $vresult)) {

            $split = explode("/",$details['rs_title']->videourl); ?>
    <script type="text/javascript">
            window.onload = function(){
            var videodetails=new Array();
            videodetails['id']='<?php echo $details['rs_title']->id; ?>';

            videodetails['title']='<?php echo $details['rs_title']->title; ?>';

            videodetails['description']='<?php echo $details['rs_title']->description; ?>';


            currentvideo(videodetails['id'],videodetails['title'],videodetails['description']);
        }
      </script>

          <iframe src="<?php echo 'http://player.vimeo.com/video/'.$split[3].'?title=0&amp;byline=0&amp;portrait=0';?>" width="<?php echo $player_width; ?>" height="<?php echo $player_height; ?>" frameborder="0"></iframe>

    <?php    } else {
 ?>


<div class="HDFLVPlayer1" id="HDFLVPlayer1" >

        <embed wmode="opaque" src="<?php echo $playerpath; ?>"
               type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true"
               flashvars="baserefJ=<?php echo $details['baseurl']; if ($compid != 0) { echo "&amp;compid=$compid"; if ($id){ echo "&amp;id=" . $id; }} else { echo "&amp;id=" . $details['thumbid']; } if ($languages != '') { echo $languages; } ?>"
               width="<?php echo $player_width; ?>" height="<?php echo $player_height; ?> " />
       
</div>
 <?php }
   }
?>

<!--   HTML5 PLAYER ENDS -->

<!-- Description displays here-->
<?php

    //Checks for description enabled or not
    if ($player_icons['description_ovisible'] == 1) {
        $motpath = JURI::base();

?>
        <div id="content-pane" class="pane-sliders" style="width:<?php echo $width;?>px">
            <div class="panel1 selectyourhost">
                <div class="yourhost clearfix" >
                    <p class="floatleft" style="margin:0px;padding-top:7px; color: #333;">
                        <b style="padding:8px;"><?php echo JText::_('HDFLV_DESCR'); ?>
                        </b>
                    </p>
                    <div style="float:right; ">
                    </div>
                </div>
                <span style="clear:both;"> </span>
                <div class="jpane-slider content">
                    <div id="descriptiontxt" style="padding:5px; font-weight: bold;">
<?php if(!empty($details['rs_title'])){ echo trim($details['rs_title']->description); }?>
            </div>
        </div>
    </div>
</div>

<?php
    }

    $page = 1;
    $pageno = 1;
    $pageno = (int)JRequest::getvar('page');

    if ($pageno)
    {
        $page = $pageno;
    }
    else
    {
        $page=1;
    }

    $itemid = '';
    $itemid = JRequest::getvar('compid', '', 'get', 'var');
    $title_url = '';



        $totalrecords = count($details['rs_playlist']);
        if ($player_values['related_videos'] == "1" || $player_values['related_videos'] == "4") {

            if ((($player_values['nrelated']) > 0 ) && ($totalrecords > 0)) {
                echo '<div class="relatedvideos" style="width:' . $width . 'px;">';
                echo "<h3>" . JText::_('HDFLV_RELATEDVIDEOS') . "</h3>";

?>
               <div class="hd_related_vid" style="">

    <?php
                $totalrecords = count($details['rs_playlist']);
                if($width < 300)
                {
               $no_of_columns = 1;
                }
             	else if(($width > 300) && ($width < 400))
                {
                $no_of_columns = 3;
                 }
                else if(($width > 400) && ($width < 600))
                {
                $no_of_columns = 3;
                 }
                 else if(($width > 600) && ($width < 700))
                 {
                 $no_of_columns = 4;
                 }
                else
                {
                	$no_of_columns = 5;
                }
                $current_column = 1;
                for ($i = 0; $i < $totalrecords; $i++) {
                    $colcount = $current_column % $no_of_columns;

                    if ($details['rs_playlist'][$i]->filepath == "File" || $details['rs_playlist'][$i]->filepath == "FFmpeg")
                        $src_path = "components/com_hdflvplayer/videos/" . $details['rs_playlist'][$i]->thumburl;
                    else if ($details['rs_playlist'][$i]->filepath == "Url" || $details['rs_playlist'][$i]->filepath == "Youtube")
                        $src_path = trim($details['rs_playlist'][$i]->thumburl);
                    else
                        $src_path = "components/com_hdflvplayer/images/glow1.png";
                    if ($colcount == 1) {
    ?>
                    <ul>
        <?php
                    }
                    $title_string = "";
                    $get_words = "";
                    $title = "";
                    $cnt_words = "";
                    $cnt_words1 = "";


                    $title_string = $details['rs_playlist'][$i]->title;
                    $get_words = explode(' ', $title_string);
                    $cnt_words = count($get_words);
                    ($cnt_words > 7) ? $cnt_words1 = 7 : $cnt_words1 = $cnt_words;



                    for ($w = 0; $w < $cnt_words1; $w++) {
                        $title = $title . ' ' . $get_words[$w];
                    }
                    $title_url = str_replace(' ', '-', trim($details['rs_playlist'][$i]->title));
                    $title_url = str_replace('#', '', $title_url);
        ?>
                    <li>

                        <div>
                        <?php
                        if ($compid != 0 & $itemid != '') {

                              $urlString = "index.php?option=com_hdflvplayer&compid=$compid";
                      }
                          else if($compid != 0){
                           $urlString = "index.php?option=com_hdflvplayer&compid=$compid";
                          }
                          else{
                              $urlString = "index.php?option=com_hdflvplayer";
                          }
                        ?>
                            <a class="thumbimage" href="<?php echo JRoute::_( $urlString.'&amp;title='.$title_url. '&amp;id=' . $details['rs_playlist'][$i]->id .'&amp;page='.$page ); ?>">
                      <img alt="sourcepath" src="<?php echo $src_path; ?>" width="120" height="70" style="height: 70px !important"  />
                        </a>
                    </div>

            <div class="hd_video_content">

            <div style=" ">
                <a  style="text-decoration : none;" href="<?php echo JRoute::_( $urlString.'&amp;title='.$title_url. '&amp;id=' . $details['rs_playlist'][$i]->id .'&amp;page='.$page ); ?>"> <?php if (strlen($details['rs_playlist'][$i]->title) > 15) {
                        $subTitle = substr($details['rs_playlist'][$i]->title, 0, 25);
                    } else {
                        $subTitle = $details['rs_playlist'][$i]->title;
                    } echo $subTitle; ?>
                </a>
           </div>

            <!-- Videos View count,Category Displays here -->
                <?php

                ?>

                    <div style=" ">
                <?php


                        $details['rs_playlistname'][$i] = isset($details['rs_playlistname'][$i]) ? $details['rs_playlistname'][$i] : '';
                        $details['rs_playlist'][$i]->playlistid = isset($details['rs_playlist'][$i]->playlistid) ? $details['rs_playlist'][$i]->playlistid : '';

                        $details['rs_playlist'][$i]->name = isset($details['rs_playlist'][$i]->name) ? $details['rs_playlist'][$i]->name : '';
                       if ($player_icons['viewed_visible'] == 1) {
                        echo '<span class="video-info">' .JText::_( 'HDFLV_VIEWED' )." : " . $details['rs_playlist'][$i]->times_viewed . '</span>';
                         }
                        $p = count($details['rs_playlistname']);

                        for ($m = 0; $m < $p; $m++) {
                            $categoryVideo = $details['rs_playlistname'][$m];
                            $categoryVideo->id = isset($categoryVideo->id) ? $categoryVideo->id : '';
                            if ($categoryVideo->id) {
                                $details['rs_playlist'][$i]->playlistid = isset($details['rs_playlist'][$i]->playlistid) ? $details['rs_playlist'][$i]->playlistid : '';

                                if ($details['rs_playlist'][$i]->playlistid == $categoryVideo->id) {
                                        $subTitle = $categoryVideo->name;

                                    echo '<span class="video-info">' . $subTitle . '</span>';
                                    break;
                                }
                            }
                        }
                ?>
                </div>

            </div>
                        </li>
 <?php
                    if ($colcount == 0) {
    ?>
                        </ul>
<?php
                        $current_column = 0;
                    }

                    $current_column++;
                }
                echo '</ul>';
                if ($current_column != 0) {
                    $rem_columns = $no_of_columns - $current_column + 1; ?>

<?php }
?>
                </div>

<?php
echo '</div><div style="clear: both;"></div>';
            }
        }



?>
<?php
if ($player_values['related_videos'] == "1" || $player_values['related_videos'] == "4") { ?>
        <!-- Pagination here -->
<table id="pagination" >

    <tr >
        <td   >
            <table >
                <tr>
                    <?php
                    //Pagination coding
                    $pageno = (int)JRequest::getvar('page');


                    if ($page)
                    {
                        $page = $page;
                    }
                    else
                    {
                        $page=1;
                    }


                    if (empty($page)) {
                        $page = 1;
                    }
                    if ($page > 1) {
                        $pageprev = $page - 1;

                        echo("<td style='text-align:right'><a href=\"$urlString&page=$pageprev\">".JText::_('HDFLV_PREVIOUS')."</a></td>");
                    }
                    $numofpages = ceil($details['total'] / $details['length']);

                    $title = '';

                    if ($numofpages > 1) {

                        for ($i = 1; $i <= $numofpages; $i++) {
                            if ($page == $i)
                            {

                                echo("<td style='width:13px;text-align:center;color:#ffffff; font-size:11px; background-color:#6699ff;'><a href=\"$urlString&page=$i\">$i</a></td>");
                            }
                            else {
                                $title = trim($title);

                                echo("<td style='text-align:right'><a href=\"$urlString&page=$i\">$i</a></td>");
                            }
                        }
                        if ($page < $numofpages) {
                            $pagenext = ($page + 1);

                            echo ("<td style='text-align:right;float:left'><a href=\"$urlString&page=$pagenext\">".JText::_('HDFLV_NEXT')."</a></td>");
                        }
                    }
 else {
     $doc = JFactory::getDocument();
$style = '#pagination
     {
         display: none;
      }';
$doc->addStyleDeclaration( $style );

echo "<td>&nbsp;</td>";
  }
                    ?>
                             </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
<div style="clear: both;"></div>
        <?php } ?>
                    <!-- Component Ends-->

