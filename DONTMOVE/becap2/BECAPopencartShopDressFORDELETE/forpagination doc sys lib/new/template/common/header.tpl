<!DOCTYPE html >
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">

    <title><?php echo $title; ?></title>
    <base href="<?php echo $base; ?>" />
    <?php if ($description) { ?>
    <meta name="description" content="<?php echo $description; ?>" />
    <?php } ?>
    <?php if ($keywords) { ?>
    <meta name="keywords" content= "<?php echo $keywords; ?>" />
    <?php } ?>
    <?php if ($icon) { ?>
    <link href="<?php echo $icon; ?>" rel="icon" />
    <?php } ?>
    <?php foreach ($links as $link) { ?>
    <link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
    <?php } ?>

    <link href="http://allfont.ru/allfont.css?fonts=arial-narrow" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="http://netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo HTTP_THEME; ?>css/reset.css">
    <link rel="stylesheet" type="text/css" href="/catalog/view/javascript/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo HTTP_THEME; ?>css/jquery.bxslider.css">
    <link rel="stylesheet" type="text/css" href="<?php echo HTTP_THEME; ?>css/cssUi/jquery-ui.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo HTTP_THEME; ?>css/index.css">
     <? if (mb_strpos($_SERVER["HTTP_USER_AGENT"], "Mozilla") !== false):?>
        <link rel="stylesheet" type="text/css" href="<?php echo HTTP_THEME; ?>css/firefox.css">
     <? endif; ?>
     <? if (mb_strpos($_SERVER["HTTP_USER_AGENT"], "YaBrowser") !== false):?>
        <link rel="stylesheet" type="text/css" href="<?php echo HTTP_THEME; ?>css/yandex.css">
     <? endif; ?>
    <script type="text/javascript" src="catalog/view/javascript/js/jquery-1.12.1.min.js"></script>
    <script type="text/javascript" src="catalog/view/javascript/js/jquery.bxslider.min.js"></script>
    <script type="text/javascript" src="catalog/view/javascript/js/jqueryui/jquery-ui.min.js"></script>
    <script type="text/javascript" src="catalog/view/javascript/js/bigSlide.min.js"></script>
    <script type="text/javascript" src="catalog/view/javascript/js/script.js"></script>
    <script src="catalog/view/javascript/common.js" type="text/javascript"></script>

    <?php foreach ($styles as $style) { ?>
    <link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
    <?php } ?>
    <?php foreach ($scripts as $script) { ?>
    <script src="<?php echo $script; ?>" type="text/javascript"></script>
    <?php } ?>
    <?php echo $google_analytics; ?>






<!-- SAM S -->
	<script>

    //$("#input-telephone").inputmask("7(999)999-99-99");

    $(document).ready(function () {

    /* copy style*/
    $('.click2').addClass($('.click1').attr('class'));



        $('#button-oneclick').on('click', function () {
           // $('.alert, .text-danger').remove();
            var tel_number = $("#input-telephone").val();
            var product_id = $("#curent_id").val();
            var curent_price = $("#curent_price").val(); 
            var user_name = $("#user_name").val();

      // alert(' clik button-oneclick');

            var pattern = /^.{1,50}$/;
            var pattern_name = /^\w{1,50}$/;
             var pattern_name = /^[^\d]{1,50}$/;
              var pattern_name = /^.{1,50}$/;
//   only click
if (pattern.test(tel_number) && pattern_name.test(user_name))
{
    $('#mes_main').hide();
    $('#name1click').hide();
 $('#input-telephone').hide();
 $('#button-oneclick').hide();
  $('#input-telephone').hide();
    $('#user_name').hide();
 $('#mes1').show();
 $('#mes2').show();
}

 // hide button buyoneclkick
 
   /*  $('.buy').hide();
     sleep(15000);*/


//window.location.href = '/';
                 
//   



//alert('test');

        // добавление товара в корзину но возврат ERROR хотя все работает 
        // если надо будет то переделать обработчик popup (что все ок ) 
        // по как что там
            if (pattern.test($("#input-telephone").val()) &&pattern_name.test($("#user_name").val())) {
                $.ajax({
                    url: 'index.php?route=product/buyoneclick/oneclickadd',
                    type: 'post',
                    data: 'product_id=' + product_id + '&tel_number=' + tel_number+'&curent_price='+curent_price+'&user_name='+user_name,
                    dataType: 'json',
                    complete: function () {
                        $('#cart > button').button('reset');
                    console.log('comletwe');
                    },
                    success: function (json) {
                    	console.log('success');
                        if (json['redirect']) {
                            location = json['redirect'];
                        }

                        if (json['success']) {
                           $('.form-one-click-call').html('<label class="control-label" for="input-telephone">' + json['text_order_success'] + ' ' + json['code'] + '</label>');
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log('error');
                        
                         $('#mes_main').hide();
                          $('#name1click').hide();
 $('#input-telephone').hide();
 $('#button-oneclick').hide();
  $('#input-telephone').hide();
    $('#user_name').hide();
 $('#mes1').show();
 $('#mes2').show();

 // hide button buyoneclkick
 
     $('.buy').hide();
     sleep(15000);


//window.location.href = '/';
                        alert('ok error');
                        //console.log(thrownError);
                        $('#content').parent().before('<div class="alert alert-danger"><i class="fa fa-minus-circle"></i>'+ xhr.responseText +' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
					}
                });
            }
            else {
                $('#content').parent().before('<div class="alert alert-danger"><i class="fa fa-minus-circle"></i> Телефонный номер неверен. Он должен состаять из цифр.<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
            }
        });



      // обработчки для задержкы закрытия формы
    $("#call_form").submit(function() {
   //  alert('submi ');
  // $(this).dialog("close").delay(50000);
    setTimeout(function() {closeModal(); }, 5000);


  return false;;
});


//      calback area


//КУПИТЬ В 1 КЛИК
$('#calback_user').click(function () {
	//alert('dddddddd');
    $(".backgroundModalClick").fadeIn(300);
    var obj = $(".click2");
    var miliseconds = 700;
    
    obj.fadeIn(miliseconds);
    
    var left = ($(window).width() - obj.width())/2+"px";
    var top = ($(window).height() - obj.height())/2+"px";
        
    obj.css({
        "top":top,
        "left":left
    });
        $(window).resize(function () {
            var left = ($(window).width() - obj.width())/2+"px";
            var top = ($(window).height() - obj.height())/2+"px";
            obj.css({
                "top":top,
                "left":left
            });
        });
});
/*       $('.X').click( function () {
        $('.click1').fadeOut(400);
       });
$('.buy2').click(function () {
    $(".backgroundModalClick").fadeIn(300);
    var obj = $(".click1");
    var miliseconds = 700;
    
    obj.fadeIn(miliseconds);
    
    var left = ($(window).width() - obj.width())/2+"px";
    var top = ($(window).height() - obj.height())/2+"px";
        
    obj.css({
        "top":top,
        "left":left
    });
        $(window).resize(function () {
            var left = ($(window).width() - obj.width())/2+"px";
            var top = ($(window).height() - obj.height())/2+"px";
            obj.css({
                "top":top,
                "left":left
            });
        });
});*/

//     end calback area






//  end onload
    });






</script>

<!-- SAM E -->












</head>
<body>

<div class="menuMobile" id="menuMoblie">
	<div class="forMenuMob" role="navigation">
		<p class="categoriestext">КАТЕГОРИИ</p>
		<a href="<?php echo $week_sale_href; ?>"><img src="<?php echo HTTP_THEME; ?>images/nedelnaiaprodaj.png" height="55" width="290"></a>

		<?php if($category_items) { ?>
			<div class="submenuLink1">
				<?php foreach($category_items as $item) { ?>
					<ul class="meniul">
						<li><a href="<?php echo $item['href']; ?>" class="parent"><?php echo $item['title']; ?></a></li>
						<?php if($item['childs']) { ?>
							<ul id="submenu">
								<?php foreach($item['childs'] as $child) { ?>
									<li><a href="<?php echo $child['href']; ?>"><?php echo $child['title']; ?></a></li>
								<?php } ?>
							</ul>
						<?php } ?>
					</ul>
				<?php } ?>
			</div>
		<?php } ?>

		<p class="informationSlideLeft">ИНФОРМАЦИЯ</p>
		<ul class="intra">
			<?php if($is_logged) { ?>
				<li><p><a href="<?php echo $account; ?>"><?php echo $username; ?></a></p></li>
			<?php } else { ?>
				<li class="parent3">
					<p><a href="<?php echo $login; ?>">ВХОД</a><span>/</span><a href="<?php echo $login; ?>">РЕГИСТРАЦИЯ</a></p>
				</li>
			<?php } ?>
			<ul>
				<?php foreach($top_menu as $item) { ?>
					<li><a href="<?php echo $item['href']; ?>"><?php echo $item['title']; ?></a></li>
				<?php } ?>
			</ul>
		</ul>
		<p class="phoneNumber"><?php echo $telephone; ?></p>
		<a href="#" class="obrat_zvonok">Закажи обратный звонок</a>
	</div>
</div>

<div class="allContent">
	<section class="wrapper1 width">
		<header>
			<div class="numberTel">
				<p><?php echo $telephone; ?></p>
			</div>
			<div id="calback_user" class="Call" >
				<a  >ЗАКАЖИ ОБРАТНЫЙ ЗВОНОК</a>
			</div>
			<nav class="menuTop">
				<?php foreach($top_menu as $item) { ?>
					<a href="<?php echo $item['href']; ?>"><?php echo $item['title']; ?></a>
				<?php } ?>
			</nav>
			<div class="Registrer">
				<?php if($is_logged) { ?>
					<a href="<?php echo $account; ?>"><?php echo $username; ?></a>
				<?php } else { ?>
					<a href="<?php echo $login; ?>">ВХОД</a>
					<span>/</span>
					<a href="<?php echo $register; ?>">РЕГИСТРАЦИЯ</a>
				<?php } ?>
			</div>



     <!-- JS в header look !!! SAM   -->
                        <div class="click2">
                            <div class="textClick">
                                <p class="textBot" id='mes_main'>Мы вам перезвоним</p>
                                 
                                <form id='call_form' >
                                 <p hidden class="textBot" id='mes1'>Ваш заказ поставлен на обработку</p>
                                  <p hidden class="textBot" id='mes2'>Вам перезвонят</p>
                                    <input type="text" name="name1click" required="" id='user_name' placeholder="Ваше имя" >
                                    <input type="tel" id="input-telephone" required="" name="phone" placeholder="ТЕЛЕФОН"  >
                                    <button type="submit" id="button-oneclick" class="sendClick">ОТПРАВИТЬ</button>
                                       
                                    <input hidden type="text" id="curent_price" value="<?php 
                                    echo preg_replace("/[^0-9]/", '', $price); ?>" >   

                                    <input hidden type="text" id="curent_id" value="<?php  echo $product_id; ?>" > 
                                    <!--  <input type="submit"> -->


                                </form>
                                <hr>






















                            </div>
                            <button class="X" onclick="closeModal()"></button>
                            <!--      не работает настройте сервер !! ии htaccss
                            <img src="<?php echo DIR_IMAGE.'product/click1.png'; ?>"> -->
                            <img src="<?php echo HTTP_SERVER.'image/product/click1.png'; ?>">
                            

                        </div>

                        <!-- End calback sam  -->









		</header>
	</section>
<section class="wrapper2 width">
		<div class="forHead">
			<div class="logo">
				<a href="<?=HTTP_SERVER?>"><img src="<?php echo HTTP_THEME; ?>images/headerBlack.png" class="afaraDu_te"></a>
			</div>
			<?php echo $search; ?>

			<div class="rightNavMobile">
				<div class="otlojeno">
					<a href="#" class="imgOtlejeno"></a>
					<div class="bordetBot">
						<a href="<?php echo $wishlist; ?>">ОТЛОЖЕНО</a><br>
						<p>Товаров:<span>&nbsp;<?php echo $wishlist_total; ?></span></p>
					</div>
				</div>
				<?php echo $cart; ?>
			</div>
		</div>
	</section>
	<section class="wrapper3 width">
		<a href="#menuMoblie" class="parent2"></a>
		<?php echo $search_mobile; ?>
		<div class="formenu">
			<nav class="menu">
				<?php foreach($category_items as $k => $item) { ?>
					<div class="menuDiv">
						<a href="<?php echo $item['href']; ?>" class="linkMeenu rowTwo"><?php echo $item['title']; ?></a>
						<div class="forMenu1 <?php if($k > 6) { ?> lastSubmenu <?php } ?> ">
							<a href="<?php echo $item['href']; ?>"><img src="<?php echo $item['icon_full']; ?>"></a>
							<?php if($item['childs']) { ?>
								<div class="forSubmenu1Link">
								<?php foreach($item['childs'] as $child) { ?>
									<a href="<?php echo $child['href']; ?>"><?php echo $child['title']; ?></a><br>
								<?php } ?>
								</div>
							<?php } ?>
						</div>
					</div>
				<?php } ?>
				<div class="menuLastImg">
					<a href="<?php echo $week_sale_href; ?>" class="linkMeenu">НЕДЕЛЬНАЯ<br>РАСПРОДАЖА</a>
				</div>
			</nav>
		</div>
	</section>

