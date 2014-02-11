<?php
/**
 * @name          : Joomla HD Video Share
 ****@version	  : 3.4.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component CategoryList View Page
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */
defined('_JEXEC') or die('Restricted access');
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');

$function = JRequest::getCmd('function', 'jSelectArticle');
if(version_compare(JVERSION,'1.7.0','ge')) {
	$version='1.7';
} elseif(version_compare(JVERSION,'1.6.0','ge')) {
	$version='1.6';
} else {
	$version='1.5';
}
if(version_compare(JVERSION,'1.6.0','le')){
    ?>
<style>
table tr td a img {
	width: 16px;
}
td.center, th.center, .center {
text-align: center;
float: none;
}
</style>
<?php
}
if (JRequest::getVar('task') == 'edit' || JRequest::getVar('task') == 'add') {
 ?>
    <form action=<?php echo JRoute::_('index.php?option=com_contushdvideoshare&view=category&layout=categorylist&tmpl=component&function='.$function);?>
          method="POST" name="adminForm" id="adminForm" <?php if(version_compare(JVERSION, '3.0.0', 'ge')) echo 'style="position: relative;"'; ?>>
        <fieldset class="adminform">
            <legend>Category</legend>
            <table class="admintable">
                <tr>
                    <td class="key">Parent Category</td>
            </tr>
            <tr>
                <td class="key">Category</td>
                <td>
					<a class="pointer" onclick="if (window.parent) window.parent.<?php echo $this->escape($function);?>('<?php echo $val->id; ?>', '<?php echo $this->escape(addslashes($this->categary->category)); ?>', '<?php echo $this->escape($val->id); ?>');">
						<?php echo $this->escape($this->categary->category); ?></a>
				</td>
                <td><input type="text" name="category" id="category" size="32" maxlength="250" value="<?php echo $this->categary->category; ?>" /></td>
            </tr>
            <tr>
                <td class="key">Order</td>
                <td><input type="text" name="ordering" id="ordering" size="10" maxlength="30" value="<?php echo $this->categary->ordering; ?>" /></td>
            </tr>
            <tr>
                <td class="key">Published</td>
                <?php
                            $categoryChecked = 'checked';
                            $categoryListchecked = '';
                            if ($this->categary->published == '1')
                             {
                                $categoryChecked = 'checked';
                                $categoryListchecked = '';
                             }
                             else if ($this->categary->published == '1')
                              {
                                $categoryChecked = '';
                                $categoryListchecked = 'checked';
                             }
                ?>
                            <td><input type="radio" name="published" id="published" value="1" <?php echo $categoryChecked; ?> />Yes&nbsp;&nbsp;<input type="radio" name="published" id="published" value="0" <?php echo $categoryListchecked; ?> />No </td>
            </tr>
        </table>
                </fieldset>
                <input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>"/>
                <input type="hidden" name="id" value="<?php echo $this->categary->id; ?>"/>
                <input type="hidden" name="task" value=""/>
            </form>
<?php
                    }
                    else
                     {
                            $category = $this->category;
?>
<?php if($version !='1.5'){
	$linkPath =JRoute::_('index.php?option=com_contushdvideoshare&view=category&layout=categorylist&tmpl=component&function='.$function);
}else{
	$linkPath='index.php?option=com_contushdvideoshare&view=category&layout=categorylist&amp;tmpl=component&amp;object=catid';
}
 ?>
                            <form action=<?php echo $linkPath;?> method="POST" name="adminForm" id="adminForm">
          <table class="adminlist <?php if(version_compare(JVERSION, '3.0.0', 'ge')) echo 'table table-striped'; ?>">
		<thead>
			<tr>
				<th>Category</th>
				<th>Ordering Position</th>
				<th>Published</th>
				<th width="10">ID</th>
			</tr>
		</thead>
		<tbody>
			<?php //echo '<pre>';print_r($category['categorylist']);exit;
			foreach ($category['categorylist'] as $i => $item) :
			$states	= array(
				-2	=> array('trash.png',		'messages.unpublish','JTRASHED','COM_MESSAGES_MARK_AS_UNREAD'),
				1	=> array('tick.png',		'messages.publish',	'COM_MESSAGES_OPTION_READ','COM_MESSAGES_MARK_AS_UNREAD'),
				0	=> array('publish_x.png',	'messages.unpublish','COM_MESSAGES_OPTION_UNREAD','COM_MESSAGES_MARK_AS_READ')
			);
			$published = JHtml::_('grid.published',  $item, $i, $states[$item->published][0], $states[$item->published][0], '', 'cb');
			//$published = JHTML::_('grid.published', $item, $i);
			$link = JRoute::_('index.php?option=com_contushdvideoshare&layout=categorylist');
                        $checked = JHTML::_('grid.id', $i, $item->value);
		?>
			<tr class="row<?php echo $i % 2; ?>">
                                <td>
                                <?php if($version !='1.5'){?>
                                    <?php echo str_repeat('<span class="gi">|&mdash;</span>', $item->level) ?>
                                    <a class="pointer" onclick="if (window.parent) window.parent.<?php echo $this->escape($function);?>('<?php echo $item->value; ?>', '<?php echo $this->escape(addslashes($item->text)); ?>', '<?php echo $this->escape($item->value); ?>');">
					<?php echo $this->escape($item->text); ?></a>

					<?php }else{?>
					<a style="cursor: pointer;" onclick="window.parent.jSelectArticle('<?php echo $item->value; ?>', '<?php echo str_replace(array("'", "\""), array("\\'", ""),$item->text); ?>', '<?php echo JRequest::getVar('object'); ?>');">
					<?php echo $this->escape($item->text); ?></a>
					<?php }?>
				</td>
				<td align="center" style="width:20px;"><?php echo $item->ordering; ?></td>
                <td align="center" style="width:70px;"><?php if($item->published==1) echo "Published"; else echo "Unpublished"; ?></td>
                <td align="center" style="width:90px;"><?php echo $item->value; ?></td>
			</tr>
			<?php endforeach; ?>

		</tbody>
		<tfoot>
			<td colspan="15"><?php echo $this->category['pageNav']->getListFooter(); ?></td>
		</tfoot>
	</table>
<!--                    <input type="hidden" name="option" value="<?php echo $option; ?>" />-->
            <input type="hidden" name="task" value=""/>
            <input type="hidden" name="boxchecked" value="0"/>
            <input type="hidden" name="hidemainmenu" value="0"/>
            <input type="hidden" name="parent_id" value="-1"/>
        </form>
<?php } ?>