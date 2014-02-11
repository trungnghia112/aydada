<?php
/*
 ***********************************************************/
/**
 * @name          : Joomla HD Video Share
 ** @version	  : 2.1.0.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component Administrator modle file
 * @Creation Date : March 2010
 * @Modified Date : May 2013
 * */
/*
 ***********************************************************/
// No direct access to this file
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');

if (version_compare(JVERSION, '3.0', 'ge')) {

    class HdflvplayerModel extends JModelLegacy {
	
        public static function addIncludePath($path = '', $prefix = '') {
            return parent::addIncludePath($path, $prefix);
        }

    }

} else if (version_compare(JVERSION, '2.5', 'ge')) {

    class HdflvplayerModel extends JModel {
	
        public static function addIncludePath($path = '', $prefix = '') {
            return parent::addIncludePath($path, $prefix);
        }

    }

} else if (version_compare(JVERSION, '1.6', 'ge') || version_compare(JVERSION, '1.7', 'ge')) {

    class HdflvplayerModel extends JModel {

        public static function addIncludePath($path = '', $prefix = '') {
            return parent::addIncludePath($path, $prefix);
        }

    }

}else {

    class HdflvplayerModel extends JModel {
	
        public function addIncludePath($path = '', $prefix = '') {
            return parent::addIncludePath($path);
        }

    }

}

?>