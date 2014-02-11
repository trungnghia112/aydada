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
 * @abstract      : Contus HD Video Share Component Recent Videos View
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
 * view class for the hdvideoshare recentvideos
 */
class contushdvideoshareViewrecentvideos extends ContushdvideoshareView
{
function display($cachable = false, $urlparams = false)
	{
			$model = $this->getModel();
			/* function call for fetching recent videos */
            $recentvideos = $model->getrecentvideos();
            $this->assignRef('recentvideos', $recentvideos);
            /* function call for fetching recent videos settings */
            $recentvideosrowcol = $model->getrecentvideosrowcol();
            $this->assignRef('recentvideosrowcol', $recentvideosrowcol);
            parent::display();
	}
}
?>