
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

var pagearray=new Array();
var timerout1 ;
var timerout;
var timerout2;
var timerout3;
pageno =0 ;

//postadd
setTimeout('onplayerloaded()',10000);
pagearray[0]="index.php?option=com_hdflvplayer&task=googleadd";


function getFlashMovie(movieName)
{
    var isIE = navigator.appName.indexOf("Microsoft") != -1;
    return (isIE) ? window[movieName] : document[movieName];
}

function googleclose()
{
    if(document.all)
    {
        document.all.IFrameName.src="";
    }
    else
    {
        frames['IFrameName'].location.href="";
    }
    document.getElementById('lightm').style.display="none";
    clearTimeout();

    setTimeout('bindpage(0)', ropen);
}

function onplayerloaded()
{
    pageno=1;
   
    w=parseInt(document.getElementById('HDFLVPlayer1').style.width);
    // document.getElementById('light').style.left=X+((w-300)/2);
    h=parseInt(document.getElementById('HDFLVPlayer1').style.height);
    //document.getElementById('light').style.top=Y+((h-300)/2);
   
    document.getElementById('lightm').style.left="0px";
    timerout1 =window.setTimeout('bindpage(0)', 1000);
    //setTimeout(closediv(), 10000);
    getFlashMovie('player').playmovie();

}

function findPosX(obj)
{
    var curleft = 0;
    if(obj.offsetParent)
        while(1)
        {
            curleft += obj.offsetLeft;
            if(!obj.offsetParent)
                break;
            obj = obj.offsetParent;
        }
    else if(obj.x)
        curleft += obj.x;
    return curleft;
}

function findPosY(obj)
{
    var curtop = 0;
    if(obj.offsetParent)
        while(1)
        {
            curtop += obj.offsetTop;
            if(!obj.offsetParent)
                break;
            obj = obj.offsetParent;
        }
    else if(obj.y)
        curtop += obj.y;
    return curtop;
}

function closediv()
{

 document.getElementById('lightm').style.display="none";
 clearTimeout();
 if( ropen!=''){setTimeout('bindpage(0)', ropen); }
}

function bindpage(pageno)
{
    //document.getElementById('lightm').style.display="none";

    if(document.all)
    {
        document.all.IFrameName.src=pagearray[0];
    }
    else
    {
        frames['IFrameName'].location.href=pagearray[pageno];
    }

    document.getElementById('closeimgm').style.display="block";
    document.getElementById('lightm').style.display="block";
    if(closeadd !='') setTimeout('closediv()', closeadd);
    //setInterval('closediv()', 10000);
}



//function onEndVideo()
//{
//    postadd();
//}