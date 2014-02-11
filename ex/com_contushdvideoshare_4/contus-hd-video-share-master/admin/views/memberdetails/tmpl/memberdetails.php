<?php
/*
 ***********************************************************/
/**
 * @name          : Joomla HD Video Share
 ****@version	  : 3.4.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component Memberdetails View Page
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */
/*
 ***********************************************************/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import joomla filter library
jimport('joomla.filter.output');
$arrMemberList = $this->memberdetails;
$arrMemberFilter = $this->memberdetails['memberFilter'];
$arrMemberPageNav = $this->memberdetails['pageNav'];
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
<?php $document = JFactory::getDocument();
$document->addStyleSheet('components/com_contushdvideoshare/css/cc.css');
if(version_compare(JVERSION, '3.0.0', 'ge')) {
   $document->addScript( 'components/com_contushdvideoshare/js/jquery-1.3.2.min.js' );
	$document->addScript( 'components/com_contushdvideoshare/js/jquery-ui-1.7.1.custom.min.js' );
}?>
<form action='index.php?option=com_contushdvideoshare&layout=memberdetails'
	method="POST" name="adminForm" id="adminForm"  enctype="multipart/form-data">
	
<fieldset id="filter-bar" <?php if(version_compare(JVERSION, '3.0.0', 'ge')) echo 'class="btn-toolbar"'; ?>>
		<div class="filter-search fltlft" style="float: left;">
		<?php if(!version_compare(JVERSION, '3.0.0', 'ge')) { ?>
                    <label for="member_search" class="filter-search-lbl">Filter:</label>
			<input type="text" title="Search in module title." value="<?php if (isset($arrMemberFilter['member_search'])) echo $arrMemberFilter['member_search']; ?>" id="member_search" name="member_search">
			<button type="submit"><?php echo JText::_('Search'); ?></button>
			<button onclick="document.id('member_search').value='';this.form.submit();" type="button">
			<?php echo JText::_('Clear'); ?></button>
                        <?php }else { ?>
                        <input type="text" title="Search in module title." id="member_search" placeholder="Search Members" name="member_search" style="float:left; margin-right: 10px;">
                        <div class="btn-group pull-left">
                            <button type="submit"  class="btn hasTooltip"><i class="icon-search"></i></button>
                            <button  class="btn hasTooltip" onclick="document.id('member_search').value='';this.form.submit();" type="button">
                            <i class="icon-remove"></i></button>
                        </div>
                        <?php } ?>
		</div>
		<div class="filter-select fltrt" style="float: right;">
<!--			<select onchange="this.form.submit()" class="inputbox" name="member_upload">
			<option selected="selected" value="">- Select Upload Status -</option>
			<option value="1" <?php if (isset($arrMemberFilter['member_upload']) && $arrMemberFilter['member_upload'] == '1')echo 'selected=selected'; ?>>Enable</option>
			<option value="2" <?php if (isset($arrMemberFilter['member_upload']) && $arrMemberFilter['member_upload'] == '2')echo 'selected=selected'; ?>>Disable</option>
			</select>-->
			<select onchange="this.form.submit()" class="inputbox" name="member_status">
			<option selected="selected" value="">- Select Status -</option>
			<option value="1" <?php if (isset($arrMemberFilter['member_status']) && $arrMemberFilter['member_status'] == '1')echo 'selected=selected'; ?>>Enable</option>
			<option value="2" <?php if (isset($arrMemberFilter['member_status']) && $arrMemberFilter['member_status'] == '2')echo 'selected=selected'; ?>>Disable</option>
			</select>		
		</div>
</fieldset>	
	<table class="adminlist <?php if(version_compare(JVERSION, '3.0.0', 'ge')) echo 'table table-striped'; ?>">
		<thead>
			<tr>
			<?php
			$videoListId = JHTML::_('grid.sort', 'ID', 'id', @$arrMemberFilter['filter_order_Dir'], $arrMemberFilter['filter_order']);
			$firstName = JHTML::_('grid.sort', 'Name', 'name', @$arrMemberFilter['filter_order_Dir'], @$arrMemberFilter['filter_order']);

			?>
				<th width="1%">#</th>
				<th width="2%"><input type="checkbox" name="toggle" value="" onclick="
                                            <?php if(!version_compare(JVERSION, '3.0.0', 'ge')) { ?>
                                            checkAll(<?php echo count($arrMemberList['memberdetails']); ?>);
                                        <?php } else ?>
                          Joomla.checkAll(this)
                                    " />
				</th>
				<th width="20%" class="left"><?php echo $firstName;  ?>
				</th>
				<th width="20%" class="left"><?php echo JHTML::_('grid.sort', 'User Name', 'username', @$arrMemberFilter['filter_order_Dir'], $arrMemberFilter['filter_order']);?>
				</th>
				<th width="20%" class="left">Email</th>
				<th width="20%">Joined Date</th>				
				<th width="8%" class="center"><?php echo JHTML::_('grid.sort', 'Allow Upload', 'allowupload', @$arrMemberFilter['filter_order_Dir'], $arrMemberFilter['filter_order']);?>
				</th>				
				<th width="5%" align="center"><?php echo JHTML::_('grid.sort', 'Status', 'block', @$arrMemberFilter['filter_order_Dir'], $arrMemberFilter['filter_order']);?>
				</th>
				<th width="1%"><?php echo $videoListId; ?></th>
			</tr>
		</thead>
		<?php
		$memberDetailscount = count($arrMemberList['memberdetails']);
		$upload = $arrMemberList['settingupload'];
		$option = JRequest::getCmd('option');
		//display the member details
		for ($i = 0; $i < $memberDetailscount; $i++)
		{
			$memberDetail = $arrMemberList['memberdetails'][$i];
			$published = $memberDetail->block;
                        if(version_compare(JVERSION, '3.0.0', 'ge')) {
                         if($published==1)
                            $status_image=0;
                        else if($published==0)
                            $status_image=1;
                        $states	= array(
				-2	=> array('trash.png',		'messages.unpublish','JTRASHED','COM_MESSAGES_MARK_AS_UNREAD'),
				0	=> array('tick.png',		'messages.publish',	'COM_MESSAGES_OPTION_READ','COM_MESSAGES_MARK_AS_UNREAD'),
				1	=> array('publish_x.png',	'messages.unpublish','COM_MESSAGES_OPTION_UNREAD','COM_MESSAGES_MARK_AS_READ')
				);
//                        echo $states[$memberDetail->block][0];
                        if(version_compare(JVERSION,'1.6.0','ge'))
                                {
                                    $published1 = JHtml::_('jgrid.published', $status_image, $i);
                                } else {
                                    $published1 = JHtml::_('grid.published',  $memberDetail, $i, $states[$status_image][0], $states[$status_image][0], '', 'cb');
                                }
                        }
			if ($published == 0)
			{
				$statusImage = '<a title="Deactivate User" onclick="return listItemTask(\'cb' . $i . '\',\'unpublish\')" href="javascript:void(0);">
								<img src="components/com_contushdvideoshare/images/tick.png" />';
			}
			else
			{
				$statusImage = '<a title="Activate User" onclick="return listItemTask(\'cb' . $i . '\',\'publish\')" href="javascript:void(0);">
								<img src="components/com_contushdvideoshare/images/publish_x.png" />';
			}

			$checked = JHTML::_('grid.id', $i, $memberDetail->id);
			$link = JRoute::_('index.php?option=' . $option . '&task=editmember&cid[]=' . $memberDetail->id);
			?>

		<tr class="<?php echo 'row' . ($i % 2); ?>">
			<td class="center"><?php echo $i + 1; ?></td>			
			<td class="center"><?php echo $checked; ?></td>			
			<td class="left"><?php echo $memberDetail->name; ?></td>			
			<td class="left"><?php echo $memberDetail->username; ?></td>			
			<td class="left"><?php echo $memberDetail->email; ?></td>			
			<td class="center"><?php echo JHTML::Date($memberDetail->registerDate); ?></td>			
			<td class="center"><?php
			$allowUpload = $memberDetail->allowupload;

			if ($allowUpload == null)
			$allowUpload = $upload;
			if ($allowUpload == '1')
			{
				$allowUploadImage = '<a title="Unupload User" onclick="return listItemTask(\'cb' . $i . '\',\'unallowupload\')" href="javascript:void(0);">
									 <img src="components/com_contushdvideoshare/images/tick.png" />';
			}
			else
			{
				$allowUploadImage = '<a title="Allowupload User" onclick="return listItemTask(\'cb' . $i . '\',\'allowupload\')" href="javascript:void(0);">
									 <img src="components/com_contushdvideoshare/images/publish_x.png" />';
			}
			?> <?php echo $allowUploadImage; ?>
			</td>
			<td class="center"><?php if(version_compare(JVERSION, '3.0.0', 'ge')) { echo $published1; } else{ echo $statusImage; }?></td>
			<td><?php echo $memberDetail->id; ?></td>
		</tr>
		<?php
		}
		?>
		<tfoot>
			<td colspan="15"><?php echo $arrMemberPageNav->getListFooter(); ?>
			</td>
		</tfoot>
	</table>
	<input type="hidden" name="id" value="<?php if(isset($memberDetail->id)){echo $memberDetail->id;} ?>" />
	<input type="hidden" name="option" value="<?php echo $option; ?>" /> 
	<input type="hidden" name="task" value="" /> 
	<input type="hidden" name="boxchecked" value="0" /> 
	<input type="hidden" name="filter_order" value="<?php echo @$arrMemberFilter['filter_order']; ?>" /> 
	<input type="hidden" name="filter_order_Dir" value="<?php echo @$arrMemberFilter['filter_order_Dir']; ?>" />
        <?php echo JHtml::_('form.token'); ?>
	<input type="hidden" name="submitted" value="true" id="submitted" />
</form>

