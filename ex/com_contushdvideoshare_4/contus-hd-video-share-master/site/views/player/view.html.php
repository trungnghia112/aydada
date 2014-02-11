<?php
/**
 * @name          : Joomla HD Video Share
 * @version	  : 3.4.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component Hdvideoshare Player View
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */
## No direct acesss
defined('_JEXEC') or die('Restricted access');
##  import Joomla view library
jimport('joomla.application.component.view');
## view class for the hdvideoshare player
class contushdvideoshareViewplayer extends ContushdvideoshareView {

	function display($cachable = false, $urlparams = false) {
		$videoid        = $categoryid = $videourl = '';
                $videodetails   = array();
		$model          =  $this->getModel();

		## CODE FOR SEO OPTION OR NOT - START
		$video          = JRequest::getVar('video');
		$id             = JRequest::getInt('id');
		$flagVideo      = is_numeric($video);
		if (isset($video) && $video != "") {
			if ($flagVideo != 1) {
				##  joomla router replaced to : from - in query string
				$videoTitle                 = JRequest::getString('video');
				$video                      = str_replace(':', '-', $videoTitle);
                                $category_name              = JRequest::getString('category');
                                $category                   = str_replace(':', '-', $category_name);
                                if(!empty ($category) && !empty ($video)){
                                    $videodetails           = $model->getVideoCatId($video,$category);
                                    $videoid                = $videodetails->id;
				    $categoryid             = $videodetails->playlistid;
                                }else{
                                    $videodetails           = $model->getVideoId($video);
                                    $videoid                = $videodetails->id;
                                    $categoryid             = $videodetails->playlistid;
                                    $videodetails->videourl = $videodetails->videourl;
                                }
			} else {
				$videoid                    = JRequest::getInt('video');
				$videodetails               = $model->getVideodetail($videoid);
				$categoryid                 = JRequest::getInt('category');
				$videodetails->id           = $videoid;
				$videodetails->playlistid   = $categoryid;
				$videodetails->videourl     = $videodetails->videourl;
			}
			$this->assignRef('videodetails', $videodetails);
		} else if (isset($id) && $id != '') {

			$videoid                            = JRequest::getInt('id');
			$videodetails                       = $model->getVideodetail($videoid);
			$categoryid                         = JRequest::getInt('catid');
			$videodetails->id                   = $videoid;
			$videodetails->playlistid           = $categoryid;
			$videodetails->videourl             = $videodetails->videourl;
			$this->assignRef('videodetails', $videodetails);
		}
		/* CODE FOR SEO OPTION OR NOT - END */

		## Code for html5 player
		$htmlVideoDetails   = $model->getHTMLVideoDetails($videoid);
		$this->assignRef('htmlVideoDetails', $htmlVideoDetails);

		$getfeatured        = $model->getfeatured();
		$this->assignRef('getfeatured', $getfeatured);

		$detail             = $model->showhdplayer($videoid);
		$this->assignRef('detail', $detail);

		$commentsview       = $model->ratting($videoid);
		$this->assignRef('commentview', $commentsview);

		$comments           = $model->displaycomments($videoid);        ##  calling the function in models comment.php
		$this->assignRef('commenttitle', $comments[0]);                 ##  Assigning the reference for the results
		$this->assignRef('commenttitle1', $comments[1]);                ##  Assigning the reference for the results

		$homepagebottom     = $model->gethomepagebottom();              ## calling the function in models homepagebottom.php
		$this->assignRef('rs_playlist1', $homepagebottom);              ##  assigning the reference for the results

		$homepagebottomsettings = $model->gethomepagebottomsettings();  ## calling the function in models homepagebottom.php
		$this->assignRef('homepagebottomsettings', $homepagebottomsettings); ##  assigning the reference for the results

		$homeAccessLevel    = $model->getHTMLVideoAccessLevel();
		$this->assignRef('homepageaccess', $homeAccessLevel);

                $homePageFirst      =   $model->initialPlayer();
                $this->assignRef('homePageFirst', $homePageFirst);
		parent::display();
	}
}
?>