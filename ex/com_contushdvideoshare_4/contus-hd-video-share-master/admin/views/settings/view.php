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
 * @abstract      : Contus HD Video Share Component Settings View Page
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */
/*
 ***********************************************************/
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import Joomla view library
jimport('joomla.application.component.view');

/**
 *  view class for the hdvideoshare component (Playersettings tab)
 */

class contushdvideoshareViewsettings extends ContushdvideoshareView {

	/**
	 *  function to display settings
	 */

	function display($cachable = false, $urlparams = false) {
			JHTML::stylesheet( 'styles.css', 'administrator/components/com_contushdvideoshare/css/' );
			JToolBarHelper::title(JText::_('Player Settings'), 'settings');			
			JToolBarHelper::apply();
			$model = $this->getModel();

			/**
			 *  Function to get player settings
			 */

			$playersettings = $model->showplayersettings();
			$this->assignRef('playersettings', $playersettings);
			parent::display();
	}
}
?>
