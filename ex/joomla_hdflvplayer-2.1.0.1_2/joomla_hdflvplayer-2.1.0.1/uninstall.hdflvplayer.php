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
 * @Creation Date	23-2-2011
 * @modified Date	15-11-2012
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

error_reporting(0);
// Imports
jimport('joomla.installer.installer');

$db = &JFactory::getDBO();

$db->setQuery("DROP TABLE IF EXISTS `#__hdflvaddgoogle_backup`");
$db->query();
$db->setQuery("RENAME TABLE `#__hdflvaddgoogle` TO `#__hdflvaddgoogle_backup`");
$db->query();

$db->setQuery("DROP TABLE IF EXISTS `#__hdflvplayerads_backup`");
$db->query();
$db->setQuery("RENAME TABLE `#__hdflvplayerads` TO `#__hdflvplayerads_backup`");
$db->query();

$db->setQuery("DROP TABLE IF EXISTS `#__hdflvplayerlanguage_backup`");
$db->query();
$db->setQuery("RENAME TABLE `#__hdflvplayerlanguage` TO `#__hdflvplayerlanguage_backup`");
$db->query();

$db->setQuery("DROP TABLE IF EXISTS `#__hdflvplayername_backup`");
$db->query();
$db->setQuery("RENAME TABLE `#__hdflvplayername` TO `#__hdflvplayername_backup`");
$db->query();

$db->setQuery("DROP TABLE IF EXISTS `#__hdflvplayersettings_backup`");
$db->query();
$db->setQuery("RENAME TABLE `#__hdflvplayersettings` TO `#__hdflvplayersettings_backup`");
$db->query();

$db->setQuery("DROP TABLE IF EXISTS `#__hdflvplayerupload_backup`");
$db->query();
$db->setQuery("RENAME TABLE `#__hdflvplayerupload` TO `#__hdflvplayerupload_backup`");
$db->query();


////count checked cid

$count = count( JRequest::getVar('cid','','post','array'));
if($count !=3 || $count !=2 )
{
if (version_compare(JVERSION, '1.6.0', 'ge')) {

    $db->setQuery("SELECT extension_id FROM #__extensions WHERE type = 'module' AND element = 'mod_hdflvplayer' LIMIT 1");
}
 else {
$db->setQuery("SELECT id FROM #__modules WHERE module = 'mod_hdflvplayer' LIMIT 1");
}
$id = $db->loadResult();
if ($id) {
    $installer = new JInstaller();
    $installer->uninstall('module', $id);
}

if (version_compare(JVERSION, '1.6.0', 'ge')) {

   $db->setQuery("SELECT extension_id FROM #__extensions WHERE type = 'plugin' AND element = 'hdflvplayer' AND folder = 'content' LIMIT 1");

}
 else {
 $db->setQuery("SELECT id FROM #__plugins WHERE element = 'hdflvplayer' AND folder = 'content' LIMIT 1");
}

$id = $db->loadResult();
if ($id) {
    $installer = new JInstaller();
    $installer->uninstall('plugin', $id);
}

}
?>

<h2 align="center">HD FLV Player UnInstallation Status</h2>
<table class="adminlist">
    <thead>
        <tr>
            <th class="title" colspan="2"><?php echo JText::_('Extension'); ?></th>
            <th><?php echo JText::_('Status'); ?></th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <td colspan="3"></td>
        </tr>
    </tfoot>
    <tbody>
        <tr>
            <th colspan="3"><?php echo JText::_('Core'); ?></th>
        </tr>
        <tr class="row0">
            <td class="key" colspan="2"><?php echo 'HD FLVPlayer ' .JText::_('Component'); ?></td>
            <td style="text-align: center;">
                <?php
                //check installed components
                $db = &JFactory::getDBO();
                $db->setQuery("SELECT id FROM #__hdflvplayersettings LIMIT 1");
                $id = $db->loadResult();
                if (!$id) {
                    echo "<strong>" . JText::_('Uninstalled successfully') . "</strong>";
                } else {
                    echo "<strong>" . JText::_('Remove Manually') . "</strong>";
                }
                ?>
            </td>
        </tr>
        <tr class="row1">
            <td class="key" colspan="2"><?php echo 'HD FLVPlayer ' . JText::_('Module'); ?></td>
            <td style="text-align: center;">
                <?php
                //check installed modules
                $db = &JFactory::getDBO();
                $db->setQuery("SELECT extension_id FROM #__extensions WHERE type = 'module' AND element = 'mod_hdflvplayer' LIMIT 1");
                $id = $db->loadResult();
                if (!$id) {
                    echo "<strong>" . JText::_('Uninstalled successfully') . "</strong>";
                } else {
                    echo "<strong>" . JText::_('Remove Manually') . "</strong>";
                }
                ?>
            </td>
        </tr>
        <tr>

            <th colspan="3"><?php echo JText::_('Plugins'); ?></th>
        </tr>
        <tr class="row0">
            <td class="key" colspan="2"><?php echo 'HD FLVPlayer'; ?></td>

            <td style="text-align: center;">
                <?php
                //check installed plugin
                $db = &JFactory::getDBO();
                $db->setQuery("SELECT extension_id FROM #__extensions WHERE type = 'plugin' AND element = 'hdflvplayer' AND folder = 'content' LIMIT 1");
                $id = $db->loadResult();
                if (!$id) {
                    echo "<strong>" . JText::_('Uninstalled successfully') . "</strong>";
                } else {
                    echo "<strong>" . JText::_('Remove Manually') . "</strong>";
                }
                ?>
            </td>
        </tr>
    </tbody>
</table>