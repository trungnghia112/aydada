<?php
/**
 * @name 	        hdflvplayer
 ** @version	        2.1.0.1
 * @package	        Apptha
 * @since	        Joomla 1.5
 * @subpackage	        hdflvplayer
 * @author      	Apptha - http://www.apptha.com/
 * @copyright 		Copyright (C) 2011 Powered by Apptha
 * @license 		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      	com_hdflvplayer installation file.
 ** @Creation Date	23 Feb 2011
 ** @modified Date	28 Aug 2013
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

//importing default joomla components
jimport( 'joomla.application.component.view');

/*
 * HDFLV player view class to call model functions to diplay Ads list
 */
class hdflvplayerViewshowads extends HdflvplayerView
{
	protected $items;
	protected $pagination;
	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$this->state		= $this->get('State');
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		if(version_compare(JVERSION, '3.0.0', 'ge')) {
		$this->addToolbar();
}
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{
            JHTML::stylesheet( 'styles.css', 'components/com_hdflvplayer/css/' );
            $app = JFactory::getApplication();
		global $option;
		JToolBarHelper::title( JText::_( 'Video Ads' ),'ads-icon.png' );
		JToolBarHelper::addNew('addads','New Ad');
		JToolBarHelper::editList('editads','Edit');
		JToolBarHelper::publishList();
		JToolBarHelper::unpublishList();
		if($app->getUserStateFromRequest( $option.'filter_order_Status', 'filter_state', '', 'int' ) == -2)
		{
			JToolBarHelper::deleteList('', 'removeads', 'JTOOLBAR_EMPTY_TRASH');
		}
		else{
			JToolBarHelper::trash('trash');
		}

	}
	//Function to display submenu and model function calling for show Ads
	function showads()
	{
	if(version_compare(JVERSION, '3.0.0', 'ge')) {
		$this->addToolbar();
}
        //Model function calling and assign result set to display
        $model = $this->getModel();
        $showads = $model->showadsmodel();
		$this->assignRef('showads', $showads);
		parent::display();
	}

}
?>
