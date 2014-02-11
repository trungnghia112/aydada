<?php

/*
 * @version	  : 2.5
 * @package       : apptha
 * @subpackage    : wp-flash-player
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license	      : GNU General Public License version 2 or later; see LICENSE.txt
 * @Purpose       : Common functions needed throughout the plugin
 * @Creation Date : Dec 09, 2011
 * @Modified Date : Jul 23, 2012
 *
 */


$to = $_POST['to'];
$from = $_POST['from'];
$url = $_POST['url'];
$subject = $_POST['Note'];
$title = $_POST['title'];




// variables are sent to this PHP page through
// the POST method.  POST is a global associative array
// of variables passed through this method.  From that, we
// can get the values sent to this page from Flash and
// assign them to appropriate variables which can be used
// in the PHP mail() function.


// header information not including sendTo and Subject
// these all go in one variable.  First, include From:
$headers = "From: "."<" . $_POST['from'] .">\r\n";
// next include a replyto
$headers .= "Reply-To: " . $_POST['from'] . "\r\n";
// often email servers won't allow emails to be sent to
// domains other than their own.  The return path here will
// often lift that restriction so, for instance, you could send
// email to a hotmail account. (hosting provider settings may vary)
// technically bounced email is supposed to go to the return-path email
$headers .= "Return-path: " . $_POST['from'];

// now we can add the content of the message to a body variable

$message = $_POST['Note'] . "\n\n";
$message .= "Video URL: " . $url;



// once the variables have been defined, they can be included
// in the mail function call which will send you an email
if(mail($to, $title, $message, $headers))
{
	echo "output=sent";
} else {
	echo "output=error";
}

?>
