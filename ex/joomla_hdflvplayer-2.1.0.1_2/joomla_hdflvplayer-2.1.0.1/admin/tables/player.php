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


/**
 * Player Table class
 */
class TablePlayer extends JTable
{
    /**
     * Primary Key
     *
     * @var int
     */
    var $id = null;

    /**
     * @var int
     */
    var $version = 0;

    /**
     * @var int
     */
    var $minw = 0;

    /**
     * @var int
     */
    var $minh = 0;

    /**
     * @var int
     */
    var $isjw = 0;

    /**
     * @var string
     */
    var $name = '';

    /**
     * @var string
     */
    var $code = '';

    /**
     * @var string
     */
    var $description = '';

    /**
     * Constructor
     *
     * @param object Database connector object
     */
    function TablePlayer(& $db) {
        parent::__construct('#__avr_player', 'id', $db);
    }
}
