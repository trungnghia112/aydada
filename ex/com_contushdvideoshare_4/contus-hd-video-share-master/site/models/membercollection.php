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
 * @abstract      : Contus HD Video Share Component MemberCollection Model
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */
/*
 ***********************************************************/
//No direct acesss
defined( '_JEXEC' ) or die( 'Restricted access' );
// import Joomla model library
jimport( 'joomla.application.component.model' );
/**
 * Contushdvideoshare Component Myvidos Model
 */
class Modelcontushdvideosharemembercollection extends ContushdvideoshareModel
{
    
/* Following function is to display the videos of a particular registered member */
function getmembercollection()
{
    
    $user = JFactory::getUser();
        $session = JFactory::getSession();
    if(JRequest::getVar('memberidvalue','','post','int')){
                 $session->set( 'memberid', JRequest::getVar('memberidvalue','','post','int') );
                }
        // Query for fetching membercollection total for pagination
        $totalquery	= "SELECT count(a.id)
        			   FROM  #__hdflv_upload a 
        			   LEFT JOIN #__hdflv_category b on a.playlistid=b.id 
        			   LEFT JOIN #__users d on a.memberid=d.id 
        			   WHERE a.published=1 AND b.published=1 AND a.type=0 AND d.block=0 AND a.memberid=".$session->get( 'memberid', 'empty' );
        $db = JFactory::getDBO();
        $db->setQuery($totalquery);
        $resulttotal = $db->loadResult();        
        $total=$resulttotal;
        $pageno = 1;
        if(JRequest::getVar('page','','post','int'))
        {
            $pageno = JRequest::getVar('page','','post','int');
        }
        $limitrow=$this->getmemberpagerowcol();//function call for fetching member collection settings
        $thumbview       = unserialize($limitrow[0]->thumbview);
        $length=$thumbview['memberpagerow']* $thumbview['memberpagecol'];
        $pages = ceil($total/$length);
        if($pageno==1)
        $start=0;
        else
        $start= ($pageno - 1) * $length;
        // Query for displaying the member collection videos when click on his name
        $query = "SELECT a.id,a.filepath,a.thumburl,a.title,a.description,a.times_viewed,a.ratecount,a.rate,
				  a.times_viewed,a.seotitle,b.category,b.seo_category,d.username,e.catid,e.vid 
        		  FROM #__hdflv_upload a 
        		  LEFT JOIN #__users d on a.memberid=d.id 
        		  LEFT JOIN #__hdflv_video_category e on e.vid=a.id 
        		  LEFT JOIN #__hdflv_category b on e.catid=b.id 
        		  WHERE a.published=1 and b.published=1 and d.block=0 and a.type=0 and a.memberid=".$session->get( 'memberid', 'empty' )."
        		  GROUP BY e.vid 
        		  ORDER BY a.id desc 
        		  LIMIT $start,$length";
        $db->setQuery($query);
        $rows=$db->LoadObjectList();
        // Below code is to merge the pagination values like pageno,pages,start value,length value
        if(count($rows)>0)
        {
        	$rows['pageno'] = $pageno;
			$rows['pages'] = $pages;
			$rows['start'] = $start;
			$rows['length'] = $length;	            
        }       
        return $rows;
}



function getmemberpagerowcol()
{

        $db = $this->getDBO();
        //Query is to fetch membercollection settings
        $memberpagequery="SELECT thumbview,dispenable FROM #__hdflv_site_settings";
        $db->setQuery($memberpagequery);
        $rows=$db->LoadObjectList();
        return $rows;
}



}
?>