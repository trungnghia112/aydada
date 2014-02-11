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
 * @abstract      : Contus HD Video Share Component Comment Table
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */
/*
 ***********************************************************/
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
// table for comment
class Tablecomment extends JTable {
	var $id = null;
	var $parentid = null;
    var $videoid = null;
    var $name = null;
    var $email = null;
    var $subject = null;
    var $message = null;
    var $created = null;
    var $published = null;

   	function Tablecomment(&$db){
		parent::__construct('#__hdflv_comments', 'id', $db);
	}
}
?>
