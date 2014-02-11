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
/*
 * Class for HDFLV player installation
 */
//No direct acesss
defined('_JEXEC') or die('Restricted access');
class plgContenthdflvplayerInstallerScript {

    function install($parent) {
        
        $db = & JFactory::getDBO();

        if (version_compare(JVERSION, '1.7.0', 'ge')) {
            $query = 'UPDATE  #__extensions ' .
                    'SET enabled=1 ' .
                    'WHERE element = "hdflvplayer"';
            $db->setQuery($query);
            $db->query();
        } elseif (version_compare(JVERSION, '1.6.0', 'ge')) {
            $query = 'UPDATE  #__extensions ' .
                    'SET enabled=1 ' .
                    'WHERE element= "hdflvplayer"';
            $db->setQuery($query);
            $db->query();
        }
        else {
            $query = 'UPDATE  #__plugins ' .
                    'SET enabled=1 ' .
                    'WHERE element = "hdflvplayer"';
            $db->setQuery($query);
            $db->query();
        }
           
    }
        function uninstall($parent) {
           
        }

        function update($parent) {
            
        }

        function preflight($type, $parent) {
            
        }

        function postflight($type, $parent) {
            
        }

    }

?>