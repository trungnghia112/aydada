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
 * @abstract      : Contus HD Video Share Component Category Controller 
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
 * Contushdvideoshare Component Administrator Categiry Controller
 */
class contushdvideoshareControllercategory extends ContusvideoshareController {

	/**
	 * function to prepare view for category page
	 */ 
    function display($cachable = false, $urlparams = false)
    {
        $viewName = JRequest::getVar('view', 'category');
        $viewLayout = JRequest::getVar('layout', 'category');        
        $view = $this->getView($viewName);
        if ($model = $this->getModel('category'))
        {
            $view->setModel($model, true);
        }       
        $view->setLayout($viewLayout);
        $view->display();
    }
	
	/**
	 * function to save category
	 */   
    function save()
    {
        $detail = JRequest::get('POST');        
        $model = $this->getModel('category');
        $model->savecategory($detail);
        $this->setRedirect('index.php?option=' . JRequest::getVar('option') . '&layout=category', 'Saved Successfully');
    }	

	/**
	 * function to remove category
	 */   
    function remove()
    {
        $arrayIDs = JRequest::getVar('cid', null, 'default', 'array'); //Reads cid as an array
        if ($arrayIDs[0] === null)
        { //Make sure the cid parameter was in the request
            JError::raiseWarning(500, 'Category missing from the request');
        }
        $model = $this->getModel('category');
        $model->deletecategary($arrayIDs);
        $this->setRedirect('index.php?option=' . JRequest::getVar('option') . '&layout=category', 'Saved Successfully');
    }

	/**
	 * function to cancel action
	 */    
    function cancel()
    {
        $this->setRedirect('index.php?option=' . JRequest::getVar('option') . '&layout=category');
    }

	/**
	 * function to publish action
	 */   
    function publish()
    {
        $detail = JRequest::get('POST');
        $model = $this->getModel('category');
        $model->changeStatus($detail);
        $this->setRedirect('index.php?option=' . JRequest::getVar('option') . '&layout=category');
    }

	/**
	 * function to unpublish action
	 */    
    function unpublish()
    {
        $detail = JRequest::get('POST');
        $model = $this->getModel('category');
        $model->changeStatus($detail);
        $this->setRedirect('index.php?option=' . JRequest::getVar('option') . '&layout=category');
    }

	/**
	 * function to save category.
	 */    
    function apply()
    {
        $detail = JRequest::get('POST');
        $model = $this->getModel('category');
        $model->savecategory($detail);
        $link = 'index.php?option=' . JRequest::getVar('option') . '&layout=category&task=edit&cid[]=' . $detail['id'];
        $this->setRedirect($link, 'Saved Successfully');
    }
    
	/**
	 * function to trash action
	 */    
    function trash()
    {
        $detail = JRequest::get('POST');
        $model = $this->getModel('category');
        $model->changeStatus($detail);
        $this->setRedirect('index.php?option=' . JRequest::getVar('option') . '&layout=category');
    }
}
?>
