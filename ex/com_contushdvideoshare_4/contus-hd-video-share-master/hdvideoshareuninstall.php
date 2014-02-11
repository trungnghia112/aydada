<?php
/**
 * @name          : Joomla HD Video Share
 *** @version	  : 3.4.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component Uninstallation File 
 * @Creation Date : March 2010
 * @Modified Date : May 2013
 * */

/**
 * Description :    Uninstallation file
 */

//No direct access
defined('_JEXEC') or die('Restricted access');
error_reporting(0);
// Imports
jimport('joomla.installer.installer');
$db = JFactory::getDBO();
$db->setQuery("DROP TABLE IF EXISTS `#__hdflv_category_backup`");
$db->query();
$db->setQuery("RENAME TABLE `#__hdflv_category` TO `#__hdflv_category_backup`");
$db->query();

$db->setQuery("DROP TABLE IF EXISTS `#__hdflv_comments_backup`");
$db->query();
$db->setQuery("RENAME TABLE `#__hdflv_comments` TO `#__hdflv_comments_backup`");
$db->query();

$db->setQuery("DROP TABLE IF EXISTS `#__hdflv_player_settings_backup`");
$db->query();
$db->setQuery("RENAME TABLE `#__hdflv_player_settings` TO `#__hdflv_player_settings_backup`");
$db->query();

$db->setQuery("DROP TABLE IF EXISTS `#__hdflv_site_settings_backup`");
$db->query();
$db->setQuery("RENAME TABLE `#__hdflv_site_settings` TO `#__hdflv_site_settings_backup`");
$db->query();

$db->setQuery("DROP TABLE IF EXISTS `#__hdflv_upload_backup`");
$db->query();
$db->setQuery("RENAME TABLE `#__hdflv_upload` TO `#__hdflv_upload_backup`");
$db->query();

$db->setQuery("DROP TABLE IF EXISTS `#__hdflv_video_category_backup`");
$db->query();
$db->setQuery("RENAME TABLE `#__hdflv_video_category` TO `#__hdflv_video_category_backup`");
$db->query();

$db->setQuery("DROP TABLE IF EXISTS `#__hdflv_googlead_backup`");
$db->query();
$db->setQuery("RENAME TABLE `#__hdflv_googlead` TO `#__hdflv_googlead_backup`");
$db->query();

$db->setQuery("DROP TABLE IF EXISTS `#__hdflv_ads_backup`");
$db->query();
$db->setQuery("RENAME TABLE `#__hdflv_ads` TO `#__hdflv_ads_backup`");
$db->query();

$db->setQuery("DROP TABLE IF EXISTS `#__hdflv_user_backup`");
$db->query();
$db->setQuery("RENAME TABLE `#__hdflv_user` TO `#__hdflv_user_backup`");
$db->query();

if (version_compare(JVERSION, '1.6.0', 'ge')) {
    $db->setQuery("SELECT extension_id FROM #__extensions WHERE type = 'module' AND element = 'mod_HDVideoShareCategories' LIMIT 1");
} else {
    $db->setQuery("SELECT id FROM #__modules WHERE module = 'mod_HDVideoShareCategories' LIMIT 1");
}
$id = $db->loadResult();
if ($id) {
    $installer = new JInstaller();
    $installer->uninstall('module', $id);
}
if (version_compare(JVERSION, '1.6.0', 'ge')) {
    $db->setQuery("SELECT extension_id FROM #__extensions WHERE type = 'module' AND element = 'mod_HDVideoShareFeatured' LIMIT 1");
} else {
    $db->setQuery("SELECT id FROM #__modules WHERE module = 'mod_HDVideoShareFeatured' LIMIT 1");
}
$id = $db->loadResult();
if ($id) {
    $installer = new JInstaller();
    $installer->uninstall('module', $id);
}
if (version_compare(JVERSION, '1.6.0', 'ge')) {
    $db->setQuery("SELECT extension_id FROM #__extensions WHERE type = 'module' AND element = 'mod_HDVideoSharePopular' LIMIT 1");
} else {
    $db->setQuery("SELECT id FROM #__modules WHERE module = 'mod_HDVideoSharePopular' LIMIT 1");
}
$id = $db->loadResult();
if ($id) {
    $installer = new JInstaller();
    $installer->uninstall('module', $id);
}
if (version_compare(JVERSION, '1.6.0', 'ge')) {
    $db->setQuery("SELECT extension_id FROM #__extensions WHERE type = 'module' AND element = 'mod_HDVideoShareRecent' LIMIT 1");
} else {
    $db->setQuery("SELECT id FROM #__modules WHERE module = 'mod_HDVideoShareRecent' LIMIT 1");
}
$id = $db->loadResult();
if ($id) {
    $installer = new JInstaller();
    $installer->uninstall('module', $id);
}
if (version_compare(JVERSION, '1.6.0', 'ge')) {
    $db->setQuery("SELECT extension_id FROM #__extensions WHERE type = 'module' AND element = 'mod_HDVideoShareRelated' LIMIT 1");
} else {
    $db->setQuery("SELECT id FROM #__modules WHERE module = 'mod_HDVideoShareRelated' LIMIT 1");
}
$id = $db->loadResult();
if ($id) {
    $installer = new JInstaller();
    $installer->uninstall('module', $id);
}
if (version_compare(JVERSION, '1.6.0', 'ge')) {
    $db->setQuery("SELECT extension_id FROM #__extensions WHERE type = 'module' AND element = 'mod_HDVideoShareSearch' LIMIT 1");
} else {
    $db->setQuery("SELECT id FROM #__modules WHERE module = 'mod_HDVideoShareSearch' LIMIT 1");
}
$id = $db->loadResult();
if ($id) {
    $installer = new JInstaller();
    $installer->uninstall('module', $id);
}

if (version_compare(JVERSION, '1.6.0', 'ge')) {
    $db->setQuery("SELECT extension_id FROM #__extensions WHERE type = 'plugin' AND element = 'hvsarticle' AND folder = 'content' LIMIT 1");
} else {
    $db->setQuery("SELECT id FROM #__plugins WHERE element = 'hvsarticle' LIMIT 1");
}
$id = $db->loadResult();
if ($id) {
    $installer = new JInstaller();
    $installer->uninstall('plugin', $id);
}
?>
<h2 align="center">HDVideo Share UnInstallation Status</h2>
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
        <tr class="row0">
            <td class="key" colspan="2"><?php echo JText::_('HDVideoShare - Component'); ?></td>
            <td style="text-align: center;">
                <?php
                //check installed components
                $db = &JFactory::getDBO();
                $db->setQuery("SELECT id FROM #__hdflv_player_settings_backup LIMIT 1");
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
            <td class="key" colspan="2"><?php echo 'HDVideoShare Categories - ' . JText::_('Module'); ?></td>
            <td style="text-align: center;">
                <?php
                //check installed modules
                $db = &JFactory::getDBO();
                if (version_compare(JVERSION, '1.6.0', 'ge')) {
                    $db->setQuery("SELECT extension_id FROM #__extensions WHERE type = 'module' AND element = 'mod_HDVideoShareCategories' LIMIT 1");
                } else {
                    $db->setQuery("SELECT id FROM #__modules WHERE module = 'mod_HDVideoShareCategories' LIMIT 1");
                }
                $id = $db->loadResult();
                if (!$id) {
                    echo "<strong>" . JText::_('Uninstalled successfully') . "</strong>";
                } else {
                    echo "<strong>" . JText::_('Remove Manually') . "</strong>";
                }
                ?>
            </td>
        </tr>

        <tr class="row0">
            <td class="key" colspan="2"><?php echo 'HDVideoShare Featured - ' . JText::_('Module'); ?></td>
            <td style="text-align: center;">
                <?php
                //check installed modules
                $db = &JFactory::getDBO();
                if (version_compare(JVERSION, '1.6.0', 'ge')) {
                    $db->setQuery("SELECT extension_id FROM #__extensions WHERE type = 'module' AND element = 'mod_HDVideoShareFeatured' LIMIT 1");
                } else {
                    $db->setQuery("SELECT id FROM #__modules WHERE module = 'mod_HDVideoShareFeatured' LIMIT 1");
                }

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
            <td class="key" colspan="2"><?php echo 'HDVideoShare Related - ' . JText::_('Module'); ?></td>
            <td style="text-align: center;">
                <?php
                //check installed modules
                $db = &JFactory::getDBO();
                if (version_compare(JVERSION, '1.6.0', 'ge')) {
                    $db->setQuery("SELECT extension_id FROM #__extensions WHERE type = 'module' AND element = 'mod_HDVideoShareRelated' LIMIT 1");
                } else {
                    $db->setQuery("SELECT id FROM #__modules WHERE module = 'mod_HDVideoShareRelated' LIMIT 1");
                }

                $id = $db->loadResult();
                if (!$id) {
                     echo "<strong>" . JText::_('Uninstalled successfully') . "</strong>";
                } else {
                    echo "<strong>" . JText::_('Remove Manually') . "</strong>";
                }
                ?>
            </td>
        </tr>

        <tr class="row0">
            <td class="key" colspan="2"><?php echo 'HDVideoShare Popular - ' . JText::_('Module'); ?></td>
            <td style="text-align: center;">
                <?php
                //check installed modules
                $db = &JFactory::getDBO();
                if (version_compare(JVERSION, '1.6.0', 'ge')) {
                    $db->setQuery("SELECT extension_id FROM #__extensions WHERE type = 'module' AND element = 'mod_HDVideoSharePopular' LIMIT 1");
                } else {
                    $db->setQuery("SELECT id FROM #__modules WHERE module = 'mod_HDVideoSharePopular' LIMIT 1");
                }

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
            <td class="key" colspan="2"><?php echo 'HDVideoShare Recent - ' . JText::_('Module'); ?></td>
            <td style="text-align: center;">
                <?php
                //check installed modules
                $db = &JFactory::getDBO();
                if (version_compare(JVERSION, '1.6.0', 'ge')) {
                    $db->setQuery("SELECT extension_id FROM #__extensions WHERE type = 'module' AND element = 'mod_HDVideoShareRecent' LIMIT 1");
                } else {
                    $db->setQuery("SELECT id FROM #__modules WHERE module = 'mod_HDVideoShareRecent' LIMIT 1");
                }

                $id = $db->loadResult();
                if (!$id) {
                    echo "<strong>" . JText::_('Uninstalled successfully') . "</strong>";
                } else {
                    echo "<strong>" . JText::_('Remove Manually') . "</strong>";
                }
                ?>
            </td>
        </tr>



        <tr class="row0">
            <td class="key" colspan="2"><?php echo 'HDVideoShare Search - ' . JText::_('Module'); ?></td>
            <td style="text-align: center;">
                <?php
                //check installed modules
                $db = &JFactory::getDBO();
                if (version_compare(JVERSION, '1.6.0', 'ge')) {
                    $db->setQuery("SELECT extension_id FROM #__extensions WHERE type = 'module' AND element = 'mod_HDVideoShareSearch' LIMIT 1");
                } else {
                    $db->setQuery("SELECT id FROM #__modules WHERE module = 'mod_HDVideoShareSearch' LIMIT 1");
                }

                $id = $db->loadResult();
                if (!$id) {
                    echo "<strong>" . JText::_('Uninstalled successfully') . "</strong>";
                } else {
                    echo "<strong>" . JText::_('Remove Manually') . "</strong>";
                }
                ?>
            </td>
        </tr>
        <tr class="row0">
            <td class="key" colspan="2"><?php echo 'HVS Article Plugin - ' . JText::_('Plugin'); ?></td>
            <td style="text-align: center;">
                <?php
                //check installed modules
                $db = &JFactory::getDBO();
                if (version_compare(JVERSION, '1.6.0', 'ge')) {
                        $db->setQuery("SELECT extension_id FROM #__extensions WHERE type = 'plugin' AND element = 'hvsarticle' AND folder = 'content' LIMIT 1");
                } else {
                        $db->setQuery("SELECT id FROM #__plugins WHERE element = 'hvsarticle' LIMIT 1");
                }

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
