<?php
/*
 ***********************************************************/
/**
 * @name          : Joomla HD Video Share
 *** @version	  : 3.4.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2012 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Recent Videos Module Helper
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */

/*
 ***********************************************************/
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
/**
 * Contushdvideoshare Recent Videos Module Helper
 */
class modrecentvideos {
	/* function to get recent video module */
	public static function getrecentvideos() {
		$db = JFactory::getDBO();
		$limitrow = modrecentvideos::getrecentvideossettings();
                $thumbview       = unserialize($limitrow[0]->sidethumbview);
		$length = $thumbview['siderecentvideorow'] * $thumbview['siderecentvideocol'];
		// Query is to display recent videos
		$recentquery = "SELECT a.id,a.filepath,a.thumburl,a.title,a.description,a.times_viewed,a.ratecount,a.rate,
						a.times_viewed,a.seotitle,b.category,b.seo_category,d.username,e.catid,e.vid
        			    FROM  #__hdflv_upload a 
        			    LEFT JOIN #__users d on a.memberid=d.id 
        			    LEFT JOIN #__hdflv_video_category e on e.vid=a.id 
        			    LEFT JOIN #__hdflv_category b on e.catid=b.id 
        			    WHERE a.published='1' and b.published=1 and a.type='0' 
        			    GROUP BY e.vid 
        			    ORDER BY a.id desc 
        			    LIMIT 0,$length "; 
		$db->setQuery($recentquery);
		$recentvideos = $db->loadobjectList();
		return $recentvideos;
	}
	/* function to get recent videos module settings */
	public static function getrecentvideossettings() {
		$db = JFactory::getDBO();
		//Query is to select the recent videos settings
		$featurequery = "SELECT dispenable,sidethumbview FROM #__hdflv_site_settings"; 
		$db->setQuery($featurequery);
		$rows = $db->LoadObjectList();
		return $rows;
	}
}

?>
