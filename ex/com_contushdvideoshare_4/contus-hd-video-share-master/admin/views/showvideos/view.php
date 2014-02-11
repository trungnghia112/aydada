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
 * @abstract      : Contus HD Video Share Component Showvideos View Page
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */
/*
 ***********************************************************/
// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.access.access');
jimport('joomla.application.component.view');
jimport('joomla.html.pagination');

/**
 * view class for the hdvideoshare showvideos 
 */ 
class contushdvideoshareViewshowvideos extends ContushdvideoshareView {
	/**
	 * function to prepare view for showvideos 
	 */ 
    function showvideos($cachable = false, $urlparams = false) {
    	JHTML::stylesheet( 'styles.css', 'administrator/components/com_contushdvideoshare/css/' );	
    	if (JRequest::getVar('page') != 'comment') {	
        $user = JFactory::getUser();
        if(JRequest::getVar('user', '', 'get'))
        {
        JToolBarHelper::title(JText::_('Admin Videos'), 'adminvideos');
        }
        else
        {
            JToolBarHelper::title(JText::_('Member Videos'), 'membervideos');
        }
        $strAdmin = (JRequest::getVar('user', '', 'get')) ? JRequest::getVar('user', '', 'get') : '';
        
        // Joomla! 1.6 code here
        if(version_compare(JVERSION,'1.6.0','ge'))
        {
        $userid = $user->get('id');
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('g.id AS group_id')
                ->from('#__usergroups AS g')
                ->leftJoin('#__user_usergroup_map AS map ON map.group_id = g.id')
                ->where('map.user_id = ' . (int) $userid);
        $db->setQuery($query);
        $ugp = $db->loadObject();
        $ugp->group_id;
        $uid = JRequest::getVar('user', '', 'get', 'STRING');
        $usertype = (JRequest::getVar('actype', '', 'get', 'string') == 'adminvideos') ? JRequest::getVar('actype', '', 'get', 'string') : 0;
        
        if ((($ugp->group_id == "7") || ($ugp->group_id == "8") || ($ugp->group_id == "6")) && ($strAdmin == 'admin')) {
            JToolBarHelper::addNew('addvideos', 'New Video');
        }
        if ($ugp->group_id == "8") {            
            JToolBarHelper::editList('editvideos', 'Edit');
            JToolBarHelper::publishList();
	        JToolBarHelper::unpublishList();
	        JToolBarHelper::custom($task = 'featured', $icon = 'featured.png', $iconOver = 'featured.png', $alt = 'Enable Featured', $listSelect = true);
	        JToolBarHelper::custom($task = 'unfeatured', $icon = 'unfeatured.png', $iconOver = 'unfeatured.png', $alt = 'Disable Featured', $listSelect = true);
	        if(JRequest::getVar('filter_state') == 3) {        	
        	JToolBarHelper::deleteList('', 'Removevideos', 'JTOOLBAR_EMPTY_TRASH');
        	}else {           
            JToolBarHelper::trash('trash');
        	}
        }
        }
        // Joomla! 1.5 code here
        else
        {
        if (($user->gid == "25") && ($strAdmin == 'admin') || ($strAdmin == 0)) {           
            if ((($user->gid == "25") || ($user->gid == "23")) && ($strAdmin == 'admin')) {
                JToolBarHelper::addNew('addvideos', 'New Video');
            }            
            JToolBarHelper::editList('editvideos', 'Edit');
            JToolBarHelper::publishList();
	        JToolBarHelper::unpublishList();
	        JToolBarHelper::custom($task = 'featured', $icon = 'featured.png', $iconOver = 'featured.png', $alt = 'Enable Featured', $listSelect = true);
	        JToolBarHelper::custom($task = 'unfeatured', $icon = 'unfeatured.png', $iconOver = 'unfeatured.png', $alt = 'Disable Featured', $listSelect = true);
         	if(JRequest::getVar('filter_state') == 3) {        	
        	JToolBarHelper::deleteList('', 'Removevideos', 'JTOOLBAR_EMPTY_TRASH');
        	}else {  
         	JToolBarHelper::trash('trash');
        	}
        }
        }  
             
        $model = $this->getModel();
        $showvideos = $model->showvideosmodel();
        $this->assignRef('videolist', $showvideos);
    	}
        if (JRequest::getVar('page') == 'comment') {
            JToolBarHelper::title('Comments');
            JToolBarHelper::cancel('Commentcancel','Cancel');
            $model = $this->getModel('showvideos');
            $comment = $model->getcomment();
            $this->assignRef('comment', $comment);
            parent::display();
        } else {
            parent::display();
        }
    }
}
?>   
