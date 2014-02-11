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
 * @abstract      : Contus HD Video Share Component Memberdetails Table
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */
/*
 ***********************************************************/
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
// table for memberdetails
class Tablememberdetails extends JTable {
	var $id = null;
	var $name = null;
    var $username = null;
    var $email = null;
    var $password = null;
    var $created_date = null;
    var $published = null;

	function Tablememberdetails(&$db){
		parent::__construct('#__hdflv_member_details', 'id', $db);
	}
}
?>
