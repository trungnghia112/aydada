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

// importing default joomla components
jimport('joomla.application.component.model');

/*
 * HDFLV player Model class to fetching checklist info.
 */
class hdflvplayerModelchecklist extends HdflvplayerModel {
	
	//Function to check the allow_url_fopen,file_uploads and Videos,Uploads folder permission 
	function checklistmodel()
	{
		$allow_status 		= 0;
		$per_video			= 0;
		$per_upload			= 0;
		$allow_fileuploads	= 0;
		
		//check whether file operations will allow the current hosting server or not
		if(ini_get('allow_url_fopen') == 1)
		{
			$allow_status = 1;
		}
		
		//check whether file uploads possible or not
		if(ini_get('file_uploads') == 1) 
		{
			$allow_fileuploads = 1;
		}
		$videopath 		= VPATH."/";
		$uploadpath 	= FVPATH."/images/uploads/";
		
		//Check whether the video upload file path writable or not
		if(is_writable($videopath))
		{
		$per_video = 1;
		}
		
		//check whether image upload writeable or not
		if(is_writable($uploadpath))
		{
			$per_upload = 1;
		}
		
		//Assigns info and return results
		$checklist = array('allow_status' 		=> $allow_status,
							'per_video'			=> $per_video,
							'per_upload'		=> $per_upload,
							'allow_fileuploads'	=> $allow_fileuploads);
		return $checklist;
	}
}
?>
