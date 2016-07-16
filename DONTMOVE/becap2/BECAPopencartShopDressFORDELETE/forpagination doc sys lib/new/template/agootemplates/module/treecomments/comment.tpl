<? 		$opendiv++;
		if (isset($admin_name[trim($comment['author'])])) {
		 $back_color = 'background-color: '.$record_comment['admin_color'].';';
		 $admin = true;
		} else {
		 $back_color ='';
		 $admin = false;
		}
	?>

	<div id="commentlink_<?php  echo $comment['comment_id']; ?>_<?php  echo $cmswidget; ?>" class="<?php echo $prefix;?>form_customer_pointer comment_content level_0">

		<p class="questionText"><b><? if ($comment['level'] == 0) echo "Вопрос"; else echo "Ответ"; ?>:</b><?php echo  $comment['text']; ?></p>
		<div class="container_comment_vars" id="container_comment_<?php echo $mark;?>_<?php echo $mark_id;?>_<?php echo  $comment['comment_id']; ?>" style="display: none">
			<div class="comment_id"><?php echo  $comment['comment_id']; ?></div>
		</div>

			<?php if (isset($settings_widget['avatar_status']) && $settings_widget['avatar_status'] && $comment['avatar']) { ?>
			<div class="seocmspro_avatar">
			<img src="<?php  echo $comment['avatar']; ?>" alt="<?php  echo $comment['author']; ?>" title="<?php  echo $comment['author']; ?>">
			</div>
			<?php } ?>



			<!-- karma -->
			<?php  if (isset($record_comment['karma']) && $record_comment['karma']) { ?>
			<div class="voting  <?php  if ($comment['customer_delta'] < 0) echo 'voted_blog_minus';  if ($comment['customer_delta'] > 0) echo 'voted_blog_plus';?> floatright /*margintop5*/ marginright90px"  id="voting_<?php  echo $comment['comment_id']; ?>">

				<?php
				if (!$comment['customer'] && (isset($thislist['karma_reg']) && $thislist['karma_reg']==1) ){ ?>
				<div class="floatright marginleft10">
				<a href="#" class="textdecoration_none">
					<ins  class="customer_enter"><span  title="<?php echo  $text_vote_will_reg; ?>"   class="comment_yes blog_plus  voted_comment_plus"><?php echo $text_review_yes; ?></span><span class="comments_stat"><?php if ($comment['rate_count_blog_plus']!="0")    { ;?><span class="score_plus"><?php  echo $comment['rate_count_blog_plus'];?></span><?php    } else { ?><span class="score_plus"></span><?php  } ?></span></ins></a>&nbsp;/
				<a href="#" class="textdecoration_none">
					<ins  class="customer_enter"><span  title="<?php echo  $text_vote_will_reg; ?>"  class="comment_no blog_minus  voted_comment_minus"><?php echo $text_review_no;  ?></span><span class="comments_stat"><?php if ($comment['rate_count_blog_minus']!="0")   { ;?><span class="score_minus"><?php echo $comment['rate_count_blog_minus'];?></span><?php   } else { ?><span class="score_minus"></span><?php } ?></span></ins>
				</a>
				</div>
				<?php } else { ?>
				<div class="floatright marginleft10">
				<a href="#blog_plus"   data-cmswidget="<?php echo $cmswidget; ?>" title="<?php echo  $text_vote_blog_plus; ?>"   class="comment_yes blog_plus comments_vote <?php if (isset($comment['voted']) && $comment['voted']) echo "voted_comment_plus"; ?>" ><?php echo $text_review_yes; ?></a><span class="comments_stat"><?php if ($comment['rate_count_blog_plus']!="0")    { ;?><span class="score_plus"><?php  echo $comment['rate_count_blog_plus'];?></span><?php    } else { ?><span class="score_plus"><?php  echo $comment['rate_count_blog_plus'];?></span><?php  } ?></span>
				</div>
				<?php } ?>


			</div>
			<?php } ?>
             <!-- karma -->

			<!-- for reply form -->



		</div>
	
		<div id="parent<?php echo $comment['comment_id']; ?>" class="comments_parent">
			<?php
			if ($comment['flag_end']>0) {

			if ($comment['flag_end']>$opendiv) {
				$comment['flag_end']=$opendiv;
			}
			for ($i=0; $i<$comment['flag_end']; $i++)
			{
				$opendiv--;

			?>
		</div>
	</div>
	<?php

	}
	}
	?>