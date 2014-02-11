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
// no direct access
defined('_JEXEC') or die('Restricted access');

/***************************************************\
 * PHP 4.1.0+ version of email script. For more
 * information on the mail() function for PHP, see
 * http://www.php.net/manual/en/function.mail.php
\***************************************************/


// First, set up some variables to serve you in
// getting an email.  This includes the email this is
// sent to (yours) and what the subject of this email
// should be.  It's a good idea to choose your own
// subject instead of allowing the user to.  This will
// help prevent spam filters from snatching this email
// out from under your nose when something unusual is put.

$to = JRequest::getVar('to','','post');
$from = JRequest::getVar('from','','post');
$url = JRequest::getVar('url','','post');
$note = JRequest::getVar('note','','post');





$subject = "You have received a video!";

// variables are sent to this PHP page through
// the POST method.  $_POST is a global associative array
// of variables passed through this method.  From that, we
// can get the values sent to this page from Flash and
// assign them to appropriate variables which can be used
// in the PHP mail() function.


// header information not including sendTo and Subject
// these all go in one variable.  First, include From:
$headers = "From: "."<" . $from .">\r\n";
// next include a replyto
$headers .= "Reply-To: " . $from . "\r\n";
// often email servers won't allow emails to be sent to
// domains other than their own.  The return path here will
// often lift that restriction so, for instance, you could send
// email to a hotmail account. (hosting provider settings may vary)
// technically bounced email is supposed to go to the return-path email
$headers .= "Return-path: " . $from;

// now we can add the content of the message to a body variable





$message = $note . "\n\n";
$message .= "Video URL: " . $url;


// once the variables have been defined, they can be included
// in the mail function call which will send you an email
if(mail($to, $subject, $message, $headers))
{
	echo "output=sent";
} else {
	echo "output=error";
}

?>