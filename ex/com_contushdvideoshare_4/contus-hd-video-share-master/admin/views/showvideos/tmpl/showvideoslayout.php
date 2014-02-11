<?php
/**
 * @name          : Joomla HD Video Share
 * @version	  : 3.4.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component Showvideos View Page
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */

## no direct access
defined('_JEXEC') or die('Restricted access');
##  import joomla filter library
jimport('joomla.filter.output'); 
$videolist1 = '';
if(isset($this->videolist)) {
$videolist1 = $this->videolist;
}
$baseurl = JURI::base();
$thumbpath1 = JURI::base() . "/components/com_contushdvideoshare";
JHTML::_('behavior.tooltip');
$toolTipArray = array('className' => 'custom2', 'showDelay' => '0', 'hideDelay' => '500',
    'fixed' => 'true', 'onShow' => "function(tip) {tip.effect('opacity',{duration: 500, wait: false}).start(0,1)}"
    , 'onHide' => "function(tip) {tip.effect('opacity',{duration: 500, wait: false}).start(1,0)}");		
    JHTML::_('behavior.tooltip', '.hasTip2', $toolTipArray);  ##  class="hasTip2" titles
    $filename = 'testtooltip.js'; ##  used for class="hasTip3" titles
    $path = 'templates/rhuk_milkyway/js/';
    JHTML::script($filename, $path, true); ##  MooTools will load if it is not already loaded
    $document = JFactory::getDocument();
    $document->addStyleSheet('components/com_contushdvideoshare/css/cc.css');
    $document->addStyleSheet('components/com_contushdvideoshare/css/styles.css');
    $document->addScript( 'components/com_contushdvideoshare/js/jquery-1.3.2.min.js' );
    $document->addScript( 'components/com_contushdvideoshare/js/jquery-ui-1.7.1.custom.min.js' ); 
	
	##  variable initialization
	$option = JRequest::getCmd('option');
	$user = JRequest::getVar('user');
	$userUrl = ($user == 'admin')?"&user=$user":"";
	$page = JRequest::getVar('page', '', 'get', 'string');
    if(version_compare(JVERSION,'1.6.0','le')){?>
	<style>
	table tr td a img {width:16px;}
	td.center, th.center, .center {
	text-align: center;
	float: none;
	}
	</style>
	<?php } ?>
<?php if(version_compare(JVERSION, '3.0.0', 'ge')){ ?>
<script src="components/com_contushdvideoshare/js/jquery-ui.js"></script>
<?php } ?>
<style>
fieldset input,fieldset textarea,fieldset select,fieldset img,fieldset button{float: none;}
#commentlist tr td{text-align:left;}
#commentlist .pagination div.limit {float:none;}
</style>
<script type="text/javascript">
    // When the document is ready set up our sortable with it's inherant function(s)
    var dragdr = jQuery.noConflict();
    var videoid = new Array();
    dragdr(document).ready(function() {
        dragdr("#test-list").sortable({
            handle : '.handle',
            update : function () {
                var order = dragdr('#test-list').sortable('serialize');

                orderid= order.split("listItem[]=");

                for(i=1;i<orderid.length;i++)
                {
                    videoid[i]=orderid[i].replace('&',"");
                    oid= "ordertd_"+videoid[i];
                    document.getElementById(oid).innerHTML=i-1;
                }
                //dragdr("#info").load("<?php echo $baseurl; ?>/index.php?option=com_contushdvideoshare&task=videos&layout=sortorder&"+order);
                dragdr.post("<?php echo $baseurl; ?>/index.php?option=com_contushdvideoshare&task=videos&layout=sortorder",order);
               
                <!-- Codes by Quackit.com -->
               
            }
        });
    });
</script>
<script language="javascript">
   
    function deletecomment(cmtid,vid,user)
    {
        var userurl = '';
        if(user == '1'){
        userurl = '&user=admin';
        }
        window.open('index.php?option=com_contushdvideoshare&layout=adminvideos'+userurl+'&page=comment&id='+vid+'&cmtid='+cmtid,'_self',false);
    }
</script>
    <?php
    if ($page == 'comment' && $page != 'myvideos' && $page != 'deleteuser') {
    	$cmd = $this->comment['comment'];
    	$tot = count($cmd);
    	$id = JRequest::getVar('id', '', 'get', 'int');
    	if ($id) {
    		$cid = "&id=" . $id;
    	}
    	?>
<form action="index.php?option=<?php echo $option; ?>&layout=adminvideos<?php echo $userUrl; ?>&page=comment<?php echo $cid; ?>"
	method="post" id="adminForm" name="adminForm">
	<div id="videocontent" align="center">
		<div class="videocont">

			<div class="clearfix">
				<h1>
				<?php echo $this->comment['videotitle']; ?>
				</h1>
			</div>
			<h2>Comments</h2>
			<table border="0" width="600" id="commentlist">
			<?php if ($tot > 0) {
				foreach ($this->comment['comment'] as $row) {
					?>
					<?php
					if ($row->parentid == 0) {
						?>
				<tr>
					<td>
						<div class="clearfix">
							<p class="subhead" style="color: #132855;">
								<b><?php echo $row->name; ?> :  </b>
							</p>

						</div>
						<p>
						<?php echo $string = nl2br($row->message); ?>
						</p>
					</td>
					<td valign="center" <?php if(version_compare(JVERSION, '3.0.0', 'ge')) echo 'class="videoshare_closeimage"'; ?> align="center"><img
						id="<?php echo $row->id; ?>"
						src="components/com_contushdvideoshare/images/delete_x.png" title="Delete"
						onclick="deletecomment(id,<?php echo ($userUrl)?"$row->videoid,1":"$row->videoid,0"; ?>);"
						style="cursor: pointer;" />
					</td>
				</tr>
				<tr>
					<td colspan="2"><hr></td>
				</tr>
				<?php } else { ?>
				<tr>
					<td>
						<blockquote>
							<p>
								<strong>Re : <span style="color: #132855;"><?php echo $row->name; ?>
								</span> </strong>													
							<p>
							<?php echo $string = nl2br($row->message); ?>
							</p>
							</p>
						</blockquote>
					</td>
					<td valign="center" align="center"><img
						id="<?php echo $row->id; ?>"
						src="components/com_contushdvideoshare/images/publish_x.png"
						onclick="deletecomment(id,<?php echo ($userUrl)?"$row->videoid,1":"$row->videoid,0"; ?>);"
						style="cursor: pointer;" /></td>
				
				
				<tr>
					<td colspan="2"><hr
							style="background-color: #fff; border: 1px dotted #132855; border-style: none none dotted;">
					</td>
				</tr>
				</tr>
				<?php }
				}
			} ?>
				<tfoot>

					<td colspan="2"><?php echo $this->comment['pageNav']->getListFooter(); ?></td>
				</tfoot>
			</table>
		</div>
	</div>

	<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
	<input type="hidden" name="submitted" value="true" id="submitted" /> 
	<input type="hidden" name="task" id="task" value="1" />
	<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHTML::_('form.token'); ?>
</form>
		<?php
    } else {
    	?>
<form action="index.php?option=com_contushdvideoshare&layout=adminvideos<?php echo $userUrl; ?>"
	method="post" id="adminForm" name="adminForm">
	<fieldset id="filter-bar" <?php if(version_compare(JVERSION, '3.0.0', 'ge')) echo 'class="btn-toolbar"'; ?>>
		<div class="filter-search fltlft" style="float: left;">
<?php if(!version_compare(JVERSION, '3.0.0', 'ge')) { ?><label for="search" class="filter-search-lbl">Filter:</label> <input type="text" title="Search in module title." value="<?php if (isset($videolist1['lists']['search']))
            	echo $videolist1['lists']['search']; ?>" id="search" name="search">
			<button type="submit" style="padding: 1px 6px;"><?php echo JText::_('Search'); ?></button>
			<button onclick="document.getElementById('search').value='';this.form.submit();" type="button" style="padding: 1px 6px;"><?php echo JText::_('Clear'); ?></button><?php } else {?>
		<input type="text" title="Search in module title." placeholder="Search Videos" id="search" name="search" style="float: left; margin-right: 10px; ">
                        <div class="btn-group pull-left">
                            <button type="submit" class="btn hasTooltip">
                                <i class="icon-search"></i>
                            </button>
                            <button onclick="document.getElementById('search').value='';this.form.submit();" type="button" class="btn hasTooltip">
                                <i class="icon-remove"></i>
                            </button>
                            </div>
                        <?php } ?>
		</div>
		<div class="<?php if(!version_compare(JVERSION, '3.0.0', 'ge')) { ?>filter-select fltrt<?php } else { ?>btn-group pull-right hidden-phone<?php } ?>" style="float: right; margin-left: 5px;">
			<select onchange="this.form.submit()" class="<?php if(!version_compare(JVERSION, '3.0.0', 'ge')) { ?>inputbox<?php } else { ?>input-medium chzn-done<?php } ?>" name="filter_state">
			<option selected="selected" value="">- Select Status -</option>			
			<option value="1" <?php if (isset($videolist1['lists']['state_filter']) && $videolist1['lists']['state_filter'] == '1')echo 'selected=selected'; ?>>Published</option>
			<option value="2" <?php if (isset($videolist1['lists']['state_filter']) && $videolist1['lists']['state_filter'] == '2')echo 'selected=selected'; ?>>Unpublished</option>
			<option value="3" <?php if (isset($videolist1['lists']['state_filter']) && $videolist1['lists']['state_filter'] == '3')echo 'selected=selected'; ?>>Trashed</option>
			</select>
<?php if(!version_compare(JVERSION, '3.0.0', 'ge')) { ?>
			<select name="filter_featured" class="inputbox" onchange="this.form.submit()">
                            <?php } else { ?></div>
                <div class="btn-group pull-right hidden-phone">
			<select name="filter_featured" class="input-medium chzn-done" onchange="this.form.submit()">
<?php } ?>
			<option value="">- Select Featured -</option>
			<option value="1" <?php if (isset($videolist1['lists']['featured_filter']) && $videolist1['lists']['featured_filter'] == '1')echo 'selected=selected'; ?>>Featured</option>
			<option value="2" <?php if (isset($videolist1['lists']['featured_filter']) && $videolist1['lists']['featured_filter'] == '2')echo 'selected=selected'; ?>>Unfeatured</option>
			</select>
<?php if(!version_compare(JVERSION, '3.0.0', 'ge')) { ?>
			<select name="filter_category" class="inputbox" onchange="this.form.submit()">
                            <?php } else { ?></div>
                <div class="btn-group pull-right hidden-phone">
			<select name="filter_category" class="input-medium chzn-done" onchange="this.form.submit()">
<?php } ?>
			<option value="">- Select Category -</option>			
			<?php foreach($videolist1['rs_showplaylistname'] as $arrCategories) {?>		
			<option value="<?php echo $arrCategories->id;?>" <?php if (isset($videolist1['lists']['category_filter']) && $videolist1['lists']['category_filter'] == $arrCategories->id) echo 'selected=selected'; ?>><?php echo $arrCategories->category;?></option>					
			<?php 	}
			?>
			</select>			
		</div>
</fieldset>	
	

	<table class="adminlist <?php if(version_compare(JVERSION, '3.0.0', 'ge')) echo "table table-striped"; ?>">
		<thead>
                    <?php if(!version_compare(JVERSION, '3.0.0', 'ge')) { ?>
			<th width="5%">Sorting</th>
			<th width="2%"><input type="checkbox" name="toggle" value=""
				onClick="
                                    <?php if(!version_compare(JVERSION, '3.0.0', 'ge')) { ?>
                                    checkAll(<?php echo count($videolist1['rs_showupload']); ?>);
                      <?php } else ?>
                          Joomla.checkAll(this)
                    " />
			</th>
                        <?php } else { ?>
                        <th width="1%">
                            <a href="#" onclick="Joomla.tableOrdering('a.ordering','asc','');" class="hasTip" title="">
                                <i class="icon-menu-2"></i>
                            </a>
                        </th>
			<th width="1%">
                            <input type="checkbox" name="toggle" value="" onClick="Joomla.checkAll(this)" />
			</th> <?php } ?>
			<th class="left">
                          <?php echo JHTML::_('grid.sort', 'Title', 'a.title', @$videolist1['lists']['order_Dir'], @$videolist1['lists']['order']); ?>

                        </th>
			<th width="5%"><?php echo JText::_('Comments'); ?>
			</th>
			<th><?php echo JHTML::_('grid.sort', 'Category', 'playlistid', @$videolist1['lists']['order_Dir'], @$videolist1['lists']['order']); ?>
			</th>
			<th width="5%"><?php echo JHTML::_('grid.sort', 'Viewed', 'times_viewed', @$videolist1['lists']['order_Dir'], @$videolist1['lists']['order']); ?>
			</th>
			<th><?php echo JText::_('Streamer Name'); ?>
			</th>
			<?php if(!JRequest::getVar('user', '', 'get')) {?>
			<th><?php echo JText::_('User Name'); ?>
			</th>
			<?php }?>
			<th><?php echo JHTML::_('grid.sort', 'Video Link', 'videourl', @$videolist1['lists']['order_Dir'], @$videolist1['lists']['order']); ?>
			</th>
			<th><?php echo JHTML::_('grid.sort', 'Thumb Link', 'thumburl', @$videolist1['lists']['order_Dir'], @$videolist1['lists']['order']); ?>
			</th>
			<th>Postroll Ad</th>
			<th>Preroll Ad</th>
			<th>Midroll Ad</th>
			<th><?php echo JHTML::_('grid.sort', 'Order', 'ordering', @$videolist1['lists']['order_Dir'], @$videolist1['lists']['order']); ?>
			</th>
			<th width="4%"><?php echo JHTML::_('grid.sort', 'Status', 'published', @$videolist1['lists']['order_Dir'], @$videolist1['lists']['order']); ?>
			</th>
			<th width="4%"><?php echo JHTML::_('grid.sort', 'Featured', 'featured', @$videolist1['lists']['order_Dir'], @$videolist1['lists']['order']); ?>
			</th>
			<th width="2%"><?php echo JHTML::_('grid.sort', 'ID', 'Id', @$videolist1['lists']['order_Dir'], @$videolist1['lists']['order']); ?>
			</th>
		</thead>
		<tbody id="test-list" <?php if(version_compare(JVERSION, '3.0.0', 'ge')) echo 'class="ui-sortable"'; ?>>
		<?php
		$imagepath = JURI::base() . "components/com_contushdvideoshare/images";
		?>
		<?php
		$k = 0;
		jimport('joomla.filter.output');
		$j = $videolist1['limitstart'];
		$n = count($videolist1['rs_showupload']);


		$vpath = VPATH . "/";
		if ($n >= 1) {
			for ($i = 0; $i < $n; $i++) {

				$row_showupload = $videolist1['rs_showupload'][$i];
				$checked = JHTML::_('grid.id', $i, $row_showupload->id);
				$states	= array(
				-2	=> array('trash.png',		'messages.unpublish','JTRASHED','COM_MESSAGES_MARK_AS_UNREAD'),
				1	=> array('tick.png',		'messages.publish',	'COM_MESSAGES_OPTION_READ','COM_MESSAGES_MARK_AS_UNREAD'),
				0	=> array('publish_x.png',	'messages.unpublish','COM_MESSAGES_OPTION_UNREAD','COM_MESSAGES_MARK_AS_READ')
				);
				## $published = JHtml::_('grid.published',  $row_showupload, $i, $states[$row_showupload->published][0], $states[$row_showupload->published][0], '', 'cb');
				## $published = JHTML::_('grid.published', $row_showupload, $i);
                                if(version_compare(JVERSION,'1.6.0','ge'))
                                {
                                    $published = JHtml::_('jgrid.published', $row_showupload->published, $i);
                                } else {
                                    $published = JHtml::_('grid.published',  $row_showupload, $i, $states[$row_showupload->published][0], $states[$row_showupload->published][0], '', 'cb');
                                }
				$userId = (JRequest::getVar('user', '', 'get') == 'admin') ? "&user=" . JRequest::getVar('user', '', 'get') : "";

				$link = JRoute::_('index.php?option=com_contushdvideoshare&layout=adminvideos&task=editvideos' . $userId . '&cid[]=' . $row_showupload->id);
				$str1 = explode('administrator', JURI::base());
				$videopath = $str1[0] . "components/com_contushdvideoshare/videos/";
				?>
			<tr id="listItem_<?php echo $row_showupload->id; ?>" class="<?php echo 'row' . ($i % 2); ?>">
				<td>
					<p class="hasTip content" title="Click and Drag"
						style="padding: 6px;">
						<img src="<?php echo $imagepath . '/arrow.png'; ?>" alt="move"
							width="16" height="16" class="handle" />
					</p>
				</td>
				<td class="center">
					<?php echo $checked; ?>
				</td>
				<td class="left">
						<a href="<?php echo $link; ?>" style="word-wrap: break-word;width: 130px;display: block;"> <?php echo $row_showupload->title; ?>
						</a>
				</td>
				<td align="center"><?php if (isset($row_showupload->cvid)) {
					$model = $this->getModel('showvideos');
                    $commentCount = $model->getCommentcount($row_showupload->cvid);
					if ($row_showupload->cvid == $row_showupload->id) { 
        			$commentUrl = 'index.php?option='.$option.'&layout=adminvideos'.$userUrl.'&page=comment&id='.$row_showupload->id; ?>
					<a href="<?php echo $commentUrl ?>"> Comments(<?php echo $commentCount;?>)					
					</a> <?php }
				} else { ?>No Comments<?php } ?></td>

				<td class="center">
					<?php
					$showname = "";
					($row_showupload->category == "" ? $showname = "None" : $showname = $row_showupload->category);
					echo $newtext = wordwrap($showname, 15, "\n", true);
					?>
				</td>
				<td class="center">
					<?php echo $row_showupload->times_viewed; ?>
				</td>
				<td class="center">
					<?php echo $newtext = wordwrap($row_showupload->streameroption, 15, "\n", true); ?>
				</td>
				<?php if(!JRequest::getVar('user', '', 'get')) {?>
				<td class="center">	
					<?php echo $newtext = wordwrap($row_showupload->username, 15, "\n", true); ?>
				</td>
				<?php }?>
				<td class="center">
					<?php
					$str1 = explode('administrator', JURI::base());
					$videopath1 = $str1[0];
					$videolink1 = 'index.php?option=com_contushdvideoshare&view=player&id=' . $row_showupload->id.'&adminview=true';
					$videolink = $videopath1 . $videolink1;
					if ($row_showupload->filepath == "File" || $row_showupload->filepath == "FFmpeg") {
						$videolink2 = $row_showupload->videourl;
						if ($videolink2 != "") : ?>
						<a href="javascript:void(0)" <?php if($row_showupload->published == 1){ ?>
							onclick="window.open('<?php echo $videolink; ?>','','width=300,height=200,maximize=yes,menubar=no,status=no,location=yes,toolbar=yes,scrollbars=yes')" <?php } ?>>
							<?php echo $newtext = wordwrap($row_showupload->videourl, 15, "\n", true); ?>
						</a>
						<?php else : ?>
						&nbsp;
						<?php
						endif;
					}
					elseif ($row_showupload->filepath == "Url" || $row_showupload->filepath == "Youtube") {
						$videolink2 = $row_showupload->videourl;
						if ($videolink2 != "") : ?>
						<a href="javascript:void(0)" 
							onclick="window.open('<?php echo $videolink; ?>','','width=600,height=500,maximize=yes,menubar=no,status=no,location=yes,toolbar=yes,scrollbars=yes')" >
							<?php echo $newtext = wordwrap($videolink2, 15, "\n", true); ?> </a>
							<?php else : ?>
						&nbsp;
						<?php
						endif;
					}
					?>	
				</td>
				<td class="center">

					<?php
					$str1 = explode('administrator', JURI::base());
					$thumbpath1 = $str1[0] . "/components/com_contushdvideoshare/videos/";
					if ($row_showupload->filepath == "File" || $row_showupload->filepath == "FFmpeg") {
						$thumblink2 = $row_showupload->thumburl;
						if ($thumblink2 != "") : ?>
						<a href="javascript:void(0)"
							onclick="window.open('<?php echo $thumbpath1 . $row_showupload->thumburl; ?>','','width=300,height=200,menubar=yes,status=yes,location=yes,toolbar=yes,scrollbars=yes')">
							<?php echo $newtext = wordwrap($row_showupload->thumburl, 15, "\n", true); ?>
						</a>
						<?php else : ?>
						&nbsp;
						<?php
						endif;
					}
					elseif ($row_showupload->filepath == "Url" || $row_showupload->filepath == "Youtube") {
						$thumblink2 = $row_showupload->thumburl;
						if ($thumblink2 != "") : ?>
						<a href="javascript:void(0)"
							onClick="window.open('<?php echo trim($thumblink2); ?>','','width=600,height=500,menubar=yes,status=yes,location=yes,toolbar=yes,scrollbars=yes')">
							<?php echo $newtext = wordwrap($thumblink2, 15, "\n", true); ?> </a>
							<?php else : ?>
						&nbsp;
						<?php
						endif;
					}
					else {
						?>
						&nbsp;
						<?php
					}
					?>
				</td>
				<td class="center"><?php
				if ($row_showupload->postrollads == 1)
				$postrollads = "Enable";
				else
				$postrollads="Disable";
				?>
					<?php echo $postrollads; ?>
				</td>
				<td class="center"><?php
				if ($row_showupload->prerollads == 1)
				$prerollads = "Enable";
				else
				$prerollads="Disable";
				?>
					<?php echo $prerollads; ?>
				</td>
				<td class="center"><?php
				if ($row_showupload->midrollads == 1)
				$midrollads = "Enable";
				else
				$midrollads="Disable";
				?>
					<?php echo $midrollads; ?>
				</td>
				<td id="<?php echo $row_showupload->id; ?>">
                        <p style="padding:6px;" id="ordertd_<?php echo $row_showupload->id; ?>"> <?php echo $row_showupload->ordering; ?> </p>
                </td>
				<td class="center">
					<?php echo $published; ?>
				</td>
				<td class="center">
				
				<?php
				$featured = $row_showupload->featured;
				if ($featured == "1") {
					$fimg = '<a title="unfeatured Item" onclick="return listItemTask(\'cb' . $i . '\',\'unfeatured\')" href="javascript:void(0);">
								<img src="components/com_contushdvideoshare/images/tick.png" /></a>';
				} else {
					$fimg = '<a title="featured Item" onclick="return listItemTask(\'cb' . $i . '\',\'featured\')" href="javascript:void(0);"><img src="components/com_contushdvideoshare/images/publish_x.png" /></a>';
				}
				?> <?php echo $fimg; ?>
				
				</td>
				<td class="center">					
					<?php echo $row_showupload->id; ?>					
				</td>

			</tr>
			<?php
			$k = 1 - $k;
			$j++;
			}
			?>

			<tr>
				<td colspan="17"><?php echo $videolist1['pageNav']->getListFooter(); ?>
				</td>
			</tr>

			<?php
		} ##  If condn for count
		?>
		</tbody>
	</table>

	<!-- To sort Table Ordering -->
	<input type="hidden" name="filter_order" value="<?php echo $videolist1['lists']['order']; ?>" /> 
	<input type="hidden" name="filter_order_Dir" value="<?php echo $videolist1['lists']['order_Dir']; ?>" />                                            
	<input type="hidden" name="task" id="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<?php echo JHTML::_('form.token'); ?>
</form>

		<?php } ?>