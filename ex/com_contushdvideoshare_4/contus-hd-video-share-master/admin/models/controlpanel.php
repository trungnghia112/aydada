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
 * @abstract      : Contus HD Video Share Component Controlpanel Model 
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */

/*
 ***********************************************************/

//No direct acesss
defined( '_JEXEC' ) or die( 'Restricted access' );
// import joomla model library
jimport('joomla.application.component.model');

class contushdvideoshareModelcontrolpanel extends ContushdvideoshareModel {

	//function to show Top 5 popular videos,added videos etc.
    function controlpaneldetails() 
    {
        $db =  JFactory::getDBO();
        $query = "SELECT  count(b.memberid) as count ,a.username as username 
        		  FROM #__users a 
        		  LEFT JOIN  #__hdflv_upload b on b.memberid = a.id 
        		  GROUP BY a.id";
        $db->setQuery($query);
        $member_detail = $db->loadObjectList();
        //Query is to display the top 5 popular videos
        $popularquery = "SELECT id,title,times_viewed 
                         FROM #__hdflv_upload 
                         WHERE published=1 and type='0'  
                         ORDER BY times_viewed desc 
                         LIMIT 5";
        $db->setQuery($popularquery);
        $popularvideos = $db->LoadObjectList();
        //Query is to display the last 5 added videos
        $latestquery = "SELECT id,title,created_date 
                        FROM #__hdflv_upload 
                        WHERE published=1 and type='0'  
                        ORDER BY id desc 
                        LIMIT 5"; 
        $db->setQuery($latestquery);
        $latestvideos = $db->LoadObjectList();
        $count = array('membervideos' => $member_detail,'popularvideos' => $popularvideos,'latestvideos' => $latestvideos);
        return $count;
    }    
}
?>
