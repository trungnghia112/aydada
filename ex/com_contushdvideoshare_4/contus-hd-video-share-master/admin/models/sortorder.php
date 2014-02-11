<?php
/*
 ***********************************************************/
/**
 * @name          : Joomla HD Video Share
 ****@version	  : 3.4.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component Sortorder Model 
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */

/*
 ***********************************************************/
// No direct access to this file
defined( '_JEXEC' ) or die( 'Restricted access' );
// import joomla model library
jimport('joomla.application.component.model');

class contushdvideoshareModelsortorder extends ContushdvideoshareModel {


	//Function to change sort order when drags the row
	function videosortordermodel()
	{
		global $mainframe;
		$db = JFactory::getDBO();
		$listitem=JRequest::getvar('listItem');
		$ids = implode(',', $listitem);
		$sql = 'UPDATE `#__hdflv_upload` SET `ordering` = CASE id ';
		foreach ($listitem as $position => $item) {
			$sql .= sprintf("WHEN %d THEN %d ", $item, $position);
		}
		$sql .= ' END WHERE id IN ('.$ids.')';
		$db->setQuery($sql);
		$db->query();	
		exit();

	}
	
	
	



}
?>
