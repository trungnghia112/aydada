<?php
/**
 * @name 	        hdflvplayer
 ** @version	        2.1.0.1
 * @package	        Apptha
 * @since	        Joomla 1.5
 * @subpackage	        hdflvplayer
 * @author      	Apptha - http://www.apptha.com/
 * @copyright 		Copyright (C) 2011 Powered by Apptha
 * @license 		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      	com_hdflvplayer installation file.
 ** @Creation Date	23 Feb 2011
 ** @modified Date	28 Aug 2013
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.html.html');
jimport('joomla.form.formfield');

/*
 * Jformfield Class for Videos list field
 */
class JFormFieldVideonames extends JFormField
{
    protected $type = 'Videonames';

    function getInput() {
        return $this->fetchElement($this->element['name'], $this->value, $this->element, $this->name);
    }

	 //Function to fetch videos from table and display in module parameter
    function fetchElement($name, $value, &$node, $control_name)
    {
        global $mainframe;
        $videocat="";
        $style="display:none;";
        $db = JFactory::getDBO();
        $query = 'SELECT a.id,a.title'
        . ' FROM #__hdflvplayerupload AS a'
        . ' WHERE a.published = 1'
        . ' ORDER BY a.title'
        ;
        $db->setQuery( $query );
        $options = $db->loadObjectList();
         $moduleId=$get_id="";
        $get_id = JRequest::getVar('id');
        if(isset($get_id))
      $moduleId =  $get_id;
		
        if($moduleId != '')
        {
            $qry = 'SELECT params from #__modules WHERE id='.$moduleId;
			$db->setQuery( $qry );
			$rs_params = $db->loadObject();
			$paramdecode = json_decode($rs_params->params, true);
			$videocat = $paramdecode['videocat']['videocat'];
			
            if($videocat == '1')
            {
                $style = 'display:block;';

            }
            else
            {
                $style = 'display:none;';

            }

        }
        array_unshift($options, JHTML::_('select.option', '0', '- '.JText::_('Select Videos').' -', 'id', 'title'));
        return JHTML::_('select.genericlist',  $options, ''.$control_name.'['.$name.']', 'class="inputbox" style='.$style, 'id', 'title', $value, $control_name.$name );
    }
} 
