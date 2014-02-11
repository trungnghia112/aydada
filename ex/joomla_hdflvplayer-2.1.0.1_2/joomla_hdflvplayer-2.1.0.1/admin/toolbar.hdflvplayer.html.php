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
defined( '_JEXEC' ) or die( 'Restricted access' );

class TOOLBAR_hdflvplayer {

	public static function _DEFAULTSETTINGS()
	{
		JToolBarHelper::title( JText::_( 'Player Settings' ),'generic.png' );
	}
	public static function _DEFAULTVIDEO()
	{
		$app =  JFactory::getApplication();
		global $option;
		JToolBarHelper::title( JText::_( 'Videos' ),'upload-videos.png' );
		JToolBarHelper::addNew('addvideoupload','New Video');
		JToolBarHelper::editList('editvideoupload','Edit');
		JToolBarHelper::publishList();
		JToolBarHelper::unpublishList();
		if($app->getUserStateFromRequest( $option.'filter_order_Status', 'filter_state', '', 'int' ) == -2)
		{
			JToolBarHelper::deleteList('', 'Remove', 'JTOOLBAR_EMPTY_TRASH');
		}
		else{
			JToolBarHelper::trash('trash');
		}
		JToolBarHelper::unpublishList('resethits','Viewed Reset');
		JToolBarHelper::makeDefault( 'setdefault' );

	}
	public static function _NEWSETTINGS1() {
		JToolBarHelper::title( JText::_( 'Player Settings' ),'player-settings-icon.png' );
		JToolBarHelper::apply('applyplayersettings','Apply');
	}

	public static function _DEFAULTPLAYLISTNAME()
	{
		$app = JFactory::getApplication();
		global $option;
		JToolBarHelper::title( JText::_( 'Playlist' ),'category-icon.png' );
		JToolBarHelper::addNew('addplaylistname','Add Playlist');
		JToolBarHelper::editList('editplaylistname','Edit');
		JToolBarHelper::publishList();
		JToolBarHelper::unpublishList();
		if($app->getUserStateFromRequest( $option.'filter_order_Status', 'filter_state', '', 'int' ) == -2)
		{
			JToolBarHelper::deleteList('', 'removeplaylistname', 'JTOOLBAR_EMPTY_TRASH');
		}
		else{
			JToolBarHelper::trash('trash');
		}
		

	}

	public static function _NEWSETTINGS() {
		JToolBarHelper::title( JText::_( 'Video' ),'upload-videos.png' );
		JToolBarHelper::save('savevideoupload','Save');
		JToolBarHelper::apply('applyvideoupload','Apply');
		JToolBarHelper::cancel('UPLOADVIDEOCANCEL','Cancel');
	}
	public static function _NEWPLAYLISTNAME() {
		JToolBarHelper::title( JText::_( 'Playlist' ),'category-icon.png' );
		JToolBarHelper::save('saveplaylistname','Save');
		JToolBarHelper::apply('applyplaylistname','Apply');
		JToolBarHelper::cancel('PLAYLISTNAMECANCEL','Cancel');
	}
	public static function _NEWLANGUAGESETUP()
	{
		JToolBarHelper::title( JText::_( 'Language Settings' ),'language-settings-icon.png' );
		JToolBarHelper::apply('applylanguagesetup','Apply');
	}

	public static function _NEWADS()
	{
		JToolBarHelper::title( JText::_( 'Video Ads' ),'ads-icon.png' );
		JToolBarHelper::save('saveads','Save');
		JToolBarHelper::apply('applyads','Apply');
		JToolBarHelper::cancel('CANCELADS','Cancel');

	}
	public static  function _GOOGLEADD()
	{
		JToolBarHelper::title( JText::_( 'Google Adsense' ),'google-adsense-icon.png' );
		JToolBarHelper::apply('saveaddgoogle','Apply');
	}

	public static function _NEWCHECKLISt()
	{
		JToolBarHelper::title( JText::_( 'Checklist' ),'checklist-icon.png' );
	}

	public static  function _DEFAULTADS() {
		$app = JFactory::getApplication();
		global $option;
		JToolBarHelper::title( JText::_( 'Video Ads' ),'ads-icon.png' );
		JToolBarHelper::addNew('addads','New Ad');
		JToolBarHelper::editList('editads','Edit');
		JToolBarHelper::publishList();
		JToolBarHelper::unpublishList();
		if($app->getUserStateFromRequest( $option.'filter_order_Status', 'filter_state', '', 'int' ) == -2)
		{
			JToolBarHelper::deleteList('', 'removeads', 'JTOOLBAR_EMPTY_TRASH');
		}
		else{
			JToolBarHelper::trash('trash');
		}
		

	}
}
?>