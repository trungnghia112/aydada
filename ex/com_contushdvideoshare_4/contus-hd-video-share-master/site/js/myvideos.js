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
 * @abstract      : Contus HD Video Share Component myvideos.js file
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */

/*
 ***********************************************************/

function changepage(pageno)
    {
        document.getElementById("page").value=pageno;
        document.pagination.submit();
    }

    function my_message(vid)
    {
        var flg=confirm('Do you Really Want To Delete This Video? \n\nClick OK to continue. Otherwise click Cancel.\n');
        if (flg)
        {
            var r=document.getElementById('deletevideo').value=vid;
            document.deletemyvideo.submit();
            return true;
        }
        else
        {
            return false;
        }
    }
    function videoplay(vid,cat)
    {
        window.open('index.php?option=com_contushdvideoshare&view=player&id='+vid+'&catid='+cat,'_self');
    }
    function editvideo(evid)
    {

        window.open(evid,'_self');
    }
    function sortvalue(sortvalue)
    {
        document.getElementById("sorting").value=sortvalue;
        document.sortform.submit();
    }
    function membervalue(memid)
    {
        document.getElementById('memberidvalue').value=memid;
        document.memberidform.submit();
    }