<?php
/**
 * @name 	        languagexml.php
 ** @version	        2.1.0.1
 * @package	        Apptha
 * @since	        Joomla 1.5
 * @author      	Apptha - http://www.apptha.com/
 * @copyright 		Copyright (C) 2011 Powered by Apptha
 * @license 		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      	Contus HD FLV Player Language XML file
 * @Creation Date	23 Feb 2011
 * @modified Date	28 Aug 2013
 */
## No direct acesss
defined('_JEXEC') or die();

##  implementing default component libraries
jimport( 'joomla.application.component.model' );

/*
 * Model class for generating languagexml
 */
class hdflvplayerModellanguagexml extends HdflvplayerModel
{
	## Function to fetch language settings
	function getlanguage()
	{
		$db     = JFactory::getDBO();
		$query  = "SELECT `player_lang` FROM `#__hdflvplayerlanguage` WHERE id = 1 ";
		$db->setQuery( $query );
		$rows   = $db->loadObject();
		return $rows;
	}
}