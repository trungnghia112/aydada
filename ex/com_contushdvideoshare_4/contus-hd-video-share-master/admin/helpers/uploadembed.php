<?php
/**
 * @name          : Joomla HD Video Share
 * @version	  : 3.4.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component Showvideos Uploadyoutube Helper
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */

## No direct access to this file
defined('_JEXEC') or die;

## Contushdvideoshare Upload embed code Helper
class uploadEmbedHelper
{
	##  function to upload youtube video
	function uploadEmbed($arrFormData,$idval)
	{
		$embedcode      = $arrFormData['embedcode'];
		$strThumbImg    = '';
		$fileoption     = $arrFormData['fileoption'];
                ##  update fields
		$db             = JFactory::getDBO();
		$query          = "UPDATE #__hdflv_upload SET embedcode='$embedcode' where id=$idval";
		$db->setQuery($query);
		$db->query();
		##  get thumb image name and set thumb image name
		$strThumbImg    = $arrFormData['thumbimageform-value'];
		$arrThumbImg    = explode('uploads/', $strThumbImg);
		if(isset($arrThumbImg[1])){
		$strThumbImg    = $arrThumbImg[1];
                }
                ## Get upload helper file to upload thumb
                require_once(FVPATH.DS.'helpers'.DS.'uploadfile.php');
                uploadFileHelper::uploadVideoProcessing('','',$idval, '', $strThumbImg, '', '','','', $arrFormData['newupload'], $fileoption);
                ## Delete temp file
                if ($strThumbImg != ''){
		uploadFileHelper::unlinkUploadedTmpFiles($strThumbImg);
                }
	}
}
?>