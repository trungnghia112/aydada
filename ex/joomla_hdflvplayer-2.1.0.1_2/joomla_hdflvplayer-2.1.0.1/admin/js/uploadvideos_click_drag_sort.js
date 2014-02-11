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
//When the document is ready set up our sortable with it's inherant function(s)
var dragdr = jQuery.noConflict();
var videoid = new Array();
dragdr(document).ready(function() {
	var baseUrl = window.location.protocol+ '//'+window.location.hostname + window.location.pathname
	
    dragdr("#test-list").sortable({
        handle : '.handle',
        update : function () {
            var order = dragdr('#test-list').sortable('serialize');

            orderid= order.split("listItem[]=");
            
            for(i=1;i<orderid.length;i++)
            {
                videoid[i]=orderid[i].replace('&',"");
                oid= "ordertd_"+videoid[i];
                document.getElementById(oid).innerHTML=i-1;
            }

            dragdr("#info").load(baseUrl+"?option=com_hdflvplayer&task=sortorder&"+order);
        }
    });
});