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
 * @abstract      : Contus HD Video Share Component Category Table
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */
/*
 ***********************************************************/
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
// table for category
class Tablecategory extends JTable {
    var $id = null;
    var $category = null;
    var $seo_category = null;
    var $parent_id = null;
    var $ordering = null;
    var $published = null;
    function Tablecategory(&$db) {
        parent::__construct('#__hdflv_category', 'id', $db);
    }
}
?>
