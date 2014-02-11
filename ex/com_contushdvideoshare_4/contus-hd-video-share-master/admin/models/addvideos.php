<?php
/*
 ***********************************************************/
/**
 * @name          : Joomla HD Video Share
 ****@version	  : 3.4.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component Addvideos Model 
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */

/*
 ***********************************************************/
//No direct acesss
defined( '_JEXEC' ) or die( 'Restricted access' );
// import joomla model library
jimport('joomla.application.component.model');
/**
 * Contushdvideoshare Component Administrator Addvideos Model
 */
class contushdvideoshareModeladdvideos extends ContushdvideoshareModel {

	 //Function to fetch categories,ads and adding new video
	function addvideosmodel()
	{
		$db = JFactory::getDBO();
		// query to get ffmpegpath & file max upload size from #__hdflv_player_settings
		$query = "SELECT `uploadmaxsize`
				  FROM #__hdflv_player_settings";
		$db->setQuery($query);
		$rs_playersettings = $db->loadObjectList();
		//to get total no.of records
		if (count($rs_playersettings) > 0)
		{
			// To set max file size in php.ini
			ini_set('upload_max_filesize', $rs_playersettings[0]->uploadmaxsize . "M"); // to assign value to the php.ini file
			// To set max execution_time in php.ini
			ini_set('max_execution_time', 3600); // max execution time 5 Min
			ini_set('max_input_time', 3600);			
			$upload_maxsize = $rs_playersettings[0]->uploadmaxsize;
		}
		$rs_editupload = JTable::getInstance('adminvideos', 'Table');
		// query to fetch category list
		$query = "SELECT `id`,`member_id`,`category`,`seo_category`,`parent_id`,`ordering`
				  FROM  #__hdflv_category 
				  WHERE `published`=1 ORDER BY category asc";
		$db->setQuery($query);
		$rs_play = $db->loadObjectList();
		//query to fetch pre/post roll ads		
		$query = "SELECT `id`,`adsname`
				  FROM #__hdflv_ads 
				  WHERE `published`=1 and `typeofadd`!='mid' and `typeofadd`!='ima' ORDER BY adsname asc";
		$db->setQuery($query);
		$rs_ads = $db->loadObjectList();
		//query to fetch mid roll ads
		$query = "SELECT `id`,`adsname`
				  FROM #__hdflv_ads 
				  WHERE `published`=1 and `typeofadd` ='mid' ORDER BY adsname asc";
		$db->setQuery($query);
		$rs_midads = $db->loadObjectList();
		if(version_compare(JVERSION,'1.6.0','ge'))
		{
			$strTable = '#__viewlevels';
			$strName = 'title';
		}
		else
		{
			$strTable = '#__groups';
			$strName = 'name';
		}
		//query to fetch user groups
		$query = "SELECT `id` as id ,`$strName` as title 
				  FROM `$strTable` 
				  ORDER BY id asc";
		$db->setQuery($query);
		$usergroups = $db->loadObjectList();
		$user = JFactory::getUser();
        $userid = $user->get('id');
        //query to get group id of logged user        
        if(version_compare(JVERSION,'1.6.0','ge'))
        {
        $query = $db->getQuery(true);
        $query->select('g.id AS group_id')
              ->from('#__usergroups AS g')
              ->leftJoin('#__user_usergroup_map AS map ON map.group_id = g.id')
              ->where('map.user_id = ' . (int) $userid);
        $db->setQuery($query);
        $ugp = $db->loadObject();        
        }
        else
        {
            $query ='SELECT gid AS group_id from #__users
                	 WHERE id = ' . (int) $userid;
        $db->setQuery($query);
        $ugp = $db->loadObject();
        }        
		$add = array('upload_maxsize' => $upload_maxsize,'rs_play' => $rs_play, 'rs_editupload' => $rs_editupload, 'rs_ads' => $rs_ads, 'rs_midads' => $rs_midads,'user_groups' => $usergroups,'user_group_id' => $ugp);
		return $add;
	}

        /**
	 * function to get player settings
	 */
        function showplayersettings()
	{
		$db = JFactory::getDBO();
		//query to fetch player settings
		$query = "SELECT `player_values` FROM #__hdflv_player_settings";
		$db->setQuery( $query);
		return $db->loadResult();
}
}

?>
