$(function() {

	$(".populatTovar").appendTo(".forSlide_otziv");
	$(".populatTovar").attr("class", "populatTovar2");
	$(".slide").appendTo(".forSlide_otziv");
	$(".forSlide").remove();
	$(".breadСrumbs span").html("");
	$(".stars, .reiting_otziv").remove();

	/* product form */
	$(document).on('click', "#tab-questions .links a", function() {
		var page = $(this).attr('href').match(/\d*$/);
		$('#tab-questions').load('index.php?route=module/reviews&page='+page+'&product_id='+pq_product_id);
		return false;
	});

	$(document).on('click', '#pqSubmitBtn:not(.disabled)', function() {
		$.ajax({
			type: "POST",
			dataType: "json",
			url: 'index.php?route=module/reviews/submitProductQuestion&product_id='+pq_product_id,
			data: 'pqEmail=' + encodeURIComponent($('input[name=\'pqEmail\']').val()) + '&pqName=' + encodeURIComponent($('input[name=\'pqName\']').val()) + '&pqText=' + encodeURIComponent($('textarea[name=\'pqText\']').val()) + '&captcha=' + encodeURIComponent($('input[name=\'pqCaptcha\']').val()),
			beforeSend: function() {
				$('.success, .warning').remove();
				$('#pqSubmitBtn').addClass('disabled');
				$('#question-title').after('<div class="attention"><img src="catalog/view/theme/default/image/loading.gif" alt="" /> ' + pq_wait + '</div>');
			},		
			complete: function() {
				$('#pqSubmitBtn').removeClass('disabled');
				$('.attention').remove();
			},
			success: function(jsonData) {
				if (!$.isEmptyObject(jsonData.errors)) {
					var errors = '';
					jQuery.each(jsonData.errors, function(index, item) {
					    errors += '<li>' + item + '</li>';
					});
					
					$('#question-title').after('<div class="warning"><ul>' + errors + '</ul></div>');
				} else {
					$('#question-title').after('<div class="success">' + jsonData.success + '</div>');
					$('#tab-questions input[type="text"], #tab-questions textarea').val('');
				}
			}
		});
		return false;
	});
	
	$('#pqText[maxlength], #pqsText[maxlength]').keyup(function(){
		var limit = parseInt($(this).attr('maxlength'));
		if($(this).val().length > limit){
			$(this).val($(this).val().substr(0, limit));
		}
	});

	$("#pqsSubmitBtn").click(function() {
		$.ajax({
			type: "POST",
			dataType: "json",
			url: 'index.php?route=module/reviews/submitquestion',
			data: $(this).parents("form").serialize(),
			beforeSend: function() {
				$("#pqsSubmitBtn").hide().before('<p class="attention"><span class="wait">&nbsp;<img src="" alt="" /></span>' + pq_wait + '</p>');
				$("#pqsError, #pqsSuccess").empty().hide();
			},
			error: function(a,b,c) {
				alert(a+b+c);
				$("#pqsSubmitBtn").show();
			},
			success: function(jsonData) {
				$("#pqsBlockLeft p.attention").remove();
				if (!$.isEmptyObject(jsonData.errors)) {
					var errors = '';
					jQuery.each(jsonData.errors, function(index, item) {
					    errors += '<li>' + item + '</li>';
					});
					
					$("#pqsError").html('<ul>' + errors + '</ul>').show();
					$("#pqsSubmitBtn").show();
				} else {
					$("#pqsError").after('<p id="pqsSuccess" class="success">' + jsonData.success + '</p>');
					$("#qForm input[type='text'], #qForm textarea").empty();
				}
			}
		});
		return false;
	});
	
	$("#pqsText").focus(function() {
		$(this).val('').unbind('focus');
	});
});
