<?php
/*
 ***********************************************************/
/**
 * @name          : Joomla HD Video Share
 *** @version	  : 3.4.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component Uploadvideos Model
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */

/*
 ***********************************************************/
// No direct access to this file
defined( '_JEXEC' ) or die( 'Restricted access' );
// import joomla model library
jimport('joomla.application.component.model');
//Import filesystem libraries.
jimport('joomla.filesystem.file');
/**
 * Contushdvideoshare Component Uploadvideos Model
 */
//session_start();
//session_regenerate_id();
class contushdvideoshareModeluploadvideo extends ContushdvideoshareModel {
	/**
	 * Constructor
	 * global variable initialization
	 */
	function __construct() {
		global $option, $mainframe, $allowedExtensions;
		global $target_path,$error,$errorcode,$errormsg,$clientupload_val;
		parent::__construct();
		// get global configuration
		$mainframe = JFactory::getApplication();
		$option = JRequest::getVar('option');
		$target_path = $error = '';
		$errorcode = 12;
		$clientupload_val="false";
		$errormsg[0] = " File Uploaded Successfully";
		$errormsg[1] = " Cancelled by user";
		$errormsg[2] = " Invalid File type specified";
		$errormsg[3] = " Your File Exceeds Server Limit size";
		$errormsg[4] = " Unknown Error Occured";
		$errormsg[5] = " The uploaded file exceeds the upload_max_filesize directive 
						in php.ini";
		$errormsg[6] = " The uploaded file exceeds the MAX_FILE_SIZE directive that 
						was specified in the HTML form";
		$errormsg[7] = " The uploaded file was only partially uploaded";
		$errormsg[8] = " No file was uploaded";
		$errormsg[9] = " Missing a temporary folder";
		$errormsg[10] = " Failed to write file to disk";
		$errormsg[11] = " File upload stopped by extension";
		$errormsg[12] = " Unknown upload error.";
		$errormsg[13] = " Please check post_max_size in php.ini settings";
}

/**
	 * function to get uploaded file details
	 * from form
 */
	function fileupload()
	{
		global $clientupload_val,$allowedExtensions,$errorcode,$error,$target_path,$errormsg;
if (JRequest::getVar('error') != '') {
	$error = JRequest::getVar('error');
}
if (JRequest::getVar('processing') != '') {
	$pro = JRequest::getVar('processing');
}
if (JRequest::getVar('clientupload') != '') {
	$clientupload_val = JRequest::getVar('clientupload');
}
$uploadFile = JRequest::getVar('myfile', null, 'files', 'array');
if (JRequest::getVar('mode') != '') {
	$exttype = JRequest::getVar('mode');
	if ($exttype == 'video')
	$allowedExtensions = array("mp3","MP3","flv", "FLV", "mp4", "MP4" , "m4v", "M4V", "M4A", "m4a", "MOV",
			"mov", "mp4v", "Mp4v", "F4V", "f4v");
	else if ($exttype == 'image')
	$allowedExtensions = array("jpg", "JPG", "png", "PNG");
	else if ($exttype == 'video_ffmpeg')
	$allowedExtensions = array("avi","AVI","dv","DV","3gp","3GP","3g2","3G2","mpeg","MPEG","wav","WAV","rm",
			"RM","mp3","MP3","flv", "FLV", "mp4", "MP4" , "m4v", "M4V", "M4A", "m4a", "MOV", "mov", "mp4v", "Mp4v", 
			"F4V", "f4v");
}

/**
 * function to check error
 */
if (!$this->iserror()) {
	//check if stopped by post_max_size
	if (($pro == 1) && (empty($uploadFile))) {
		$errorcode = 13;
	}
	else {
		$file = $uploadFile;
		if ($this->no_file_upload_error($file)) {
			if ($this->isAllowedExtension($file)) {
				//check file size
				if (!$this->filesizeexceeds($file)) {
					$this->doupload($file,$clientupload_val);
				}
			}
		}
	}
		}
		?>
<script language="javascript" type="text/javascript">
    window.top.window.updateQueue(<?php echo $errorcode;
?>,"<?php echo $errormsg[$errorcode]; ?>","<?php echo $target_path; ?>");
</script>
<?php 
	}
/**
 * function to check error
 */
function iserror() {
	global $error;
	global $errorcode;
	if ($error == "cancel") {
		$errorcode = 1;
		return true;
	}
	else {
		return false;
	}
}
/**
 * function to set file upload error
 */
function no_file_upload_error($file) {
	global $errorcode;
	$error_code = $file['error'];
	switch ($error_code) {
		case 1:
			$errorcode = 5;
			return false;
		case 2:
			$errorcode = 6;
			return false;
		case 3:
			$errorcode = 7;
			return false;
		case 4:
			$errorcode = 8;
			return false;
		case 6:
			$errorcode = 9;
			return false;
		case 7:
			$errorcode = 10;
			return false;
		case 8:
			$errorcode = 11;
			return false;
		case 0:
			return true;
		default:
			$errorcode = 12;
			return false;
	}
}
/**
 * function to check the extension of the file
 */
function isAllowedExtension($file) {
	global $allowedExtensions;
	global $errorcode;
	$filename = $file['name'];

	$output =  in_array(end(explode(".", $filename)), $allowedExtensions);
	if (!$output) {
		$errorcode = 2;
		return false;
	}
	else {
		return true;
	}
}

/**
 * function to check the file size
 */
function filesizeexceeds($file) {
	global $errorcode;
	$POST_MAX_SIZE = ini_get('post_max_size');
	$filesize = $file['size'];
	$mul = substr($POST_MAX_SIZE, -1);
	$mul = ($mul == 'M' ? 1048576 : ($mul == 'K' ? 1024 : ($mul == 'G' ? 1073741824 : 1)));
	if ($_SERVER['CONTENT_LENGTH'] > $mul*(int)$POST_MAX_SIZE && $POST_MAX_SIZE) {
		return true;
		$errorcode = 3;
	}
	else {
		return false;
	}
}

/**
 * function to upload video to temporary folder
 */
function doupload($file,$clientupload_val) {	
	global $errorcode;
    global $target_path;
		$destination_path="components/com_contushdvideoshare/views/videoupload/tmpl";
		if($clientupload_val=="true") {
			$destination=realpath(dirname(__FILE__).'/../../../components/com_contushdvideoshare/videos/');
			$destination_path=str_replace('\\', '/', $destination)."/";
		}
		$filename = JFile::makeSafe($file['name']);
		$target_path = $destination_path . rand() . "." . end(explode(".", $filename));
		//Clean up filename to get rid of strange characters like spaces etc
		$sourceImage = $file['tmp_name'];
			
		// To store images to a directory called components/com_contushdvideoshare/videos
		if(JFile::upload($sourceImage, $target_path)) {
        $errorcode = 0;
    }
    else {
        $errorcode = 4;
    }
    sleep(1);		
}
}
?>


