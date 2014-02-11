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
 * @abstract      : Contus HD Video Share Component Category View Page
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */

/*
 ***********************************************************/
defined('_JEXEC') or die('Restricted access');
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
<?php
if (JRequest::getVar('task') == 'edit' || JRequest::getVar('task') == 'add') {
	?>
<!-- form for add category begin -->
<form action='index.php?option=com_contushdvideoshare&layout=category'
	method="POST" name="adminForm" id="adminForm" style="position: relative;">
	<fieldset class="adminform">
		<legend>Category</legend>
		<table class="admintable">
			<tr>
				<td class="key">Parent Category</td>
				<td><select id="parent_id" name="parent_id">
						<option id="" value="0">Main</option>
						<?php

						foreach ($this->categorylist as $val)
						{
							$selected = '';
							if ($this->category->parent_id == $val->value)
							{
								$selected = 'selected="selected"';
							}
							?>
						<option id="<?php echo $val->value; ?>"
							value="<?php echo $val->value; ?>" <?php echo $selected; ?>>
							<?php echo $val->text; ?>
						</option>
						<?php                    } ?>
				</select>
				</td>
			</tr>
			<tr>
				<td class="key">Category Name</td>
				<td><input type="text" name="category" id="category" size="32"
					maxlength="250" value="<?php echo $this->category->category; ?>" />
				</td>
			</tr>
<!--			<tr>
				<td class="key">Order</td>
				<td><input type="text" name="ordering" id="ordering" size="10"
					maxlength="30" value="<?php echo $this->category->ordering; ?>" />
				</td>
			</tr>-->
			<tr>
				<td class="key">Status</td>
				<td>
				<select name="published" id="published">					
					<option value="1" <?php if($this->category->published == 1 || $this->category->published == '') echo 'selected';?>>Published</option>
					<option value="0" <?php if($this->category->published == 0 && $this->category->published != '') echo 'selected';?>>Unpublished</option>
					<option value="-2" <?php if($this->category->published == -2) echo 'selected';?>>Trashed</option>
				</select>				
					</td>
			</tr>

		</table>
	</fieldset>
	<input type="hidden" name="option"
		value="<?php echo JRequest::getVar('option'); ?>" /> <input
		type="hidden" name="id" value="<?php echo $this->category->id; ?>" />
	<input type="hidden" name="task" value="" />
</form>
<!-- form for add category end -->
					<?php
}
else
{
	$category = $this->category;
	$arrCategoryFilter = $this->category['categoryFilter'];
	?>
<!-- form for display category begin -->	
<form action='index.php?option=com_contushdvideoshare&layout=category'
	method="POST" name="adminForm" id="adminForm">
<fieldset id="filter-bar" <?php if(version_compare(JVERSION, '3.0.0', 'ge')) echo 'class="btn-toolbar"'; ?>>
		<div class="filter-search fltlft" style="float: left;">
			<?php if(!version_compare(JVERSION, '3.0.0', 'ge')) { ?>
                    <label for="category_search" class="filter-search-lbl">Filter:</label>
			<input type="text" title="Search in module title." value="<?php if (isset($arrCategoryFilter['category_search'])) echo $arrCategoryFilter['category_search']; ?>" id="category_search" name="category_search">
			<button type="submit" style="padding: 1px 6px;"><?php echo JText::_('Search'); ?></button>
			<button onclick="document.getElementById('category_search').value='';this.form.submit();" type="button" style="padding: 1px 6px;">
			<?php echo JText::_('Clear'); ?></button>
                        <?php } else { ?>
                        <input type="text" title="Search in module title." placeholder="Search Category" id="category_search" style="float:left; margin-right: 10px;" name="category_search">
                <div class="btn-group pull-left">
                        <button type="submit" class="btn hasTooltip"><i class="icon-search"></i></button>
			<button onclick="document.getElementById('category_search').value='';this.form.submit();" type="button" class="btn hasTooltip"><i class="icon-remove"></i></button>
                </div>
                        <?php } ?>
		</div>
		<div class="filter-select fltrt" style="float: right;">
			<select onchange="this.form.submit()" class="inputbox" name="category_status">
			<option selected="selected" value="0">- Select Status -</option>
			<option value="1" <?php if (isset($arrCategoryFilter['category_status']) && $arrCategoryFilter['category_status'] == '1')echo 'selected=selected'; ?>>Published</option>
			<option value="2" <?php if (isset($arrCategoryFilter['category_status']) && $arrCategoryFilter['category_status'] == '2')echo 'selected=selected'; ?>>Unpublished</option>
			<option value="3" <?php if (isset($arrCategoryFilter['category_status']) && $arrCategoryFilter['category_status'] == '3')echo 'selected=selected'; ?>>Trashed</option>
			</select>
		</div>
</fieldset>	
	<table class="adminlist <?php if(version_compare(JVERSION, '3.0.0', 'ge')) echo 'table table-striped'; ?>">
		<thead>
			<tr>
				<th>#</th>
				<th width="10"><input type="checkbox" name="toggle" value=""
					onclick="
                                            <?php if(!version_compare(JVERSION, '3.0.0', 'ge')) { ?>
                                            checkAll(<?php echo count($category['categorylist']); ?>)
                                        <?php } else ?>
                          Joomla.checkAll(this)
                                    " />
				</th>
				<th>
                                    <?php echo JHTML::_('grid.sort', 'Category', @$arrCategoryFilter['order'], @$arrCategoryFilter['order_Dir']); ?>
                                    </th>
				<th>Ordering Position</th>
				<th>Status</th>
				<th width="10">ID</th>
			</tr>
		</thead>
		<tbody>		
			<?php 
			foreach ($category['categorylist'] as $i => $item) :
			$states	= array(
				-2	=> array('trash.png',		'messages.unpublish','JTRASHED','COM_MESSAGES_MARK_AS_UNREAD'),
				1	=> array('tick.png',		'messages.publish',	'COM_MESSAGES_OPTION_READ','COM_MESSAGES_MARK_AS_UNREAD'),
				0	=> array('publish_x.png',	'messages.unpublish','COM_MESSAGES_OPTION_UNREAD','COM_MESSAGES_MARK_AS_READ')
			);
                        if(version_compare(JVERSION,'1.6.0','ge'))
                        {
                            $published = JHtml::_('jgrid.published', $item->published, $i);
                        } else {
                            $published = JHtml::_('grid.published',  $item, $i, $states[$item->published][0], $states[$item->published][0], '', 'cb');
                        }
			$link = JRoute::_('index.php?option=com_contushdvideoshare&layout=category&task=edit&cid[]=' . $item->value);                                
			$checked = JHTML::_('grid.id', $i, $item->value);
		?>
			<tr class="row<?php echo $i % 2; ?>">
			<td align="center" style="width:50px;"><?php echo $i + 1; ?></td>				
				 <td><?php echo $checked; ?></td>
				<td>
					<?php echo str_repeat('<span class="gi">|&mdash;</span>', $item->level) ?>					
					<a href="<?php echo $link;?>">
						<?php echo $this->escape($item->text); ?></a>					
				</td>				
				<td align="center" style="width:20px;"><?php echo $item->ordering; ?></td>
                <td align="center" style="width:70px;"><?php echo $published; ?></td>
                <td align="center" style="width:90px;"><?php echo $item->value; ?></td>
			</tr>
			<?php endforeach; ?>
			
		</tbody>
		<tfoot>
			<td colspan="15"><?php echo $this->category['pageNav']->getListFooter(); ?></td>
		</tfoot>
	</table>
<input type="hidden" name="task" value="" />
        <input type="hidden" name="filter_order" value="<?php echo $arrCategoryFilter['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $arrCategoryFilter['order_Dir']; ?>" />
        <input type="hidden"
               name="boxchecked" value="0" /> <input type="hidden"
		name="hidemainmenu" value="0" /> <input type="hidden" name="parent_id"
		value="-1" />

</form>
<!-- form for display category begin -->
		<?php } ?>
<script language="JavaScript" type="text/javascript">
   <?php if(version_compare(JVERSION,'1.6.0','ge'))
                    { ?>Joomla.submitbutton = function(pressbutton) {<?php } else { ?>
                        function submitbutton(pressbutton) {<?php } ?>
        if (pressbutton == "save")
        {
            if (document.getElementById('category').value == "")
            {
                alert( "<?php echo JText::_('You must provide a category name', true); ?>" )
                return;
            }

            submitform( pressbutton );
            return;
        }
        submitform( pressbutton );
        return;

    }
</script>
