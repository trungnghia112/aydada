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
 * @abstract      : Contus HD Video Share Component Googlead Controller 
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */

/*
 ***********************************************************/
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import joomla controller library
jimport('joomla.application.component.controller');

/**
 * googlead Component Administrator Controller
 */
class contushdvideoshareControllergooglead extends ContusvideoshareController {

	/**
	 * Fuction to display google ad
	 */
    function display($cachable = false, $urlparams = false)
    {
        $viewName = JRequest::getVar('view', 'googlead');
        $viewLayout = JRequest::getVar('layout', 'googlead');
        $view = $this->getView($viewName);
        if ($model = $this->getModel('googlead'))
        {
            $view->setModel($model, true);
        }
        $view->setLayout($viewLayout);
        $view->display();
    }

    /**
     * Fuction to save google ad
     */
    function apply() 
    {
        $model = $this->getModel('googlead');
        $model->savegooglead();        
    }   
}
?>
