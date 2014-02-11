<?php
/**
 * @name          : Joomla HD Video Share
 *** @version	  : 3.4.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2012 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component Edit View View Page
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.view');
class hdvideoshareVieweditvideo extends ContushdvideoshareView
{
function display()
	{
			$model = $this->getModel();
            $editdetails = $model->geteditdetails(); //calling the function in models editvideo.php
            $this->assignRef('editdetails', $editdetails); // assigning the reference for the result
            parent::display();
	}
}
?>