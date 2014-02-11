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
 * HDFLV player Model class to show Pre-roll, Post-roll, Mid-roll Ads.
 */
class hdflvplayerModelshowads extends HdflvplayerModel {

	function __construct()
	{
		parent::__construct();

		//Get configuration
		$app	= JFactory::getApplication();
		$config = JFactory::getConfig();

		// Get the pagination request variables
		$this->setState('limit', $app->getUserStateFromRequest('ads.limit', 'limit', $config->get('list_limit'), 'int'));
		$this->setState('limitstart', JRequest::getVar('limitstart', 0, '', 'int'));
	}

	//Function to fetch Ads info
	function showadsmodel() {
		global $option;
		$option = 'com_hdflvplayer';
		$app = JFactory::getApplication();
		$queryOrder = $querySearch = '';
		$db = JFactory::getDBO();

		//Instantiate variables for Filter
		$filter_order     	= $app->getUserStateFromRequest( $option.'filter_orderads', 'filter_order', 'id', 'cmd' );
		$filter_order_Dir 	= $app->getUserStateFromRequest( $option.'filter_order_Dir', 'filter_order_Dir', 'ASC', 'word' );
		$filter_order_State = $app->getUserStateFromRequest( $option.'filter_order_Status', 'filter_state', '', 'int' );
		$filter_order_Type 	= $app->getUserStateFromRequest( $option.'filter_order_Type', 'filter_type', '', 'string' );
		$search = $app->getUserStateFromRequest( $option.'search','search','','post','string' );
		
		//Filter for Status
		if($filter_order_State != '')
			{
				$filter_state = $filter_order_State;
				if($filter_order_State == 2)
				{
					$filter_state = 0;
				}
				$querySearch .= ' WHERE published = '.$filter_state;
			}
			else{
				$querySearch .= ' WHERE published != -2';
			}
			
		
			//Filter for Type of Ad
			if($filter_order_Type != '')
			{
			
				$querySearch .= ' AND typeofadd LIKE \'%'.$filter_order_Type.'%\'';
			}
			
			//Filter by Ad Name
			if($search != ''){
							
				$querySearch .= ' AND adsname LIKE \'%'.$search.'%\'';
				$lists['search']= $search;
			}
		
			
		//Fetching count for pagination and instantiate Pagination values
		$query = 'SELECT count(id) FROM #__hdflvplayerads'.$querySearch;
		$db->setQuery( $query );
		$total = $db->loadResult();

		jimport('joomla.html.pagination');
		$pageNav = new JPagination($total,  $this->getState('limitstart'), $this->getState('limit'));

		//Sorting query
		if($filter_order)
		{
			$queryOrder = ' ORDER BY '.$filter_order.' '. $filter_order_Dir.' LIMIT '.$pageNav->limitstart.','.$pageNav->limit;
		}
		
		//Assign filter values into array for return
		$lists['order_Dir']	= $filter_order_Dir;
		$lists['order']	= $filter_order;
		$lists['ads_state']= $filter_order_State;
		$lists['ads_type'] = $filter_order_Type;
			
		//Query to fetch results
		$query = 'SELECT id,adsname,postvideopath,imaaddet,clickcounts,impressioncounts,typeofadd,published FROM #__hdflvplayerads'.$querySearch.$queryOrder;
		$db->setQuery( $query );
		$rs_showads = $db->loadObjectList();

		//Checks if any error in database and displays here
		if ($db->getErrorNum())
		{
			echo $db->stderr();
			return false;
		}

		// search filter
		$rs_showadsname = '';
		$javascript		= 'onchange="document.adminForm.submit();"';
//		$lists['adsname'] = JHTML::_('list.category',  'filter_playlistname', 'com_hdflvplayer', (int) $rs_showadsname, $javascript );

		//Returns result set
		$showarray = array('pageNav' 				=> $pageNav,
            				   'limitstart'			=> $rs_showadsname,
            				   'lists'				=> $lists,
            				   'rs_showadslistname'	=> $rs_showadsname,
            				   'rs_showads'			=> $rs_showads);
		return $showarray;
	}

	//Function to save Ads
	function saveads($task) {
		//Instantiate variables and global variables
		global $option;
		$option= 'com_hdflvplayer';
		$db = JFactory::getDBO();
		$adsSave = JTable::getInstance('hdflvplayerads', 'Table');

		//Fetch the selected row id
		$cid = JRequest::getVar('cid', array(0), '', 'array');
		$id = $cid[0];
		$adsSave->load($id);
                $adsetting = JRequest::get('post');
                $typeofadd = JRequest::getVar('typeofadd','post');
                
                ## Get IMA ad details and serialize data
                if($typeofadd=="ima"){
                $imaaddetail                    = array(
                    'imaadtype'                 => $adsetting['imaadtype'],
                    'videoimaadwidth'           => $adsetting['videoimaadwidth'],
                    'videoimaadheight'          => $adsetting['videoimaadheight'],
                    'publisherId'           => $adsetting['publisherId'],
                    'contentId'           => $adsetting['contentId'],
                    'channels'           => $adsetting['channels'],
                    'imaadpath'           => $adsetting['imaadpath']
                );
                $adsetting['imaaddet'] = serialize($imaaddetail);
                } else {
                    $adsetting['imaaddet'] = '';
                }
		//Binds given input with table columns
		if (!$adsSave->bind($adsetting)) {
			JError::raiseError(500, JText::_($adsSave->getError()));
		}

		// ad description and ad name to table
		$adsSave->adsdesc = JRequest::getVar('adsdesc', '', 'post', 'string', JREQUEST_ALLOWRAW);
		$adsSave->adsname = JRequest::getVar('adsname', '', 'post', 'string', JREQUEST_ALLOWRAW);

		//Stores the input into table into appropriate columns
		$fileoption = JRequest::getVar('fileoption','post');
		if (!$adsSave->store()) {
			JError::raiseError(500, JText::_($adsSave->getError()));
		}

		//Checks whether the given column available in the table or not
		$adsSave->checkin();

		//Fetch the last added id
		$idval = $adsSave->id;

		//If File Path option Url means, the below code will work
		if ($fileoption == 'Url') {
			$postvideopath = JRequest::getVar('posturl-value','post');
			$query = 'UPDATE #__hdflvplayerads
            		  SET filepath=\''.$fileoption.'\',postvideopath=\''.$postvideopath.'\'
            		  WHERE id='.$idval;
			$db->setQuery($query);
			$db->query();
		}

		//If File Path option File means, the below code will work.
		else if ($fileoption == 'File') {

			//Getting file name from hidden value.
			$normal_video = JRequest::getVar('normalvideoform-value','post');
			$video_name = explode('uploads/', $normal_video);
			$vpath = VPATH . '/';
			$file_video = $video_name[1];

			//Checks if file uploaded, the uploaded file moves into com_hdflvplayer\images\uploads folder
			if ($file_video <> '') {
				$exts = $this->findexts($file_video);
				$videoPath = FVPATH . '/images/uploads/' . $file_video;
				$target_path = $vpath . $idval . '_ads' . '.' . $exts;
				$file_name = $idval . '_ads' . '.' . $exts;

				//removes file from 'uploads' folder and move it to 'videos' folder.
				if (file_exists($target_path)) {
					unlink($target_path);
				}
				rename($videoPath, $target_path);

				//The renamed file name updated in table for last saved record.
				$query = 'UPDATE #__hdflvplayerads
                		SET postvideopath=\''.$file_name.'\',filepath=\''.$fileoption.'\'
                		WHERE id = '.$idval;
				$db->setQuery($query);
				$db->query();
			}
		}

		//Assigns message and redirects link for Apply and Save tasks
		switch ($task) {
			case 'applyads':
				$msg = 'Changes Saved';
				$link = 'index.php?option=' . $option . '&task=editads&cid[]=' . $adsSave->id;
				break;
			case 'saveads':
			default:
				$msg = 'Saved';
				$link = 'index.php?option=' . $option . '&task=ads';
				break;
		}

		//Redirects to given url with message
		JFactory::getApplication()->redirect($link, $msg);
	}

	// Extracting file extension from uploaded files
	function findexts($filename) {
		$filename 	= strtolower($filename);
		$exts 		= explode("[/\\.]", $filename);
		$count 		= count($exts) - 1;
		$exts 		= $exts[$count];
		return $exts;
	}
}
?>