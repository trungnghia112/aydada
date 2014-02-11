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
 * @abstract      : Contus HD Video Share Component Controlpanel Controller 
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */

/*
 ***********************************************************/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import Joomla controller library
jimport('joomla.application.component.controller');
/**
 * hdvideoshare component controlpanel administrator controller
 */
class contushdvideoshareControllercontrolpanel extends ContusvideoshareController {
	// function to display hdvideoshare controlpanel
	function display($cachable = false, $urlparams = false) {
		$viewName = JRequest::getVar('view', 'controlpanel');
		$viewLayout = JRequest::getVar('layout', 'controlpanel');
		$view = $this->getView($viewName);
		if ($model = $this->getModel('controlpanel')) {
			$view->setModel($model, true);
		}
		$view->setLayout($viewLayout);
		$view->display();
	}
}
?>
