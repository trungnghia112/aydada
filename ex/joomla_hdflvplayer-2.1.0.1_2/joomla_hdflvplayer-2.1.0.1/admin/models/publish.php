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
 * HDFLV player Model class to publish,unpublish videos, playlists,ads.
 */
class hdflvplayerModelpublish extends HdflvplayerModel {

	//Function to publish,unpublish videos,ads, playlists 
	function publishmodel($task)
    {
            //Assigns component into option variable
            $option = 'com_hdflvplayer';
            
            //Fetch the selected rows for publish or unpublish
            $cid = JRequest::getVar( 'cid', array(), '', 'array' );
            $msg = '';
            $tblname = '';
            $taskname = '';
            
            //Assigns publish variable based on selection of task. 
            if( $task == 'publish')
            {
                $publish = 1;
            }
            else if($task == 'trash')
            {
                $publish = -2;
                $msg = 'Trashed successfully';
            }
            else{
            	$publish = 0;
            }
			
            $taskname=JRequest::getvar('task','','get','var');
			
            //Checks taskname and assign table names based on task
            if($taskname == 'uploadvideos')
            {
                $tblname = 'hdflvplayerupload';
            }
            elseif($taskname == 'ads')
            {
                $tblname = 'hdflvplayerads';
            }
            elseif($taskname == 'playlistname')
            {
                $tblname = 'hdflvplayername';
            }
			
            //Initialize table name for publish or unpublish
            $reviewTable = JTable::getInstance($tblname, 'Table');
                      
            //Calls publish function with selected row(s) set, publish or unpublish flag 
            $reviewTable->publish($cid, $publish);
            
            //Redirects with message
            $link = 'index.php?option=' . $option.'&task='.$taskname;
            
            JFactory::getApplication()->redirect($link, $msg);
      }
  }
?>