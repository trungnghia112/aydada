<?php
/*
 ***********************************************************/
/**
 * @name          : Joomla HD Video Share
 *** @version	  : 3.4.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2012 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Category Module Helper
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */

/*
 ***********************************************************/
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
/* Contushdvideoshare Category Module Helper */
class modcategorylist {
	/* function to get category list */
	public static function getcategorylist() {
		$db =  JFactory::getDBO();
		$query = "SELECT id,category,seo_category
        		  FROM #__hdflv_category 
        		  WHERE parent_id=0 AND published=1 
        		  ORDER BY category asc";
		$db->setQuery($query);
		$rs = $db->loadObjectList();
		return $rs;
	}

        public static function getcategorysettings() {
        $db =  JFactory::getDBO();
        $featurequery = "SELECT dispenable FROM #__hdflv_site_settings"; //Query is to select the popular videos row
        $db->setQuery($featurequery);
        $rows = $db->loadResult();
        return $rows;
    }

}

?>
