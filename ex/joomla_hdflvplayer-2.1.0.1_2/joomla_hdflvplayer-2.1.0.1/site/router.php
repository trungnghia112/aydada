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

function hdflvplayerBuildRoute(&$query) {
    $segments = array();

    //Parameter for Playlist id
    if (isset($query['compid'])) {
        $segments[] = 'compid';
        $segments[] = $query['compid'];
        unset($query['compid']);
    }

    //Parameter for Item id
    if (isset($query['Itemid'])) {
        $segments[] = $query['Itemid'];
        unset($query['Itemid']);
    } else {
        $db = JFactory::getDBO();
        $db->setQuery("select id from #__menu where link='index.php?option=com_hdflvplayer'");
        $query['Itemid'] = $db->loadResult();
        $segments[] = $query['Itemid'];
        unset($query['Itemid']);
    }

    //Parameter for Title of the Video

    if (isset($query['title'])) {
        $segments[] = 'title';
        $segments[] = $query['title'];
        unset($query['title']);
    }

    //Parameter for Playlist id

    if (isset($query['id'])) {
        $segments[] = 'id';
        $segments[] = $query['id'];
        unset($query['id']);
    }

    if (isset($query['page'])) {
        $segments[] = 'page';
        $segments[] = $query['page'];
        unset($query['page']);
    }
    if (isset($query['lang'])) {
        $segments[] = 'lang';
        $segments[] = $query['lang'];
        unset($query['lang']);
    }

    return $segments;
}

function hdflvplayerParseRoute($segments) {
    $vars = array();

    // view is always the first element of the array
    $count = count($segments);

    if ($count) {
        switch ($count) {
            case 1:
                $vars['Itemid'] = $segments[0];
                break;
            case 2:
                if (isset($segments[1]) && $segments[0] == 'compid') {
                    $vars['compid'] = $segments[1];
                } else if (isset($segments[1]) && $segments[0] == 'page') {
                    $vars['page'] = $segments[1];
                }
                break;
            case 3:
                $vars['Itemid'] = $segments[2];

                if ($segments[0] == 'compid') {
                    $vars['compid'] = $segments[1];
                }


                if (isset($segments[2]) && $segments[1] == 'page') {
                    $vars['page'] = $segments[2];
                }

                break;

            case 5:
                if (isset($segments[1]) && $segments[0] == 'compid') {
                    $vars['compid'] = $segments[1];
                    if (isset($segments[2])) {
                        $vars['Itemid'] = $segments[2];
                    }
                    if (isset($segments[4]) && $segments[3] == 'page') {
                        $vars['page'] = $segments[4];
                    }
                }
                break;
            case 6:
                if (isset($segments[1]) && $segments[0] == 'title') {

                    $vars['title'] = $segments[1];
                    if (isset($segments[3]) && $segments[2] == 'id') {
                        $vars['id'] = $segments[3];
                        if (isset($segments[5]) && $segments[4] == 'page') {
                            $vars['page'] = $segments[5];
                        }
                    }
                }
                break;
            case 7:

                $vars['Itemid'] = $segments[0];
                if (isset($segments[2]) && $segments[1] == 'title') {

                    $vars['title'] = $segments[2];
                    if (isset($segments[4]) && $segments[3] == 'id') {
                        $vars['id'] = $segments[4];
                        if (isset($segments[6]) && $segments[5] == 'page') {
                            $vars['page'] = $segments[6];
                        }
                    }
                }

                break;
            case 9:
                if (isset($segments[1]) && $segments[0] == 'compid') {
                    $vars['compid'] = $segments[1];
                    $vars['Itemid'] = $segments[2];
                    if (isset($segments[4]) && $segments[3] == 'title') {

                        $vars['title'] = $segments[4];
                        if (isset($segments[6]) && $segments[5] == 'id') {
                            $vars['id'] = $segments[6];
                            if (isset($segments[8]) && $segments[7] == 'page') {
                                $vars['page'] = $segments[8];
                            }
                        }
                    }
                }
                break;
        }
    }

    return $vars;
}
