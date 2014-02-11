<?php
/**
 * @name          : Joomla HD Video Share
 *** @version	  : 3.4.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component Controller
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */
## No direct access to this file
defined('_JEXEC') or die('Restricted access');
## import Joomla controller library
jimport('joomla.application.component.controller');
## hdvideoshare component main controller
if (version_compare(JVERSION, '1.6.0', 'ge')) {
    $jlang = JFactory::getLanguage();
    $jlang->load('com_contushdvideoshare', JPATH_SITE, $jlang->get('tag'), true);
    $jlang->load('com_contushdvideoshare', JPATH_SITE, null, true);
}

class contushdvideoshareController extends ContusvideoshareController {

    function display($cachable = false, $urlparams = false) {
        $db = JFactory::getDBO();
        $query = "SELECT dispenable FROM #__hdflv_site_settings WHERE published=1";
        $db->setQuery($query);
        $rows = $db->loadResult();
        $dispenable       = unserialize($rows);
        define('USER_LOGIN', $dispenable['user_login']);
        $viewName = JRequest::getVar('view');
        if ($viewName != "languagexml" && $viewName != "configxml" && $viewName != "playxml" && $viewName != "googlead") {
            $document = JFactory::getDocument();
            $document->addScript(JURI::base() . 'components/com_contushdvideoshare/js/jquery.js');
            $document->addScript(JURI::base() . "components/com_contushdvideoshare/js/htmltooltip.js");
            $lang = JFactory::getLanguage();
            $langDirection = (bool) $lang->isRTL();
            if ($langDirection == 1) {
                $document->addStyleSheet(JURI::base() . 'components/com_contushdvideoshare/css/stylesheet_rtl.css');
            } else {
                $document->addStyleSheet(JURI::base() . 'components/com_contushdvideoshare/css/stylesheet.css');
            }
        }
        $this->getdisplay($viewName);
        if ($viewName == "" || $viewName == "index")
            $this->getdisplay('player');
    }

    function getdisplay($viewName="index") {
        $document = JFactory::getDocument();
        $viewType = $document->getType();
        $view = $this->getmodView($viewName, $viewType);
        $model = $this->getModel($viewName, 'Modelcontushdvideoshare');
        if (!JError::isError($model)) {

            $view->setModel($model, true);
        }
        $view->display($cachable = false, $urlparams = false);
    }

    function &getmodView($name = '', $type = '', $prefix = '', $config = array()) {
        static $views;
        if (empty($prefix)) {
            $prefix = $this->getName() . 'View';
        }
        if (empty($views[$name])) {
            if (version_compare(JVERSION, '1.6.0', 'ge')) {
                if ($view = $this->createView($name, $prefix, $type, $config)) {
                    $views[$name] = & $view;
                } else {
                    header("Location:index.php?option=com_contushdvideoshare&view=player&itemid=0");
                }
            } else {
                if ($view = $this->_createView($name, $prefix, $type, $config)) {
                    $views[$name] = & $view;
                } else {
                    header("Location:index.php?option=com_contushdvideoshare&view=player&itemid=0");
                }
            }
        }

        return $views[$name];
    }

    function adsxml() {
        $view = $this->getView('adsxml');
        if ($model = $this->getModel('adsxml')) {
            ## Push the model into the view (as default)
            ## Second parameter indicates that it is the default model for the view
            $view->setModel($model, true);
        }
        $view->display();
    }
    function imaadxml() {
        $view = $this->getView('imaadxml');
        if ($model = $this->getModel('imaadxml')) {
            ## Push the model into the view (as default)
            ## Second parameter indicates that it is the default model for the view
            $view->setModel($model, true);
        }
        $view->display();
    }

    ## viewed Ad's for player
    function impressionclicks() {
        $view = $this->getView('impressionclicks');
        if ($model = $this->getModel('impressionclicks')) {
            $view->setModel($model, true);
        }
        $view->display();
    }

    function videourl() {
        $view = $this->getView('videourl');
        if ($model = $this->getModel('videourl')) {
            ##Push the model into the view (as default)
            ##Second parameter indicates that it is the default model for the view
            $view->setModel($model, true);
        }
        $view->getvideourl();
    }

    function updateView() {
        $db = JFactory::getDBO();
        $videoid = JRequest::getVar('videoid');
        if ($videoid) {
            $query = "update #__hdflv_upload SET times_viewed=1+times_viewed where id=$videoid";
            $db->setQuery($query);
            $db->query();
        }
        $query = "select times_viewed from #__hdflv_upload where id=$videoid";
        $db->setQuery($query);
        $timeView = $db->loadResult();
        echo $timeView;
        jexit();
    }

    ## function to upload file processing
    function uploadfile() {
        $model = $this->getModel('uploadvideo');
        $model->fileupload();
    }
    function downloadfile() {
        $url = JRequest::getInt('f');
        $db = JFactory::getDBO();
        $query = "select filepath,videourl from #__hdflv_upload where id=$url";
        $db->setQuery($query);
        $video_details = $db->loadObject();
        $filename = JPATH_COMPONENT . "/videos/" . $video_details->videourl;
            if(file_exists($filename)){
            header('Content-disposition: attachment; filename=' . basename($filename));
            readfile($filename);
}
    }

    function emailuser() {

        $to = JRequest::getVar('to');
        $from = JRequest::getVar('from');
        $url = JRequest::getVar('url');
        $subject = JRequest::getVar('Note');
        $title = JRequest::getVar('title');

        $headers = "From: " . "<" . $from . ">\r\n";
        $headers .= "Reply-To: " . $from . "\r\n";
        $headers .= "Return-path: " . $from;
        $message = $subject . "\n\n";
        $message .= "Video URL: " . $url;
        if (mail($to, $title, $message, $headers)) {
            $a= "sent";
        } else {
            $a= "error";
        }
          echo $a;exit;
    }
}
?>