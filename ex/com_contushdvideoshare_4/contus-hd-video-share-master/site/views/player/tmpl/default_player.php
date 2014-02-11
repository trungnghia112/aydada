<?php
/**
 * @name          : Joomla HD Video Share
 * @version	  : 3.4.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component Hdvideoshare Player View
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */
## No direct acesss
defined('_JEXEC') or die('Restricted access');
## Varaiable decalation and assign values
$user               = JFactory::getUser();
$details1           = $this->detail;
$player_values      = unserialize($details1[0]->player_values);
$player_icons       = unserialize($details1[0]->player_icons);
$video_title        = $video_desc = $video_thumb = $memberidvalue = '';
$playerpath         = JURI::base() . "components/com_contushdvideoshare/hdflvplayer/hdplayer.swf";
$document           = JFactory::getDocument();
$thumbview          = unserialize($this->homepagebottomsettings[0]->homethumbview);
$dispenable         = unserialize($this->homepagebottomsettings[0]->dispenable);
$facebookapi        = $dispenable['facebookapi'];
$htmlVideoDetails   = $this->htmlVideoDetails;
## Get detail for Meta Information
if (isset($this->htmlVideoDetails) && $this->htmlVideoDetails != '') {
    if ($this->htmlVideoDetails->filepath == "File" || $this->htmlVideoDetails->filepath == "FFmpeg" || $this->htmlVideoDetails->filepath == "Embed") {
        $current_path       = "components/com_contushdvideoshare/videos/";
        $video_url          = JURI::base() . $current_path . $this->htmlVideoDetails->videourl;
        $video_thumb        = JURI::base() . $current_path . $this->htmlVideoDetails->thumburl;
        $video_preview      = JURI::base() . $current_path . $this->htmlVideoDetails->previewurl;
    } elseif ($this->htmlVideoDetails->filepath == "Youtube") {
        if(strpos($this->htmlVideoDetails->videourl,'youtube') > 0) { 
            $imgstr         = explode("v=", $this->htmlVideoDetails->videourl);
            $imgval         = explode("&", $imgstr[1]);
            $video_thumb    = "http://i3.ytimg.com/vi/$imgval[0]/mqdefault.jpg";
            $video_url      = $this->htmlVideoDetails->videourl;
            $video_preview  = "http://i3.ytimg.com/vi/$imgval[0]/maxresdefault.jpg";
        } else if (strpos($this->htmlVideoDetails->videourl, 'dailymotion') > 0 || strpos($this->htmlVideoDetails->videourl, 'viddler') > 0) {
            $video_url      = $this->htmlVideoDetails->videourl;
            $video_thumb    = $this->htmlVideoDetails->thumburl;
            $video_preview  = $this->htmlVideoDetails->previewurl;
        }
    } else {
        $video_url          = $this->htmlVideoDetails->videourl;
        $video_thumb        = $this->htmlVideoDetails->thumburl;
        $video_preview      = $this->htmlVideoDetails->previewurl;
    }
}
$instance                   = JURI::getInstance();
## Get site name from global configuration
$config                     = JFactory::getConfig();
if (version_compare(JVERSION, '3.0.0', 'ge')) {
    $siteName               = $config->get('config.sitename');
} else {
    $siteName               = $config->getValue('config.sitename');
}
$document->addScript(JURI::base() . 'components/com_contushdvideoshare/js/autoHeight.js');
$document->addScript(JURI::base() . 'components/com_contushdvideoshare/js/popup.js');
## Meta Information
if (!empty($this->videodetails) && $this->videodetails->id) {
    $document->setTitle($this->htmlVideoDetails->title);
    $document->setMetaData("keywords", $this->htmlVideoDetails->tags);
    $document->setDescription(strip_tags($this->htmlVideoDetails->description));
}

if (!empty($this->htmlVideoDetails->title)){
    $video_title            = $this->htmlVideoDetails->title;
}
if (!empty($this->htmlVideoDetails->description)){
    $video_desc             = $this->htmlVideoDetails->description;
}
## Fb Share og detail
$document->addCustomTag('<link rel="image_src" href="' . $video_thumb . '"/>');
$document->addCustomTag('<meta property="fb:app_id" content="' . $facebookapi . '"/>');
$document->addCustomTag('<meta property="og:site_name" content="' . $siteName . '"/>');
$document->addCustomTag('<meta property="og:type" content="website"/>');
$document->addCustomTag('<meta property="og:url" content="' . $instance->toString() . '"/>');
$document->addCustomTag('<meta property="og:title" content="' . $video_title . '"/>');
$document->addCustomTag('<meta property="og:description" content="' . strip_tags($video_desc) . '"/>');
$document->addCustomTag('<meta property="og:image" content="' . $video_thumb . '"/>');

$style = '#face-comments iframe{width:  ' . $player_values['width'] . 'px !important; }
#video-grid-container .ulvideo_thumb .popular_gutterwidth{margin-left:' . $thumbview['homepopularvideowidth'] . 'px; }
#video-grid-container .ulvideo_thumb .featured_gutterwidth{margin-left:' . $thumbview['homefeaturedvideowidth'] . 'px; }
#video-grid-container .ulvideo_thumb .recent_gutterwidth{margin-left:' . $thumbview['homerecentvideowidth'] . 'px; }
#video-grid-container_pop .ulvideo_thumb .popular_gutterwidth{margin-left:' . $thumbview['homepopularvideowidth'] . 'px; }
#video-grid-container_pop .ulvideo_thumb .featured_gutterwidth{margin-left:' . $thumbview['homefeaturedvideowidth'] . 'px; }
#video-grid-container_pop .ulvideo_thumb .recent_gutterwidth{margin-left:' . $thumbview['homerecentvideowidth'] . 'px; }
#video-grid-container_rec .ulvideo_thumb .popular_gutterwidth{margin-left:' . $thumbview['homepopularvideowidth'] . 'px; }
#video-grid-container_rec .ulvideo_thumb .featured_gutterwidth{margin-left:' . $thumbview['homefeaturedvideowidth'] . 'px; }
#video-grid-container_rec .ulvideo_thumb .recent_gutterwidth{margin-left:' . $thumbview['homerecentvideowidth'] . 'px; }';
$document->addStyleDeclaration($style);
?>
<script src="http://connect.facebook.net/en_US/all.js#xfbml=1" type="text/javascript"></script>
<input type="hidden" name="category" value="<?php if (isset($this->videodetails->playlistid)) { echo $this->videodetails->playlistid; } ?>" id="category"/>
<input type="hidden" value="<?php if (isset($this->videodetails->id)) { echo $this->videodetails->id; } ?>" name="videoid" id="videoid"/>
<script type="text/javascript">
    function submitform()
    {
        document.myform.submit();
    }
</script>
<!--Login and Registration form-->
<form name="myform" action="" method="post" id="login-form1">
    <div class="logout-button">
        <input type="hidden" name="option" value="com_users" />
        <input type="hidden" name="task" value="user.logout" />
<?php echo JHtml::_('form.token'); ?>
    </div>
</form>
<?php
## Google analytics code
if ($player_icons['googleana_visible'] == 1) {
    ?>
    <script type="text/javascript">
        var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
        document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
        var pageTracker = _gat._getTracker("<?php echo $player_values['googleanalyticsID']; ?>");
        pageTracker._trackPageview();
        pageTracker._trackEvent();
    </script>
<?php } ?>
<script type="text/javascript">
    function loadifr()
    {
        ev = document.getElementById('myframe1');
        if (ev != null)
        {
            setHeight(ev);
            addEvent(ev, 'load', doIframe);
        }
    }
    window.onload = function()
    {
<?php if (isset($this->videodetails->id)) { ?>
            setInterval("loadifr()", 500);
<?php } ?>
    }
</script>
<?php
## Login and Registration links
if (USER_LOGIN == '1') {
    if ($user->get('id') != '') {
        ?>
        <div class="toprightmenu">
            <a href="index.php?option=com_contushdvideoshare&amp;view=myvideos"><?php echo JText::_('HDVS_MY_VIDEOS'); ?></a> |
            <?php
            if (version_compare(JVERSION, '1.6.0', 'ge')) {
                ?>
                <a href="javascript: submitform();"><?php echo JText::_('HDVS_LOGOUT'); ?></a>
            <?php } else {
                ?>
                <a href="index.php?option=com_user&amp;task=logout"><?php echo JText::_('HDVS_LOGOUT'); ?></a>
            <?php
        }
        ?>
        </div>

        <?php
    } else {
        if (version_compare(JVERSION, '1.6.0', 'ge')) {
            $register_url = "index.php?option=com_users&amp;view=registration";
            $login_url = "index.php?option=com_users&amp;view=login";
        } else {
            $register_url = "index.php?option=com_user&amp;view=register";
            $login_url = "index.php?option=com_user&amp;view=login";
        }
        ?>
        <div class="toprightmenu">
            <a href="<?php echo $register_url; ?>"><?php echo JText::_('HDVS_REGISTER'); ?></a> |
            <a  href="<?php echo $login_url; ?>"> <?php echo JText::_('HDVS_LOGIN'); ?></a>
        </div>
        <?php
    }
}
    ## Detect mobile device
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

            ## Pre-final check to reset everything if the user is on Windows
            if(strpos($agent, 'windows') !== false)
                $mobile_browser=0;

            ## But WP7 is also Windows, with a slightly different characteristic
            if(strpos($agent, 'windows phone') !== false)
                $mobile_browser++;

            if($mobile_browser>0)
                return true;
            else
                return false;
        }
?>
<div class="fluid bg playerbg clearfix" id="player_page" >
    <div id="HDVideoshare1" style="position:relative;   " class="clearfix">
        <h1 id="viewtitle" class="floatleft" style="" ><?php if (isset($this->htmlVideoDetails->title)) echo $this->htmlVideoDetails->title; ?></h1>
        <div class="clear"></div>
        
        <?php
        $mobile = detect_mobile();
        if (!empty($this->videodetails) && ($this->videodetails->id) && ($this->videodetails->playlistid)) {
            $baseref    = '&amp;id=' . $this->videodetails->id . '&amp;catid=' . $this->videodetails->playlistid;
        } else if (!empty($this->videodetails) && $this->videodetails->id) {
            $baseref    = '&amp;id=' . $this->videodetails->id;
        } else {
            $baseref    = '&amp;featured=true';
        }
        $adminview = JRequest::getString('adminview');              ## For Admin preview popup
        if ($adminview == true) {
            $baseref    .= '&amp;adminview=true';
        }
        ?>
        <?php
        if ($htmlVideoDetails->filepath == 'Embed') {
               $playerembedcode = $htmlVideoDetails->embedcode;
               $playeriframewidth =  str_replace('width=', 'width="'.$player_values['width'].'"', $playerembedcode);
               if($mobile === true){
                   echo $playerembedcode;
               } else {   
               ?>
        <div id="flashplayer">
                 <?php  echo str_replace('height=', 'height="'.$player_values['height'].'"', $playeriframewidth); ?>
                   </div>
                    <?php 
               }## For embed code videos
        } else if (!empty($htmlVideoDetails) && (preg_match('/vimeo/', $htmlVideoDetails->videourl)) && ($htmlVideoDetails->videourl != '')) {
            $split = explode("/", $htmlVideoDetails->videourl);     ## For vimeo videos
            if($mobile === true){
                   $widthheight = '';
               } else {
                   $widthheight = 'width="'.$player_values['width'].'" height="'.$player_values['height'].'"';
               }
            ?>
        <div id="flashplayer">
            <iframe <?php echo $widthheight; ?> src="<?php echo 'http://player.vimeo.com/video/' . $split[3] . '?title=0&amp;byline=0&amp;portrait=0'; ?>"  class="iframe_frameborder"></iframe>
        </div>
<?php } else if (!empty($this->videodetails) && (preg_match('/vimeo/', $this->videodetails->videourl)) && ($this->videodetails->videourl != '')) {
            $split = explode("/", $this->videodetails->videourl);   ## For vimeo videos
    ?>
        <div id="flashplayer">
            <iframe src="<?php echo 'http://player.vimeo.com/video/' . $split[3] . '?title=0&amp;byline=0&amp;portrait=0'; ?>" width="<?php echo $player_values['width']; ?>" height="<?php echo $player_values['height']; ?>" class="iframe_frameborder"></iframe>
        </div>
<?php } else {
                        if($mobile === true){
    ?>
             <!-- HTML5 player starts here -->
            <div id="htmlplayer">
                <?php
                ## Generate details for HTML5 player
                if ($this->homepageaccess == 'true') {
                    if ($htmlVideoDetails->filepath == "File" || $htmlVideoDetails->filepath == "FFmpeg" || $htmlVideoDetails->filepath == "Url") {
                        $current_path       = "components/com_contushdvideoshare/videos/";
                        if ($htmlVideoDetails->filepath == "Url") {                             ## For URL Method videos
                            if ($htmlVideoDetails->streameroption == 'rtmp') {
                                $rtmp       = str_replace('rtmp', 'http', $htmlVideoDetails->streamerpath);
                                $video      = $rtmp . '_definst_/mp4:'. $htmlVideoDetails->videourl . '/playlist.m3u8';   ## For RTMP videos
                            } else {
                                $video      = $htmlVideoDetails->videourl;
                            }
                        } else {
                            $video          = JURI::base() . $current_path . $htmlVideoDetails->videourl;   ## For upload Method videos
                        }
                        ?>
                        <video id="video" src="<?php echo $video; ?>" width="<?php echo $player_values['width']; ?>" height="<?php echo $player_values['height']; ?>" autobuffer controls onerror="failed(event)">
                            Html5 Not support This video Format.
                        </video>
                            <?php
                        } elseif ($htmlVideoDetails->filepath == "Youtube") {                   ## For youtube videos
                            if (preg_match('/www\.youtube\.com\/watch\?v=[^&]+/', $htmlVideoDetails->videourl, $vresult)) {
                                $urlArray = explode("=", $vresult[0]);
                                $videoid = trim($urlArray[1]);
                                $video = "http://www.youtube.com/embed/$videoid";
                            ?>
                            <iframe width="<?php echo $player_values['width']; ?>" height="<?php echo $player_values['height']; ?>" src="<?php echo $video; ?>" class="iframe_frameborder" ></iframe>
                            <?php
                        } else if (strpos($htmlVideoDetails->videourl, 'dailymotion') > 0) {    ## For dailymotion videos
                            $video = $htmlVideoDetails->videourl;
                            ?>
                            <iframe width="<?php echo $player_values['width']; ?>" height="<?php echo $player_values['height']; ?>" src="<?php echo $video; ?>" class="iframe_frameborder" ></iframe>
                            <?php
                        } else if (strpos($htmlVideoDetails->videourl, 'viddler') > 0) {        ## For viddler videos
                            $imgstr = explode("/", $htmlVideoDetails->videourl);
                            ?>
                            <iframe id="viddler-<?php echo $imgstr; ?>" src="//www.viddler.com/embed/<?php echo $imgstr; ?>/?f=1&autoplay=0&player=full&secret=26392356&loop=false&nologo=false&hd=false" width="<?php echo $player_values['width']; ?>" height="<?php echo $player_values['height']; ?>" frameborder="0" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>
                <?php
            }
        }
    } else {               ## Restricted video design part 
        ?>
                            <style type="text/css">
                                .login_msg{vertical-align: middle;height:<?php echo $player_values['height']; ?>px;display: table-cell; color: #fff;}
                                .login_msg a{background: #999; color:#fff; padding: 5px;}
                            </style>
                            
                    <div id="video" style="height:<?php echo $player_values['height']; ?>px; background-color:#000000; position: relative;" >
                        <div class="login_msg">
                        <h3>Please login to watch this video</h3>
                        <a href="<?php if (!empty($player_icons['login_page_url'])) { echo $player_icons['login_page_url']; } else { echo "#"; } ?>"><?php echo JText::_('HDVS_LOGIN'); ?></a>
                    </div>
                    </div>
    <?php } ?>
            </div>
             
                        <?php } else { ?>
             
             <!-- Flash player Start -->
            <div id="flashplayer">
                <embed wmode="opaque" src="<?php echo $playerpath; ?>" type="application/x-shockwave-flash"
                       allowscriptaccess="always" allowfullscreen="true" flashvars="baserefJHDV=<?php echo $details1['baseurl']; ?><?php echo $baseref; ?>"  style="width:<?php echo $player_values['width']; ?>px; height:<?php echo $player_values['height']; ?>px" />
            </div>
                        <?php } ?>
            <!--Platform check-->
            <script type="text/javascript">
                var txt = navigator.platform;
                function failed(e)
                {
                    if (txt == 'iPod' || txt == 'iPad' || txt == 'iPhone' || windo == "Windows Phone" || txt == 'Linux armv7l' || txt == 'Linux armv6l')
                    {
                        alert('Player doesnot support this video.');
                    }
                }
            </script>
            <!-- HTML5 PLAYER  END -->
    <?php
}
## Display Google Adsense
if (isset($details1['publish']) == '1' && isset($details1['showaddc']) == '1' && $mobile !== true && $htmlVideoDetails->filepath != 'Embed') {
    ?>
            <div>
                <?php if($player_values['width']>468){
                    $adstyle = "margin-left: -234px;";
                } else { 
                    $margin_left = ($player_values['width']-100)/2;
                    $adwidth = $player_values['width']-100;
                    $adstyle = "width:".$adwidth."px;margin-left: -".$margin_left."px;";
                }
?>
            <div id="lightm"  style="<?php echo $adstyle; ?>height:76px;position:absolute;display:none;background:none !important;background-position: initial initial !important;background-repeat: initial initial !important;bottom: 50px;left: 50%;">
                <span id="divimgm" ><img alt="close" id="closeimgm"  src="components/com_contushdvideoshare/images/close.png" style="z-index: 10000000;width:48px;height:12px;cursor:pointer;top:-12px;" onclick="googleclose();"  /> </span>
                <iframe  height="60" width="<?php echo $player_values['width']-100; ?>" scrolling="no" align="middle" id="IFrameName" src="" name="IFrameName" marginheight="0" marginwidth="0" class="iframe_frameborder" ></iframe>
                    </div>
        </div>
            
            <script src="<?php echo JURI::base(); ?>components/com_contushdvideoshare/js/googlead.js" type="text/javascript"></script>
<?php } ?>
    </div>
</div>
<?php
if (isset($details1['closeadd'])) {
    $closeadd = $details1['closeadd'];
    $ropen = $details1['ropen'];
    ?>
    <script type="text/javascript">
                var closeadd = <?php echo $closeadd * 1000; ?>;
                var ropen = <?php echo $ropen * 1000; ?>;
    </script>
<?php } ?>
    <!--Rating starts here-->
<div id="rateid" class="ratingbg" >
    <div class="content_center clearfix" style="">
                <?php if ($dispenable['ratingscontrol'] == 1) {
                    ?>
            <div class="centermargin floatleft" >
                <div class="rateimgleft" id="rateimg" onmouseover="displayrating('');" onmouseout="resetvalue();" >
                    <div id="a" class="floatleft"></div>
                    <?php
                    if (isset($this->commentview[0]->ratecount) && $this->commentview[0]->ratecount != 0) {
                        $ratestar = round($this->commentview[0]->rate / $this->commentview[0]->ratecount);
                    } else {
                        $ratestar = 0;
                    }
                    ?>
                    <ul class="ratethis " id="rate" >
                        <li class="one" >
                            <a title="<?php echo JText::_('HDVS_ONE_STAR_RATING'); ?>"  onclick="getrate('1');"  onmousemove="displayrating('1');" onmouseout="resetvalue();">1</a>
                        </li>
                        <li class="two" >
                            <a title="<?php echo JText::_('HDVS_TWO_STAR_RATING'); ?>"  onclick="getrate('2');"  onmousemove="displayrating('2');" onmouseout="resetvalue();">2</a>
                        </li>
                        <li class="three" >
                            <a title="<?php echo JText::_('HDVS_THREE_STAR_RATING'); ?>"  onclick="getrate('3');"   onmousemove="displayrating('3');" onmouseout="resetvalue();">3</a>
                        </li>
                        <li class="four" >
                            <a  title="<?php echo JText::_('HDVS_FOUR_STAR_RATING'); ?>"  onclick="getrate('4');"  onmousemove="displayrating('4');" onmouseout="resetvalue();"  >4</a>
                        </li>
                        <li class="five" >
                            <a title="<?php echo JText::_('HDVS_FIVE_STAR_RATING'); ?>"  onclick="getrate('5');"  onmousemove="displayrating('5');" onmouseout="resetvalue();" >5</a>
                        </li>
                    </ul>
                    <input type="hidden" name="id" id="id" value="<?php
                    if (isset($this->videodetails->id) && $this->videodetails->id != '')
                        echo $this->videodetails->id; else if (isset($this->getfeatured->id) && $this->getfeatured->id != '')
                        echo $this->getfeatured->id;
                    ?>" />
                </div>
                <div class="rateright-views floatleft" >
                    <span  class="clsrateviews"  id="ratemsg" onmouseover="displayrating('');" onmouseout="resetvalue();"> </span>
                    <span  class="rightrateimg" id="ratemsg1" onmouseover="displayrating('');" onmouseout="resetvalue();">  </span>
                </div>
            </div>
<?php } ?>
        <!--Display video created date-->
        <div class="video_addedon">
            <b><?php if ($dispenable['viewedconrtol'] == 1) { ?>   <?php echo JText::_('HDVS_VIEWS'); ?> :</b> <span id="viewcount"><?php if (isset($this->htmlVideoDetails->times_viewed)) echo $this->htmlVideoDetails->times_viewed; ?></span> <?php } ?>
            <span class="addedon"><b><?php echo JText::_('HDVS_ADDED_ON'); ?> : </b></span><span id="createdate">
                <?php if (isset($this->htmlVideoDetails->created_date)) {
                    $created_on = date('j-M-Y', strtotime($this->htmlVideoDetails->created_date));
                echo $created_on; 
                }
                ?></span>
        </div>
    </div>
    <!-- Script for rating of the video starts here -->
    <script type="text/javascript">
            function ratecal(rating, ratecount)
            {
                if (rating == 1)
                    document.getElementById('rate').className = "ratethis onepos";
                else if (rating == 2)
                    document.getElementById('rate').className = "ratethis twopos";
                else if (rating == 3)
                    document.getElementById('rate').className = "ratethis threepos";
                else if (rating == 4)
                    document.getElementById('rate').className = "ratethis fourpos";
                else if (rating == 5)
                    document.getElementById('rate').className = "ratethis fivepos";
                else
                    document.getElementById('rate').className = "ratethis nopos";
                document.getElementById('ratemsg').innerHTML = "<span class='ratting_txt'><?php echo JText::_('HDVS_RATTING'); ?> :</span> " + ratecount;
            }
<?php if (isset($ratestar) && isset($this->commentview[0]->ratecount) && isset($this->commentview[0]->times_viewed)) { ?>
                ratecal('<?php echo $ratestar; ?>', '<?php echo $this->commentview[0]->ratecount; ?>', '<?php echo $this->commentview[0]->times_viewed; ?>');
<?php } ?>
            function createObject()
            {
                var request_type;
                var browser = navigator.appName;
                if (browser == "Microsoft Internet Explorer") {
                    request_type = new ActiveXObject("Microsoft.XMLHTTP");
                } else {
                    request_type = new XMLHttpRequest();
                }
                return request_type;
            }
            var http = createObject();
            var nocache = 0;
            function getrate(t)
            {
                if (t == '1')
                {
                    document.getElementById('rate').className = "ratethis onepos";
                    document.getElementById('a').className = "ratethis onepos";
                }
                if (t == '2')
                {
                    document.getElementById('rate').className = "ratethis twopos";
                    document.getElementById('a').className = "ratethis twopos";
                }
                if (t == '3')
                {
                    document.getElementById('rate').className = "ratethis threepos";
                    document.getElementById('a').className = "ratethis threepos";
                }
                if (t == '4')
                {
                    document.getElementById('rate').className = "ratethis fourpos";
                    document.getElementById('a').className = "ratethis fourpos";
                }
                if (t == '5')
                {
                    document.getElementById('rate').className = "ratethis fivepos";
                    document.getElementById('a').className = "ratethis fivepos";
                }
                document.getElementById('rate').style.display = "none";
                document.getElementById('ratemsg').innerHTML = "Thanks for rating!";
                var id = document.getElementById('id').value;
                nocache = Math.random();
                http.open('get', '<?php echo JURI::base(); ?>index.php?option=com_contushdvideoshare&amp;view=player&amp;tmpl=component&amp;id=' + id + '&amp;rate=' + t + '&amp;nocache = ' + nocache, true);
                http.onreadystatechange = insertReply;
                http.send(null);
                document.getElementById('rate').style.visibility = 'disable';
            }
            function insertReply()
            {
                if (http.readyState == 4)
                {
                    document.getElementById('ratemsg').innerHTML = "<span class='ratting_txt'><?php echo JText::_('HDVS_RATTING'); ?> : </span>" + http.responseText;
                    document.getElementById('rate').className = "";
                    document.getElementById('storeratemsg').value = http.responseText;
                }
            }

            function resetvalue()
            {
                document.getElementById('ratemsg1').style.display = "none";
                document.getElementById('ratemsg').style.display = "block";
                if (document.getElementById('storeratemsg').value == '') {
                    document.getElementById('ratemsg').innerHTML = "<span class='ratting_txt'><?php echo JText::_('HDVS_RATTING'); ?> :</span> <?php echo $this->commentview[0]->ratecount; ?>";
                } else {
                    document.getElementById('ratemsg').innerHTML = "<span class='ratting_txt'><?php echo JText::_('HDVS_RATTING'); ?> : </span> " + document.getElementById('storeratemsg').value;
                }
            }
            function displayrating(t)
            {
                if (t == '1')
                {
                    document.getElementById('ratemsg').innerHTML = "<?php echo JText::_('HDVS_POOR'); ?>";
                }
                if (t == '2')
                {
                    document.getElementById('ratemsg').innerHTML = "<?php echo JText::_('HDVS_NOTHING_SPECIAL'); ?>";
                }
                if (t == '3')
                {
                    document.getElementById('ratemsg').innerHTML = "<?php echo JText::_('HDVS_WORTH_WATCHING'); ?>";
                }
                if (t == '4')
                {
                    document.getElementById('ratemsg').innerHTML = "<?php echo JText::_('HDVS_PRETTY_COOL'); ?>";
                }
                if (t == '5')
                {
                    document.getElementById('ratemsg').innerHTML = "<?php echo JText::_('HDVS_AWESOME'); ?>";
                }
                document.getElementById('ratemsg1').style.display = "none";
                document.getElementById('ratemsg').style.display = "block";
            }
    </script>
    <!-- Script for rating of the video ends here -->
</div>
    <!--Social Sharing icons-->
<div class="clscenter" style="width:<?php echo $player_values['width']; ?>px;">
    <?php
        if (isset($this->commenttitle)) {
            foreach ($this->commenttitle as $row) {
                $mid = isset($row->memberid) ? $row->memberid : '';
                $row->username = isset($row->username) ? $row->username : '';
                if ($row->username != '') {
                    ?>
                <div class="viewsubname"><span class="uploadedby"><?php echo JText::_('HDVS_UPLOADED_BY'); ?> :</span>  <a  href="#" title="<?php echo $row->username; ?>" class="namelink cursor_pointer" onclick="membervalue('<?php echo $mid; ?>')" ><?php echo $row->username; ?></a></div><?php
                }
                ?><div class="clear"></div>
            <!-- Social sharing starts here -->
            <div class="sharing_vid clearfix">
                    <?php if ($dispenable['facebooklike'] == 1) {
                        $pageURL = str_replace('&', '%26', JURI::getInstance()->toString());
                        ?>
                    <div id="share_like">
                        <div id="fb-root" class="floatleft">
                            <div style="position: absolute; top: -10000px; height: 0px; width: 0px;"></div>
                        </div>
                        <?php
                        if (strpos($this->htmlVideoDetails->videourl, 'vimeo') > 0) {
                            $url_fb = "http://www.facebook.com/dialog/feed?app_id=19884028963&ref=share_popup&link=" . urlencode($this->htmlVideoDetails->videourl) . "&redirect_uri=" . urlencode($this->htmlVideoDetails->videourl) . "%3Fclose";
                        } else {
                            $url_fb = "http://www.facebook.com/sharer/sharer.php?s=100&amp;p%5Btitle%5D=" . $this->htmlVideoDetails->title . "&amp;p%5Bsummary%5D=" . strip_tags($this->htmlVideoDetails->description) . "&amp;p%5Bmedium%5D=103&amp;p%5Bvideo%5D%5Bwidth%5D=" . $player_values['width'] . "&amp;p%5Bvideo%5D%5Bheight%5D=" . $player_values['height'] . "&amp;p%5Bvideo%5D%5Bsrc%5D=" . urlencode($playerpath) . "%3Ffile%3D" . urlencode($video_url) . "%26embedplayer%3Dtrue%26share%3Dfalse%26HD_default%3Dtrue%26autoplay%3Dtrue%26skin_autohide%3Dtrue%26showPlaylist%3Dfalse%26id%3D" . $this->videodetails->id . "%26baserefJHDV%3D" . urlencode(JURI::base()) . "&amp;p%5Burl%5D=" . urlencode($pageURL) . "&amp;p%5Bimages%5D%5B0%5D=" . urlencode($video_thumb);
                        }
                        ?>
                        <!--Facebook Share icon-->
                        <a href="<?php echo $url_fb; ?>" class="fbshare" id="fbshare" target="_blank" ></a>
                        <!--Twitter Share icon-->
                        <div class="floatleft">
                            <a href="http://twitter.com/home?status=<?php echo $this->htmlVideoDetails->title; ?>:+<?php echo $pageURL; ?>%26random%3D<?php echo rand(); ?>" data-count="horizontal" id="twshare" target="_blank"><img alt="" src="<?php echo JURI::base(); ?>components/com_contushdvideoshare/images/twitter-icon.png" width="16" height="16" />Tweet</a>
                        </div>
                        <!-- Google plus share icon -->
                        <div class="floatleft google-plus">
                            <script type="text/javascript" src="http://apis.google.com/js/plusone.js"></script>
                            <div class="g-plusone" data-size="medium" data-count="true"></div>
                        </div>
                        <!--Facebook like button-->
                        <script src="http://connect.facebook.net/en_US/all.js"></script>
                        <iframe class="facebook_hdlike" src="http://www.facebook.com/plugins/like.php?href=<?php echo $pageURL; ?>&amp;layout=button_count&amp;show_faces=false&amp;width=450&amp;action=like&amp;colorscheme=light&amp;height=21" scrolling="no" class="iframe_frameborder"  allowTransparency="true"> </iframe>
                    </div>
                <?php } ?>
                <!--Embed code section starts here-->
                <div class="vinfo_right_embed">
                <?php if ($this->htmlVideoDetails->download == 1 && $this->htmlVideoDetails->filepath != "Youtube" && $this->htmlVideoDetails->filepath != "Embed" && $this->htmlVideoDetails->streameroption != "rtmp") {
                    ?>
                        <a href="<?php echo $video; ?>" target="_blank" id="downloadurl"><?php echo JText::_('HDVS_DOWNLOAD'); ?></a>
                <?php } ?>
                        <?php if($player_icons['embedVisible']== 1) { ?>
                    <a href="javascript:void(0)" onclick="enableEmbed()" class="embed" id="allowEmbed"><?php echo JText::_('HDVS_EMBED'); ?> </a>
                <?php } ?>
                    <div class="clear"></div>
                </div>
                <?php
                $split = explode("/", $this->videodetails->videourl);
                if (!empty($this->videodetails) && (preg_match('/vimeo/', $this->videodetails->videourl)) && ($this->videodetails->videourl != '')) {
                    ## For vimeo videos
                    $embed_code = '<iframe src="http://player.vimeo.com/video/' . $split[3] . '?title=0&amp;byline=0&amp;portrait=0&amp;color=6fde9f" width="'.$player_values['width'].'" height="'.$player_values['height'].'" class="iframe_frameborder" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
                } else if ($this->htmlVideoDetails->filepath == 'Embed') {
                    ## For embed code videos
                    $embed_code = $this->htmlVideoDetails->embedcode;
                } else {
                    ## For other type videos
                    $embed_code = '<embed id="player" src="' . $playerpath . '" flashvars="id=' . $this->videodetails->id . '&amp;baserefJHDV=' . JURI::base() . '&amp;playlist_auto=false&amp;Preview=' . $video_preview . '&amp;showPlaylist=false&amp;embedplayer=true&amp;shareIcon=false&amp;email=false&amp;zoomIcon=false&amp;playlist_autoplay=false" style="width:' . $player_values['width'] . 'px;height:' . $player_values['height'] . 'px" allowFullScreen="true" allowScriptAccess="always" type="application/x-shockwave-flash" wmode="transparent"></embed>';
                }
                ?>
                <textarea id="embedcode" name="embedcode" style="display:none;width:<?php
                if ($player_values['width'] > 10) {
                    echo ($player_values['width']) - (17);
                } else {
                    echo $player_values['width'];
                }
                ?>px;}" rows="7" ><?php echo $embed_code; ?></textarea>
                <input type="hidden" name="flagembed" id="flagembed" />
            </div>
            <script type="text/javascript">
                    function enableEmbed() {
                        embedFlag = document.getElementById('flagembed').value
                        if (embedFlag != 1) {
                            document.getElementById('embedcode').style.display = "block";
                            document.getElementById('flagembed').value = '1';
                        }
                        else {
                            document.getElementById('embedcode').style.display = "none";
                            document.getElementById('flagembed').value = '0';
                        }
                    }
            </script>
            <!--Embed code section ends here-->
            <!-- Social sharing ends and Description display place starts here -->
            <p id="videoDescription"><?php echo $this->htmlVideoDetails->description; ?></p>
            <div class="clear"></div>
        <?php
        break;
    }
}
?>
</div>
<div class="clear"></div>
<!-- Add Facebook Comment -->
<?php
if (!empty($this->videodetails) && $this->videodetails->id) {
    if ($dispenable['comment'] == 1) {
        ?>

        <div class="fbcomments" id="theFacebookComment">
            <h3><?php echo JText::_('HDVS_ADD_YOUR_COMMENTS'); ?></h3>
        <?php
        $dispenable['facebookapi'] = isset($dispenable['facebookapi']) ? $dispenable['facebookapi'] : '';
        if ($dispenable['facebookapi'])
            $facebookapi = $dispenable['facebookapi'];
        ?>
            <br />
            <div id ="face-comments">
                <script type="text/javascript">
                    window.fbAsyncInit = function() {
                        FB.init({
                            appId: "<?php echo $facebookapi; ?>",
                            status: true, // check login status
                            cookie: true, // enable cookies to allow the server to access the session
                            xfbml: true  // parse XFBML
                        });
                    };
                    (function() {
                        var e = document.createElement('script');
                        e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
                        e.async = true;
                        document.getElementById('face-comments').appendChild(e);
                    }());
                </script>
                <fb:comments xid="<?php echo JRequest::getVar('id'); ?>" css="facebook_style.css" simple="1" href="<?php echo JFactory::getURI()->toString(); ?>" num_posts="2" width="<?php echo $player_values['width']; ?>"></fb:comments>
            </div>
        </div>
    <?php } else if ($dispenable['comment'] == 5) { ## Disqus Comments ?>
        <div id="disqus_thread"></div>
        <script type="text/javascript">
            var disqus_shortname = "<?php echo $dispenable['disqusapi']; ?>";
            (function() {
                var dsq = document.createElement("script");
                dsq.type = "text/javascript";
                dsq.async = true;
                dsq.src = "http://" + disqus_shortname + ".disqus.com/embed.js";
                (document.getElementsByTagName("head")[0] || document.getElementsByTagName("body")[0]).appendChild(dsq);
            })();
        </script>
        <noscript><?php echo JText::_('HDVS_DISQUS_ENABLE_JS'); ?><a href="http://disqus.com/?ref_noscript"><?php echo JText::_('HDVS_DISQUS_POWERED_BY'); ?></a></noscript>
        <a href="http://disqus.com" class="dsq-brlink"><?php echo JText::_('HDVS_DISQUS_POWERED'); ?> <span class="logo-disqus"><?php echo JText::_('HDVS_DISQUS'); ?></span></a>
        <?php }
        ?>
    <input type="hidden" value="<?php echo $dispenable['comment']; ?>" id="commentoption" name="commentoption" />
    <div id="commentappended" class="clscenter" style="<?php if ($dispenable['comment'] == 1) {
            ?>display:none;<?php } ?>width:<?php echo $player_values['width']; ?>px;">
    <?php
    if (USER_LOGIN == '1') {
        if ($user->get('id') != '') {
            if ($dispenable['comment'] != 0) {
                ?>
                <!-- Jcomments starts here-->
                    <div id="commentcontainer" style="margin-top:0px;" class="clearfix clear">
                        <iframe id="myframe1"  width="<?php echo $player_values['width']; ?>" name="myframe1" class="autoHeight clearfix" frameborder="0" scrolling="no" src="index.php?option=com_contushdvideoshare&view=commentappend&tmpl=component&id=<?php echo $this->videodetails->id; ?>&cmdid=<?php echo $dispenable['comment']; ?>"  >
                        </iframe>
                    </div>
            <?php } if ($dispenable['comment'] == 2) { ## Default Comments ?>

                    <div id="commentcontainer"></div>
                    <!--Script for default comment append in player page-->
                    <script type="text/javascript">
                        var xmlhttp;
                        var nocache = 0;
                        function GetXmlHttpObject()
                        {
                            if (window.XMLHttpRequest)
                            {
                                // code for IE7+, Firefox, Chrome, Opera, Safari
                                return new XMLHttpRequest();
                            }
                            if (window.ActiveXObject)
                            {
                                // code for IE6, IE5
                                return new ActiveXObject("Microsoft.XMLHTTP");
                            }
                            return null;
                        }
                        var xmlhttp;
                        xmlhttp = GetXmlHttpObject();
                        var url = "<?php echo JURI::base(); ?>index.php?option=com_contushdvideoshare&view=commentappend&tmpl=component&id=<?php echo $this->videodetails->id; ?>&cmdid=<?php echo $dispenable['comment']; ?>";
                        xmlhttp.onreadystatechange = function stateChanged()
                        {
                            if (xmlhttp.readyState == 4)
                            {
                                document.getElementById("commentcontainer").innerHTML = xmlhttp.responseText;
                            }
                        };
                        xmlhttp.open("GET", url, true);
                        xmlhttp.send(null);
                        function changepage(pageno)
                        {
                            xmlhttp = GetXmlHttpObject();
                            if (xmlhttp == null)
                            {
                                alert("Browser does not support HTTP Request");
                                return;
                            }
                            document.getElementById('prcimg').style.display = "block";
                            var url = "<?php echo JURI::base(); ?>index.php?option=com_contushdvideoshare&view=commentappend&tmpl=component&id=<?php echo $this->videodetails->id; ?>&cmdid=2&page=" + pageno;
                            url = url + "&sid=" + Math.random();
                            xmlhttp.onreadystatechange = function stateChanged()
                            {
                                if (xmlhttp.readyState == 4)
                                {
                                    document.getElementById("commentcontainer").innerHTML = xmlhttp.responseText;
                                }
                            };
                            xmlhttp.open("GET", url, true);
                            xmlhttp.send(null);
                        }

                        window.onload = function()
                        {
                            document.getElementById('txt').style.display = "none";

                        }
                        function comments()
                        {
                            var d = document.getElementById('txt').innerHTML;
                            document.getElementById('initial').innerHTML = d;
                        }
                        function insert()
                        {
                            var name = encodeURI(document.getElementById('username').value);
                            var message = encodeURI(document.getElementById('comment_message').value);
                            var id = encodeURI(document.getElementById('id').value);

                            var category = encodeURI(document.getElementById('category').value);
                            var parentid = encodeURI(document.getElementById('parentvalue').value);
                            // Set te random number to add to URL request
                            var nocache = Math.random();
                            xmlhttp = GetXmlHttpObject();
                            if (xmlhttp == null)
                            {
                                alert("Browser does not support HTTP Request");
                                return;
                            }
                            document.getElementById('prcimg').style.display = "block";
                            var url = "<?php echo JURI::base(); ?>index.php?option=com_contushdvideoshare&view=player&id=" + id + "&category=" + category + "&name=" + name + "&message=" + message + "&pid=" + parentid + "&nocache = " + nocache + "&sid=" + Math.random();
                            xmlhttp.onreadystatechange = stateChanged;
                            xmlhttp.open("GET", url, true);
                            xmlhttp.send(null);

                        }
                        function stateChanged()
                        {
                            if (xmlhttp.readyState == 4)
                            {
                                document.getElementById('prcimg').style.display = "none";
                                var name = document.getElementById('username').value;
                                var message = document.getElementById('comment_message').value;
                                var id = encodeURI(document.getElementById('videoid').value);
                                var boxid = encodeURI(document.getElementById('id').value);
                                var category = encodeURI(document.getElementById('category').value);
                                var parentid = encodeURI(document.getElementById('parentvalue').value);
                                var commentcountval = document.getElementById('commentcount').innerHTML;
                                document.getElementById('username').disabled = true;
                                document.getElementById('comment_message').disabled = true;
                                if (parentid == 0)
                                {
                                    document.getElementById("al").innerHTML = "<div class='underline'></div><div class='clearfix'><div class='subhead changecomment'><span class='video_user_info'><strong>" + name + "</strong><span class='user_says'> says </span></span><span class='video_user_comment'>" + message + "</span></div></div>" + document.getElementById("al").innerHTML;
                                    document.getElementById('commentcount').innerHTML = parseInt(commentcountval) + 1;
                                }
                                else
                                {
                                    document.getElementById(parentid).innerHTML = "<div class='clsreply'><span  class='video_user_info'><strong>Re : <span>" + name + "</span></strong><span class='user_says'> says </span></span><span class='video_user_comment'>" + message + "</span></div></blockquote>";
                                    document.getElementById('commentcount').innerHTML = parseInt(commentcountval) + 1;
                                }
                                document.getElementById('txt').style.display = "none";
                                document.getElementById('initial').innerHTML = " ";
                            }
                        }
                        function CountLeft(field, count, max)
                        {
                            // if the length of the string in the input field is greater than the max value, trim it
                            if (field.value.length > max)
                                field.value = field.value.substring(0, max);
                            else
                                count.value = max - field.value.length;
                        }
                        function textdisplay(rid)
                        {

                            if (document.getElementById('divnum').value > 0)
                            {
                                document.getElementById(document.getElementById('divnum').value).innerHTML = "";

                            }
                            document.getElementById('initial').innerHTML = " ";
                            var r = rid;
                            var d = document.getElementById('txt').innerHTML;
                            document.getElementById(r).innerHTML = d;
                            document.getElementById('txt').style.display = "none";
                            document.getElementById('divnum').value = r;
                        }
                        function hidebox()
                        {
                            document.getElementById('txt').style.display = "none";
                            document.getElementById('initial').innerHTML = " ";

                        }
                        function validation(form)
                        {
                            if (document.getElementById('username').value == '')
                            {
                                alert("Enter Your Name");
                                document.getElementById('username').focus();
                                return false;
                            }
                            var comments = form.comment_message.value;
                            if (comments.length == 0)
                            {
                                alert("Enter Your Message");
                                form.comment_message.focus();
                                return false;
                            }
                            return true;
                        }
                        function parentvalue(parentid)
                        {

                            document.getElementById('parentvalue').value = parentid;
                            document.getElementById('name').focus();
                        }
                    </script>
                <?php
            }
        } else if ($dispenable['comment'] != 5 && $dispenable['comment'] != 1 && $dispenable['comment'] != 0) {
            if (version_compare(JVERSION, '1.6.0', 'ge')) {
                $login_url = "index.php?option=com_users&amp;view=login";
            } else {
                $login_url = "index.php?option=com_user&amp;view=login";
            }
            ?>
                 <!--Ask user to login to post comment-->
                <div class="commentpost floatright"><a  href="<?php echo $login_url; ?>"  class="utility-link"><?php echo "Login to post comment"; ?></a></div>
            <?php
        }
    }
    ?>
    </div>
<?php }  ?>
<?php
## Display member collection link starts here
if (JRequest::getVar('memberidvalue', '', 'post', 'int')) {
    $memberidvalue = JRequest::getVar('memberidvalue', '', 'post', 'int');
}
?>
<form name="memberidform" id="memberidform" action="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&amp;view=membercollection'); ?>" method="post">
    <input type="hidden" id="memberidvalue" name="memberidvalue" value="<?php echo $memberidvalue; ?>" />
</form>
<script type="text/javascript">
    function membervalue(memid)
    {
        document.getElementById('memberidvalue').value = memid;
        document.getElementById('memberidform').submit();
    }
</script>
<!--Display member collection link ends here-->
<input type="hidden" value="" id="storeratemsg" />
<script type="text/javascript">
    txt = navigator.platform;
    if (txt == 'iPod' || txt == 'iPad' || txt == 'iPhone' || txt == 'Linux armv7l' || txt == 'Linux armv6l')
    {
        document.getElementById('downloadurl').style.display = 'none';
        document.getElementById('allowEmbed').style.display = 'none';
        document.getElementById('share_like').style.display = 'none';
        var cmdoption = document.getElementById('commentoption').value;
        if (cmdoption == 1) {
            document.getElementById('theFacebookComment').style.display = 'block';
        }
    }
</script>
<?php
$lang = JFactory::getLanguage();
$langDirection = (bool) $lang->isRTL();
if ($langDirection == 1) {
    $rtlLang = 1;
} else {
    $rtlLang = 0;
}
?>
<!--Tooltip for video thumbs-->
<script type="text/javascript">
    jQuery.noConflict();
    jQuery(document).ready(function($) {
        jQuery(".ulvideo_thumb").mouseover(function() {
            htmltooltipCallback("htmltooltip", "",<?php echo $rtlLang; ?>);
            htmltooltipCallback("htmltooltip1", "1",<?php echo $rtlLang; ?>);
            htmltooltipCallback("htmltooltip2", "2",<?php echo $rtlLang; ?>);
        });
    });
    jQuery(document).ready(function($) {
        htmltooltipCallback("htmltooltip", "",<?php echo $rtlLang; ?>);
        htmltooltipCallback("htmltooltip1", "1",<?php echo $rtlLang; ?>);
        htmltooltipCallback("htmltooltip2", "2",<?php echo $rtlLang; ?>);
    })
    jQuery(document).click(function() {
        htmltooltipCallback("htmltooltip", "",<?php echo $rtlLang; ?>);
        htmltooltipCallback("htmltooltip1", "1",<?php echo $rtlLang; ?>);
        htmltooltipCallback("htmltooltip2", "2",<?php echo $rtlLang; ?>);
    })
</script>