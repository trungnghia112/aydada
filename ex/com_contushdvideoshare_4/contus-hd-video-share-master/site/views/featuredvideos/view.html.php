<?php
/*
 ***********************************************************/
/**
 * @name          : Joomla HD Video Share
 *** @version	  : 3.4.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component Featured Videos View
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */
/*
 ***********************************************************/
//No direct acesss
defined( '_JEXEC' ) or die( 'Restricted access' );
// import Joomla view library
jimport('joomla.application.component.view');
/**
 * view class for the hdvideoshare featured videos
 */
class contushdvideoshareViewfeaturedvideos extends ContushdvideoshareView
{
	function display($cachable = false, $urlparams = false)
	{
		$model = $this->getModel();
		/* function call for fetching featured videos */
		$featuredvideos = $model->getfeaturedvideos();
		$this->assignRef('featuredvideos', $featuredvideos);
		/* function call for fetching featured videos settings */
		$featurevideosrowcol = $model->getfeaturevideorowcol();
		$this->assignRef('featurevideosrowcol', $featurevideosrowcol);
		parent::display();
	}
}
?>