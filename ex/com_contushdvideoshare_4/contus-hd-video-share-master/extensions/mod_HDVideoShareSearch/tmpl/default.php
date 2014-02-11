<?php
/*
 ***********************************************************/
/**
 * @name          : Joomla HD Video Share
 *** @version	  : 3.4.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2012 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Search Videos Module
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */

/*
 ***********************************************************/
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
if(JRequest::getVar('option') != 'com_contushdvideoshare') {
$document = JFactory::getDocument();
$document->addStyleSheet( JURI::base().'components/com_contushdvideoshare/css/mod_stylesheet.css' );
}
?>


<div class="module_menu module_videos <?php echo $class;?> ">
     <form name="hsearch" id="hsearch" method="post" action="<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=hdvideosharesearch'); ?>"  enctype="multipart/form-data"  >
        <input type="text" value="<?php
        $searchtxtbox =JRequest::getVar('searchtxtbox','','post');
        if (isset($searchtxtbox)) {
            echo $searchtxtbox;
             } else {
                 $searchval = JRequest::getVar('searchval','','post');
                 echo isset($searchval)?$searchval:'';
                 } ?>" name="searchtxtbox" id="searchtxtbox" class="clstextfield"  onkeypress="validateenterkey(event,'hsearch');"/>
        <input type="submit" name="search_btn" id="search_btn" class="button" value="<?php echo JText::_('HDVS_SEARCH'); ?>" />
        <input type="hidden" name="searchval" id="searchval" value="
        <?php
        $searchtxtbox =JRequest::getVar('searchtxtbox','','post');
        if (isset($searchtxtbox)) {
            echo $searchtxtbox;
             } else {
                 $searchval = JRequest::getVar('searchval','','post');
                 echo isset($searchval)?$searchval:'';
                 } ?>" />
    </form>
</div>
<div class="clear"></div>
