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
 * @abstract      : Contus HD Video Share Component Commentappend Model
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */
/*
 ***********************************************************/
//No direct acesss
defined( '_JEXEC' ) or die( 'Restricted access' );
// import Joomla view library
jimport( 'joomla.application.component.view');
/**
 * view class for the hdvideoshare commentappend
 */
class contushdvideoshareViewcommentappend extends ContushdvideoshareView
{

	function display($cachable = false, $urlparams = false)
	{
            $model = $this->getModel();
            $getcomments = $model->getcomment();
            $this->assignRef('commenttitle', $getcomments[0]); // Assigning the reference for the results
            $this->assignRef('commenttitle1', $getcomments[1]); // Assigning the reference for the results
            $this->assignRef('playersettings', $getcomments[2]); // Assigning the reference for the results
            $commentsview = $model->ratting();
            $this->assignRef('commentview', $commentsview);
            parent::display();
	}

}
?>   
