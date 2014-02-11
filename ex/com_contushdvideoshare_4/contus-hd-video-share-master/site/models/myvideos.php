<?php

/*
 * ********************************************************* */
/**
 * @name          : Joomla HD Video Share
 *** @version	  : 3.4.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component Myvideos Model
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */
/*
 * ********************************************************* */
//No direct acesss
defined('_JEXEC') or die('Restricted access');
// import Joomla model library
jimport('joomla.application.component.model');

/**
 * Contushdvideoshare Component Myvidos Model
 */
class Modelcontushdvideosharemyvideos extends ContushdvideoshareModel {

    function phpSlashes($string, $type='add') {
        if ($type == 'add') {
            if (get_magic_quotes_gpc ()) {
                return $string;
            } else {
                if (function_exists('addslashes')) {
                    return addslashes($string);
                } else {
                    return mysql_real_escape_string($string);
                }
            }
        } else if ($type == 'strip') {
            return stripslashes($string);
        } else {
            die('error in PHP_slashes (mixed,add | strip)');
        }
    }

    /* function is to delete a particular video and display videos of user who logged in */

    function getmembervideo() {
        $user = JFactory::getUser();
        $session = JFactory::getSession();
        $db = $this->getDBO();
        $where = $order = '';
        $search = '';
        $pageno = 1;
        if (JRequest::getVar('deletevideo', '', 'post', 'int')) {
            $id = JRequest::getVar('deletevideo', '', 'post', 'int'); //Getting the video id which is going to be deleted
            // Query for deleting a selected video
            $query = "UPDATE #__hdflv_upload SET published = -2 WHERE id=$id";
            $db->setQuery($query);
            $db->query();
        }
        /* Video Delete function Ends here */

        // Following code for displaying videos of the particular member when he logged in

        if ($user->get('id')) {
            $memberid = $user->get('id'); //Setting the loginid into session
        }
        $hiddensearchbox = $searchtextbox = $hidden_page = '';
        $searchtextbox = JRequest::getVar('searchtxtboxmember', '', 'post', 'string');
        $hiddensearchbox = JRequest::getVar('hidsearchtxtbox', '', 'post', 'string');
        if ($searchtextbox) {
            $search = $searchtextbox;
        } else {
            $search = $hiddensearchbox;
        }
        if (JRequest::getVar('page', '', 'post', 'int')) {
            $pageno = JRequest::getVar('page', '', 'post', 'int');
        }

        $search = $this->phpSlashes($search);
        if ($search) {
            $where = " AND (a.title like '%$search%' OR a.description like '%$search%' OR a.tags like '%$search%' OR b.category like '%$search%')";
        }
        // Query to get the total videos for user
        $myvideostotal = "SELECT count(a.id)
        			   	  FROM  #__hdflv_upload a 
                 LEFT JOIN #__users d on a.memberid=d.id
        			      LEFT JOIN #__hdflv_category b on b.id=a.playlistid
        				  WHERE a.published=1 AND b.published=1 AND a.memberid=$memberid $where";
        $db->setQuery($myvideostotal);
        $total = $db->loadResult();
        $limitrow = $this->getmyvideorowcol();
        $thumbview       = unserialize($limitrow[0]->thumbview);
        $length = $thumbview['myvideorow'] * $thumbview['myvideocol'];
        //Query is to select the videos of the logged in users
        $myvideorowcolquery = "SELECT allowupload
        					 FROM #__hdflv_user 
        					 WHERE member_id=" . $memberid;
        $db = $this->getDBO();
        $db->setQuery($myvideorowcolquery);
        $row = $db->LoadObjectList();
        if (count($row) != 0) {
            $allowupload = $row[0]->allowupload;
        } else {
            $dispenable       = unserialize($limitrow[0]->dispenable);
            $allowupload = $dispenable['allowupload'];
        }
        $pages = ceil($total / $length);
        if ($pageno == 1)
            $start = 0;
        else
            $start= ( $pageno - 1) * $length;

        if (JRequest::getVar('sorting', '', 'post', 'int')) {
            $session = JFactory::getSession();
            $session->set('sorting', JRequest::getVar('sorting', '', 'post', 'int'));
        }
        /* quries to display myvideos based on sorting */
        if ($session->get('sorting', 'empty') == "1") {
            // Query is to display the myvideos results order by title
            $order = "ORDER BY a.title asc";
        } else if ($session->get('sorting', 'empty') == "2") {
            // Query is to display the myvideos results order by added date
            $order = "ORDER BY a.addedon desc";
        } else if ($session->get('sorting', 'empty') == "3") {
            // Query is to display the myvideos results order by time of views
            $order = "ORDER BY a.times_viewed desc";
        } else if (strlen(JRequest::getVar('searchtxtboxmember', '', 'post', 'string')) > 0) {
            // Query for display the myvideos results based on search value
            $where = " AND (a.title like '%$search%' OR a.description like '%$search%' OR a.tags like '%$search%' OR b.category like '%$search%')";
        } else {
            // Query is to display the myvideos results
            $order = "ORDER BY a.id desc";
        }
        // Query is to display the myvideos results
        $query = "SELECT a.*,b.category,b.seo_category,d.username,e.*,count(f.videoid) as total
	        		  FROM  #__hdflv_upload a 
	        		  LEFT JOIN #__users d on a.memberid=d.id 
	        		  LEFT JOIN #__hdflv_video_category e on e.vid=a.id 
	        		  LEFT JOIN #__hdflv_category b on e.catid=b.id 
	        		  LEFT JOIN #__hdflv_comments f on f.videoid=a.id 
	        		  WHERE a.published=1 AND b.published=1 AND a.memberid=$memberid $where
	        		  GROUP BY a.id 
	        		  $order 
	        		  LIMIT $start,$length";

        $db->setQuery($query);
        $rows = $db->LoadObjectList();
        $row1['allowupload'] = $allowupload;
        if (count($rows) > 0) {
            $rows['pageno'] = $pageno;
            $rows['pages'] = $pages;
            $rows['start'] = $start;
            $rows['length'] = $length;
        }
        return array('rows' => $rows, 'row1' => $row1);
    }

    function getmyvideorowcol() {
        $user = JFactory::getUser();
        $memberid = "";
        if ($user->get('id')) {
            $memberid = $user->get('id'); //Setting the login id into session
        }
        $db = $this->getDBO();
        //Query is to select the myvideos settings
        $myvideorowcolquery = "SELECT thumbview,dispenable FROM #__hdflv_site_settings";
        $db->setQuery($myvideorowcolquery);
        $rows = $db->LoadObjectList();
        return $rows;
    }

}

?>