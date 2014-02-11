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
$checklist = $this->checklist;

?>

<!-- Form content starts here -->
<form action="index.php?option=com_hdflvplayer&task=checklist" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
	<?php
	$videoPath  = FVPATH;
	$playerPath = VPATH;
	$rows = 1;
	$successColor = '#339900';
	$failureColor = '#FF0000';
	?>

	<table class="adminlist<?php if(version_compare(JVERSION, '3.0.0', 'ge')) { echo "_checklist"; } ?>">

		<!-- Header content here -->
		<thead>
			<tr>
				<th <?php if(!version_compare(JVERSION, '3.0.0', 'ge')) { echo "width='1%'"; } ?> >#</th>
				<th <?php if(!version_compare(JVERSION, '3.0.0', 'ge')) { echo "width='5%'"; } ?>>Name of the file/folder</th>
				<th <?php if(!version_compare(JVERSION, '3.0.0', 'ge')) { echo "width='8%'"; } ?>>To be checked</th>
				<th <?php if(!version_compare(JVERSION, '3.0.0', 'ge')) { echo "width='6%'"; } else { echo 'colspan="2"'; } ?>>Status</th>

			</tr>
		</thead>

		<!-- checklist file/folder name, path, result for fopen here -->
		<tr <?php if(!version_compare(JVERSION, '3.0.0', 'ge')) { echo "class='row'"; } ?>>
			<td align="center"><?php echo $rows++;?>
			</td>
			<td align="center">php.ini</td>
			<td align="center">allow_url_fopen</td>
			<?php
			if($checklist['allow_status'] == 1)
			{
				$color = $successColor;
				$checklist['allow_status'] = 'Success';
			}
			else
			{
				$color = $failureColor;
				$checklist['allow_status'] = 'Failure (allow_url_fopen should be turned On )';
			}
			?>
			<td style="font-weight:bold;color:<?php echo $color ;?>" align="center"><?php echo $checklist['allow_status']; ?>
			</td>
		</tr>

		<!-- checklist file/folder name, path, result for file uploads here -->
		<tr <?php if(!version_compare(JVERSION, '3.0.0', 'ge')) { echo "class='row'"; } ?>>
			<td align="center"><?php echo $rows++;?>
			</td>
			<td align="center">php.ini</td>
			<td align="center">file_uploads</td>
			<?php
			if($checklist['allow_fileuploads'] == 1)
			{
				$color = $successColor;
				$checklist['allow_fileuploads'] = 'Success';
			}
			else
			{
				$color = $failureColor;
				$checklist['allow_fileuploads'] = 'Failure (file_uploads should be turned On );';
			}
			?>
			<td style="font-weight:bold;color:<?php echo $color ;?>" align="center">
			<?php echo $checklist['allow_fileuploads']; ?>
			</td>
		</tr>

		<!-- checklist videos folder permission here -->
		<tr>
			<td align="center"><?php echo $rows++;?>
			</td>
			<td align="center">Videos</td>
			<td align="center"><?php echo $playerPath;?>
			</td>
			<?php
			if($checklist['per_video'] == 1)
			{
				$color = $successColor;
				$checklist['per_video'] = 'Success';
			}
			else
			{
				$color = $failureColor;
				$checklist['per_video'] = 'Failure (Please make $playerPath to writable  )';
			}
			?>
			<td style="font-weight:bold;color:<?php echo $color ;?>" align="center">
			<?php echo $checklist['per_video']; ?>
			</td>
		</tr>

		<!-- checklist Uploads folder permission here -->
		<tr>
			<td align="center"><?php echo $rows++;?>
			</td>
			<td align="center">Uploads</td>

			<td align="center"><?php echo $videoPath;?>
			</td>
			<?php
			if($checklist['per_upload'] == 1)
			{
				$color = $successColor;
				$checklist['per_upload'] = 'Success';
			}
			else
			{
				$color = $failureColor;
				$checklist['per_upload'] = 'Failure (Please make $videoPath to writable )';
			}
			?>
			<td style="font-weight:bold;color:<?php echo $color ;?>" align="center"><?php echo $checklist['per_upload']; ?>
			</td>
		</tr>
	</table>

	<!-- Note statement displays here -->
	<span class="hd_alert">
		<table class="">
			<tr>
				<td>
                                   <?php if(version_compare(JVERSION, '3.0.0', 'ge')) { echo '<span class="note_grid">';  ?> <strong>Note :</strong> Most of the hosting company limit the
					upload file size. So, if you have trouble in uploading large files
					please consult with your hosting provider to increase the upload
					limit. Alternatively you can upload files through FTP and Choose
					URL to provide the video path url. Ex
					:http://www.yourdomain.com/videos/videoname.mp4
                                        <?php echo '</span>'; } ?>
                                </td>
			</tr>
		</table>
	</span>

	<input type="hidden" name="id" value="" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="1"/>
	<input type="hidden" name="submitted" value="true" id="submitted"/>
		<?php echo JHTML::_( 'form.token' ); ?>
</form>
