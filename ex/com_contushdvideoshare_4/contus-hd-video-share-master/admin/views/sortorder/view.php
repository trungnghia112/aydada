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
 * @abstract      : Contus HD Video Share Component Sortorder View Page
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */
/*
 ***********************************************************/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
// import joomla view library
jimport( 'joomla.application.component.view');

class contushdvideoshareViewsortorder extends ContushdvideoshareView
{
	//function for category sorting
	function categorysortorder()
	{        
        $model = $this->getModel();
        $sortorder = $model->categorysortordermodel();		
		
	}
	
	//function for video sorting
	function videosortorder()
	{        
        $model = $this->getModel();
        $sortorder = $model->videosortordermodel();		
		
	}
    
}
?>   
