<?php
/*
 ***********************************************************/
/**
 * @name          : Joomla HD Video Share
 * @version	  : 3.4
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2012 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component Playxml View Page
 * @Creation Date : March 2010
 * @Modified Date : May 2013
 * */

/*
 ***********************************************************/
// No direct access to this file

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');


class contushdvideoshareViewrss extends ContushdvideoshareView
{

	function display($cachable = false, $urlparams = false)
	{
        $model =& $this->getModel();
		$detail = $model->playgetrecords();
	}

}
?>   
