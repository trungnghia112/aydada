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
 * @abstract      : Contus HD Video Share Component Googlead View Page
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
 * Contushdvideoshare Component GoogleAd View
 */
class contushdvideoshareViewgooglead extends ContushdvideoshareView {
	/**
	 * Function to get google ad
	 */
	function display($cachable = false, $urlparams = false) {
		JHTML::stylesheet( 'styles.css', 'administrator/components/com_contushdvideoshare/css/' );
		JToolBarHelper::title(JText::_('Google AdSense'),'googlead');
		JToolBarHelper::apply();
		$model = $this->getModel();		
		$googlead = $model->getgooglead();
		$this->assignRef('googlead', $googlead);
		parent::display();
	}
}
?>
