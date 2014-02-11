<?php
/**
 * @name          : Joomla HD Video Share
 * @version	  : 3.4.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component Showads View Page
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */
##  no direct access
defined('_JEXEC') or die('Restricted access');
$arrAdsList = $this->showads['adsList'];
$arrAdsFilter = $this->showads['adsFilter'];
$arrAdsPageNav = $this->showads['pageNav'];
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
<form action="" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">

<fieldset id="filter-bar" <?php if(version_compare(JVERSION, '3.0.0', 'ge')) echo 'class="btn-toolbar"';?> >
		<div class="filter-search fltlft" style="float: left;">
<?php if(version_compare(JVERSION, '3.0.0', 'ge')){ ?>
                    <input type="text" title="Search in module title." placeholder="Search Ads" id="ads_search" name="ads_search" style="float:left; margin-right: 10px;">
                        <div class="btn-group pull-left">
                            <button type="submit"  class="btn hasTooltip">
                                <i class="icon-search"></i>
                            </button>
                            <button class="btn hasTooltip" onclick="document.getElementById('ads_search').value='';this.form.submit();" type="button" >
                                <i class="icon-remove"></i>
                            </button>
                        </div>
                    <?php } else { ?>
                    <label for="ads_search" class="filter-search-lbl">Filter:</label>
			<input type="text" title="Search in module title." value="<?php if (isset($arrAdsFilter['ads_search']))
            	echo $arrAdsFilter['ads_search']; ?>" id="ads_search" name="ads_search">
			<button type="submit" style="padding: 1px 6px;"><?php echo JText::_('Search'); ?></button>
			<button onclick="document.getElementById('ads_search').value='';this.form.submit();" type="button" style="padding: 1px 6px;">
			<?php echo JText::_('Clear'); ?></button>
                        <?php } ?>
		</div>
		<div class="filter-select fltrt" style="float: right;">
			<select onchange="this.form.submit()" class="inputbox" name="ads_status">
			<option selected="selected" value="">- Select Status -</option>
			<option value="1" <?php if (isset($arrAdsFilter['ads_status']) && $arrAdsFilter['ads_status'] == '1')echo 'selected=selected'; ?>>Published</option>
			<option value="2" <?php if (isset($arrAdsFilter['ads_status']) && $arrAdsFilter['ads_status'] == '2')echo 'selected=selected'; ?>>Unpublished</option>
			<option value="3" <?php if (isset($arrAdsFilter['ads_status']) && $arrAdsFilter['ads_status'] == '3')echo 'selected=selected'; ?>>Trashed</option>
			</select>
			
			<select onchange="this.form.submit()" class="inputbox" name="ads_type">
			<option selected="selected" value="">- Select Ad Type -</option>
			<option value="1" <?php if (isset($arrAdsFilter['ads_type']) && $arrAdsFilter['ads_type'] == '1')echo 'selected=selected'; ?>>Pre/Post Roll</option>
			<option value="2" <?php if (isset($arrAdsFilter['ads_type']) && $arrAdsFilter['ads_type'] == '2')echo 'selected=selected'; ?>>Mid Roll</option>
			</select>
		</div>
</fieldset>	
	<table  class="adminlist <?php if(version_compare(JVERSION, '3.0.0', 'ge')) echo 'table table-striped';?>">
		<thead>
			<tr>
				<th>#</th>
				<th <?php if(version_compare(JVERSION, '3.0.0', 'ge')) echo 'class="center"';?>><input type="checkbox" name="toggle" value=""
onClick=" <?php if(!version_compare(JVERSION, '3.0.0', 'ge')) { ?> checkAll(<?php echo count($arrAdsList); ?>); <?php } else ?> Joomla.checkAll(this)" />
				</th>
				<th class="left"><?php echo JHTML::_('grid.sort', 'Ad Name', 'adsname', @$arrAdsFilter['filter_order_Dir_ads'], @$arrAdsFilter['filter_order_ads']); ?>
				</th>	
				<th><?php echo JHTML::_('grid.sort', 'Ad Type', 'typeofadd', @$arrAdsFilter['filter_order_Dir_ads'], @$arrAdsFilter['filter_order_ads']); ?>
				</th>			
				<th>Ad Video Path</th>
				<th <?php if(version_compare(JVERSION, '3.0.0', 'ge')) echo 'class="center"';?>><?php echo JHTML::_('grid.sort', 'Published', 'published', @$arrAdsFilter['filter_order_Dir_ads'], @$arrAdsFilter['filter_order_ads']); ?>
				</th>
				<th <?php if(version_compare(JVERSION, '3.0.0', 'ge')) echo 'class="center"';?>><?php echo JHTML::_('grid.sort', 'Ad Visits', 'clickcounts', @$arrAdsFilter['filter_order_Dir_ads'], @$arrAdsFilter['filter_order_ads']); ?>
				</th>
				<th <?php if(version_compare(JVERSION, '3.0.0', 'ge')) echo 'class="center"';?>><?php echo JHTML::_('grid.sort', 'Impression Hits', 'impressioncounts', @$arrAdsFilter['filter_order_Dir_ads'], @$arrAdsFilter['filter_order_ads']); ?>
				</th>
				<th <?php if(version_compare(JVERSION, '3.0.0', 'ge')) echo 'class="center"';?>><?php echo JHTML::_('grid.sort', 'ID', 'Id', @$arrAdsFilter['filter_order_Dir_ads'], @$arrAdsFilter['filter_order_ads']); ?>
				</th>
			</tr>
		</thead>
		<tbody>
		<?php		
		jimport('joomla.filter.output');		
		$n = count($arrAdsList);		
			for ($i = 0; $i < $n; $i++) {
				$arrAd = $arrAdsList[$i];
                                $imaaddetail = unserialize($arrAd->imaaddet);
				$checked = JHTML::_('grid.id', $i, $arrAd->id);
				$states	= array(
				-2	=> array('trash.png',		'messages.unpublish','JTRASHED','COM_MESSAGES_MARK_AS_UNREAD'),
				1	=> array('tick.png',		'messages.publish',	'COM_MESSAGES_OPTION_READ','COM_MESSAGES_MARK_AS_UNREAD'),
				0	=> array('publish_x.png',	'messages.unpublish','COM_MESSAGES_OPTION_UNREAD','COM_MESSAGES_MARK_AS_READ')
				);
				if(version_compare(JVERSION,'1.6.0','ge'))
                                {
                                    $published = JHtml::_('jgrid.published', $arrAd->published, $i);
                                } else {
                                    $published = JHtml::_('grid.published',  $arrAd, $i, $states[$arrAd->published][0], $states[$arrAd->published][0], '', 'cb');
                                }
				$link = JRoute::_('index.php?option=com_contushdvideoshare&layout=ads&task=editads&cid[]=' . $arrAd->id);
				if (($arrAd->typeofadd == 'prepost') || ($arrAd->typeofadd == ''))
                                {
                                        $videoType = 'Pre/Post-roll Ad';
                                        $videoPath = $arrAd->postvideopath;
                                }
                                else if (($arrAd->typeofadd == 'ima'))
                                {
                                        $videoType = 'IMA Ad';
                                        if (strlen($imaaddetail['imaadpath']) > 45)
                                        {
                                            $videoPath = (substr($imaaddetail['imaadpath'], 0, 45)) . '..';
                                        }
                                        else
                                        {
                                            $videoPath = $imaaddetail['imaadpath'];
                                        }
                                }
                                else
                                {
                                        $videoType = 'Mid-roll Ad';
                                        $videoPath = '';
                                }
                                ?>
		<tr class="<?php echo 'row' . ($i % 2); ?>">
			<td class="center"><?php echo $i + 1; ?></td>
			<td class="center"><?php echo $checked; ?></td>
			<td class="left">
			<a href="<?php echo $link; ?>"> <?php echo $arrAd->adsname; ?></a>
			</td>	
			<td class="<?php if(version_compare(JVERSION, '3.0.0', 'ge')) echo 'left'; else echo 'center'; ?>">
                            <?php echo $videoType; ?>
			</td>		
			<td class="center"><?php echo $videoPath; ?>
			</td>
			<td class="center"><?php echo $published; ?>
			</td>
			<td class="center"><?php echo $arrAd->clickcounts; ?>
			</td>
			<td class="center"><?php echo $arrAd->impressioncounts; ?>
			</td>
			<td class="center"><?php echo $arrAd->id; ?>
			</td>

		</tr>
		<?php		
			}		
		?>
	
		</tbody>
		<tfoot>
			<td colspan="15"><?php echo $arrAdsPageNav->getListFooter() ;?></td>
		</tfoot>
	</table>

	<input type="hidden" name="filter_order" value="<?php echo @$arrAdsFilter['filter_order_ads']; ?>" /> 
	<input type="hidden"name="filter_order_Dir" value="<?php echo @$arrAdsFilter['filter_order_Dir_ads']; ?>" />
	<input type="hidden" name="task" value="" /> 
	<input type="hidden" name="boxchecked" value="0"> 
	<input type="hidden" name="submitted" value="true" id="submitted">
</form>


