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
 * HDFLV player view class to call model functions to diplay Player settings
 */
class hdflvplayerViewplayersettings extends HdflvplayerView
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
            $document = JFactory::getDocument();
            $document->addStyleSheet('components/com_hdflvplayer/css/styles.css');

            JToolBarHelper::title( JText::_( 'Player Settings' ),'player-settings-icon.png' );
		JToolBarHelper::apply('applyplayersettings','Apply');

	}


    function playersettingsedit()
	{
		if(version_compare(JVERSION, '3.0.0', 'ge')) {
		$this->addToolbar();
}
        $model = $this->getModel();
        $playersettings = $model->playersettingsmodel();
		$this->assignRef('playersettings', $playersettings);
		parent::display();
	}
}
?>
