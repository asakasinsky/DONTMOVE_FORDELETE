<div class="fQuestions" id="container_comments_<?php echo $mark;?>_<?php echo $mark_id;?>">
	<noindex>
		<div class="container_comments_vars acc<?php echo $cmswidget; ?>" id="container_comments_vars_<?php echo $mark;?>_<?php echo $mark_id;?>" style="display: none">
			<div class="mark"><?php echo $mark; ?></div>
			<div class="mark_id"><?php echo $mark_id; ?></div>
			<div class="text_rollup_down"><?php echo $text_rollup_down; ?></div>
			<div class="text_rollup"><?php echo $text_rollup; ?></div>
			<div class="visual_editor"><?php echo $visual_editor; ?></div>
			<div class="sorting"><?php echo $sorting; ?></div>
			<div class="page"><?php echo $page; ?></div>
			<div class="ascp_widgets_position"><?php echo $ascp_widgets_position; ?></div>
			<div class="text_voted_blog_plus"><?php echo  $text_voted_blog_plus; ?></div>
			<div class="text_voted_blog_minus"><?php echo  $text_voted_blog_minus; ?></div>
			<div class="text_all"><?php echo  $text_all; ?></div>
			<div class="prefix"><?php echo $prefix;?></div>
			<div class="cmswidgetid"><?php echo $cmswidget;?></div>
		</div>
	</noindex>

	<?php
	if (isset($mycomments) && $mycomments) {
	  	if (isset($record_comment['admin_name']) && $record_comment['admin_name']) {
			$admin_name =  array_flip(explode(";",trim($record_comment['admin_name'])));
		}

		$admin = false;
		$opendiv=0;
		foreach ($mycomments as $number => $comment) {?>
			<div class="exQuestion">
			  <div class="headQuestion">
				<p class="namePerson"><?php  echo $comment['author']; ?></p>
				<p class="dateQuestion"><?php  echo $comment['date_added']; ?></p>
			  </div><!-- .headQuestion -->
			  
				<? require("comment.tpl");
				if (isset($comment["admin_comments"])) foreach ($comment["admin_comments"] as $number => $comment) require("comment.tpl"); ?>
			</div><?

	}//foreach ($mycomments as $number => $comment)
	// for not close div
	if ($opendiv>0 ) {
	for ($i=0; $i<$opendiv; $i++)
	{
	?>
</div>
</div>
<?php
}
}
?>

<!--<div class="floatright displayinline"><?php  echo $entry_sorting; ?>
	<select name="sorting" data-cmswidget="<?php echo $cmswidget; ?>" class="comments_sorting" onchange="$('#comment').comments(this[this.selectedIndex].value);">
		<option <?php if ($sorting == 'desc')  echo 'selected="selected"'; ?> data-cmswidget="<?php echo $cmswidget; ?>" value="desc"><?php echo $text_sorting_desc; ?></option>
		<option <?php if ($sorting == 'asc')   echo 'selected="selected"'; ?> data-cmswidget="<?php echo $cmswidget; ?>" value="asc"><?php  echo $text_sorting_asc;  ?></option>
	</select>
</div>-->
<div class="pagination" style="margin-left: 40px;"><?php echo $pagination; ?></div>
<?php  }  else { ?>
<div class="content"><?php echo $text_no_comments; ?></div>
<?}?>
</div>