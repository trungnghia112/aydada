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
 * @abstract      : Contus HD Video Share Component Googlead Table
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */
/*
 ***********************************************************/
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
// table for googlead
class Tablegooglead extends JTable {
	
	var $id = null;
	var $code = null;
    var $showoption = null;
    var $closeadd = null;
	var $reopenadd = null;
    var $publish = null;
    var $ropen = null;
	var $showaddc  = null;
    var $showaddm = null;
    var $showaddp = null;
  
	function Tablegooglead(&$db){       
		parent::__construct('#__hdflv_googlead', 'id', $db);
     
	}
}
?>
