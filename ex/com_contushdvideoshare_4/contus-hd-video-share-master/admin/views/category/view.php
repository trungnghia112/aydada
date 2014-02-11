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
 * @abstract      : Contus HD Video Share Component Category View Page
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
 * hdvideoshare component category administrator view
 */
class contushdvideoshareViewcategory extends ContushdvideoshareView {

	// view for manage categories
	function display($cachable = false, $urlparams = false) {
		JHTML::stylesheet( 'styles.css', 'administrator/components/com_contushdvideoshare/css/' );
		if (JRequest::getVar('task') == 'edit') {
			JToolBarHelper::title('Category' . ': [<small>Edit</small>]','category');
			JToolBarHelper::save();
			JToolBarHelper::apply();
			JToolBarHelper::cancel();
			$model = $this->getModel();
			$id = JRequest::getVar('cid');
			$category = $model->getcategorydetails($id[0]);
			$this->assignRef('category', $category[0]);
			$this->assignRef('categorylist', $category[1]);
			parent::display();
		}
		if (JRequest::getVar('task') == 'add') { {
			JToolBarHelper::title('Category' . ': [<small>Add</small>]','category');
			JToolBarHelper::save();
			JToolBarHelper::cancel();
			$model = $this->getModel();
			$category = $model->getNewcategory();
			$this->assignRef('category', $category[0]);
			$this->assignRef('categorylist', $category[1]);
			parent::display();
		}
		}
		if (JRequest::getVar('task') == '') {
			JToolBarHelper::title('Category', 'category');
                         if(version_compare(JVERSION, '3.0.0', 'ge')) {
                             JToolbarHelper::addNew();
                             JToolBarHelper::editList();
                         }else {
                             JToolBarHelper::addNewX();
                             JToolBarHelper::editListX();
                         }
			JToolBarHelper::publishList();
			JToolBarHelper::unpublishList();
			if(JRequest::getVar('category_status') == 3) {        	
        	JToolBarHelper::deleteList('', 'remove', 'JTOOLBAR_EMPTY_TRASH');
        	}else {			
			JToolBarHelper::trash('trash');	
        	}		
			$model = $this->getModel('category');
			$category = $model->getcategory();
			$this->assignRef('category', $category);
			parent::display();
		}
	}
}
?>
