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
 * HDFLV player Model class to show playlists details.
 */
class hdflvplayerModelplaylistname extends HdflvplayerModel {

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

	//Function to fetch playlist details
	function playlistnamemodel()
	{
		//Variables declaration and import pagination library
		global $option;
		$app = JFactory::getApplication();
		jimport('joomla.html.pagination');
		$filterOrder = $filter_order_Dir = $filter_name = '';
		
		// Instantiate id as asc for ordering
		$filterOrder     = $app->getUserStateFromRequest( $option.'filter_orders', 'filter_order', 'name', 'cmd' );
		$filter_order_Dir = $app->getUserStateFromRequest( $option.'filter_order_Dir', 'filter_order_Dir', 'ASC', 'word' );
		$filter_order_State 	= $app->getUserStateFromRequest( $option.'filter_order_Status', 'filter_state', '', 'int' );
		
		// Instantiate search filter
		$search = JRequest::getVar('search','', 'string');
		
		$db =JFactory::getDBO();
		$querySearch = $orderQuery = '';
		
		//Filter query
		if ($filter_order_State != '')
		{
			$filter_state = $filter_order_State;
			if($filter_order_State == 2)
				{
					$filter_state = 0;
				}
			$querySearch.=' WHERE published = '.$filter_state;
		}
		else{
			$querySearch.=' WHERE published != -2';
		}
			
			if($search != ''){
				$querySearch .= ' AND name LIKE \'%'.$search.'%\'';
				$lists['search']= $search;
			}
		
		$lists['playlist_state']= $filter_order_State;
		
		//Query to fetch playlists count for pagination 
		$query = 'SELECT count(id) FROM #__hdflvplayername'.$querySearch;
		$db->setQuery( $query );
		$total = $db->loadResult();
		$pageNav = new JPagination($total,  $this->getState('limitstart'), $this->getState('limit'));
		
		//order query
		if($filterOrder)
		{
			$orderQuery = ' ORDER BY '.$filterOrder.' '.$filter_order_Dir.
							' LIMIT '.$pageNav->limitstart.','.$pageNav->limit;
		}
		
		//Query to fetch playlists details
		$query = 'SELECT id,name,published FROM #__hdflvplayername'.$querySearch.$orderQuery;
		$db->setQuery( $query);
		$rs_showplaylistname = $db->loadObjectList();
		
		// table ordering
		$lists['order_Dir']	= $filter_order_Dir;
		$lists['order']		= $filterOrder;
		
		//Checks and display if any database error exists
		if ($db->getErrorNum())
		{
			echo $db->stderr();
			return false;
		}
		
		//Limit set for filter
		$limitstart 	= $this->getState('limitstart');
		$javascript		= 'onchange="document.adminForm.submit();"';
//		$lists['playlistid'] = JHTML::_('list.category',  'filter_playlistid', 'com_hdflvplayer', (int) $total, $javascript );
		
		//Returns pagination and table record set results 
		$resultarray = array('pageNav' 		=> $pageNav,
							'limitstart'	=> $limitstart,
							'lists'		 	=> $lists,
							'rs_showupload' => $rs_showplaylistname);
		return $resultarray;
	}
}
?>
