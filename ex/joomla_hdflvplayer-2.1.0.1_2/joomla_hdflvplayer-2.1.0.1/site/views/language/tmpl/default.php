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

//Fetch details from model
$detail = $this->detail;
$rs_lang = unserialize($detail->player_lang);
//generates xml here
ob_clean();
header ("content-type: text/xml");
if(count($rs_lang)>0)
{
    echo '<?xml version="1.0" encoding="utf-8"?>';
    echo '<language>';
    echo'<Play><![CDATA['.$rs_lang['play'].']]></Play>
        <Pause><![CDATA['.$rs_lang['pause'].']]></Pause>
        <Replay><![CDATA['.$rs_lang['replay'].']]></Replay>
        <Changequality><![CDATA['.$rs_lang['changequality'].']]></Changequality>
        <zoomIn><![CDATA['.$rs_lang['zoomin'].']]></zoomIn>
        <zoomOut><![CDATA['.$rs_lang['zoomout'].']]></zoomOut>
        <zoom><![CDATA['.$rs_lang['zoom'].']]></zoom>
        <share><![CDATA['.$rs_lang['share'].']]></share>
        <FullScreen><![CDATA['.$rs_lang['fullscreen'].']]></FullScreen>
        <ExitFullScreen><![CDATA['.$rs_lang['exitfullScreen'].']]></ExitFullScreen>
        <PlayListHide><![CDATA['.$rs_lang['playlisthide'].']]></PlayListHide>
        <PlayListView><![CDATA['.$rs_lang['playlistview'].']]></PlayListView>
        <sharetheword><![CDATA['.$rs_lang['sharetheword'].']]></sharetheword>
        <sendanemail><![CDATA['.$rs_lang['sendanemail'].']]></sendanemail>
        <Mail><![CDATA['.$rs_lang['email'].']]></Mail>
        <to><![CDATA['.$rs_lang['to'].']]></to>
        <from><![CDATA['.$rs_lang['from'].']]></from>
        <note><![CDATA['.$rs_lang['note'].']]></note>
        <send><![CDATA['.$rs_lang['send'].']]></send>
        <copy><![CDATA['.$rs_lang['copy'].']]></copy>
        <link><![CDATA['.$rs_lang['copylink'].']]></link>
        <social><![CDATA['.$rs_lang['social'].']]></social>
        <embed><![CDATA['.$rs_lang['copyembed'].']]></embed>
        <Quality><![CDATA['.$rs_lang['quality'].']]></Quality>
        <facebook><![CDATA['.$rs_lang['facebook'].']]></facebook>
        <tweet><![CDATA['.$rs_lang['tweet'].']]></tweet>
        <tumblr><![CDATA['.$rs_lang['tumblr'].']]></tumblr>
        <google+><![CDATA['.$rs_lang['googleplus'].']]></google+>
        <autoplayOff><![CDATA['.$rs_lang['turnoffplaylistautoplay'].']]></autoplayOff>
        <autoplayOn><![CDATA['.$rs_lang['turnonplaylistautoplay'].']]></autoplayOn>
        <adindicator><![CDATA['.$rs_lang['adindicator'].']]></adindicator>
        <skip><![CDATA['.$rs_lang['skipadd'].']]></skip>
        <skipvideo><![CDATA['.$rs_lang['skipvideo'].']]></skipvideo>
        <download><![CDATA['.$rs_lang['download'].']]></download>
        <Volume><![CDATA['.$rs_lang['volume'].']]></Volume>
        <ads><![CDATA['.$rs_lang['mid'].']]></ads>
        <nothumbnail><![CDATA['.$rs_lang['nothumbnail'].']]></nothumbnail>
        <live><![CDATA['.$rs_lang['live'].']]></live>
        <fill_required_fields><![CDATA['.$rs_lang['fillrequiredfields'].']]></fill_required_fields>
        <wrong_email><![CDATA['.$rs_lang['wrongemail'].']]></wrong_email>
        <email_wait><![CDATA['.$rs_lang['emailwait'].']]></email_wait>
        <email_sent><![CDATA['.$rs_lang['emailsent'].']]></email_sent>
        <video_not_allow_embed_player><![CDATA['.$rs_lang['notallow_embed'].']]></video_not_allow_embed_player>
        <youtube_ID_Invalid><![CDATA['.$rs_lang['youtube_ID_Invalid'].']]></youtube_ID_Invalid>
        <video_Removed_or_private><![CDATA['.$rs_lang['video_Removed_or_private'].']]></video_Removed_or_private>
        <streaming_connection_failed><![CDATA['.$rs_lang['streaming_connection_failed'].']]></streaming_connection_failed>
        <audio_not_found><![CDATA['.$rs_lang['audio_not_found'].']]></audio_not_found>
        <video_access_denied><![CDATA['.$rs_lang['video_access_denied'].']]></video_access_denied>
        <FileStructureInvalid><![CDATA['.$rs_lang['FileStructureInvalid'].']]></FileStructureInvalid>
        <NoSupportedTrackFound><![CDATA['.$rs_lang['NoSupportedTrackFound'].']]></NoSupportedTrackFound>';
    echo '</language>';

}
exit();
?>
