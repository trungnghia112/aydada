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
 * @abstract      : Contus HD Video Share Component Popular Videos Model
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
 * Contushdvideoshare Component Popular Vidos Model
 */
class Modelcontushdvideosharepopularvideos extends ContushdvideoshareModel
{
	/* function is to display the popular videos */
	function getpopularvideos()
	{
		$user = JFactory::getUser();
		$accessid = $user->get('aid');
		//Query is to get the pagination for related values
		$populartotal = "SELECT count(a.id)
        			 FROM  #__hdflv_upload a 
        			 LEFT JOIN #__users d on a.memberid=d.id 
        			 LEFT JOIN #__hdflv_category b on a.playlistid=b.id  
                                 WHERE a.published=1 AND b.published=1 AND a.type='0' AND d.block=0";
		$db = $this->getDBO();
		$db->setQuery($populartotal);
		$total = $db->loadResult();
		$pageno = 1;
		if(JRequest::getVar('page','','post','int'))
		{
			$pageno = JRequest::getVar('page','','post','int');
		}
		$limitrow=$this->getpopularvideorowcol();
                $thumbview       = unserialize($limitrow[0]->thumbview);
		$length=$thumbview['popularrow'] * $thumbview['popularcol'];
		$pages = ceil($total/$length);
		if($pageno==1)
		$start=0;
		else
		$start= ($pageno - 1) * $length;
		//Query is to display the popular videos
		$popularquery="SELECT a.id,a.filepath,a.thumburl,a.title,a.description,a.times_viewed,a.ratecount,a.rate,
					   a.times_viewed,a.seotitle,b.category,b.seo_category,d.username,e.catid,e.vid 
		  			   FROM #__hdflv_upload a 
		  			   LEFT JOIN #__users d on a.memberid=d.id 
		  			   LEFT JOIN #__hdflv_video_category e on e.vid=a.id 
		  			   LEFT JOIN #__hdflv_category b on e.catid=b.id 
		  			   WHERE a.published=1 and a.type='0' and b.published=1 and d.block=0 
		  			   GROUP BY e.vid 
		  			   ORDER BY a.times_viewed desc 
		  			   LIMIT $start,$length";     
		$db->setQuery($popularquery);
		$rows=$db->LoadObjectList();
		if(count($rows)>0){
			$rows['pageno'] = $pageno;
			$rows['pages'] = $pages;
			$rows['start'] = $start;
			$rows['length'] = $length;	
		}		
		return $rows;
	}
	function getpopularvideorowcol()
	{
		$db = $this->getDBO();
		//Query is to select the popular videos row
		$popularquery="SELECT thumbview,dispenable FROM #__hdflv_site_settings";
		$db->setQuery($popularquery);
		$rows=$db->LoadObjectList();
		return $rows;
	}
}
?>