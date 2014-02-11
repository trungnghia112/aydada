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
 * @abstract      : Contus HD Video Share Component Memberdetails Controller 
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */

/*
 ***********************************************************/
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import joomla controller library
jimport('joomla.application.component.controller');

class contushdvideoshareControllermemberdetails extends ContusvideoshareController {

	function display($cachable = false, $urlparams = false) //Function to list registered members
	{

		$viewName = JRequest::getVar('view', 'memberdetails');
		$viewLayout = JRequest::getVar('layout', 'memberdetails');
		$view = $this->getView($viewName);
		if ($model = $this->getModel('memberdetails'))
		{
			$view->setModel($model, true);
		}
		$view->setLayout($viewLayout);
		$view->display();
	}

	function publish() //Function to activate member
	{
		$detail = JRequest::get('POST');
		$model = $this->getModel('memberdetails');
		$model->memberActivation($detail);
		$this->setRedirect('index.php?layout=memberdetails&option=' . JRequest::getVar('option'));
	}

	function unpublish() //Function to deactivate member
	{
		$detail = JRequest::get('POST');
		$model = $this->getModel('memberdetails');
		$model->memberActivation($detail);
		$this->setRedirect('index.php?layout=memberdetails&option=' . JRequest::getVar('option'));
	}

	function allowupload() //Function to allow the user to upload
	{
		$detail = JRequest::get('POST');
		$model = $this->getModel('memberdetails');
		$model->allowUpload($detail);
		$this->setRedirect('index.php?layout=memberdetails&option=' . JRequest::getVar('option'));
	}

	function unallowupload() //Function to not allow the user to upload
	{
		$detail = JRequest::get('POST');
		$model = $this->getModel('memberdetails');
		$model->allowUpload($detail);
		$this->setRedirect('index.php?layout=memberdetails&option=' . JRequest::getVar('option'));
	}
}
?>
