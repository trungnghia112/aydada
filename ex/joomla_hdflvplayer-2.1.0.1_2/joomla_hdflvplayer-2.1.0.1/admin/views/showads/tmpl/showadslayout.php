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

jimport('joomla.filter.output');
$rs_showads = $this->showads;

$states	= array(
			-2	=> array('trash.png',		'messages.unpublish',	'JTRASHED',				'COM_MESSAGES_MARK_AS_UNREAD'),
			1	=> array('tick.png',		'messages.unpublish',	'COM_MESSAGES_OPTION_READ',		'COM_MESSAGES_MARK_AS_UNREAD'),
			0	=> array('publish_x.png',	'messages.publish',		'COM_MESSAGES_OPTION_UNREAD',	'COM_MESSAGES_MARK_AS_READ')
		);
if(version_compare(JVERSION,'1.6.0','le')){?>
<style>
table tr td a img {
	width: 16px;
}
td.center, th.center, .center {
	text-align: center;
	float: none;
}
</style>
<?php } ?>

<form action="index.php?option=com_hdflvplayer&task=ads" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">

    <!-- Filter content starts here -->
	<fieldset id="filter-bar">

		<!-- Filter By search Box -->
		<div class="filter-search fltlft">
			<label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?>
			</label> <input type="text" name="search" id="search"
				value="<?php if (isset($rs_showads['lists']['search'])){ echo $rs_showads['lists']['search']; }?>"
				onchange="document.adminForm.submit();" />
			<button onClick="this.form.submit();" class="searhbtn">
			<?php echo JText::_('Search'); ?>
			</button>
			<button onClick="document.getElementById('search').value='';" class="searhbtn">
			<?php echo JText::_('Clear'); ?>
			</button>
		</div>


		<div class="filter-select fltrt">

			<!-- Filter by publish status -->
			<select name="filter_state" class="inputbox" onchange="this.form.submit()">
				<option><?php echo JText::_('JOPTION_SELECT_PUBLISHED');?></option>
				<option value="1" <?php if($rs_showads['lists']['ads_state'] == '1'){ echo 'selected'; }?>>Published</option>
				<option value="2" <?php if($rs_showads['lists']['ads_state'] == '2'){ echo 'selected'; }?>>Unpublished</option>
				<option value="-2" <?php if($rs_showads['lists']['ads_state'] == '-2'){ echo 'selected'; }?>>Trashed</option>
			</select>

			<!-- Filter by Ads Type -->
			<select name="filter_type" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo '-Select Type-';?></option>
				<option value="prepost" <?php if($rs_showads['lists']['ads_type'] == 'prepost'){ echo 'selected'; }?>>Pre/Post Roll Ad</option>
				<option value="mid" <?php if($rs_showads['lists']['ads_type'] == 'mid'){ echo 'selected'; }?>>Mid Roll Ad</option>
				<option value="ima" <?php if($rs_showads['lists']['ads_type'] == 'ima'){ echo 'selected'; }?>>IMA Ad</option>
			</select>

		</div>
	</fieldset>
	<!-- Filter content ends here -->

	<table style=" margin-bottom: 18px; " class="adminlist<?php if(version_compare(JVERSION, '3.0.0', 'ge')) { echo "_ads"; } ?>">
        <thead>
            <tr <?php if(version_compare(JVERSION, '3.0.0', 'ge')) { echo 'class="row"'; } ?>>
                <th>#</th>
                <th>
                    <input type="checkbox" name="toggle"
                           value="" onClick="
    <?php if(!version_compare(JVERSION, '3.0.0', 'ge')) { ?>
                                    checkAll(<?php echo count($rs_showads['rs_showads']); ?>);
                      <?php } else ?>
                          Joomla.checkAll(this)                                
" />
                </th>
                <th>
					<?php echo JHTML::_('grid.sort', 'Ads name', 'adsname', @$rs_showads['lists']['order_Dir'], @$rs_showads['lists']['order'], 'ads'); ?>
                </th>
                <th>
                    Ad Type
                </th>
                <th>
                    Ads video path
                </th>
                <th>
                    Status
                </th>
                <th>
					<?php echo JHTML::_('grid.sort', 'ID', 'Id', @$rs_showads['lists']['order_Dir'], @$rs_showads['lists']['order'],'ads'); ?>
                </th>
                <th>
                    <?php echo JHTML::_('grid.sort', 'Ad Visits', 'clickcounts', @$rs_showads['lists']['order_Dir'], @$rs_showads['lists']['order'],'ads'); ?>
                </th>
                <th colspan="9">
                	<?php echo JHTML::_('grid.sort', 'Impression Hits', 'impressioncounts', @$rs_showads['lists']['order_Dir'], @$rs_showads['lists']['order'],'ads'); ?>
                </th>
            </tr>
        </thead>
			<?php

			$countAds = count($rs_showads['rs_showads']);
			if ($countAds >= 1) {
			    for ($i = 0; $i < $countAds; $i++) {
			        $rsplay = $rs_showads['rs_showads'][$i];
			        $checked = JHTML::_('grid.id', $i, $rsplay->id);

			        if(version_compare(JVERSION, '3.0.0', 'ge')) {
                                  $published 		= JHtml::_('jgrid.published',  $rsplay->published, $i);
                                }else{
                                $published 		= JHtml::_('grid.published',  $rsplay, $i, $states[$rsplay->published][0], $states[$rsplay->published][0], '', 'cb');
                                }
			        $link = JRoute::_('index.php?option=com_hdflvplayer&task=editads&cid[]=' . $rsplay->id);

					if (($rsplay->typeofadd == 'prepost') || ($rsplay->typeofadd == ''))
					{
						$videoType = 'Pre/Post-roll Ad';
						$videoPath = $rsplay->postvideopath;
					}
					else if (($rsplay->typeofadd == 'ima'))
					{
						$videoType = 'IMA Ad';
						$videoPath = $rsplay->postvideopath;
					}
					else
					{
						$videoType = 'Mid-roll Ad';
						$videoPath = '';
					}
			?>
        <tr class="row">
            <td align="center">
				<?php echo $i + 1; ?>
            </td>
            <td align="center">
				<?php echo $checked; ?>
            </td>

            <td align="left">
                <a href="<?php echo $link; ?>">
					<?php echo $rsplay->adsname; ?>
                </a>
            </td>

            <td align="center">

				<?php echo $videoType; ?>
            </td>

            <td align="center">
				<?php echo $videoPath; ?>
            </td>

            <td align="center">
                <?php echo $published; ?>
            </td>
            <td align="center">
                <?php echo $rsplay->id; ?>
            </td>
            <td align="center">
                <?php echo $rsplay->clickcounts; ?>
            </td>
            <td align="center" colspan="9">
                <?php echo $rsplay->impressioncounts; ?>
            </td>
        </tr>

        <?php
            }
        }
        ?>
    </table>
<?php echo $rs_showads['pageNav']->getListFooter(); ?>
    <!--<input type="hidden" name="id" value="<?php ?>"/>-->
    <input type="hidden" name="filter_order" value="<?php echo $rs_showads['lists']['order']; ?>" />
    <input type="hidden" name="filter_order_Dir" value="<?php echo $rs_showads['lists']['order_Dir']; ?>" />
    <input type="hidden" name="task" value="ads" />
    <input type="hidden" name="boxchecked" value="0">
    <?php echo JHTML::_('form.token'); ?>
</form>