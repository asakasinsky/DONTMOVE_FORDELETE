<?php echo $header; ?>
<script>
var rrPartnerId = "5615a3401e9947326ca18492";
var rrApi = {};
var rrApiOnReady = rrApiOnReady || [];
rrApi.addToBasket = rrApi.order = rrApi.categoryView = rrApi.view =
rrApi.recomMouseDown = rrApi.recomAddToCart = function() {};
(function(d) {
var ref = d.getElementsByTagName('script')[0];
var apiJs, apiJsId = 'rrApi-jssdk';
if (d.getElementById(apiJsId)) return;
apiJs = d.createElement('script');
apiJs.id = apiJsId;
apiJs.async = true;
apiJs.src = "//cdn.retailrocket.ru/content/javascript/api.js";
ref.parentNode.insertBefore(apiJs, ref);
}(document));
</script>
<script type="text/javascript">
            rrApiOnReady.push(function() {
                try{ rrApi.view(<?php echo $product_id; ?>); }
                catch(e) {}
        })
    </script>
<div class="wrapper wrappFilters">
    <section>
    <div class="breadСrumbs">
        <a href="<?php echo HTTP_SERVER; ?>">Главная</a>
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
            <a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
            <? if (end($breadcrumbs) !== $breadcrumb) echo "<span> > </span>"; ?>
        <?php } ?>
    </div>
    <?php echo $column_left; ?>
    <?php echo $content_top; ?>
    
    
    
    <div class="gallery" itemscope itemtype="http://schema.org/Product" order-product="<?php echo $product_id; ?>">
        <?php if ($thumb || $images) { ?>
            <?php if ($thumb) array_unshift($images, array("popup"=>$thumb , "thumb"=>$thumb)); ?>
            <?php if ($images) { ?>
            <div class="leftFotos60">            
                <?php foreach ($images as $image) { ?>
                <img name-image="<?php echo $image['popup']; ?>" src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" width="60" />
                <?php } ?>
                <?php } ?>
            </div>
            <?php if ($images) { ?>
            <div class="modalWindow modalImage hide">
              <span class="close-window" onclick="closeModal();">✖</span>
              <div class="controlsModalImage">
                <span class="leftImage"></span>
                <span class="rightImage"></span>
              </div><!-- .controlsModalImage -->
              <?php foreach ($images as $key => $image) { ?>
              <img src="<?php echo $image['popup']; ?>" height="600" name-image="<?php echo $image['popup']; ?>" order-image="<?=$key+1?>" alt="imageProduct" class="activeImage420">
              <?php } ?>
            </div>
            <?php } ?>
            <?php if ($thumb) { ?>
              <div class="headerProduct">
                <? /*if($new_product) {*/ ?><span class="newProduct">НОВИНКА</span><? /*}*/?>
                <?php if ($special) { ?><span class="saleProduct"><? echo floor(100 - 100*$special/$price); ?>%</span><?}?>
              </div><!-- .headerProduct -->
              <div class="myyyyyy">
              <img name-image="<?php echo $thumb; ?>" class="activeImageGallery" src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" itemprop="image" />
              <script type="text/javascript">(function() {
              if (window.pluso)if (typeof window.pluso.start == "function") return;
              if (window.ifpluso==undefined) { window.ifpluso = 1;
                var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
                s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
                s.src = ('https:' == window.location.protocol ? 'https' : 'http')  + '://share.pluso.ru/pluso-like.js';
                var h=d[g]('body')[0];
                h.appendChild(s);
              }})();</script>
            <div class="pluso" style="padding-left: 10px;" data-background="#ebebeb" data-options="medium,square,line,horizontal,counter,theme=04" data-services="vkontakte,odnoklassniki,facebook,twitter,moimir,print"></div>
                  <div class="tabs">
             <span order-tab="1" class="selectedTab"><?php echo $tab_description; ?></span>
             <span order-tab="2"><?php echo $tab_review; ?></span>
             <span order-tab="3">Доставка</span>
             <span order-tab="4">Таблица размеров</span>
           </div><!-- .tabs -->
           <div order-text="1" class="textProduct activeText" itemprop="description">
             <p><?php echo $description; ?></p>
               <?php if($show_sizes) { ?>
                <p class="hide-on-popup">Чтобы правильно подобрать размер - воспользуетесь <a href="#" id="show-table-sizes" class="titleProduct" style="display: inline;">Таблицей размеров.</a></p>
                 <div id="table-sizes" style="display: none;" class="hide-on-popup"><?=$ean?></div>
               <?php } ?>
             <br><br>

             <?php if ($attribute_groups) { ?>
             <?php foreach ($attribute_groups as $attribute_group) { ?>
             <!-- <p><?php echo $attribute_group['name']; ?></p> -->
             <ul>
               <?php foreach ($attribute_group['attribute'] as $attribute) { ?>
               <li><span><?php echo $attribute['name']; ?></span><?php echo $attribute['text']; ?></li>
               <?php } ?>
             </ul>
             <?php } ?>
             <?php } ?>
           </div><!-- .textProduct -->
           <div order-text="2" class="textProduct">
             <p>
               <form class="form-horizontal">
                 <div id="review"></div>
                 <h2><?php echo $text_write; ?></h2>
                 <?php if ($review_guest) { ?>
                 <div class="form-group required">
                   <div class="col-sm-12">
                     <label class="control-label" for="input-name"><?php echo $entry_name; ?></label>
                     <input type="text" name="name" value="" id="input-name" class="" />
                   </div>
                 </div>
                 <div class="form-group required">
                   <div class="col-sm-12">
                     <label class="control-label" for="input-review"><?php echo $entry_review; ?></label>
                     <textarea name="text" rows="5" id="input-review" class="form-control" style="width: 90%;"></textarea>
                     <div class="help-block"><?php echo $text_note; ?></div>
                   </div>
                 </div>
                 <div class="form-group required">
                   <div class="col-sm-12">
                     <label class="control-label"><?php echo $entry_rating; ?></label>
                     &nbsp;&nbsp;&nbsp; <?php echo $entry_bad; ?>&nbsp;
                     <input type="radio" name="rating" value="1" />
                     &nbsp;
                     <input type="radio" name="rating" value="2" />
                     &nbsp;
                     <input type="radio" name="rating" value="3" />
                     &nbsp;
                     <input type="radio" name="rating" value="4" />
                     &nbsp;
                     <input type="radio" name="rating" value="5" />
                     &nbsp;<?php echo $entry_good; ?></div>
                 </div>
                 <div class="form-group required">
                   <div class="col-sm-12">
                     <label class="control-label" for="input-captcha"><?php echo $entry_captcha; ?></label>
                     <input type="text" name="captcha" value="" id="input-captcha" />
                   </div>
                 </div>
                 <div class="form-group">
                   <div class="col-sm-12"> <img src="index.php?route=tool/captcha" alt="captcha" id="captcha" /> </div>
                 </div>
                 <div class="buttons">
                   <div class="pull-right">
                     <button type="button" id="button-review" data-loading-text="<?php echo $text_loading; ?>" class=" btn-primary"><?php echo $button_continue; ?></button>
                   </div>
                 </div>
                 <?php } else { ?>
                 <?php echo $text_login; ?>
                 <?php } ?>
               </form>
             </p>
           </div><!-- .textProduct -->
           <div order-text="3" class="textProduct">
             <br/>
             <p><span style="margin: 0px; padding: 0px; border: 0px; outline: 0px; font-size: small; font-family: UbuntuRegular; vertical-align: baseline; color: #373737;">Примерная стоимость доставки:<br /><br /></span><br style="color: #373737; font-family: UbuntuRegular; font-size: 14px; line-height: 18.2px;" /><span style="margin: 0px; padding: 0px; border: 0px; outline: 0px; font-size: small; font-family: UbuntuRegular; vertical-align: baseline; color: #373737;"><span style="margin: 0px; padding: 0px; border: 0px; outline: 0px; font-weight: bold; font-style: inherit; font-size: 13px; font-family: inherit; vertical-align: baseline;">Почта России (получение на почтамте) &ndash; 250 руб.</span>&nbsp;&nbsp;<br />- Стоимость доставки рассчитывается от габаритов груза и веса.<br />- При подтверждении заказа менеджер скажет точную сумму пересылки именно Вашего заказа.</span><br style="color: #373737; font-family: UbuntuRegular; font-size: 14px; line-height: 18.2px;" /><br style="color: #373737; font-family: UbuntuRegular; font-size: 14px; line-height: 18.2px;" /><span style="margin: 0px; padding: 0px; border: 0px; outline: 0px; font-size: small; font-family: UbuntuRegular; vertical-align: baseline; color: #373737;"><span style="margin: 0px; padding: 0px; border: 0px; outline: 0px; font-weight: bold; font-style: inherit; font-size: 13px; font-family: inherit; vertical-align: baseline;">Доставка курьером в Москву - от 700 руб.</span>&nbsp;&nbsp;<br />&nbsp;-стоимость доставки зависит от габаритов и веса заказа.</span><br style="color: #373737; font-family: UbuntuRegular; font-size: 14px; line-height: 18.2px;" /><br style="color: #373737; font-family: UbuntuRegular; font-size: 14px; line-height: 18.2px;" /><span style="margin: 0px; padding: 0px; border: 0px; outline: 0px; font-size: small; font-family: UbuntuRegular; vertical-align: baseline; color: #373737;">После оформления заказа, наш менеджер позвонит и уточнит стоимость доставки и итоговую сумму покупки,<br />так же ответит на все ваши вопросы, после чего отправит заказ по назначению.</span><br style="color: #373737; font-family: UbuntuRegular; font-size: 14px; line-height: 18.2px;" /><br style="color: #373737; font-family: UbuntuRegular; font-size: 14px; line-height: 18.2px;" /><span style="margin: 0px; padding: 0px; border: 0px; outline: 0px; font-size: small; font-family: UbuntuRegular; vertical-align: baseline; color: #373737;"><span style="margin: 0px; padding: 0px; border: 0px; outline: 0px; font-weight: bold; font-style: inherit; font-size: 13px; font-family: inherit; vertical-align: baseline;">*</span>&nbsp;Оплатить можно как при получении, так и заранее (картой Сбербанк и другими способами).</span></p>
           </div><!-- .textProduct -->
           <div order-text="4" class="textProduct">
             <p><?=$ean?></p>
           </div><!-- .textProduct -->
              </div>
            <?php } ?>
        <?php } ?>
        
        <div class="descriptionProduct" id="product">
          <h1 class="nameProduct" itemprop="name"><?php echo $heading_title; ?> <?php echo $stock_status_id; ?></h1>
            <button type="button" class="noneInsklad" id="noneInsklad" >НЕТ НА СКЛАДЕ, ПОСМОТРИТЕ НИЖЕ ПОХОЖИЕ ПРОДУКТЫ</button>

          <div class="linkeProduct<? if($is_liked) echo ' likes_active' ?>" onclick="wishlist.add(<?php echo $product_id; ?>);"></div>

            <div class="product-liked-info" <?php if(!$liked) { ?> style="display: none;" <?php } ?> ><?php echo $liked_text; ?></div>

            
          <div class="clear"></div>

            <div class="wrapper wrappContent">
                <section class="content">
                    <div class="rr-widget"
                 data-rr-widget-product-id="<?php echo $product_id; ?>"
                 data-rr-widget-id="5615a3401e9947326ca18494"
                 data-rr-widget-width="100%"></div>
                </section>
            </div>

        </div><!-- .descriptionProduct -->
        <div class="clear"></div>
      </div><!-- .gallery -->
    

    
      <?php echo $column_right; ?>
      <?php echo $content_bottom; ?>    
    </section>
</div>
<div class="wrapper wrappContent">
    <section class="content">
    </section>
</div>

<script type="text/javascript"><!--
$('select[name=\'recurring_id\'], input[name="quantity"]').change(function(){
	$.ajax({
		url: 'index.php?route=product/product/getRecurringDescription',
		type: 'post',
		data: $('input[name=\'product_id\'], input[name=\'quantity\'], select[name=\'recurring_id\']'),
		dataType: 'json',
		beforeSend: function() {
			$('#recurring-description').html('');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();
			
			if (json['success']) {
				$('#recurring-description').html(json['success']);
			}
		}
	});
});
//--></script> 

<script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});

$('.datetime').datetimepicker({
	pickDate: true,
	pickTime: true
});

$('.time').datetimepicker({
	pickDate: false
});

//--></script>
<script type="text/javascript"><!--
$('#show-table-sizes').on('click', function(e) {
    e.preventDefault();
    $('#table-sizes').slideToggle();
});
$('#review').delegate('.pagination a', 'click', function(e) {
  e.preventDefault();

    $('#review').fadeOut('slow');

    $('#review').load(this.href);

    $('#review').fadeIn('slow');
});

$('#review').load('index.php?route=product/product/review&product_id=<?php echo $product_id; ?>');

$('#button-review').on('click', function() {
	$.ajax({
		url: 'index.php?route=product/product/write&product_id=<?php echo $product_id; ?>',
		type: 'post',
		dataType: 'json',
		data: 'name=' + encodeURIComponent($('input[name=\'name\']').val()) + '&text=' + encodeURIComponent($('textarea[name=\'text\']').val()) + '&rating=' + encodeURIComponent($('input[name=\'rating\']:checked').val() ? $('input[name=\'rating\']:checked').val() : '') + '&captcha=' + encodeURIComponent($('input[name=\'captcha\']').val()),
		beforeSend: function() {
			$('#button-review').button('loading');
		},
		complete: function() {
			$('#button-review').button('reset');
			$('#captcha').attr('src', 'index.php?route=tool/captcha#'+new Date().getTime());
			$('input[name=\'captcha\']').val('');
		},
		success: function(json) {
			$('.alert-success, .alert-danger').remove();
			
			if (json['error']) {
				$('#review').after('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}
			
			if (json['success']) {
				$('#review').after('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');
				
				$('input[name=\'name\']').val('');
				$('textarea[name=\'text\']').val('');
				$('input[name=\'rating\']:checked').prop('checked', false);
				$('input[name=\'captcha\']').val('');
			}
		}
	});
});

$(document).ready(function() {
	$('.thumbnails').magnificPopup({
		type:'image',
		delegate: 'a',
		gallery: {
			enabled:true
		}
	});
});
//--></script> 
<?php echo $footer; ?>
<style type="text/css">
    .myyyyyy {
      display: inline-block;
      width: 500px;
      min-height: 765px;
      float: left;
    }
    .noneInsklad{
            font: 15px 'UbuntuBold' !important;
    border-radius: 3px;
    background-color: #660033;
    border: none;
    margin-left: 40px;
    height: 57px;
    width: 295px;
    color: #fefefe;
    float: left;
    }
</style>
