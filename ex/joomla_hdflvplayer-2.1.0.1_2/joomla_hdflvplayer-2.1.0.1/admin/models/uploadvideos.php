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
//No direct acesss
defined('_JEXEC') or die();

//importing defalut joomla components
jimport('joomla.application.component.model');

/*
 * HDFLV player Model class to fetch Video details.
 */
class hdflvplayerModeluploadvideos extends HdflvplayerModel {

	function __construct()
	{
		parent::__construct();

		//Get configuration
		$app	= JFactory::getApplication();
		$config = JFactory::getConfig();

		// Get the pagination request variables
		$this->setState('limit', $app->getUserStateFromRequest('com_hdflvplayer.limit', 'limit', $config->get('list_limit'), 'int'));
		$this->setState('limitstart', JRequest::getVar('limitstart', 0, '', 'int'));

	}

	//Function to fetch Videos list and their
	function videoslist()
	{
		//Global variable declaration
		global $option;
		$app =  JFactory::getApplication();

		// Instantiate ordering as asc for ordering
		$filter_order       = $app->getUserStateFromRequest( $option.'filter_order', 'filter_order', 'ordering', 'cmd' );
		$filter_order_Dir   = $app->getUserStateFromRequest( $option.'filter_order_Dir', 'filter_order_Dir', 'asc', 'word' );
		$filter_order_State = $app->getUserStateFromRequest( $option.'filter_order_Status', 'filter_state', '', 'int' );
		$filter_order_Type 	= $app->getUserStateFromRequest( $option.'filter_order_Type', 'filter_type', '', 'string' );

		$this->setState('filter.state', $filter_order_State);
		// Instantiate search filter
		$search = JRequest::getVar('search', '', 'string');

		$db = JFactory::getDBO();

		$querySearch = '';

		//Filter for Published
		if($filter_order_State != '')
		{
			$filter_state = $filter_order_State;
			if($filter_order_State == 2)
			{
				$filter_state = 0;
			}
			$querySearch .= ' WHERE a.published = '.$filter_state;
		}
		else{
			$querySearch .= ' WHERE a.published != -2';
		}
			
		//Filter for Playlist
		if($filter_order_Type != '')
		{
			$querySearch .= ' AND playlistid ='.$filter_order_Type;
		}
			
		//Filter by Video Name
		if($search != ''){
			$querySearch .= ' AND a.title LIKE \'%'.$search.'%\'';
			$lists['search']= $search;
		}

		$query = 'SELECT count(a.id) FROM #__hdflvplayerupload as a'.$querySearch;
		$db->setQuery( $query );
		$total = $db->loadResult();

		//import for Pagination
		jimport('joomla.html.pagination');
		$limitstart = $this->getState('limitstart');
		$pageNav = new JPagination($total,  $this->getState('limitstart'), $this->getState('limit'));

		//Sorting query
		if($filter_order)
		{
			$queryOrder = ' ORDER BY '.$filter_order.' '.$filter_order_Dir.
						  ' LIMIT '.$pageNav->limitstart.','.$pageNav->limit;
		}

		//Fetch video details
		if(version_compare(JVERSION,'1.6.0','ge'))
		{
			$query = 'SELECT a.id,a.published,a.title,a.times_viewed,a.filepath,a.videourl,a.thumburl,a.previewurl,a.hdurl,a.home,a.streamerpath,a.streameroption,a.prerollads,a.postrollads,a.midrollads,a.ordering,a.access,
						  b.name,g.title AS groupname FROM #__hdflvplayerupload a
						  LEFT JOIN #__hdflvplayername b ON a.playlistid=b.id  
						  LEFT JOIN #__usergroups AS g ON g.id = a.access '.$querySearch.$queryOrder;

		}
		else
		{
			$query = 'SELECT a.id,a.published,a.title,a.times_viewed,a.filepath,a.videourl,a.thumburl,a.previewurl,a.hdurl,a.home,a.streamerpath,a.streameroption,a.prerollads,a.postrollads,a.midrollads,a.ordering,a.access,
						  b.name,g.name AS groupname FROM #__hdflvplayerupload a
						  LEFT JOIN #__hdflvplayername b ON a.playlistid=b.id  
						  LEFT JOIN #__groups AS g ON g.id = a.access '.$querySearch.$queryOrder;

		}
		
		$db->setQuery( $query );
		$rs_showupload = $db->loadObjectList();

		//Query for fetch playlist names
		$query = 'SELECT id,name FROM  #__hdflvplayername
            			WHERE published=1 ORDER BY id ASC';
		$db->setQuery( $query );
		$rs_play 			= $db->loadObjectList();


		// table ordering
		$lists['order_Dir']		= $filter_order_Dir;
		$lists['order']			= $filter_order;
		$lists['video_state']	= $filter_order_State;
		$lists['playlist'] 		= $filter_order_Type;
		//check and display error when database operations
		if ($db->getErrorNum())
		{
			echo $db->stderr();
			return false;
		}

		//returns page navigation, limits,video details
		$showarray = array('pageNav' 				=> $pageNav,
							'limitstart'			=> $limitstart,
							'lists'					=> $lists,
							'rs_showupload'			=> $rs_showupload,
							'playlist'				=> $rs_play
		);
		return $showarray;
	}

	//Function for mark video as default
	function setdefault()
	{
		//Database connection and fetch selected row
		$db =& JFactory::getDBO();
		$cid	= JRequest::getVar( 'cid', array(), 'post', 'array' );//getting selected record
		JArrayHelper::toInteger($cid);

		$link = 'index.php?option=com_hdflvplayer&task=uploadvideos';
		$tblname = 'hdflvplayerupload';
		$msg = '';

		//Fetching 1st video from selected list
		if (isset($cid[0]) && $cid[0]) {
			$id = $cid[0];
		}

		//returns when no item selected
		else {
			$msg = JText::_('No '.$msg.' selected');
			$app =& JFactory::getApplication();
			$app->redirect($link, $msg);
			return false;
		}
		$item =& JTable::getInstance( "$tblname",'Table' );
		$item->load($id);

		//Checks whether the item published or not.
		if(!$item->get('published')) {
			$msg=JText::_('The Default Video Must Be Published');
			$app =& JFactory::getApplication();
			$app->redirect($link, $msg);
			return false;
		}

		//Update as default for selected item in table.
		$query = 'UPDATE #__'.$tblname.' SET home=1 WHERE id='.$id;
		$db->setQuery($query );
		$db->query();

		//Remaining items reset
		$query = 'UPDATE #__'.$tblname.' SET home=0 WHERE id <> '.$id.' AND home=1';
		$db->setQuery($query );
		$db->query();

		//Displays message with redirects
		$app =& JFactory::getApplication();
		$app->redirect($link, $msg);
	}

	//Function to reset viewed count
	function resethitsmodel($task)
	{
		//Database connection initialization
		$db	= JFactory::getDBO();

		//Fetch row id
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		$id = $cid[0];
		$cids = implode( ',', $cid );

		//Reset view count for selected video row
		$query = 'UPDATE #__hdflvplayerupload SET times_viewed=0 WHERE id IN ('. $cids.' )';
		$db->setQuery( $query );
		$db->query();

		//Redirects with success message
		$msg = JText::_('Successfully Reset viewed count');
		$link = 'index.php?option=com_hdflvplayer&task=uploadvideos';
		$app =& JFactory::getApplication();
		$app->redirect($link, $msg);
	}

	//Function to change sort order when drags the row
	function sortordermodel()
	{
		$db = JFactory::getDBO();
		$listitem = JRequest::getvar('listItem','','get','var');

		$ids = implode(',', $listitem);
		$sql = 'UPDATE #__hdflvplayerupload SET `ordering` = CASE id ';
		foreach ($listitem as $position => $item) {
			$sql .= sprintf("WHEN %d THEN %d ", $item, $position);
		}
		$sql .= ' END WHERE id IN ('.$ids.')';

		$db->setQuery($sql );
		$db->query();
	}
}
?>