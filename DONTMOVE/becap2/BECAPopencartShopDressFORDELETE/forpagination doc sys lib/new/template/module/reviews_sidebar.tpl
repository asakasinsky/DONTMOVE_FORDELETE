<div class="formOtziv">
	<div class="rowsOtziv" id="pqsBlockLeft">
		<div class="otzivSend">
			<p>Отзывы:</p>
			<button class="grayButton">НАПИСАТЬ</button>
		</div>
		<div class="formSend_otziv">
			<form>
				<p>Ваше имя:</p>
				<input type="text" id="pqsName" name="pqsName" maxlength="32" required="" value="<?php echo $pqsName; ?>">
				<p>Ваш E-mail:</p>
				<input type="email" id="pqsEmail" name="pqsEmail" maxlength="128" required="" value="<?php echo $pqsEmail; ?>">
				<p class="coment">Комментарий:</p>
				<textarea id="pqsText" name="pqsText" <?php if ($productquestion_conf_maxlen > 0) echo "maxlength='$productquestion_conf_maxlen'"?> required=""></textarea><br>
				<input type="hidden" name="pqsSubmit" value="pqsSubmit" id="pqsSubmit"/>
				<p class="warning" id="pqsError" style="display: none"></p>
				<button type="submit" id="pqsSubmitBtn" class="grayButtonOtpraviti">ОТПРАВИТЬ</button>
				<div class="reiting_otziv">
					<span>Ваша оценка:</span><br>
						<div class="stars">
							<form action="">
						    	<input class="star star-5" id="star-5" type="radio" name="star"/>
						    	<label class="star star-5" for="star-5"></label>
						    	<input class="star star-4" id="star-4" type="radio" name="star"/>
						    	<label class="star star-4" for="star-4"></label>
						    	<input class="star star-3" id="star-3" type="radio" name="star"/>
						    	<label class="star star-3" for="star-3"></label>
						   		<input class="star star-2" id="star-2" type="radio" name="star"/>
						   		<label class="star star-2" for="star-2"></label>
						    	<input class="star star-1" id="star-1" type="radio" name="star"/>
						    	<label class="star star-1" for="star-1"></label>
							</form>
						</div>
				</div>
			</form>
		</div>
	</div>
	<?php if (!empty($pqQuestions)) { ?>
		<?php foreach ($pqQuestions as $q) { ?> 
			<div class="comentsForm">
				<p><?php echo htmlspecialchars($q['name']); ?>     <? echo date('d.m.Y, H:i', $q['answer_time']); ?></p>
				<span><a href="<?=$q['href']?>"><img src="<?=$q['popup']?>"></a><?php echo htmlspecialchars($q['question_text']); ?></span>
			</div>
		<?php } ?>
		<?php echo $pagination; ?>
	<?php } else { ?>
		<p><?php echo $pq_no_questions_added; ?></p>
	<?php } ?>
</div>

<div class="forSlide_otziv"></div>

<script type="text/javascript">
	var pq_wait = '<?php echo $pq_wait; ?>';
</script>