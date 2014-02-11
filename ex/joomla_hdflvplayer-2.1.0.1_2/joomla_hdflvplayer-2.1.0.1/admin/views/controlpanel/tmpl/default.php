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
jimport('joomla.html.pane');

?>
<style>
    .contus-icon{

margin-right: 15px;
float: left;
margin-bottom: 15px;
border:1px solid #333;
padding:10px;
    }
    .contus-icon:hover{background:#e5e5e5}
    .clear{clear:both;}
    .text{color:#333;margin:10px;line-height: 17px;font-size: 12px;}
    .text a{padding: 7px;font-size: 12px;font-weight: 700;border:1px solid #ccc;text-transform:uppercase }
    .text a:hover{padding: 7px;font-size: 12px;font-weight: 700;color: #000;background: #FAFAFA }
    #toolbar-box,#submenu-box{display: none;}
    html, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, font, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, b, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td{margin:0; padding:0; border:0; outline:0}

ol, ul{list-style:none}
.floatleft{float:left}
.floatright{float:right}

.clear{clear:both; height:0px; font-size:0px}
.clearfix:after{ clear:both;  display:block;  content:"";  height:0px;  visibility:hidden}
.clearfix{ display:inline-block}

* html .clearfix{ height:1%}
.clearfix{ display:block}
li.clearfix{ display:list-item}
div#element-box div.m {overflow: hidden;}

div.cpanel-left {float: left;width:40%;}
.banner{padding-bottom: 10px;}
#cpanel div.icon {background: white;float: left;margin-bottom: 15px;margin-right: 15px;text-align: center;}
#cpanel div.icon a {border: 1px solid #EAEAEA;color: #565656;display: block;float: left;height: 97px;text-decoration: none;vertical-align: middle;width: 108px;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;}
#cpanel div.icon a:hover {background: #FBFBFB;border-bottom: 1px solid #CCC;border-left: 1px solid #EEE;border-right: 1px solid #CCC;border-top: 1px solid #EEE;}
#cpanel img {margin: 0px auto;padding: 10px 0px;}
#cpanel span {display: block;text-align: center;font-family: 'arial';color:#8D8371;font-size: 12px;}
.heading{ margin-bottom: 10px;  font-family: arial; line-height: 24px;  font-size: 24px;  font-weight: bold;  color: #146295;    padding: 0;}
.pane-sliders{margin: 0px;padding: 0px;}
</style>
<div class="contus-contropanel">
    <h2 class="heading">HD FLV Player Control panel</h2>
    </div>
<div class="cpanel-left" >
            <div class="banner"><a href="http://www.apptha.com" target="_blank"><img src="components/com_hdflvplayer/assets/apptha-banner.jpg" width="485" height="94" alt=""></a></div>
            <div id="cpanel">
                <div class="icon">
                   <a href="<?php echo JRoute::_("index.php?option=com_hdflvplayer&task=uploadvideos");?>" title="Videos">
                        <img src="components/com_hdflvplayer/assets/images/upload-videos.png" title="Videos" alt="Videos">
                        <span>Videos</span></a>
                </div>

                <div class="icon">
                   <a href="<?php echo JRoute::_("index.php?option=com_hdflvplayer&task=editplayersettings");?>" title="Player Settings">
                        <img src="components/com_hdflvplayer/assets/images/player-settings-icon.png" title="Player Settings" alt="Player Settings">
                        <span>Player Settings</span></a>
                </div>

                <div class="icon">
                    <a href="<?php echo JRoute::_("index.php?option=com_hdflvplayer&task=playlistname");?>" title="Playlist">
                        <img src="components/com_hdflvplayer/assets/images/category-icon.png" title="Playlist" alt="Playlist">
                        <span>Playlist</span></a>
                </div>

                <div class="icon">
                  <a href="<?php echo JRoute::_("index.php?option=com_hdflvplayer&task=checklist");?>" title="Checklist">
                        <img src="components/com_hdflvplayer/assets/images/checklist-icon.png" title="Checklist" alt="Checklist">
                        <span>Checklist</span></a>
                </div>

                <div class="icon">
                  <a href="<?php echo JRoute::_("index.php?option=com_hdflvplayer&task=editlanguagesetup");?>" title="Language Settings">
                        <img src="components/com_hdflvplayer/assets/images/language-settings-icon.png" title="Language Settings" alt="Language Settings">
                        <span>Language Settings</span></a>
                </div>

                <div class="icon">
                   <a href="<?php echo JRoute::_("index.php?option=com_hdflvplayer&task=ads");?>" title="Video Ads">
                        <img src="components/com_hdflvplayer/assets/images/ads-icon.png" title="Video Ads" alt="Video Ads">
                        <span>Video Ads</span></a>
                </div>

                <div class="icon">
                     <a href="<?php echo JRoute::_("index.php?option=com_hdflvplayer&task=addgoogle");?>" title="Google Adsense">
                        <img src="components/com_hdflvplayer/assets/images/google- adsense-icon.png" title="Google Adsense" alt="Google Adsense">
                        <span>Google Adsense</span></a>
                </div>
            </div>
        </div>
<?php if(!version_compare(JVERSION, '3.0.0', 'ge')) { ?>
<div style="width:50%;float:right;">
<?php
$pane   = JPane::getInstance('sliders');
echo $pane->startPane( 'pane' );
echo $pane->startPanel( 'Welcome to HD FLV Player', 'panel1' );?>

    <div class="main-text">

        <div class="text">
  Joomla HD FLV Player enhances the quality of your joomla sites or blogs. Some of the most salient features like Lighttpd, RTMP streaming, Monetization, Native language support, Bookmarking etc makes the Player Unique!! HTML5 support in the Player facilitates the purpose of playing it in iPhone and iPads.
        </div>   <div class="text" align="center" style=" text-align: left; ">
   <a href="https://www.apptha.com/downloadable/download/sample/sample_id/11/">Documentation</a>
   </div>
    </div>
    </div>
<?php
echo $pane->endPanel();
}else{
	?>
    <div style="width:50%;float:right;" class="well well-small"><div class="module-title nav-header">Welcome to HD FLV Player</div><div class="row-striped">
			<div class="row-fluid">
			<div class="span9" style=" text-align: justify;width: auto !important; ">

				<div class="row-title">Joomla HD FLV Player enhances the quality of your joomla sites or blogs. Some of the most salient features like Lighttpd, RTMP streaming, Monetization, Native language support, Bookmarking etc makes the Player Unique!! HTML5 support in the Player facilitates the purpose of playing it in iPhone and iPads.
									</div></div>
			<div class="text" style=" float: left; text-align: left; margin-left: 0;">
<a href="https://www.apptha.com/downloadable/download/sample/sample_id/11/">Documentation</a>
		</div></div></div></div>
<?php }	?>
