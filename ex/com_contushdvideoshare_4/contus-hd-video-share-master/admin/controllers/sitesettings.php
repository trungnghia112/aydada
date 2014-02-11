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
 * @abstract      : Contus HD Video Share Component Sitesettings Controller 
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
 * hdvideoshare component sitesettings administrator controller
 */
class contushdvideoshareControllersitesettings extends ContusvideoshareController
{
	/**
	 * function to display sitesettings
	 */ 
    function display($cachable = false, $urlparams = false)
    {
        $viewName = JRequest::getVar('view', 'sitesettings');
        $viewLayout = JRequest::getVar('layout', 'sitesettings');
        $view = $this->getView($viewName);
        if ($model = $this->getModel('sitesettings'))
        {
            $view->setModel($model, true);
        }
        $view->setLayout($viewLayout);
        $view->display();
    }

    /**
     * function to edit sitesettings     
     */ 
    function edit()
    {
        $this->display();
    }

    /**
     * function to save sitesettings     
     */ 
    function apply()
    {      
        $arrFormData = JRequest::get('POST');
        $model = $this->getModel('sitesettings');
        $model->savesitesettings($arrFormData);        
    }
}
?>
