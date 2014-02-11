<?php
/**
 * @name          : Joomla HD Video Share
 *** @version	  : 3.4.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2012 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Search Module Install file
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Include the actual subinstaller class
jimport('joomla.filesystem.folder');
jimport('joomla.installer.installer');
jimport( 'joomla.environment.uri' );

/**
 * API entry point. Called from main installer.
 */
class mod_HDVideoShareSearchInstallerScript
{
    

     function preflight($type, $parent){

}
    function install($parent)
		{
       
            $db = JFactory::getDBO();
     $query = "UPDATE #__modules SET published='1' WHERE module='mod_HDVideoShareSearch' ";
        $db->setQuery($query);
        $db->query();
$query = "SELECT id FROM #__modules WHERE module = 'mod_HDVideoShareSearch' ";
        $db->setQuery($query);
        $db->query();
        $mid4 = $db->loadResult();
        $query = "INSERT INTO #__modules_menu (moduleid) VALUES ('$mid4')";
        $db->setQuery($query);
        $db->query();
}

/**
 * API entry point. Called from main un installer.
 */
function postflight( $type, $parent ) {

                 

}
function uninstall() {
   
}
}