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
$videolist 			= $this->videolist;
$baseurl			= JURI::base();
$thumbpath			= $baseurl."components/com_hdflvplayer";

$document = JFactory::getDocument();

$document->addScript('components/com_hdflvplayer/js/jquery-1.3.2.min.js');
$document->addScript('components/com_hdflvplayer/js/jquery-ui-1.7.1.custom.min.js');
$document->addScript('components/com_hdflvplayer/js/uploadvideos_click_drag_sort.js');

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
<!-- Form content starts here -->
<form action="index.php?option=com_hdflvplayer&task=uploadvideos" method="post" name="adminForm" id="adminForm">

<!-- Filter content starts here -->
	<fieldset id="filter-bar">

		<!-- Filter By search Box -->
		<div class="filter-search fltlft">
			<label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?>
			</label> <input type="text" name="search" id="search" value="<?php if (isset($videolist['lists']['search'])) echo $videolist['lists']['search'];?>" onchange="document.adminForm.submit();" />
				<button onClick="this.form.submit();" class="searhbtn"><?php echo JText::_( 'Search' ); ?></button>
				<button onClick="document.getElementById('search').value='';" class="searhbtn"><?php  echo JText::_( 'Clear' ); ?></button>
		</div>


		<div class="filter-select fltrt">

			<!-- Filter by publish status -->
			<select name="filter_state" class="inputbox" onchange="this.form.submit()">
				<option><?php echo JText::_('JOPTION_SELECT_PUBLISHED');?></option>
				<option value="1" <?php if($videolist['lists']['video_state'] == '1'){ echo 'selected'; }?>>Published</option>
				<option value="2" <?php if($videolist['lists']['video_state'] == '2'){ echo 'selected'; }?>>Unpublished</option>
				<option value="-2" <?php if($videolist['lists']['video_state'] == '-2'){ echo 'selected'; }?>>Trashed</option>
			</select>

			<!-- Filter by Playlist -->
			<select name="filter_type" class="inputbox" onchange="this.form.submit()">
				<option value="">--Select Playlist--</option>
				<?php
						$count = count($videolist['playlist']);
						if ($count >= 1) {
							for ($j = 0; $j < $count; $j++) {
								$row_play = &$videolist['playlist'][$j];
								?>
								<option value="<?php echo $row_play->id; ?>" <?php if($videolist['lists']['playlist'] == $row_play->id){ echo 'selected'; }?>> <?php echo $row_play->name ?></option>
								<?php
							}
				 }?>
			</select>

		</div>
	</fieldset>
	<!-- Filter content ends here -->



	<table class="videolist" style=" margin-bottom: 18px; ">
		<!--  Grid titles here -->
		<thead>
			<th>Sorting</th>
			<th><input type="checkbox" name="toggle" value="" onClick="
                            <?php if(!version_compare(JVERSION, '3.0.0', 'ge')) { ?>
                                    checkAll(<?php echo count($videolist['rs_showupload']); ?>);
                      <?php } else ?>
                          Joomla.checkAll(this)
                            " />
			</th>
			<th><?php echo JHTML::_('grid.sort',  'Title', 'title', @$videolist['lists']['order_Dir'], @$videolist['lists']['order'] ); ?>
			</th>
			<th>Default
			</th>
			<th><?php echo JHTML::_('grid.sort',  'Playlist Name', 'playlistid', @$videolist['lists']['order_Dir'], @$videolist['lists']['order'] ); ?>
			</th>
			<th><?php echo JHTML::_('grid.sort',  'Viewed', 'times_viewed', @$videolist['lists']['order_Dir'], @$videolist['lists']['order'] ); ?>
			</th>
			<th>Streamer Path</th>
			<th>Streamer Name
			</th>

			<th><?php echo JHTML::_('grid.sort',  'Video Link', 'videourl', @$videolist['lists']['order_Dir'], @$videolist['lists']['order'] ); ?>
			</th>
			<th><?php echo JHTML::_('grid.sort',  'Thumb Link', 'thumburl', @$videolist['lists']['order_Dir'], @$videolist['lists']['order'] ); ?>
			</th>
			<th>Post-roll Ads</th>
			<th>Pre-roll Ads</th>
			<th>Mid-roll Ads</th>
			<th><?php echo JHTML::_('grid.sort',  'Ordering', 'ordering', @$videolist['lists']['order_Dir'], @$videolist['lists']['order'] ); ?>
			</th>
			<th>Status</th>
			<th><?php echo JHTML::_('grid.sort',  'ID', 'Id', @$videolist['lists']['order_Dir'], @$videolist['lists']['order'] ); ?>
			</th>
		</thead>
		<!--  Grid title ends here -->


		<!-- Video details displays here -->
		<tbody id="test-list">
		<?php
		$imagepath = JURI::base()."components/com_hdflvplayer/images";
		jimport('joomla.filter.output');

		$count = count( $videolist['rs_showupload'] );

		if ($count >= 1)
		{
			for ($i = 0; $i < $count; $i++)
			{
				$row_showupload = &$videolist['rs_showupload'][$i];

				$checked 		= JHTML::_('grid.id', $i, $row_showupload->id );

				if(version_compare(JVERSION, '3.0.0', 'ge')) {
                                $published 		= JHtml::_('jgrid.published',  $row_showupload->published, $i);
                                }else {
				$published 		= JHtml::_('grid.published',  $row_showupload, $i, $states[$row_showupload->published][0], $states[$row_showupload->published][0], '', 'cb');
                                }
				$row_showupload->groupname = isset($row_showupload->groupname)?$row_showupload->groupname:'';

				$link			= JRoute::_( 'index.php?option=com_hdflvplayer&task=editvideoupload&cid[]='. $row_showupload->id);
				$basepath		= explode('administrator',JURI::base());
				$videopath		= $basepath[0]."components/com_hdflvplayer/videos/";
		?>

		<tr id="listItem_<?php echo $row_showupload->id; ?>">

				<!-- Column to rearrange sort order -->
				<td>
					<p class="hasTip" title="Click and Drag" class="content" style="padding: 6px;">
						<img src="<?php echo $imagepath.'/arrow.png';?>" alt="move"	width="16" height="16" class="handle" />
					</p>
				</td>

				<!-- Column to show checkboxes for edit,delete,publish,unpublish,default,reset views -->
				<td>
					<p class="content" style="padding: 6px;">
					<?php echo $checked; ?>
					</p>
				</td>

				<!-- Column to show Video Title -->
				<td align="left">
					<p class="content" style="padding: 6px;">
						<a href="<?php echo $link; ?>"> <?php echo wordwrap($row_showupload->title, 15, "\n", true);   ?>
						</a>
					</p>
				</td>

				<!-- Column to show default video -->
				<td>
					<p class="content" style="padding: 6px;">
					<?php if ( $row_showupload->home == 1 ) :
					  ?>
						<img src="<?php echo JURI::base().'components/com_hdflvplayer/images/icon-16-default.png';?>" alt="<?php echo JText::_( 'Default' ); ?>" />
							<?php
							 else : ?>
						&nbsp;
						<?php endif; ?>
					</p>
				</td>

				<!-- Column to show playlist name of the video -->
				<td align="left">
					<p class="content" style="padding: 6px;">
					<?php
					$showname = "";
					($row_showupload->name == ""?$showname = "-":$showname = $row_showupload->name);
					echo wordwrap($showname, 15, "\n", true);
					?>
					</p>
				</td>

				<!-- Column to show viewed count of each video -->
				<td>
					<p class="content" style="padding: 6px;">
					<?php echo $row_showupload->times_viewed; ?>
					</p>
				</td>

				<!-- Column to show streamer path for rtmp video -->
				<td>
					<p class="content" style="padding: 6px;">
					<?php
					$showname = "";
					($row_showupload->name == ""?$showname = "None":$showname = $row_showupload->streamerpath);
					echo wordwrap($showname, 15, "\n", true);
					?>
					</p>
				</td>

				<!-- Column to show streamer option for each video -->
				<td>
					<p class="content" style="padding: 6px;">
					<?php echo wordwrap($row_showupload->streameroption, 15, "\n", true);   ?>
					</p>
				</td>

				<!-- Column to show video file with video link to view-->
				<td>
					<p class="content" style="padding: 6px;">
					<?php
					$videopath_temp = $basepath[0];
					$videolink_temp = 'index.php?option=com_hdflvplayer&id='. $row_showupload->id;
					$videolink	= $videopath_temp.$videolink_temp;

						$videolinkffmpeg = $row_showupload->videourl;
						 ?>
						<a href="javascript:void(0)" onclick="window.open('<?php echo $videolink; ?>','','width=600,height=500,maximize=yes,menubar=no,status=no,location=yes,toolbar=yes,scrollbars=yes')">
							<?php
                                                        if ( $videolinkffmpeg != "" ) :
                                                            echo wordwrap($videolinkffmpeg, 15, "\n", true);
                                                        elseif($row_showupload->hdurl != ''):
                                                            echo wordwrap($row_showupload->hdurl, 15, "\n", true);
                                                        endif;

                                                        ?>
						</a>

					</p>
				</td>

				<!-- Column to show thumb image file -->
				<td>
					<p class="content" style="padding: 6px;">
					<?php
						$thumblinkffmpeg = $row_showupload->thumburl;
						$frontbaseUrl = str_replace('administrator/','',$baseurl);
						if($row_showupload->filepath == 'File' || $row_showupload->filepath == 'FFmpeg')
						{
							$thumbLink =  $frontbaseUrl.'components/com_hdflvplayer/videos/'.$thumblinkffmpeg;
						}
						else{
							$thumbLink = $thumblinkffmpeg;
						}

						if ( $thumblinkffmpeg != "" ) : ?>
						<a href="javascript:void(0)"
							onClick="window.open('<?php echo $thumbLink ; ?>','','width=600,height=500,menubar=yes,status=yes,location=yes,toolbar=yes,scrollbars=yes')">
							<?php echo wordwrap($thumblinkffmpeg, 15, "\n", true); ?>
						</a>
						<?php  else :?>
						&nbsp;
						<?php endif;?>
					</p>
				</td>

				<!-- Column to show whether the pre roll, post roll, mid roll ads enabled or not -->
				<td><?php
				if($row_showupload->postrollads == 1)
				$postrollads = "Enabled";
				else
				$postrollads = "Disabled";
				?>
					<p style="padding: 6px;">
					<?php echo $postrollads; ?>
					</p>
				</td>


				<td><?php
				if($row_showupload->prerollads == 1)
				$prerollads = "Enabled";
				else
				$prerollads = "Disabled";
				?>
					<p style="padding: 6px;">
					<?php echo $prerollads; ?>
					</p>
				</td>
				<td><?php
				if($row_showupload->midrollads == 1)
				$midrollads = "Enabled";
				else
				$midrollads = "Disabled";
				?>
					<p style="padding: 6px;">
					<?php echo $midrollads; ?>
					</p>
				</td>
				<td>
					<p style="padding: 6px;"
						id="ordertd_<?php echo $row_showupload->id; ?>">
						<?php echo $row_showupload->ordering; ?>
					</p>
				</td>
				<td>
					<p style="padding: 6px;">
					<?php echo $published; ?>
					</p>
				</td>
				<td>
					<p style="padding: 3px;">
					<?php echo $row_showupload->id; ?>
					</p>
				</td>
			</tr>
			<?php
			//$j++;
			}
			?>
                        <?php if(!version_compare(JVERSION, '3.0.0', 'ge')) { ?>
			<tr>
				<td colspan="17"><?php echo $videolist['pageNav']->getListFooter(); ?>
				</td>
			</tr>
                        <?php } ?>

			<?php
		} // If condn for count
		?>
		</tbody>
	</table>
<?php if(version_compare(JVERSION, '3.0.0', 'ge')) { echo $videolist['pageNav']->getListFooter(); } ?>
	<!-- To sort Table Ordering -->
	<input type="hidden" name="filter_order" value="<?php echo $videolist['lists']['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $videolist['lists']['order_Dir']; ?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>