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
defined('_JEXEC') or die('Restricted access');

//importing default joomla components
jimport('joomla.application.component.view');

/*
 * HDFLV player view class to call model functions to diplay video details
 */
class hdflvplayerViewuploadvideos extends HdflvplayerView {
	
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

            $app =  JFactory::getApplication();
		global $option;
		JToolBarHelper::title( JText::_( 'Videos' ),'upload-videos.png' );
		JToolBarHelper::addNew('addvideoupload','New Video');
		JToolBarHelper::editList('editvideoupload','Edit');
		JToolBarHelper::publishList();
		JToolBarHelper::unpublishList();
		if($app->getUserStateFromRequest( $option.'filter_order_Status', 'filter_state', '', 'int' ) == -2)
		{
			JToolBarHelper::deleteList('', 'Remove', 'JTOOLBAR_EMPTY_TRASH');
		}
		else{
			JToolBarHelper::trash('trash');
		}
		JToolBarHelper::unpublishList('resethits','Viewed Reset');
		JToolBarHelper::makeDefault( 'setdefault' );

	}

	//Function for displaying submenus and model function calling to display videos
	function videosview() {
			
		//Model function calling
		$model 		= $this->getModel();
		$videolist 	= $model->videoslist();
		$this->assignRef('videolist', $videolist);
                if(version_compare(JVERSION, '3.0.0', 'ge')) {
		$this->addToolbar();
}
		parent::display();
	}

}
?>
