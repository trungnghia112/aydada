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
 * @abstract      : Contus HD Video Share Component Ads Controller
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
 * Contushdvideoshare Component Administrator Ads Controller
 */
class contushdvideoshareControllerads extends ContusvideoshareController {

	/**
	 * Function to display ads
	 */
	
	function display($cachable = false, $urlparams = false)
	{
		$view = $this->getView('showads');
		if ($model = $this->getModel('showads'))
		{
			$view->setModel($model, true);
		}
		$view->setLayout('showadslayout');
		$view->showads();
	}

	/**
	 * Function to add new ad
	 */
	
	function addads() 
	{
		$view = $this->getView('ads');
		// Get/Create the model
		if ($model = $this->getModel('addads'))
		{
			//Push the model into the view (as default)
			//Second parameter indicates that it is the default model for the view
			$view->setModel($model, true);
		}
		$view->setLayout('adslayout');
		$view->ads();
	}
	
	/**
	 * Function to edit the ad
	 */
	
	function editads() 
	{
		$view = $this->getView('ads');
		// Get/Create the model
		if ($model = $this->getModel('editads'))
		{
			//Push the model into the view (as default)
			//Second parameter indicates that it is the default model for the view
			$view->setModel($model, true);
		}
		$view->setLayout('adslayout');
		$view->editads();
	}
	
	/**
	 * Function to save ad
	 */
	
	function saveads() 
	{
		// Get/Create the model
		if ($model = $this->getModel('showads')) {
			//Push the model into the view (as default)
			//Second parameter indicates that it is the default model for the view
			$model->saveads(JRequest::getVar('task'));
		}
	}
	
	/**
	 * Function to save ad and redirect to same page
	 */
	
	function applyads() 
	{
		// Get/Create the model
		if ($model = $this->getModel('showads'))
		{
			//Push the model into the view (as default)
			//Second parameter indicates that it is the default model for the view
			$model->saveads(JRequest::getVar('task'));
		}
	}
	
	/**
	 * Function to remove ad
	 */
	
	function removeads() //
	{
		if ($model = $this->getModel('editads'))
		{
			//Push the model into the view (as default)
			//Second parameter indicates that it is the default model for the view
			$model->removeads();
		}
	}
	
	/**
	 * Function to cancel action
	 */
	
	function CANCEL6() 
	{
		$view = $this->getView('showads');
		// Get/Create the model
		if ($model = $this->getModel('showads'))
		{
			$view->setModel($model, true);
		}
		$view->setLayout('showadslayout');
		$view->showads();
	}
	
	/**
	 * Function to publish ad
	 */
	
	function publish() { 
		$adsdetail = JRequest::get('POST');
		$model = $this->getModel('showads');
		$model->statusChange($adsdetail);
	}
	
	/**
	 * Function to unpublish ad
	 */
	
	function unpublish() { 
		$adsdetail = JRequest::get('POST');
		$model = $this->getModel('showads');
		$model->statusChange($adsdetail);
	}
	
	/**
	 * Function to trash ad
	 */
	
	function trash() { 
		$adsdetail = JRequest::get('POST');
		$model = $this->getModel('showads');
		$model->statusChange($adsdetail);
	}
}