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
 * @abstract      : Contus HD Video Share Component Category View
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
 * Contushdvideoshare Component Category View
 */
class contushdvideoshareViewcategory extends ContushdvideoshareView
{
function display($cachable = false, $urlparams = false)
	{
	    	$model = $this->getModel();
            $getcategoryview = $model->getcategory();// calling the function in models categoryview.php
            $this->assignRef('categoryview', $getcategoryview); // assigning reference for the results
            $categorrowcol = $model->getcategoryrowcol();
            $this->assignRef('categoryrowcol', $categorrowcol);
            $getcategoryListVal = $model->getcategoryList();
            $this->assignRef('categoryList', $getcategoryListVal);            
            parent::display();
	}
}
?>