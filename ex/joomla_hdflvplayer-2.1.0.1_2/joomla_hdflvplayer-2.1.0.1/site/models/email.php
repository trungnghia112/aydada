<?php
/**
 * @name 	        email.php
 ** @version	        2.1.0.1
 * @package	        Apptha
 * @since	        Joomla 1.5
 * @author      	Apptha - http://www.apptha.com/
 * @copyright 		Copyright (C) 2011 Powered by Apptha
 * @license 		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      	Contus HD FLV Player email file
 * @Creation Date	23 Feb 2011
 * @modified Date	28 Aug 2013
 */
## No direct acesss
defined('_JEXEC') or die();

## imports libraries
jimport('joomla.application.component.model');

/*
 * HDFLV player view class for email task in player
 */

class hdflvplayerModelemail extends HdflvplayerModel {

    function getemail() {

        $to         = JRequest::getVar('to', '', 'post');
        $from       = JRequest::getVar('from', '', 'post');
        $url        = JRequest::getVar('url', '', 'post');
        $note       = JRequest::getVar('note', '', 'post');
        $subject    = "You have received a video!";
        $headers    = "From: " . "<" . $from . ">\r\n";
        $headers1  .= "Reply-To: " . $from . "\r\n";
        $headers   .= "Return-path: " . $from;
        $message    = $note . "\n\n";
        $message   .= "Video URL: " . $url;

        if (mail($to, $subject, $message, $headers)) {
            echo "output=sent";
            $headers = "From: " . "<" . $to . ">\r\n";
            $message = "Thank You ";
            mail($from, $subject, $message, $headers);
        } else {
            echo "output=error";
        }
        exit();
    }
}