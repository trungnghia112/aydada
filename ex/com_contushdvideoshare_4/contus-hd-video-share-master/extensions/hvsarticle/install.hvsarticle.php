<?php
/**
 * @name 	        HVS Article Plugin
 * @version	        1.0
 * @package	        Apptha
 * @since	        Joomla 1.5
 * @author      	Apptha - http://www.apptha.com/
 * @copyright 		Copyright (C) 2013 Powered by Apptha
 * @license 		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      	HVS Article Plugin installation file.
 * @Creation Date	July 2013
 * @modified Date	July 2013
 */
/*
 * Class for HVS Article Plugin installation
 */
class plgContenthvsarticleInstallerScript {

    function install($parent) {
            
    }
        function uninstall($parent) {
           
        }

        function update($parent) {
            
        }

        function preflight($type, $parent) {
            
        }

        function postflight($type, $parent) {

            $db = JFactory::getDBO();

        if (version_compare(JVERSION, '1.7.0', 'ge')) {
            $query = 'UPDATE  #__extensions ' .
                    'SET enabled=1 ' .
                    'WHERE element = "hvsarticle"';
            $db->setQuery($query);
            $db->query();
        } elseif (version_compare(JVERSION, '1.6.0', 'ge')) {
            $query = 'UPDATE  #__extensions ' .
                    'SET enabled=1 ' .
                    'WHERE element= "hvsarticle"';
            $db->setQuery($query);
            $db->query();
        }
        else {
            $query = 'UPDATE  #__plugins ' .
                    'SET enabled=1 ' .
                    'WHERE element = "hvsarticle"';
            $db->setQuery($query);
            $db->query();
        }
        $root = JPATH_SITE;
        JFile::move($root . '/plugins/content/hvsarticle/hvsarticle.j3.xml', $root . '/plugins/content/hvsarticle/hvsarticle.xml');
            ?>
     <!-- Display Installation Status -->
        

<?php
        }

    }

?>