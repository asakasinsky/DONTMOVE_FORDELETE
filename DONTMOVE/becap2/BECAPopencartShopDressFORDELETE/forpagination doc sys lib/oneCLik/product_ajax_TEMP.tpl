<div class="navModalSee">
    <img class="closeModalSee" src="<?php echo HTTP_THEME; ?>images/exitModal.png" alt="" onclick="closeModal()">
    <img class="leftArrowModal modalArrow" src="<?php echo HTTP_THEME; ?>images/leftArrow.png" alt="">
    <img class="rightArrowModal modalArrow" src="<?php echo HTTP_THEME; ?>images/rightArrow.png" alt="">
</div>				
<div class="go_to_prew_next">
    <div class="otlojiti_tovar2">
        <a href="#" class="imgOtlejeno2<? if($is_liked) echo ' likes_active' ?>" onclick="wishlist.add(<?php echo $product_id; ?>);">&nbsp;&nbsp;<?php echo $liked_text; ?></a>
    </div>
    <div class="reiting_tovar2">
        <div class="stars">
            <form action="">
            </form>
        </div><br>
        <a href="#">Читать комментарии</a>
    </div>
</div>
<img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>" title="<?php echo $heading_title; ?>" width="328" class="imgLeft2" active-image="1">
<div class="inform_kart4">
    <div class="textInform">
        <p class="platie"><?php echo $heading_title; ?></p>
        <p class="actia"><?php if ($special) { ?><del><?php echo $special; ?></del>&nbsp;&nbsp;&nbsp;&nbsp;<span><span class="saleProduct">-<? echo floor(100 - 100*$special/$price); ?>%</span>&nbsp;&nbsp;&nbsp;<?}?></span><i><?php echo $price; ?></i></p>
    </div>
    <div class="color_text_etc">
        <?php if ($attribute_groups) { ?>
            <?php foreach ($attribute_groups as $attribute_group) { ?>
              <?php foreach ($attribute_group['attribute'] as $attribute) { ?>
              <p class="colorsKart"><span><?php echo $attribute['name']; ?></span><?php echo $attribute['text']; ?></p>
              <?php } ?>
            <?php } ?>
        <?php } ?>
        <article><?php echo $description; ?></article>
    </div>
    <div class="magazine2">
        <div class="razmeri">
            <?php 
            if ($options) 
            foreach ($options as $option) { 
            ?>
            <?php if ($option['type'] == 'radio' && $option['required']) { $i=0; ?>
            <p><?php echo $option['name']; ?>:</p>
            <div id="option-<?php echo $option['product_option_id']; ?>" class="options-popup">
                <?php if (isset($option['product_option_value'])) foreach ($option['product_option_value'] as $option_value) { ?>
                <input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" style="display:none;" />
                <label class="option-popup" for="option-value-<?php echo $option_value['product_option_value_id']; ?>" data-addprice="<?php if ($option_value['price']) echo $option_value['price'];else echo 0; ?>" onclick="calc_price_catalog(this)"><?php echo $option_value['name']; ?></label>
                <?php 
                } ?>
            </div>
            <?php } ?>
            <?php }//foreach ?>
        </div>
        <div class="productSize_etc2">
            <button class="sizeOpredeliti">Определить размер</button>
            <div class="backgroundModal" onclick="closeModal()"></div>
            <div class="howRazmer">
                <button class="inchideRazmer" onclick="closeModal()"></button>
                <div class="cols">
                    <div class="grudi">
                        <p>ОБХВАТ ГРУДИ (СМ)</p>
                        <input type="nomer">
                    </div>
                    <div class="grudi">
                        <p>ОБХВАТ ГРУДИ (СМ)</p>
                        <input type="nomer">
                    </div>
                    <div class="grudi">
                        <p>ОБХВАТ ГРУДИ (СМ)</p>
                        <input type="nomer">
                    </div>
                    <button class="uznaiRazmer">УЗНАТЬ РАЗМЕР</button>
                </div>
                <p class="tvoiRazmer">ВАШ РАЗМЕР:<br><span>70</span></p>
            </div>
            <div class="click1">
                <div class="textClick">
                    <p class="textBot">КУПИТЬ В 1 КЛИК</p>
                    <form>
                        <input type="text" name="name" required="" placeholder="Ваше имя">
                        <input type="tel" required="" name="phone" placeholder="ТЕЛЕФОН">
                        <button class="sendClick">ОТПРАВИТЬ</button>
                    </form>
                </div>
                <button class="X" onclick="closeModal()"></button>
                <img src="<?php echo HTTP_THEME; ?>images/click1.png">
            </div>
            <div class="tableSizeModal" onclick="closeModal()">
                <img src="<?php echo HTTP_THEME; ?>images/table_size.png">
            </div>
        </div>
    </div>
    <div class="button_corzina_click">
        <div class="input-size-div" style="display: none;">

        </div>
        <div class="input-enter" style="display: none;">
            <p>Товар добавлен в корзину</p>
            <a href="/qcheckout">Перейти в корзину</a>
            <a href="">Продолжить покупки</a>
        </div>
        <button class="add_to_basket" onclick="cart.addToCartOptionsProduct('<?php echo $product_id; ?>', 1, $(this).closest('.modalBistrSee'), '.modalOptions');">ДОБАВИТЬ В КОРЗИНУ</button><br>
        <button class="buy">КУПИТЬ В 1 КЛИК</button>
        <div class="backgroundModalClick" onclick="closeModal()"></div>
    </div>
    <div class="img_modal_kartocica">
        <?php if ($thumb || $images) { ?>
            <?php if ($thumb) array_unshift($images, array("popup"=>$popup, "thumb"=>$thumb, "small"=>$small)); ?>
                <?php if(isset($images)){?>
                              <?php $i=1; ?>
                              <?php foreach($images as $photo){?>
                                  <?php if($i == 1):?>
                                  <?php $class = 'active'; ?>
                                  <?php else:  ?>
                                  <?php $class = ''; ?>
                                  <?php endif; ?>
                                  <a href="<?php echo $photo['popup']; ?>"><img order="<?php echo $i; ?>" <?php echo $class; ?> src="<?php echo $photo['small']; ?>" alt="<?php echo $heading_title; ?>" title="<?php echo $heading_title; ?>" /></a>
                              <?php $i++; ?>
                              <?php }?>
                <?php } ?>
        <?php } ?>
    </div>
    <div class="preimushestva2">
        <p>Преимущества</p>
    </div>
    <div class="social3">
        <a href="<?=end($breadcrumbs)['href'] ?>">Перейти на страницу товара</a>
    </div>
</div>

<script type="text/javascript">
    $('.img_modal_kartocica a ').hover(function(eventObject){
          if($('.modalBistrSee .imgLeft2').attr('src') != $(this).attr('href')){
          $('.modalBistrSee .imgLeft2').attr('src', $(this).attr('href'));
          $('.modalBistrSee .imgLeft2').attr('active-image', $(this).attr('order'));
          $('.modalBistrSee .imgLeft2').load(function(){
          $(this).show(0);
          });
        }
        eventObject.preventDefault();
      });
    $('.option-popup').on('click',  function(){
        $('.option-popup').removeClass('selected-option');
        $(this).addClass('selected-option');
        $(this).parent().find('[type=radio]').removeAttr('checked');
        $(this).prev('[type=radio]').attr('checked', 'checked');
    });
</script>