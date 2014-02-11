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
 * @abstract      : Contus HD Video Share Component Controlpanel View Page
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */

/*
 ***********************************************************/
// no direct access
defined('_JEXEC') or die('Restricted access');
// import Joomla view library
jimport('joomla.application.component.view');

class contushdvideoshareViewcontrolpanel extends ContushdvideoshareView {
	// function to prepare controlpanel view
    function display($cachable = false, $urlparams = false) {
        if (JRequest::getVar('task') == 'edit' || JRequest::getVar('task') == '') {
            JToolBarHelper::title('HD Video Share Control Panel', 'manege-pins.png');
            $model = $this->getModel();
            $controlpaneldetails = $model->controlpaneldetails();
            $this->assignRef('controlpaneldetails', $controlpaneldetails);
            parent::display();
        }
    }
}
?>
