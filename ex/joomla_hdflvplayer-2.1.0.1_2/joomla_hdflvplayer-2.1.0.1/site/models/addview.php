<?php
/**
 * @name 	        addview.php
 ** @version	        2.1.0.1
 * @package	        Apptha
 * @since	        Joomla 1.5
 * @author      	Apptha - http://www.apptha.com/
 * @copyright 		Copyright (C) 2011 Powered by Apptha
 * @license 		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      	Contus HD FLV Player addview file for increasing View count of a video
 * @Creation Date	23 Feb 2011
 * @modified Date	28 Aug 2013
 */
## No direct acesss
defined('_JEXEC') or die();

jimport( 'joomla.application.component.model' );

class hdflvplayerModeladdview extends HdflvplayerModel
{
	function getviewcount()
	{
		$thumbid1   = "";
		$thumbid1   = JRequest::getvar('thumbid','','get','int');
		$db         = JFactory::getDBO();
		$query      = "update #__hdflvplayerupload SET times_viewed=1+times_viewed where id=$thumbid1";
		$db->setQuery($query );
		$db->query();
	}
}