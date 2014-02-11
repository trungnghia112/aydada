<?php
/**
 * @name 	        editvideoupload.php
 ** @version	        2.1.0.1
 * @package	        Apptha
 * @since	        Joomla 1.5
 * @author      	Apptha - http://www.apptha.com/
 * @copyright 		Copyright (C) 2011 Powered by Apptha
 * @license 		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      	Contus HD FLV Player Admin Video Upload model file
 * @Creation Date	23 Feb 2011
 * @modified Date	28 Aug 2013
 */

## No direct acesss
defined('_JEXEC') or die();

## importing defalut joomla components
jimport('joomla.application.component.model');

/*
 * HDFLV player Model class to save functions,fetch video details while edit.
 */
class hdflvplayerModeleditvideoupload extends HdflvplayerModel {
        function __construct()
        {
                parent::__construct();
                global $errorcode;
                global $target_path;
                global $allowedExtensions;
                global $errorcode;
        }

        ## Function to fech playlists, preroll ads, Postroll ads, Access users list for add player.
        function addvideouploadmodel()
        {
                $db = JFactory::getDBO();

                ##  query to get ffmpegpath & file max upload size from #__hdflvplayersettings
                $query = 'SELECT uploadmaxsize FROM #__hdflvplayersettings';
                $db->setQuery( $query );
                $rs_playersettings = $db->loadResult();

                if(!empty($rs_playersettings))
                {
                        ##  To set max file size in php.ini
                        ini_set('upload_max_filesize', $rs_playersettings."M"); ##  to assign value to the php.ini file

                        ##  To set max execution_time in php.ini
                        ini_set('max_execution_time', 3600); ##  max execution time 1 Minute

                        ini_set('max_input_time',3600);

                        $upload_maxsize = $rs_playersettings;
                }

                ## To get playlist lists
                $rs_editupload = JTable::getInstance('hdflvplayerupload', 'Table');
                $query = 'SELECT id,name FROM  #__hdflvplayername
                                WHERE published=1 ORDER BY id ASC';
                $db->setQuery( $query );
                $rs_play 			= $db->loadObjectList();

                ## initialize variables
                $allow_status                   = 0;
                $per_upload			= 0;

                ## Checks whether the system allows fopen option
                if(ini_get('allow_url_fopen') == 1)
                {
                $allow_status                   = 1;
                }
                $uploadpathw                    = FVPATH.'/images/uploads/';

                ## Checks whether the com_hdflvplayer/imges/uploads folder writeable or not
                if(is_writable("$uploadpathw"))
                {
                $per_upload                     = 1;
                }

                ## query to get preroll, post roll ads
                $query  = 'SELECT id,adsname FROM #__hdflvplayerads
                                WHERE typeofadd != \'mid\' AND typeofadd != \'ima\' and published=1 ORDER BY adsname ASC';
                $db->setQuery( $query);
                $rs_ads = $db->loadObjectList();

                ## query to fetch mid roll ads
                $query  = 'SELECT id,adsname FROM #__hdflvplayerads
                                        WHERE typeofadd = \'mid\' AND typeofadd != \'ima\' and published=1 ORDER BY adsname ASC';
                $db->setQuery( $query);
                $rs_midads = $db->loadObjectList();

                ## Query to fetch accessible users
                if(version_compare(JVERSION,'1.6.0','ge'))
                {
                        $strTable   = '#__viewlevels';
                        $strName    = 'title';
                }
                else
                {
                        $strTable   = '#__groups';
                        $strName    = 'name';
                }
                ## query to fetch user groups
                $query = "SELECT `id` as id ,`$strName` as title FROM `$strTable` ORDER BY `id` asc";
                $db->setQuery($query);
                $rs_access = $db->loadObjectList();




                ## Assigns the results and returns the result
                $add = array('upload_maxsize'       => $upload_maxsize,
                            'rs_play'               => $rs_play,
                            'per_upload'            => $per_upload,
                            'allow_status'          => $allow_status,
                            'rs_editupload'         => $rs_editupload,
                            'rs_ads'                => $rs_ads,
                            'rs_access'             => $rs_access,
                            'rs_midads'             => $rs_midads);
                return $add;
        }

        ## Function to fech playlists, preroll ads, Postroll ads, Access users list for edit player.
        function editvideouploadmodel()
        {
                $db 	= JFactory::getDBO();

                ## Query to fetch playlists
                $query 	= 'SELECT id,name FROM #__hdflvplayername
                                        WHERE published=1 ORDER BY id ASC ';
                $db->setQuery( $query);
                $rs_play = $db->loadObjectList();

                ## Query to fetch the pre roll, post roll ads
                $query   = 'SELECT id,adsname FROM #__hdflvplayerads
                                        WHERE typeofadd != \'mid\' AND typeofadd != \'ima\' AND published=1 ORDER BY adsname ASC';
                $db->setQuery( $query);
                $rs_ads  = $db->loadObjectList();

                ## Query to fetch accessible users
                if(version_compare(JVERSION,'1.6.0','ge'))
                {
                        $strTable   = '#__viewlevels';
                        $strName    = 'title';
                }
                else
                {
                        $strTable   = '#__groups';
                        $strName    = 'name';
                }
                ## query to fetch user groups
                $query = "SELECT `id` as id ,`$strName` as title FROM `$strTable` ORDER BY `id` asc";
                $db->setQuery($query);
                $rs_access = $db->loadObjectList();

                $rs_editupload  = JTable::getInstance('hdflvplayerupload', 'Table');
                $cid            = JRequest::getVar( 'cid', array(0), '', 'array' );

                ##  To get the id no to be edited...
                $id 			= $cid[0];
                $rs_editupload->load($id);
                $lists['published']     = JHTML::_('select.booleanlist','published',$rs_editupload->published);

                ##  To set the fetched result into array and returns
                $editadd = array('rs_editupload' => $rs_editupload,
                                'rs_play'	 => $rs_play,
                                'rs_ads'	 => $rs_ads,
                                'rs_access'      => $rs_access);
                return $editadd;
        }

        ## Function to save video
        function savevideouploadmodel($task)
        {
                $option = 'com_hdflvplayer';

                ## Fetch the selected file option from POST
                $fileoption             = JRequest::getVar('fileoption','POST');
                $db 			= JFactory::getDBO();

                ## Instantiate table name.
                $rs_saveupload          = JTable::getInstance('hdflvplayerupload', 'Table');

                ## Loads selected video record id
                $cid 			= JRequest::getVar( 'cid', array(0), '', 'array' );
                $id 			= $cid[0];
                $rs_saveupload->load($id);

                ## Get inputs given for video to store
                $arrFormData            = JRequest::get('post');

                ##  To get height & width from playersettings for preview images
                $query = 'SELECT player_values FROM  #__hdflvplayersettings LIMIT 1';
                $db->setQuery( $query );
                $rs_settings = $db->loadResult();
                $rs_settings = unserialize($rs_settings);
                ##  Fetch width height ffmpegpath values and assign into variables

                if(!empty($rs_settings))
                {
                        ##  In Ffmpeg allowed height should be even nos.Hence 1 is added if it is odd no.
                        if(( $rs_settings['height'] % 2) == 0)
                        {
                                $previewheight = $rs_settings['height'];
                        }
                        else
                        {
                                $previewheight = $rs_settings['height']+1;
                        }

                        ##  In Ffmpeg allowed width should be even nos.Hence 1 is added if it is odd no.
                        if(( $rs_settings['width'] % 2) == 0)
                        {
                                $previewwidth = $rs_settings['width'];
                        }
                        else
                        {
                                $previewwidth = $rs_settings['width']+1;
                        }

                        ##  To make sure ffmpeg path is provided
                        if( $rs_settings['ffmpegpath'])
                        {
                                $ffmpegpath = $rs_settings['ffmpegpath'];
                        }
                }

                ## Validates the form submitted or not
                if( !$rs_saveupload->bind(JRequest::get('post')))
                {
                        exit();
                }

                ## Checks the videourl provided or not
                if(isset($rs_saveupload->videourl))
                {

                                $rs_saveupload->videourl = trim($rs_saveupload->videourl);
                }

                ## Fetch the video description
                $rs_saveupload->description = JRequest::getVar( 'description', '', 'post', 'string',JREQUEST_ALLOWRAW );

                ## Stores the given input with appropriate fields
                if (!$rs_saveupload->store())
                {
                        JError::raiseError(500, JText::_($rs_saveupload->getError()));
                }

                ## Checks whether the given field available or not
                $rs_saveupload->checkin();

                ## Gets the inserted record id
                $idval = $rs_saveupload->id;
                /**
                 * uploading videos
                 * type : URL
                 */
                if ($fileoption == 'Url'){
                        require_once(FVPATH.DS.'helpers'.DS.'uploadurl.php');
                        uploadUrlHelper::uploadUrl($arrFormData,$idval);
                }

                /**
                 * uploading videos
                 * type : YOUTUBE
                 */
                if ($fileoption == "Youtube"){
                        require_once(FVPATH.DS.'helpers'.DS.'uploadyoutube.php');
                        uploadYouTubeHelper::uploadYoutube($arrFormData,$idval);
                }

                /**
                 * uploading videos
                 * type : FILE
                 */
                ##  check in the item

                if ($fileoption == "File"){
                        require_once(FVPATH.DS.'helpers'.DS.'uploadfile.php');
                        uploadFileHelper::uploadFile($arrFormData,$idval);
                }

                /**
                 * uploading videos
                 * type : FFMPEG
                 */
                if ($fileoption == "FFmpeg"){
                        require_once(FVPATH.DS.'helpers'.DS.'uploadffmpeg.php');
                        uploadFfmpegHelper::uploadFfmpeg($arrFormData,$idval);
                }

                ## Based on tasks, assign success message and return url
                switch ($task)
                {
                        ## Loads when click on Apply button
                        case 'applyvideoupload':
                                $msg    = 'Changes Saved';
                                $link   = 'index.php?option=' . $option .'&task=editvideoupload&cid[]='. $rs_saveupload->id;
                                break;

                        ## Loads when click on Save button
                        case 'savevideoupload':
                        default:
                                $msg    = 'Saved';
                                $link   = 'index.php?option='.$option.'&task=uploadvideos';
                                break;
                }

                ##  redirect to given url
                JFactory::getApplication()->redirect($link, $msg);
        }

        ## Function to remove videos
        function removevideouploadmodel() {
                $option = 'com_hdflvplayer';

                ## Fetch the row id from selected
                $cid    = JRequest::getVar('cid', array(), '', 'array');
                $db     = JFactory::getDBO();
                $cids   = implode(',', $cid);

                ## Fetch the videourl,thumburl,preview url,hdurl file paths
                $qry = "SELECT videourl,thumburl,previewurl,hdurl FROM #__hdflvplayerupload WHERE id IN ( $cids )";
                $db->setQuery($qry);
                $rs_removeupload    = $db->loadObjectList();
                $vpath              = VPATH . "/";

                if (count($rs_removeupload)) {
                        ## If the files available, remove the files from folder
                        for ($i = 0; $i < count($rs_removeupload); $i++) {
                                if ($rs_removeupload[$i]->videourl)
                                {
                                unlink($vpath . $rs_removeupload[$i]->videourl);
                                }
                                if ($rs_removeupload[$i]->thumburl)
                                {
                                unlink($vpath . $rs_removeupload[$i]->thumburl);
                                }
                                if ($rs_removeupload[$i]->previewurl)
                                {
                                unlink($vpath . $rs_removeupload[$i]->previewurl);
                                }
                                if ($rs_removeupload[$i]->hdurl)
                                {
                                unlink($vpath . $rs_removeupload[$i]->hdurl);
                                }
                        }
                }
                ##  Checks If row selected
                if (count($cid)) {
                        $cids = implode(',', $cid);

                        ## Remove selected record(s) from table
                        $query = 'DELETE FROM #__hdflvplayerupload WHERE id IN ( '.$cids.')';
                        $db->setQuery($query);
                        if (!$db->query()) {
                                JError::raiseError(500, JText::_($db->getErrorMsg()));

                        }
                }
                ##  page redirect
                $msg    = 'File deleted successfully';
                $link   = 'index.php?option=' . $option . '&task=uploadvideos';
                JFactory::getApplication()->redirect($link, $msg);
        }

        ## Function to use upload files in temporary folder com_hdflvplayer/images/uploads/ and return status
        function fileupload()
        {

                ## Instantiate variables and all status with error message
                $target_path    = '';
                $error          = '';
                $errorcode      = 12;
                $errormsg[0]    = "File Uploaded Successfully";
                $errormsg[1]    = "Cancelled by user";
                $errormsg[2]    = "Invalid File type specified";
                $errormsg[3]    = "Your File Exceeds Server Limit size";
                $errormsg[4]    = "Unknown Error Occured";
                $errormsg[5]    = "The uploaded file exceeds the upload_max_filesize directive in php.ini";
                $errormsg[6]    = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
                $errormsg[7]    = "The uploaded file was only partially uploaded";
                $errormsg[8]    = "No file was uploaded";
                $errormsg[9]    = "Missing a temporary folder";
                $errormsg[10]   = "Failed to write file to disk";
                $errormsg[11]   = "File upload stopped by extension";
                $errormsg[12]   = "Unknown upload error.";
                $errormsg[13]   = "Please check post_max_size in php.ini settings";

                ## Get error value
                if (JRequest::getVar('error')) {
                        $error = JRequest::getVar('error');
                }

                ## Get processing value
                if (JRequest::getVar('processing')) {
                        $pro = JRequest::getVar('processing');
                }

                ## Get mode from post
                if (JRequest::getVar('mode','POST'))
                {
                        $exttype = JRequest::getVar('mode','POST');

                        ## Checking the allowable extensions for videos,images.
                        if ($exttype == 'video')
                        {
                        $allowedExtensions = array("mp3","MP3","flv", "FLV", "mp4", "MP4" , "m4v", "M4V", "M4A", "m4a", "MOV", "mov", "mp4v", "Mp4v", "F4V", "f4v");
                        }
                        elseif($exttype == 'image')
                        {
                        $allowedExtensions = array("jpg", "JPG", "png", "PNG","jpeg","JPEG");
                        }
                        if ($exttype == 'video_ffmpeg')
                        {
                        $allowedExtensions = array("avi","AVI","dv","DV","3gp","3GP","3g2","3G2","mpeg","MPEG","wav","WAV","rm","RM","mp3","MP3","flv", "FLV", "mp4", "MP4" , "m4v", "M4V", "M4A", "m4a", "MOV", "mov", "mp4v", "Mp4v", "F4V", "f4v");
                        }
                }

                $files = JRequest::getVar('myfile', null, 'files', 'array');

                ## Import filesystem libraries. Perhaps not necessary, but does not hurt
                jimport('joomla.filesystem.file');

                ## Clean up filename to get rid of strange characters like spaces etc
                $filename = JFile::makeSafe($files['name']);

                ## check if upload cancelled
                if (!$this->iserror()) {

                        ## check if stopped by post_max_size
                        if (($pro == 1) && (empty($files))) {
                                $errorcode = 13;
                        }
                        else {
                                $file               = $files;
                                $destination_path   = 'images/uploads/';

                                $db = JFactory::getDBO();
                                $query = 'SELECT `id` FROM `#__hdflvplayerupload` order by id desc limit 0,1';
                                $db->setQuery( $query );
                                $rs_playlistname    = $db->loadObjectList();
                                $img_id             = $rs_playlistname[0]->id+1;
                                $img_id             = rand(0,1000);
                                
                                ## Generates file name with target path
                                $target_path        = $destination_path . $img_id . '.' . end(explode('.', $file['name']));
                                
                                ## Checks whether the uploaded file exceeds maximum size, completely uploaded or not missing directory errors etc.
                                if ($this->no_file_upload_error($file)) {

                                        if ($this->isAllowedExtension($file,$allowedExtensions)) {

                                                ## check file size
                                                if (!$this->filesizeexceeds($file)) {
                                                        $errorcode = $this->doupload($file,$img_id);
                                                }
                                        }
                                }
                        }
                }

                ?>
                <!-- Print status after upload a file -->
                <script language="javascript" type="text/javascript">window.top.window.updateQueue(<?php echo $errorcode;?>,"<?php echo $errormsg[$errorcode]; ?>","<?php echo $target_path; ?>");</script>
        <?php
        }
        ## Checks when click on cancel button
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
        ## Checks whether the uploaded file exceeds maximum size, completely uploaded or not missing directory errors etc.
        function no_file_upload_error($file) {
                global $errorcode;
                $error_code = $file['error'];

                ## Checks and assign the error code
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

        ## Checking the uploaded video, image having the allowable extensions
        function isAllowedExtension($file,$allowedExtensions) {

                ## Gets the uploaded file extension with allowable file extensions
                $filename   = $file['name'];
                $output     =  in_array(end(explode(".", $filename)), $allowedExtensions);
                if (!$output) {
                        $errorcode = 2;
                        return false;
                }
                else {
                        return true;
                }
        }

        ## Checking the file size with Maximum size specified php.ini
        function filesizeexceeds($file) {
                $POST_MAX_SIZE  = ini_get('post_max_size');
                $filesize       = $file['size'];
                $mul            = substr($POST_MAX_SIZE, -1);
                $mul            = ($mul == 'M' ? 1048576 : ($mul == 'K' ? 1024 : ($mul == 'G' ? 1073741824 : 1)));
                if ($_SERVER['CONTENT_LENGTH'] > $mul*(int)$POST_MAX_SIZE && $POST_MAX_SIZE) {
                        return true;
                        $errorcode = 3;
                }
                else {
                        return false;
                }
        }

        ## Function to move the uploaded file into com_hdflvplayer\images\uploads\ folder
        function doupload($file,$img_id) {
                $destination_path=FVPATH.DS.'images'.DS.'uploads'.DS;
                $target_path = $destination_path . $img_id . '.' . end(explode('.', $file['name']));
                ## Moves the uploaded file into com_hdflvplayer\images\uploads\ folder
                if(@move_uploaded_file($file['tmp_name'], $target_path)) {
                        $errorcode = 0;
                }
                else {
                        $errorcode = 4;
                }
                sleep(1);
                return $errorcode;
        }
}
?>