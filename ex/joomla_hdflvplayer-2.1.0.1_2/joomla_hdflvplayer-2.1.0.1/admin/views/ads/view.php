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

//importing default component 
jimport('joomla.application.component.view');

/*
 * HDFLV player view class for showing mid roll, post roll, pre roll ads
 */
class hdflvplayerViewads extends HdflvplayerView {
	
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

            JToolBarHelper::title( JText::_( 'Video Ads' ),'ads-icon.png' );
		JToolBarHelper::save('saveads','Save');
		JToolBarHelper::apply('applyads','Apply');
		JToolBarHelper::cancel('CANCELADS','Cancel');

	}

	// viewing ads
    function ads() {
    	
        if(version_compare(JVERSION, '3.0.0', 'ge')) {
		$this->addToolbar();
}
    	//Function calling for fetchout ads info
        $model = $this->getModel();
        $adslist = $model->addadsmodel();
        $this->assignRef('adslist', $adslist);
        parent::display();
    }

    // editing ads 
    function editads() {
    	   	JToolBarHelper::title( JText::_( 'Video Ads' ),'ads-icon.png' );
		JToolBarHelper::save('saveads','Save');
		JToolBarHelper::apply('applyads','Apply');
		JToolBarHelper::cancel('CANCELADS','Cancel');
		$model = $this->getModel();
        $editlist = $model->editadsmodel();
        $this->assignRef('adslist', $editlist);
        parent::display();
    }

}
?>   
