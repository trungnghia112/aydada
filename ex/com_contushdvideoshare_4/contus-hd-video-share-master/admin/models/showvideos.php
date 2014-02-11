<?php
/**
 * @name          : Joomla HD Video Share
 * @version	  : 3.4.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component Showvideos Model
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */

## No direct acesss
defined( '_JEXEC' ) or die( 'Restricted access' );
##  import Joomla model library
jimport('joomla.application.component.model');
##  import Joomla pagination
jimport('joomla.html.pagination');
## Contushdvideoshare Component Showvideos Model
class contushdvideoshareModelshowvideos extends ContushdvideoshareModel {

	## Constructor - global variable initialization
	function __construct() {
		global $option, $mainframe,$db;
		parent::__construct();
		##  get global configuration
		$mainframe      = JFactory::getApplication();
		$option         = JRequest::getVar('option');
		$db             =  JFactory::getDBO();
		$config         = JFactory::getConfig();
	}

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

	##  function to display videos grid
	function showvideosmodel() {
		global $option, $mainframe, $db;
		$rs_showupload      = '';
		$strVideoCount      = 0;
		##   To store and retrieve filter variables that are stored with the session
		$filter_order       = $mainframe->getUserStateFromRequest($option . 'filter_order_adminvideos', 'filter_order', 'ordering', 'cmd');
		$filter_order_Dir   = $mainframe->getUserStateFromRequest($option . 'filter_order_Dir_adminvideos', 'filter_order_Dir', 'asc', 'word');
		$search             = $mainframe->getUserStateFromRequest($option . 'search', 'search', '', 'string');
                 $search1           = $search;
		$state_filter       = $mainframe->getUserStateFromRequest($option . 'filter_state', 'filter_state', '', 'int');
		$featured_filter    = $mainframe->getUserStateFromRequest($option . 'filter_featured', 'filter_featured', '', 'string');
		$category_filter    = $mainframe->getUserStateFromRequest($option . 'filter_category', 'filter_category', '', '');
		##  page navigation
		##  Default List Limit
		$limit              = $mainframe->getUserStateFromRequest($option . '.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart         = $mainframe->getUserStateFromRequest($option . '.limitstart', 'limitstart', 0, 'int');

		##  set user = admin for admin videos
		$strAdmin           = (JRequest::getVar('user', '', 'get')) ? JRequest::getVar('user', '', 'get') : '';
		##  get logged user
		$user               = JFactory::getUser();
		$userid             = $user->get('id');
		##  get user groups  from joomla version above 1.6.0
		if(version_compare(JVERSION,'1.6.0','ge'))
		{
			##  query items are returned as an associative array
			$query      = $db->getQuery(true);
			$query->select('g.id AS group_id')
				  ->from('#__usergroups AS g')
				  ->leftJoin('#__user_usergroup_map AS map ON map.group_id = g.id')
				  ->where('map.user_id = ' . (int) $userid);
			$db->setQuery($query);
			$arrUserGroup = $db->loadObject();

			/**
			 * User group
			 * 6 - Manager
			 * 7 - Administrator
			 * 8 - Super Users
			 */

			##  for videos added by admin
			if($strAdmin == 'admin') {
				if ($arrUserGroup->group_id == '8')
				$where = "WHERE a.usergroupid IN (6,7,8)";
				else
				$where = "WHERE a.usergroupid='$arrUserGroup->group_id' AND a.memberid = $userid";
				##  for videos added by member
			} else {
				$where = "WHERE a.usergroupid NOT IN (6,7,8) AND a.memberid != '$userid'";
			}
		}
		##  get user groups from joomla version below 1.6.0
		else
		{
			$query = 'SELECT gid from #__users
                                WHERE id = ' . (int) $userid;
			$db->setQuery($query);
			$arrUserGroup = $db->loadObject();
			##  for videos added by admin
			if($strAdmin == 'admin')
			{
				if ($arrUserGroup->gid == 25)
				{
					$where = "WHERE c.gid='25'";
				}
				else if($arrUserGroup->gid == 24)
				{
					$where = "WHERE c.gid='24'";
				}
			}
			##  for videos added by member
			else
			{
				$where = "WHERE c.gid NOT IN (24,25)";
			}
		}
		$query = "SELECT `id`,`member_id`,`category`,`seo_category`,`parent_id`,`ordering`,`published`
        		  FROM #__hdflv_category where published=1";
		$db->setQuery($query);
		$rs_showplaylistname = $db->loadObjectList();

		/**
		 * select videos details
		 * for filter by order,title,category,viewed,video link,thumb link,order,featured,id
		 * initially filter by order
		 */
		if ($filter_order)
		{
			##  for select videos details
			$strMainQuery = "SELECT distinct(d.videoid) as cvid,a.`id`, a.`memberid`, a.`published`, a.`title`, a.`seotitle`,
							  a.`featured`, a.`type`, a.`rate`, a.`ratecount`, a.`times_viewed`, a.`videos`, a.`filepath`,
							  a.`videourl`, a.`thumburl`, a.`previewurl`, a.`hdurl`, a.`home`, a.`playlistid`, a.`duration`,
							  a.`ordering`, a.`streamerpath`, a.`streameroption`, a.`postrollads`, a.`prerollads`, a.`midrollads`, a.`imaads`, a.`embedcode`,
							  a.`description`, a.`targeturl`, a.`download`, a.`prerollid`, a.`postrollid`, a.`created_date`,
							  a.`addedon`, a.`usergroupid`, a.`tags`, a.`useraccess`,b.category,c.username
		          			  FROM #__hdflv_upload a
		            	      INNER JOIN `#__users` c";

			##  for select user group id
			if(version_compare(JVERSION,'1.6.0','ge'))
			{
				$strMainQuery = "$strMainQuery ON c.id = a.memberid";
			}
			else
			{
				$strMainQuery = "$strMainQuery ON c.id = a.memberid";
			}

			##  for select video category and comments
			$strMainQuery = "$strMainQuery
							 LEFT JOIN #__hdflv_category b ON a.playlistid=b.id
                      		 LEFT JOIN #__hdflv_comments d ON d.videoid=a.id
                      		 $where";

		}
		##  assign filter variables
		$lists['order_Dir']     = $filter_order_Dir;
		$lists['order']         = $filter_order;
                $search                 = $this->phpSlashes($search);
		##  filtering based on search keyword
		if ($search)
		{
			$strMainQuery   .= " AND a.title LIKE '%$search%'";
			$lists['search'] = $search1;
		}
		##  filtering based on status
		if($state_filter) {
			if($state_filter == 1) {
				$state_filterval = 1;
			}elseif ($state_filter == 2) {
				$state_filterval = 0;
			}else {
				$state_filterval = -2;
			}
			$strMainQuery               .= " AND a.published = $state_filterval";
			$lists['state_filter']      = $state_filter;
		} else {
			$strMainQuery               .= " AND a.published != -2";
		}
		##  filtering based on featured status
		if($featured_filter) {
			$featured_filterval         = ($featured_filter == '1')?'1':'0';
			$strMainQuery               .= " AND a.featured = $featured_filterval";
			$lists['featured_filter']   = $featured_filter;
		}
		if($category_filter) {
			$strMainQuery               .= " AND a.playlistid = $category_filter";
			$lists['category_filter']   = $category_filter;
		}
			$strMainQuery               .= " ORDER BY $filter_order $filter_order_Dir";

			$db->setQuery($strMainQuery);
			$arrVideoList               = $db->loadObjectList();
			$strTotalVideos             = count($arrVideoList);

			##  set pagination

			$pageNav                    = new JPagination($strTotalVideos, $limitstart, $limit);

			$strMainQuery               .= " LIMIT $pageNav->limitstart,$pageNav->limit";
			$db->setQuery($strMainQuery);
			$arrVideoList               = $db->loadObjectList();

		/**
		 * get the most recent database error code
		 * display the last database error message in a standard format
		 *
		 */
		if ($db->getErrorNum())
		{
			JError::raiseWarning($db->getErrorNum(), $db->stderr());
		}

		return array('pageNav' => $pageNav, 'limitstart' => $limitstart,'lists' => $lists, 'rs_showupload' => $arrVideoList, 'rs_showplaylistname' => $rs_showplaylistname);
	}

	## function to publish and unpublish videos
	function changevideostatus($arrVideoId)
	{
		global $mainframe;
		if ($arrVideoId['task'] == "publish"){
			$msg = 'Published successfully';
			$publish = 1;
		} elseif($arrVideoId['task'] == 'trash') {
			$publish = -2;
			$msg = 'Trashed Successfully';
		} else{
			$msg = 'Unpublished successfully';
			$publish = 0;
		}
       	$objAdminVideosTable    = &$this->getTable('adminvideos');
        $objAdminVideosTable->publish($arrVideoId['cid'], $publish);
        $strRedirectPage        = 'index.php?layout=adminvideos&option=' . JRequest::getVar('option') . '&user=' . JRequest::getVar('user');
        $mainframe->redirect($strRedirectPage, $msg);

	}

	/**
	*
	* function to save videos
	* @ Normal video,Youtube,Video Url,Vimeo and ffmpeg
	*/

	function savevideos($task)
	{
		global $option,$mainframe;
		$db                 =  JFactory::getDBO();
		$userTypeRedirect   = (JRequest::getVar('user', '', 'get') == 'admin') ? "&user=" . JRequest::getVar('user', '', 'get') : "";
		##  To get an instance of the adminvideos table object
		$rs_saveupload      = JTable::getInstance('adminvideos', 'Table');
		$arrCatId           = JRequest::getVar('cid', array(0), '', 'array');
		$strCatId           = $arrCatId[0];
		$rs_saveupload->load($strCatId);
                $createddate        = date("Y-m-d h:m:s");

		##  variable initialization
		$arrFormData        = JRequest::get('post');
                $embedcode          = JRequest::getVar('embedcode', '', 'post', 'string', JREQUEST_ALLOWRAW);
		$arrFormData['embedcode']=$embedcode;
		$fileoption         = $arrFormData['fileoption'];
		$seoTitle           = trim($arrFormData['title']);
                $titlequery         = "SELECT count(id) FROM #__hdflv_upload where title='$seoTitle'";
                $db->setQuery($titlequery);
                $total_title        = $db->loadResult();
                if(!empty($total_title) || $total_title>0){
                    $seoTitle       = $seoTitle.rand();
                }
                $seoTitle = str_replace("+","",$seoTitle);
                $seoTitle           = stripslashes($seoTitle);
                $seoTitle           = strtolower($seoTitle);
		$seoTitle           = preg_replace('/[&:\s]+/i', '-', $seoTitle);
		$arrFormData['seotitle'] = preg_replace('/[#!@$%^.,:;\/&*(){}\"\'\[\]<>|?]+/i', '', $seoTitle);
		$arrFormData['seotitle'] = preg_replace('/---|--+/i', '-', $arrFormData['seotitle']);
		$description        = JRequest::getVar('description', '', 'post', 'string', JREQUEST_ALLOWRAW);
		$arrFormData['description'] = $description;

		##  object to bind to the instance
		if (!$rs_saveupload->bind($arrFormData))
		{
			JError::raiseWarning( 500, $rs_saveupload->getError() );
		}

		##  get and assign video url
		if (isset($rs_saveupload->videourl))
		{
			if ($rs_saveupload->videourl != "")
			{
				$rs_saveupload->videourl = trim($rs_saveupload->videourl);
			}
		}

		##  Inserts a new row if id is zero or updates an existing row in the hdflv_upload table
		if (!$rs_saveupload->store())
		{
			JError::raiseWarning( 500, $rs_saveupload->getError() );
		}

		##  check in the item
		$rs_saveupload->checkin();
		$idval = $rs_saveupload->id;

		## uploading videos type : URL
		if ($fileoption == 'Url'){
			require_once(FVPATH.DS.'helpers'.DS.'uploadurl.php');
			uploadUrlHelper::uploadUrl($arrFormData,$idval);
		}

		## uploading videos type : YOUTUBE
		if ($fileoption == "Youtube"){
			require_once(FVPATH.DS.'helpers'.DS.'uploadyoutube.php');
			uploadYouTubeHelper::uploadYouTube($arrFormData,$idval);
		}
		## uploading videos type : Embed
		if ($fileoption == "Embed"){
			require_once(FVPATH.DS.'helpers'.DS.'uploadembed.php');
			uploadEmbedHelper::uploadEmbed($arrFormData,$idval);
		}

		/**
		 * uploading videos
		 * type : FILE
		 */

		if ($arrFormData['fileoption'] == "File"){
		require_once(FVPATH.DS.'helpers'.DS.'uploadfile.php');
		uploadFileHelper::uploadFile($arrFormData,$idval);
		}

		## uploading videos type : FFMPEG
		if ($fileoption == "FFmpeg"){
		require_once(FVPATH.DS.'helpers'.DS.'uploadffmpeg.php');
		uploadFfmpegHelper::uploadFfmpeg($arrFormData,$idval);
		}
		$catid = JRequest::getVar('playlistid');
        ## query to update created date
            $query = "UPDATE #__hdflv_upload SET created_date='$createddate' where id=$idval";
            $db->setQuery($query);
            $db->query();
        ## query to find the existing of category for video
        $query = "SELECT count(vid) FROM #__hdflv_video_category where vid=$idval";
        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total != 0) {
            $query = "UPDATE #__hdflv_video_category SET catid= '$catid' WHERE vid=$idval";
        } else {
            $query = "INSERT INTO #__hdflv_video_category values ('$idval','$catid')";
        }

        $db->setQuery($query);
        $db->query();
        switch ($task) {
            case 'applyvideos':
                $link = 'index.php?option=' . $option . '&layout=adminvideos&task=editvideos' . $userTypeRedirect . '&cid[]=' . $rs_saveupload->id;
                break;
            case 'savevideoupload':
            default:
                $link = 'index.php?option=' . $option . '&layout=adminvideos' . $userTypeRedirect;
                break;
        }
        $msg = 'Saved Successfully';
        ##  set to redirect
        $mainframe->redirect($link, $msg);
	}

	##  function to make video as featured/unfeatured
	function featuredvideo($arrVideoId)
	{
		global $mainframe;
		$db = $this->getDBO();
		if ($arrVideoId['task'] == "featured"){
			$publish = 1;
		}
		else{
			$publish = 0;
		}
		$msg = 'Updated Successfully';
		$strVideoIds = implode( ',', $arrVideoId['cid'] );
		$query = "UPDATE `#__hdflv_upload` SET `featured`=" . $publish . " WHERE `id` IN ( $strVideoIds )";
		$db->setQuery($query);
		$db->query();
		$strRedirectPage = 'index.php?layout=adminvideos&option=' . JRequest::getVar('option') . '&user=' . JRequest::getVar('user');
        $mainframe->redirect($strRedirectPage, $msg);
	}

	/**
	 * comments display in video grid view
	 * comments received from user (front end)
	 * admin can delete the comments
	 */
	function getcomment()
	{
		##  variable initialization
		global $option, $mainframe, $db;
		$commentId = JRequest::getVar('cmtid', '', 'get', 'int');
		$id = JRequest::getVar('id', '', 'get', 'int');

		##  for pagination
		$limit = $mainframe->getUserStateFromRequest($option . '.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart = $mainframe->getUserStateFromRequest($option . 'limitstart', 'limitstart', 0, 'int');

		##  	query for delete the comments
		if ($commentId)
		{
			$query = "DELETE FROM #__hdflv_comments
            		  WHERE id=" . $commentId . "
            		  OR parentid=" . $commentId;
			$db->setQuery($query);
			$db->query();
			##  message for deleting comment
			$mainframe->enqueueMessage( 'Comment Successfully Deleted' );
		}

		$id = JRequest::getVar('id', '', 'get', 'int');
		$query = "SELECT COUNT(id) FROM #__hdflv_comments
        		  WHERE videoid = $id";
		$db->setQuery($query);
		$db->query();
		$commentTotal = $db->getNumRows();
		if (!$commentTotal)
		{
			$strRedirectPage = 'index.php?layout=adminvideos&option=' . JRequest::getVar('option') . '&user=' . JRequest::getVar('user');
        	$mainframe->redirect($strRedirectPage);
		}

		$query="SELECT id as number,id,parentid,videoid,subject,name,created,message
				FROM #__hdflv_comments where parentid = 0 and published=1 and videoid=$id union
				SELECT parentid as number,id,parentid,videoid,subject,name,created,message
				FROM #__hdflv_comments where parentid !=0 and published=1 and videoid=$id
				ORDER BY number desc,parentid";##  Query is to display the comments posted for particular video

		$db->setQuery($query);
		$db->query();
		$commentTotal = $db->getNumRows();

		$pageNav = new JPagination($commentTotal, $limitstart, $limit);

        $query = "$query LIMIT $pageNav->limitstart,$pageNav->limit";
		$db->setQuery($query);
		$comment = $db->loadObjectList();

		$query = "SELECT `title` FROM #__hdflv_upload WHERE id = $id";
		$db->setQuery($query);
		$videoTitle = $db->loadResult();

		/**
		 * get the most recent database error code
		 * display the last database error message in a standard format
		 *
		 */
		if ($db->getErrorNum())
		{
			JError::raiseWarning($db->getErrorNum(), $db->stderr());
		}

		$comment = array('pageNav' => $pageNav, 'limitstart' => $limitstart, 'comment' => $comment ,'videotitle' => $videoTitle);
		return $comment;
	}

	## function to get comments count
	function getCommentcount($videoId) {
            ##  variable initialization
            global $db;
            $query = "SELECT count(id) FROM #__hdflv_comments WHERE videoid = $videoId";
            $db->setQuery($query);
            $commentCount = $db->loadResult();
            return $commentCount;
        }
}
?>