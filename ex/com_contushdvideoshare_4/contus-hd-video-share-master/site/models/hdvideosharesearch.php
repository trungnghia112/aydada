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
 * @abstract      : Contus HD Video Share Component Hdvideoshare Search Model
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
 * Contushdvideoshare Component Hdvideoshare Search Model
 */
class Modelcontushdvideosharehdvideosharesearch extends ContushdvideoshareModel
{
	/* function is to display the search results */

    function phpSlashes($string,$type='add'){
        if ($type == 'add')
        {
            if (get_magic_quotes_gpc())
            {
                return $string;
            }
            else
            {
                if (function_exists('addslashes'))
                {
                    return addslashes($string);
                }
                else
                {
                    return mysql_real_escape_string($string);
                }
            }
        }
        else if ($type == 'strip')
        {
            return stripslashes($string);
        }
        else
        {
            die('error in PHP_slashes (mixed,add | strip)');
        }
    }

	function getsearch()
	{
		$db = $this->getDBO();
                $search='';
		$session = JFactory::getSession();
                $btn=JRequest::getVar('search_btn');
                if(isset($btn)){
			$search=JRequest::getVar('searchtxtbox','','post','string'); // Getting the search  text  box value
			$session->set('search', $search);
		}
		else
		{
			$search=$session->get('search');
		}
                                $search=$this->phpSlashes($search);
		$searchtotal="SELECT a.id as vid,a.category,a.seo_category,b.*,c.*,d.id,d.username
        			  FROM #__hdflv_category a 
        			  LEFT JOIN #__hdflv_video_category b on b.catid=a.id 
        			  LEFT JOIN #__hdflv_upload c on c.id=b.vid 
        			  LEFT JOIN #__users d on c.memberid=d.id 
        			  WHERE c.type=0 and c.published=1 and a.published=1 and d.block=0
                                  AND (c.title like '%$search%' OR c.description like '%$search%' OR c.tags like '%$search%')
        			  GROUP BY c.id";		
		$kt=preg_split("/[\s,]+/", $search);//Breaking the string to array of words
		// Now let us generate the sql
		while(list($key,$search)=each($kt)){
			if($search<>" " and strlen($search) > 0)
			{
				$searchtotal="SELECT a.id as vid,a.category,a.seo_category,b.*,c.*,d.id,d.username 
							  FROM #__hdflv_category a 
							  LEFT JOIN #__hdflv_video_category b on b.catid=a.id 
							  LEFT JOIN #__hdflv_upload c on c.id=b.vid 
							  LEFT JOIN #__users d on c.memberid=d.id 
							  WHERE c.type=0 AND c.published=1 AND a.published=1 and d.block=0
							  AND (c.title like '%$search%' OR c.description like '%$search%' OR c.tags like '%$search%')  
							  GROUP BY c.id"; 
			}
		}
		$db->setQuery($searchtotal);
		$resulttotal = $db->loadObjectList();
		$subtotal=count($resulttotal);
		$total=$subtotal;
		$pageno = 1;
		if(JRequest::getVar('page','','post','int'))
		{
			$pageno = JRequest::getVar('page','','post','int');
		}
		$limitrow=$this->getsearchrowcol();
                $thumbview       = unserialize($limitrow[0]->thumbview);
		$length=$thumbview['searchrow'] * $thumbview['searchcol'];
		$pages = ceil($total/$length);
		if($pageno==1)
		$start=0;
		else
		$start= ($pageno - 1) * $length;
		if(isset($btn)){
			$search=JRequest::getVar('searchtxtbox','','post','string'); // Getting the search  text  box value
			$session->set('search', $search);
		}
		else
		{
			$search=$session->get('search');
		}
                                $search=$this->phpSlashes($search);
		$kt=preg_split("/[\s,]+/", $search);//Breaking the string to array of words
		// Now let us generate the sql
		$searchquery="SELECT a.id as vid,a.category,a.seo_category,b.catid,b.vid,
					  c.id,c.filepath,c.thumburl,c.title,c.description,c.times_viewed,c.ratecount,c.rate,
				      c.times_viewed,c.seotitle,d.id,d.username 
					  FROM #__hdflv_category a 
					  LEFT JOIN #__hdflv_video_category b on b.catid=a.id 
					  LEFT JOIN #__hdflv_upload c on c.id=b.vid 
					  LEFT JOIN #__users d on c.memberid=d.id 
					  WHERE c.type=0 and c.published=1 and a.published=1 and d.block=0 
					  GROUP BY c.id 
					  LIMIT $start,$length";//Query for displaying the search value results

		while(list($key,$search)=each($kt)){
			if($search<>" " and strlen($search) > 0){
				$searchquery="SELECT a.id as vid,a.category,a.seo_category,b.catid,b.vid,
							  c.id,c.filepath,c.thumburl,c.title,c.description,c.times_viewed,c.ratecount,c.rate,
				              c.times_viewed,c.seotitle
							  FROM #__hdflv_category a 
							  LEFT JOIN #__hdflv_video_category b on b.catid=a.id 
							  LEFT JOIN #__hdflv_upload c on c.id=b.vid 
							  LEFT JOIN #__users d on c.memberid=d.id 
							  WHERE c.type=0 and c.published=1 and a.published=1 and d.block=0 
							  and (c.title like '%$search%' OR c.description like '%$search%' OR 
							  c.tags like '%$search%')
							  LIMIT $start,$length";//Query for displaying the search value results
			}}
			$db->setQuery($searchquery);
			$rows = $db->loadObjectList();//echo '<pre>';print_r($rows);exit;
			if(count($rows)>0)
			{
				$rows['pageno'] = $pageno;
				$rows['pages'] = $pages;
				$rows['start'] = $start;
				$rows['length'] = $length;					
			}                        
			return $rows;
	}
	function getsearchrowcol()
	{
		$db = $this->getDBO();
		//Query is to select the search video page settings
		$searchquery = "SELECT thumbview,dispenable FROM #__hdflv_site_settings";
		$db->setQuery($searchquery);
		$rows=$db->LoadObjectList();
		return $rows;
	}
}
?>