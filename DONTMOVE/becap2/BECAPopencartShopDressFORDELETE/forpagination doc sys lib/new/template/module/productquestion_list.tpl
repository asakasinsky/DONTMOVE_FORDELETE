<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
	<div class="breadcrumb">
		<?php foreach ($breadcrumbs as $breadcrumb) { ?>
		<?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
		<?php } ?>
	</div>
	<h1><?php echo $pq_questions_title; ?></h1>
	<?php if (!empty($pqQuestions)) { ?>
		<div id="pqQuestionlist">
			<ul id="qList">11111111111111
				<?php foreach ($pqQuestions as $q) { ?> 
				<li>
					<span class="question"><?php echo htmlspecialchars($q['question_text']); ?></span>
					<span class="answer"><?php echo ($q['answer_text']); ?></span>
				</li>
				<?php } ?>
			</ul>
		</div>
		<div class="pagination"><?php echo $pagination; ?></div>
	<?php } else { ?>
		<p><?php echo $pq_no_questions_added; ?></p>
	<?php } ?>
	<?php echo $content_bottom; ?>
</div>
<?php echo $footer; ?>
