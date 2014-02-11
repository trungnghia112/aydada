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

defined('JPATH_BASE') or die;

//Imports joomla application libraries
jimport('joomla.application.helper');
jimport('joomla.application.component.controller');

$option = 'com_hdflvplayer';

if (version_compare(JVERSION, '3.0', 'ge')) {
    JModelLegacy::addTablePath(JPATH_COMPONENT_ADMINISTRATOR . DS . $option . DS . 'tables');
}else{
JModel::addTablePath(JPATH_COMPONENT_ADMINISTRATOR . DS . $option . DS . 'tables');
}


//Declarations here
$task 	 = '';
$playeridUrl = '';

$playeridUrl = JRequest::getvar('pid', '', 'get', 'int');

if ($playeridUrl)
$task = "addview";
switch ($task) {
	case "addview":
		hdflvplayer::addview($playeridUrl);
	default:
		break;
}

/*
 * Class helper for mod_hdflvplayer
 */
class hdflvplayer {

	//Function to add view count for each video.
	public static function addview($playeridUrl) {
		$db =  JFactory::getDBO();
		$query = 'UPDATE #__hdflvplayerupload SET times_viewed=1+times_viewed WHERE id='.$playeridUrl;
		$db->setQuery($query);
		$db->query();
	}

	//Function to Fetch records for related videos
	public static function getrecords($params) {

		$db =  JFactory::getDBO();
		$playid = $where = '';

		//Checks the joomla version
		if (version_compare(JVERSION, '1.7.0', 'ge')) {
			$version = '1.7';
		} elseif (version_compare(JVERSION, '1.6.0', 'ge')) {
			$version = '1.6';
		} else {
			$version = '1.5';
		}

		//Fetch Playlist id, Video Category and Video ID which is given in param.
		if ($version != '1.5') {
			$playid 	= $params->get('playlistid')->playlistid;
			$videocat 	= $params->get('videocat')->videocat;
			$videoid 	= $params->get('videoid')->videoid;
		} else {
			$paramcodes = hdflvplayer::getParams();
			$playid = $paramcodes['playlistid'];
			$videocat = $paramcodes['videocat'];
			$videoid = $paramcodes['videoid'];
		}

		//If Video category 1, then fetch playlist ID of selected video
		if ($videocat == 0) {
			$query = 'SELECT playlistid FROM #__hdflvplayerupload WHERE id='.$videoid;
			$db->setQuery($query);
			$rows = $db->loadObject();
                        if(!empty($rows))
                        {
			$playid = $rows->playlistid;
		}
		}
		//else, fetch selected playlist ID
		elseif ($videocat == 1) {
			if (version_compare(JVERSION, '1.6.0', 'ge')) {

				$playid = $params->get('playlistid')->playlistid;
			} else {
				$playid = $params->get('playlistid');
			}

		}

		$where = ' WHERE published=1 AND playlistid='.$playid;

		//If nothing selected, load 1st video
		if ($playid == 0 && $videoid == 0)
		{
		$where = 'WHERE published=1 ';
		}
                $p_id = JRequest::getVar('pid');
		if(isset($p_id)){
                    $where .= " AND id !=".$p_id;
                }

		//Fetch related Video details to display
		$query = 'SELECT id,title,filepath,videourl,thumburl,previewurl,hdurl,description,times_viewed FROM #__hdflvplayerupload '
				 .$where.' ORDER BY ordering ASC';

		$db->setQuery($query);
		$rows = $db->loadObjectList();

		return $rows;
	}

	//Function to fetch the selected Video details
	public static function gettitle($pid, $params) {

		$db = JFactory::getDBO();

		//Fetch Playlist Id, Video Category, Video Id params selected in admin panel
		if (version_compare(JVERSION, '1.6.0', 'ge')) {
			$playid = $params->get('playlistid')->playlistid;
			$videocat = $params->get('videocat')->videocat;
			$videoid = $params->get('videoid')->videoid;
		} else {
			$paramcodes = hdflvplayer::getParams();
			$playid = $paramcodes['playlistid'];
			$videocat = $paramcodes['videocat'];
			$videoid = $paramcodes['videoid'];
		}

		//Checks whether the Video ID passed in the URL or not.
		$playeridUrl = JRequest::getvar('pid', '', 'get', 'int');

		//If not pid, then Fetch the video ID or Playlist ID from param and fetch that video details
		if (!$playeridUrl) {

			//Fetch by selected playlist
			if ($videocat == 1) {
				$query = 'SELECT id,title,filepath,videourl,previewurl,description  FROM #__hdflvplayerupload
                		  WHERE published=1 AND playlistid='.$playid;
			}

			//if both empty, fetch 1st video
			else if ($playid == 0 && $videoid == 0) {

				$query = 'SELECT id,title,filepath,videourl,previewurl,description FROM #__hdflvplayerupload
						  WHERE published=1 ORDER BY id ASC';
			}
//Fetch by selected video
			else if ($videocat == 0) {
				$query = 'SELECT id,title,filepath,videourl,previewurl,description FROM #__hdflvplayerupload
                		  WHERE published=1 AND id='.$videoid;
			}
			$db->setQuery($query);
			$rs_titledes = $db->loadObject();

			return $rs_titledes;
		}
		//If pid, then Fetch that video details
		else if ($playeridUrl) {
			$query = "select id,title,filepath,videourl,previewurl,description from #__hdflvplayerupload   WHERE published=1 AND id = $playeridUrl ";
			$db->setQuery($query);
			$rs_titledes = $db->loadObject();
			return $rs_titledes;
		}
	}

        /* function to get html video access level */
	public static function getHTMLVideoAccessLevel($vid){
		$user = JFactory::getUser();
                $db     = JFactory::getDBO();
                $query = 'SELECT `access` FROM `#__hdflvplayerupload`
                   WHERE id =' . $vid . ' AND published=1';
                $db->setQuery($query);
                $rows = $db->loadResult();
            
                ## Checks for member Access
                if (version_compare(JVERSION, '1.6.0', 'ge')) {
                    $uid = $user->get('id');
                    if ($uid) {
                        $query = $db->getQuery(true);
                        $query->select('g.id AS group_id')
                                ->from('#__usergroups AS g')
                                ->leftJoin('#__user_usergroup_map AS map ON map.group_id = g.id')
                                ->where('map.user_id = ' . (int) $uid);
                        $db->setQuery($query);
                        $message = $db->loadObjectList();
                        foreach ($message as $mess) {
                            $accessid[] = $mess->group_id;
                        }
                    } else {
                        $accessid[] = 1;
                    }
                } else {
                    $accessid = $user->get('aid');
                }

                if (version_compare(JVERSION, '1.6.0', 'ge')) {
                    $query = $db->getQuery(true);
                    if ($rows == 0)
                        $rows = 1;
                    $query->select('rules as rule')
                            ->from('#__viewlevels AS view')
                            ->where('id = ' . (int) $rows);
                    $db->setQuery($query);
                    $message = $db->loadResult();
                    $accessLevel = json_decode($message);
                }

                $member = "true";

                if (version_compare(JVERSION, '1.6.0', 'ge')) {
                    $member = "false";
                    foreach ($accessLevel as $useracess) {
                        if (in_array("$useracess", $accessid) || $useracess == 1) {
                            $member = "true";
                            break;
                        }
                    }
                } else {
                    if ($rows != 0) {
                        if ($accessid != $rows && $accessid != 2) {
                            $member = "false";
                        }
                    }
                } 
                return $member;
	}
        
	//Function to fetch Video Id,playlist Id, Video Category from selected param admin
	public static function getParams() {

		$module 				= JModuleHelper::getModule('hdflvplayer');
		$moduleParams 			= new JParameter($module->params);
		$params['videoid'] 		= $moduleParams->get('videoid');
		$params['playlistid'] 	= $moduleParams->get('playlistid');
		$params['videocat'] 	= $moduleParams->get('videocat');

		return $params;
	}

}
?>





