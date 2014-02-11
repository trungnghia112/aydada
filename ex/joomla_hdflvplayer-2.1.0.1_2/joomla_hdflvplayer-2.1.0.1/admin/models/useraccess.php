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

jimport('joomla.application.component.model');

class hdflvplayerModeluseraccess extends HdflvplayerModel {


    function useraccessmodel($id, $access )
    {
       global $mainframe;

	// Check for request forgeries
        
	JRequest::checkToken() or jexit( 'Invalid Token' );

	// Initialize variables
	$db =JFactory::getDBO();
    $id=$id[0];

	$row =JTable::getInstance('hdflvplayerupload', 'Table');
	$row->load( $id );
	$row->access = $access;

	if ( !$row->check() ) {
		return $row->getError();
	}
	if ( !$row->store() ) {
		return $row->getError();
	}
        $link= 'index.php?option=com_hdflvplayer&task=uploadvideos';
        JFactory::getApplication()->redirect($link, $msg);
	

    }


    
}
?>
