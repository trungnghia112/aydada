<?php
/**
 * @name 	        midrollxml.php
 ** @version	        2.1.0.1
 * @package	        Apptha
 * @since	        Joomla 1.5
 * @author      	Apptha - http://www.apptha.com/
 * @copyright 		Copyright (C) 2011 Powered by Apptha
 * @license 		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      	Contus HD FLV Player Midroll XML file
 * @Creation Date	23 Feb 2011
 * @modified Date	28 Aug 2013
 */
## No direct acesss
defined('_JEXEC') or die();

##  implementing default component libraries
jimport('joomla.application.component.model');

/*
 * HDFLV player component Model Class for Midroll XML 
 */
class hdflvplayerModelmidrollxml extends HdflvplayerModel {

	function getads() {
		
		## Declarations here
		$db = JFactory::getDBO();
		
		$playlistid = $mid = $itemid = $moduleid = $id = $videoid = 0;
		$rs_modulesettings  = '';
		$playlistautoplay   = $postrollads = $prerollads = $home_bol = $playlistrandom = 'false';
		
		## Fetch Mid-rol Ads here
		$query              = 'SELECT `id`, `published`, `adsname`, `filepath`, `postvideopath`, `home`, `targeturl`, `clickurl`, `impressionurl`, `impressioncounts`, `clickcounts`, `adsdesc`, `typeofadd` FROM `#__hdflvplayerads`
                                    WHERE published=1 AND typeofadd=\'mid\'';
		$db->setQuery($query);

		$rs_modulesettings = $db->loadObjectList();
		
		## Fetch Mid-roll Ad settings 
		$qry_settings       = "SELECT player_values,player_icons FROM #__hdflvplayersettings";
		$db->setQuery($qry_settings);
		
		$rs_random          = $db->loadObject();
                $player_values = unserialize($rs_random->player_values);
                $player_icons = unserialize($rs_random->player_icons);
		$random             = $player_icons['midrandom'];
		$adrotate           = $player_icons['midadrotate'];
		$interval           = $player_values['midinterval'];
		$begin              = $player_values['midbegin'];
		
		if ($random == 1)   $random = 'true'; else $random = 'false';
		if ($adrotate == 1) $adrotate = 'true'; else $adrotate = 'false';
		
		$this->showadsxml($rs_modulesettings, $random, $begin, $interval, $adrotate);
	}

	## Function to generate mid-roll XML
	function showadsxml($midroll_video, $random, $begin, $interval, $adrotate) {
             
		ob_clean();
		header("content-type: text/xml");
		echo '<?xml version="1.0" encoding="utf-8"?>';
		echo '<midrollad begin="' . $begin . '" adinterval="' . $interval . '" random="' . $random . '" adrotate="' . $adrotate . '">';
		if (count($midroll_video) > 0) {
			foreach ($midroll_video as $rows) {
				if($rows->clickurl=='')
				$clickpath = JURI::base() . '?option=com_hdflvplayer&task=impressionclicks&click=click&id='.$rows->id;
				else
				$clickpath = $rows->clickurl;

				if($rows->impressionurl == '')
				{
				$impressionpath = JURI::base() . '?option=com_hdflvplayer&task=impressionclicks&click=impression&id='.$rows->id;
				}
				else
				{
				$impressionpath = $rows->impressionurl;
				}
				
				echo '<midroll targeturl="' . $rows->targeturl . '" clickurl="' . $clickpath . '" impressionurl="' . $impressionpath . '" >';
				echo '<![CDATA[';
				echo '<span class="heading">' . $rows->adsname;
				echo '</span><br><span class="midroll">' . $rows->adsdesc;
				echo '</span><br><span class="webaddress">'. $rows->targeturl;
				echo '</span>]]>';
				echo '</midroll>';
			}
		}
		echo '</midrollad>';
		exit();
	}
}