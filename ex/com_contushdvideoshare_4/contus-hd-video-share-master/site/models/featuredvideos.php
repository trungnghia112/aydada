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
 * @abstract      : Contus HD Video Share Component Featured Videos Model
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
 * Contushdvideoshare Component Featured Vidos Model
 */
class Modelcontushdvideosharefeaturedvideos extends ContushdvideoshareModel
{
	/* function is to display a featured videos */
	function getfeaturedvideos()
	{
		//Query is to get the pagination for featured values
		$featuredtotal = "SELECT count(a.id)
        			  FROM  #__hdflv_upload a 
        			  LEFT JOIN #__hdflv_category b on a.playlistid=b.id  
        			  LEFT JOIN #__users d on a.memberid=d.id 
                                  WHERE a.published=1 and b.published=1 and a.featured=1 and d.block=0";
		$db = $this->getDBO();
		$db->setQuery($featuredtotal);
		$total = $db->loadResult();
		$pageno = 1;
		if(JRequest::getVar('page','','post','int'))
		{
			$pageno = JRequest::getVar('page','','post','int');
		}
		$limitrow=$this->getfeaturevideorowcol();
                $thumbview       = unserialize($limitrow[0]->thumbview);
		$length=$thumbview['featurrow'] * $thumbview['featurcol'];
		$pages = ceil($total/$length);
		if($pageno==1)
		$start=0;
		else
		$start= ($pageno - 1) * $length;
		/* Query is to display the featured videos */
		$featuredquery="SELECT a.id,a.filepath,a.thumburl,a.title,a.description,a.times_viewed,a.ratecount,a.rate,
						a.times_viewed,a.seotitle,b.category,b.seo_category,d.username,e.catid,e.vid
      					FROM  #__hdflv_upload a 
      					LEFT JOIN #__users d on a.memberid=d.id 
      					LEFT JOIN #__hdflv_video_category e on a.id=e.vid 
      					LEFT JOIN #__hdflv_category b on e.catid=b.id 
      					WHERE a.published=1 and a.featured=1 and a.type='0' and b.published=1 and d.block=0
      					GROUP BY e.vid 
      					ORDER BY a.ordering asc 
      					LIMIT $start,$length";

		$db->setQuery($featuredquery);
		$rows=$db->LoadObjectList();		
		if(count($rows)>0){
			$rows['pageno'] = $pageno;
			$rows['pages'] = $pages;
			$rows['start'] = $start;
			$rows['length'] = $length;	
		}		
		return $rows;
	}

	function getfeaturevideorowcol()
	{
		$db = $this->getDBO();
		//Query is to select the featured videos row
		$featurequery="SELECT thumbview,dispenable FROM #__hdflv_site_settings";
		$db->setQuery($featurequery);
		$rows=$db->LoadObjectList();
		return $rows;
	}


}
?>