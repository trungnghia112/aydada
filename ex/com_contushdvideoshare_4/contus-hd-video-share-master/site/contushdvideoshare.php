<?php
/*
 ***********************************************************/
/**
 * @name          : Joomla HD Video Share
 *** @version	  : 3.4.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component Controller
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */
/*
 ***********************************************************/

defined('_JEXEC') or die('Restricted access');

 JLoader::register('contusvideoshareController', JPATH_COMPONENT_ADMINISTRATOR.'/helpers/controller.php');
JLoader::register('ContushdvideoshareView', JPATH_COMPONENT_ADMINISTRATOR.'/helpers/view.php');
JLoader::register('ContushdvideoshareModel', JPATH_COMPONENT_ADMINISTRATOR.'/helpers/model.php');
if(!defined('DS')) { define('DS',DIRECTORY_SEPARATOR); }

require_once( JPATH_COMPONENT.DS.'controller.php' );
$cache = JFactory::getCache('com_contusvideoshare');
$cache->clean();
date_default_timezone_set('UTC');
if(version_compare(JVERSION,'1.7.0','ge')) {
    $version='1.7';
} elseif(version_compare(JVERSION,'1.6.0','ge')) {
    $version='1.6';
} else {
    $version='1.5';
}
if($version == '1.5'){
    JLoader::register('JHtmlString', JPATH_COMPONENT.'/string.php');
}
JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_contushdvideoshare'.DS.'tables');
$controller = new contushdvideoshareController();
$controller->execute( JRequest::getVar('task') );
$controller->redirect();
?>