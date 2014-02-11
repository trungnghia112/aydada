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
 * @abstract      : Contus HD Video Share Component Related Videos Model
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
 * Contushdvideoshare Component Related Vidos Model
 */
class Modelcontushdvideosharerelatedvideos extends ContushdvideoshareModel
{
/* function is to display the related videos */
function getrelatedvideos()
{
        $db = $this->getDBO();
        $session = JFactory::getSession();       
        $categoryid=JRequest::getVar('catid','','get','int');
        $limitrow=$this->getrelatedvideosrowcol();
         $rows='';
         $dispenable       = unserialize($limitrow[0]->dispenable);
        $seoOption = $dispenable['seo_option'];
		$videoid = $category = $video = '';

		/* CODE FOR SEO OPTION OR NOT - START */
        $video = JRequest::getVar('video');
        $id = JRequest::getInt('id');
        $flagVideo = is_numeric($video);
        if (isset($video) && $video != "") {
            if ($flagVideo != 1) {
                // joomla router replaced to : from - in query string
                $videoTitle = JRequest::getString('video');
                $videoid = str_replace(':', '-', $videoTitle);
			if ($videoid != "") {
        if(!version_compare(JVERSION, '3.0.0', 'ge'))
				$videoid = $db->getEscaped($videoid);
                        }
                        $catidquery = "select playlistid from #__hdflv_upload where seotitle ='$videoid'";
			$db->setQuery($catidquery);
			$video = $db->loadResult();
                    } else {
                $videoid = JRequest::getInt('video');
                $catidquery = "select playlistid from #__hdflv_upload where id ='$videoid'";
                $db->setQuery($catidquery);
                $video = $db->loadResult();
                    }
        } else if (isset($id) && $id != '') {
            $videoid = JRequest::getInt('id');
			$catidquery = "select playlistid from #__hdflv_upload where id ='$videoid'";
			$db->setQuery($catidquery);
			$video = $db->loadResult();
		}

                if(!isset($video) && $video=='')
                    $video=0;
                if(!isset($videoid) && $videoid=='')
                    $videoid=0;

        //Query for getting the pagination values for related video page
        $totalquery="SELECT count(a.id) FROM #__hdflv_upload a
        			 LEFT JOIN #__hdflv_video_category e on e.vid=a.id 
        			 LEFT JOIN #__hdflv_category b on e.catid=b.id 
                     WHERE a.published=1 and b.published=1 and  (a.playlistid=$video) ";
        $db->setQuery( $totalquery );
        $total = $db->loadResult();
        $pageno = 1;
        if(JRequest::getVar('page','','post','int'))
        {
            $pageno = JRequest::getVar('page','','post','int');
        }
        $thumbview       = unserialize($limitrow[0]->thumbview);
        $length=$thumbview['relatedrow'] * $thumbview['relatedcol'];
        $pages = ceil($total/$length);
        if($pageno==1)
        $start=0;
        else
        $start= ($pageno - 1) * $length;
        if (isset($videoid) && (isset($video)) && !empty($video)) {
$query = "SELECT a.id,a.filepath,a.thumburl,a.title,a.description,a.times_viewed,a.ratecount,a.rate,
						 	  a.times_viewed,a.seotitle,b.id as catid,b.category,b.seo_category,e.catid,e.vid
        		  FROM #__hdflv_upload a 
        		  LEFT JOIN #__hdflv_video_category e on e.vid=a.id 
        		  LEFT JOIN #__hdflv_category b on e.catid=b.id 
							  WHERE a.published=1 and b.published=1 and  (a.playlistid=$video )  group by a.id order by rand() LIMIT $start,$length";

				
		 $db->setQuery( $query );
        $rows = $db->loadObjectList();
		} 
        if(count($rows)>0){
        $rows['pageno'] = $pageno;
		$rows['pages'] = $pages;
		$rows['start'] = $start;
		$rows['length'] = $length;	
        }
        return $rows;
}
function getrelatedvideosrowcol()
{
        $db = $this->getDBO();
		$relatedvideosquery="SELECT thumbview,dispenable FROM #__hdflv_site_settings";//Query is to select the popular videos row
        $db->setQuery($relatedvideosquery);
        $rows=$db->LoadObjectList();
        return $rows;
}
}
?>