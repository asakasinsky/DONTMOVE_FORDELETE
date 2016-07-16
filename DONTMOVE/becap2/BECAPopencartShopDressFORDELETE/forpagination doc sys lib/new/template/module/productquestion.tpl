<?php if (!empty($pqQuestions)) {
	foreach ($pqQuestions as $q) { ?>
	<div class="content">
	    <span class="question"><?php echo htmlspecialchars($q['question_text']); ?></span>
	    <span><?php echo date('d/m/Y',$q['create_time']); ?></span>
	    <span class="answer"><?php echo ($q['answer_text']); ?></span>
	</div>
	<?php } ?>
	<div class="pagination"><?php echo $pagination; ?></div>
<?php } else { ?>
	<div class="content"><?php echo $pq_no_questions_added; ?></div>
<?php } ?>

<h2 id="question-title"><?php echo $pq_ask; ?></h2>
<b><?php echo $pq_name; ?></b><br />
<input type="text" name="pqName" value="" /><br /><br />
<b><?php echo $pq_email; ?></b><br />
<input type="text" name="pqEmail" value="" /><br />
<br />
<br />
<b><?php echo $pq_question; ?></b>
<textarea name="pqText" cols="40" rows="8" style="width: 98%;" <?php if ($productquestion_conf_maxlen > 0) echo "maxlength='$productquestion_conf_maxlen'"?>></textarea>
<span style="font-size: 11px;"><?php echo $pq_note; ?></span><br />
<br />
<b><?php echo $pq_captcha; ?></b><br />
<input type="text" name="pqCaptcha" value="" />
<br />
<img src="index.php?route=product/product/captcha" alt="" id="captcha" /><br />
<br />
<div class="buttons">
  <div class="right"><a id="pqSubmitBtn" class="button"><span><?php echo $button_continue; ?></span></a></div>
</div>

<script type="text/javascript">
	var pq_product_id = <?php echo $product_id; ?>;
	var pq_wait = '<?php echo $pq_wait; ?>';
</script>