<?php echo $header; ?>
<!--<script>
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
            }(document));</script>
<script type="text/javascript">
            rrApiOnReady.push(function() {
            try{ rrApi.view( <?php echo $product_id; ?> ); }
            catch (e) {}
            })
</script>-->

<section class="wrapper5 width">
    <div class="middleSlidekartocica">
        <div class="linkKorzina">
            <a href="<?php echo HTTP_SERVER; ?>">Главная</a>
            <?php foreach ($breadcrumbs as $breadcrumb) { ?>
            <a href="<?php echo $breadcrumb['href']; ?>" <? if (end($breadcrumbs) === $breadcrumb) echo 'class="boldKorzina"'; ?>><?php echo $breadcrumb['text']; ?></a>
            <? if (end($breadcrumbs) !== $breadcrumb) echo "<span>&nbsp;-&nbsp;</span>"; ?>
            <?php } ?>
        </div>
        <div class="kartocika">
            <div class="imgkartocika">
                <div class="imgLeft">
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
                                        <a href="<?php echo $photo['popup']; ?>" order="<?php echo $i; ?>"><img order="<?php echo $i; ?>" <?php echo $class; ?> src="<?php echo $photo['small']; ?>" alt="<?php echo $heading_title; ?>" title="<?php echo $heading_title; ?>" /></a>
                                    <?php $i++; ?>
                                    <?php }?>
                      <?php } ?>
                    <?php } ?>
                </div>
                <div class="imgLeftMobile">
                    <?php if(isset($images)){?>
                                    <?php $i=1; ?>
                                    <?php foreach($images as $photo){?>
                                        <?php if($i == 1):?>
                                        <?php $class = 'active'; ?>
                                        <?php else:  ?>
                                        <?php $class = ''; ?>
                                        <?php endif; ?>
                                        <a href="<?php echo $photo['popup']; ?>" order="<?php echo $i; ?>"><img order="<?php echo $i; ?>" <?php echo $class; ?> src="" alt="<?php echo $heading_title; ?>" title="<?php echo $heading_title; ?>" /></a>
                                    <?php $i++; ?>
                                    <?php }?>
                      <?php } ?>
                </div>
                <div class="bigKartocica fotorama" id="fotorama" data-auto="false" data-allowfullscreen="true" data-nav="false" data-navposition="right">
                    <?php if(isset($images)){?>
                        <?php $i=1; ?>
                        <?php foreach($images as $photo){?>
                    <img src="<?php echo $photo['popup']; ?>" alt="<?php echo $heading_title; ?>" title="<?php echo $heading_title; ?>" active-image="<?=$i?>" <? if ($i!=1) echo 'style="display:none"' ?>>
                    <?php $i++;
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="inform_kart">
                <div class="go_to_prew_next">
                    <button class="nazat">НАЗАД</button>
                    <button class="buttonNav button_prew" id="prew"><i class="aaddd"></i>Предыдущий товар</button>
                    <button class="buttonNav button_next" id="next">Следующий товар</button><br>
                    <img src="images/imgBigKartocika.png" alt="" width="182" class="prewTovarImg buttonImage" style="display: none;">
                    <img src="images/imgBigKartocika.png" alt="" width="182" class="nextTovarImg buttonImage" style="display: none;">
                    <div class="otlojiti_tovar">
                        <a href="#" class="imgOtlejeno2<? if($is_liked) echo ' likes_active' ?>" onclick="wishlist.add( < ?php echo $product_id; ? > );">&nbsp;&nbsp;<?php echo $liked_text; ?></a>
                    </div>
                    <div class="reiting_tovar">
                        <div class="stars">
                            <form action="">
                                <input class="star star-5<? if ($rating == 5) echo ' checked'; ?>" id="star-51" type="radio" name="star">
                                <label class="star star-5" for="star-51"></label>
                                <input class="star star-4<? if ($rating == 4) echo ' checked'; ?>" id="star-41" type="radio" name="star">
                                <label class="star star-4" for="star-41"></label>
                                <input class="star star-3<? if ($rating == 3) echo ' checked'; ?>" id="star-31" type="radio" name="star" checked="checked">
                                <label class="star star-3" for="star-31"></label>
                                <input class="star star-2<? if ($rating == 2) echo ' checked'; ?>" id="star-21" type="radio" name="star">
                                <label class="star star-2" for="star-21"></label>
                                <input class="star star-1<? if ($rating == 1) echo ' checked'; ?>" id="star-11" type="radio" name="star">
                                <label class="star star-1" for="star-11"></label>
                            </form>
                        </div><br>
                        <a href="#formOtziv">Читать комментарии</a>
                    </div>
                </div>
                <div class="textInform">
                    <h1 class="platie"><?php echo $heading_title; ?></h1>
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
                <div class="magazine" order-product="<?php echo $product_id; ?>">
                    <div class="razmeri">
                        <!--<div class="sizeProduct option">
                                <p class="titleSize">Выберите размеры:</p>
                                <input type="radio" name="option" value="3258" style="display:none;">
                                <label class="sizeProduct option-popup" data-addprice="0">42</label>
                        </div>-->
                        <?php 
                        if ($options) 
                        foreach ($options as $option) { 
                        ?>
                        <?php if ($option['type'] == 'radio' && $option['required']) { $i=0; ?>
                        <span class="eslineVibran">
                            <p class="viberiRazmerText"><?php echo $option['name']; ?>:</p>
                        </span>
                        <div id="option-<?php echo $option['product_option_id']; ?>" class="options-popup option">
                            <p class="titleSize"><?php echo $option['name']; ?>:</p>
                            <?php if (isset($option['product_option_value'])) foreach ($option['product_option_value'] as $option_value) { ?>
                            <input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" style="display:none;" />
                            <label class="option-popup" for="option-value-<?php echo $option_value['product_option_value_id']; ?>" data-addprice="<?php if ($option_value['price']) echo $option_value['price'];else echo 0; ?>" onclick="calc_price_catalog(this)"><?php echo $option_value['name']; ?></label>
                            <?php 
                            } ?>
                        </div>
                        <?php } ?>
                        <?php }//foreach ?>
                    </div>
                    <div class="productSize_etc">
                        <button class="sizeOpredeliti">Определить размер</button>
                        <button class="tableOpredeliti">Таблица размеров</button>
                        <div class="backgroundModal" onclick="closeModal()"></div>
                        <!--<div class="modalOptions">
                            <div class="navModalSee">
                                <img class="closeModalSee" src="images/exitModal.png" alt="" onclick="closeModal()">
                            </div>
                            <div class="options">
                                <p>Выберите размер:</p>
                                <div class="sizeProduct">
                                </div>
                            </div>
                        </div>-->
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
                                    <input type="text" name="name1click" required="" placeholder="Ваше имя">
                                    <input type="tel" required="" name="phone" placeholder="ТЕЛЕФОН">
                                    <button class="sendClick">ОТПРАВИТЬ</button>
                                </form>
                            </div>
                            <button class="X" onclick="closeModal()"></button>
                            <img src="images/click1.png">
                        </div>
                        <div class="backgroundModal" onclick="closeModal()"></div>
                        <div class="tableSizeModal">
                            <button class="inchideRazmer" onclick="closeModal()"></button>
                            <img src="images/table_size.png">
                        </div>
                    </div>
                </div>
                <div class="button_corzina_click">
                    <div class="input-size-div options" style="display: none;">
                        <p>Выберите размер:</p>
                        <ul>
                            <li class="option-popup2">42</li>
                        </ul>
                    </div>
                    <button id="add_to_basket" class="add_to_basket button4click" onclick="">ДОБАВИТЬ В КОРЗИНУ</button><br>
                    <button class="buy">КУПИТЬ В 1 КЛИК</button>
                    <div class="backgroundModalClick" onclick="closeModal()"></div>
                </div>
                <div class="preimushestva">
                    <p>Преимущества</p>
                </div>
                <div class="button_corzina_click32">
                    <button class="add_to_basket">ДОБАВИТЬ В КОРЗИНУ</button><br>
                    <button class="buy2">КУПИТЬ В 1 КЛИК</button>
                    <div class="backgroundModalClick" onclick="closeModal()"></div>
                </div>
                <div class="social2">
                    <a href="#"><img src="<?=HTTP_THEME?>images/vk.png" alt="ВКонтакте"></a>
                    <a href="#"><img src="<?=HTTP_THEME?>images/facebook.png" alt="Facebook"></a>
                    <a href="#"><img src="<?=HTTP_THEME?>images/ok.png" alt="Odnoklassniki"></a>
                    <a href="#"><img src="<?=HTTP_THEME?>images/instagrams.png" alt="Instagram"></a>
                </div>
            </div>
        </div>
        <div class="formOtziv"><a id="formOtziv"></a>
            <div class="rowsOtziv">
                <div class="otzivSend">
                    <p>Отзывы:</p>
                    <button class="grayButton">НАПИСАТЬ</button>
                </div>
                <div class="formSend_otziv">
                    <form>
                        <p>* Ваше имя:</p>
                        <input type="text" name="name" value="" id="input-name" required="">
                        <p class="coment">* Комментарий:</p>
                        <textarea name="text" id="input-review"></textarea><br>
                        <div class="reiting_otziv">
                            <span>* Ваша оценка:</span><br>
                            <div class="stars">						  
                                <input class="star star-5" id="star-5" type="radio" name="rating" value="5">
                                <label class="star star-5" for="star-5"></label>
                                <input class="star star-4" id="star-4" type="radio" name="rating" value="4">
                                <label class="star star-4" for="star-4"></label>
                                <input class="star star-3" id="star-3" type="radio" name="rating" value="3">
                                <label class="star star-3" for="star-3"></label>
                                <input class="star star-2" id="star-2" type="radio" name="rating" value="2">
                                <label class="star star-2" for="star-2"></label>
                                <input class="star star-1" id="star-1" type="radio" name="rating" value="1">
                                <label class="star star-1" for="star-1"></label>
                            </div>
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
                        
                        <button id="button-review" data-loading-text="<?php echo $text_loading; ?>" class="grayButtonOtpraviti">ОТПРАВИТЬ</button>
                    </form>
                </div>
            </div>
            <div id="review"></div>
            
        </div>
    </div>
    <div class="slide">
        <p class="populatTovar2">Похожие товары</p>
        <div class="slide_otziv">
            <div class="bx-wrapper" style="max-width: 100%;"><div class="bx-viewport" style="width: 100%; overflow: hidden; position: relative; height: 326px;"><ul class="bxslider" style="width: 1215%; position: relative; transition-duration: 0s; transform: translate3d(-2100px, 0px, 0px);"><li style="float: left; list-style: none; position: relative; width: 1064px;" class="bx-clone">
                            <a href=""><img src="images/pic1.png" width="190" height="323"></a>
                            <p class="textOnPhotoSlide">Платье<br>2017 р.<span></span></p>
                        </li><li style="float: left; list-style: none; position: relative; width: 1064px;" class="bx-clone">
                            <a href=""><img src="images/pic2.png" width="190" height="323"></a>
                            <p class="textOnPhotoSlide">Платье<br><del>6000 р.</del><span>4500 р</span></p>
                        </li><li style="float: left; list-style: none; position: relative; width: 1064px;" class="bx-clone">
                            <a href=""><img src="images/pic3.png" width="190" height="323"></a>
                            <p class="textOnPhotoSlide">Платье<br>3000 р.<span></span></p>
                        </li><li style="float: left; list-style: none; position: relative; width: 1064px;" class="bx-clone">
                            <a href=""><img src="images/pic4.png" width="190" height="323"></a>
                            <p class="textOnPhotoSlide">Платье<br>3000 р.<span></span></p>
                        </li><li style="float: left; list-style: none; position: relative; width: 1064px;" class="bx-clone">
                            <a href=""><img src="images/pic5.png" width="190" height="323"></a>
                            <p class="textOnPhotoSlide">Платье<br>2017 р.<span></span></p>
                        </li><li style="float: left; list-style: none; position: relative; width: 1064px;" class="bx-clone">
                            <a href=""><img src="images/pic1.png" width="190" height="323"></a>
                            <p class="textOnPhotoSlide">Платье<br>2017 р.<span></span></p>
                        </li><li style="float: left; list-style: none; position: relative; width: 1064px;" class="bx-clone">
                            <a href=""><img src="images/pic2.png" width="190" height="323"></a>
                            <p class="textOnPhotoSlide">Платье<br><del>6000 р.</del><span>4500 р</span></p>
                        </li><li style="float: left; list-style: none; position: relative; width: 1064px;" class="bx-clone">
                            <a href=""><img src="images/pic3.png" width="190" height="323"></a>
                            <p class="textOnPhotoSlide">Платье<br>3000 р.<span></span></p>
                        </li><li style="float: left; list-style: none; position: relative; width: 1064px;" class="bx-clone">
                            <a href=""><img src="images/pic4.png" width="190" height="323"></a>
                            <p class="textOnPhotoSlide">Платье<br>3000 р.<span></span></p>
                        </li><li style="float: left; list-style: none; position: relative; width: 1064px;" class="bx-clone">
                            <a href=""><img src="images/pic5.png" width="190" height="323"></a>
                            <p class="textOnPhotoSlide">Платье<br>2017 р.<span></span></p>
                        </li>
                        <li style="float: left; list-style: none; position: relative; width: 1064px;">
                            <a href=""><img src="images/pic1.png" width="190" height="323"></a>
                            <p class="textOnPhotoSlide">Платье<br>2017 р.<span></span></p>
                        </li>
                        <li style="float: left; list-style: none; position: relative; width: 1064px;">
                            <a href=""><img src="images/pic2.png" width="190" height="323"></a>
                            <p class="textOnPhotoSlide">Платье<br><del>6000 р.</del><span>4500 р</span></p>
                        </li>
                        <li style="float: left; list-style: none; position: relative; width: 1064px;">
                            <a href=""><img src="images/pic3.png" width="190" height="323"></a>
                            <p class="textOnPhotoSlide">Платье<br>3000 р.<span></span></p>
                        </li>
                        <li style="float: left; list-style: none; position: relative; width: 1064px;">
                            <a href=""><img src="images/pic4.png" width="190" height="323"></a>
                            <p class="textOnPhotoSlide">Платье<br>3000 р.<span></span></p>
                        </li>
                        <li style="float: left; list-style: none; position: relative; width: 1064px;">
                            <a href=""><img src="images/pic5.png" width="190" height="323"></a>
                            <p class="textOnPhotoSlide">Платье<br>2017 р.<span></span></p>
                        </li>
                        <li style="float: left; list-style: none; position: relative; width: 1064px;">
                            <a href=""><img src="images/pic1.png" width="190" height="323"></a>
                            <p class="textOnPhotoSlide">Платье<br>2017 р.<span></span></p>
                        </li>
                        <li style="float: left; list-style: none; position: relative; width: 1064px;">
                            <a href=""><img src="images/pic2.png" width="190" height="323"></a>
                            <p class="textOnPhotoSlide">Платье<br><del>6000 р.</del><span>4500 р</span></p>
                        </li>
                        <li style="float: left; list-style: none; position: relative; width: 1064px;">
                            <a href=""><img src="images/pic3.png" width="190" height="323"></a>
                            <p class="textOnPhotoSlide">Платье<br>3000 р.<span></span></p>
                        </li>
                        <li style="float: left; list-style: none; position: relative; width: 1064px;">
                            <a href=""><img src="images/pic4.png" width="190" height="323"></a>
                            <p class="textOnPhotoSlide">Платье<br>3000 р.<span></span></p>
                        </li>
                        <li style="float: left; list-style: none; position: relative; width: 1064px;">
                            <a href=""><img src="images/pic5.png" width="190" height="323"></a>
                            <p class="textOnPhotoSlide">Платье<br>2017 р.<span></span></p>
                        </li>
                        <li style="float: left; list-style: none; position: relative; width: 1064px;" class="bx-clone">
                            <a href=""><img src="images/pic1.png" width="190" height="323"></a>
                            <p class="textOnPhotoSlide">Платье<br>2017 р.<span></span></p>
                        </li><li style="float: left; list-style: none; position: relative; width: 1064px;" class="bx-clone">
                            <a href=""><img src="images/pic2.png" width="190" height="323"></a>
                            <p class="textOnPhotoSlide">Платье<br><del>6000 р.</del><span>4500 р</span></p>
                        </li><li style="float: left; list-style: none; position: relative; width: 1064px;" class="bx-clone">
                            <a href=""><img src="images/pic3.png" width="190" height="323"></a>
                            <p class="textOnPhotoSlide">Платье<br>3000 р.<span></span></p>
                        </li><li style="float: left; list-style: none; position: relative; width: 1064px;" class="bx-clone">
                            <a href=""><img src="images/pic4.png" width="190" height="323"></a>
                            <p class="textOnPhotoSlide">Платье<br>3000 р.<span></span></p>
                        </li><li style="float: left; list-style: none; position: relative; width: 1064px;" class="bx-clone">
                            <a href=""><img src="images/pic5.png" width="190" height="323"></a>
                            <p class="textOnPhotoSlide">Платье<br>2017 р.<span></span></p>
                        </li><li style="float: left; list-style: none; position: relative; width: 1064px;" class="bx-clone">
                            <a href=""><img src="images/pic1.png" width="190" height="323"></a>
                            <p class="textOnPhotoSlide">Платье<br>2017 р.<span></span></p>
                        </li><li style="float: left; list-style: none; position: relative; width: 1064px;" class="bx-clone">
                            <a href=""><img src="images/pic2.png" width="190" height="323"></a>
                            <p class="textOnPhotoSlide">Платье<br><del>6000 р.</del><span>4500 р</span></p>
                        </li><li style="float: left; list-style: none; position: relative; width: 1064px;" class="bx-clone">
                            <a href=""><img src="images/pic3.png" width="190" height="323"></a>
                            <p class="textOnPhotoSlide">Платье<br>3000 р.<span></span></p>
                        </li><li style="float: left; list-style: none; position: relative; width: 1064px;" class="bx-clone">
                            <a href=""><img src="images/pic4.png" width="190" height="323"></a>
                            <p class="textOnPhotoSlide">Платье<br>3000 р.<span></span></p>
                        </li><li style="float: left; list-style: none; position: relative; width: 1064px;" class="bx-clone">
                            <a href=""><img src="images/pic5.png" width="190" height="323"></a>
                            <p class="textOnPhotoSlide">Платье<br>2017 р.<span></span></p>
                        </li></ul></div><div class="bx-controls bx-has-pager bx-has-controls-direction"><div class="bx-pager bx-default-pager"><div class="bx-pager-item"><a href="" data-slide-index="0" class="bx-pager-link active">1</a></div><div class="bx-pager-item"><a href="" data-slide-index="1" class="bx-pager-link">2</a></div><div class="bx-pager-item"><a href="" data-slide-index="2" class="bx-pager-link">3</a></div><div class="bx-pager-item"><a href="" data-slide-index="3" class="bx-pager-link">4</a></div><div class="bx-pager-item"><a href="" data-slide-index="4" class="bx-pager-link">5</a></div><div class="bx-pager-item"><a href="" data-slide-index="5" class="bx-pager-link">6</a></div><div class="bx-pager-item"><a href="" data-slide-index="6" class="bx-pager-link">7</a></div><div class="bx-pager-item"><a href="" data-slide-index="7" class="bx-pager-link">8</a></div><div class="bx-pager-item"><a href="" data-slide-index="8" class="bx-pager-link">9</a></div><div class="bx-pager-item"><a href="" data-slide-index="9" class="bx-pager-link">10</a></div></div><div class="bx-controls-direction"><a class="bx-prev" href="">Prev</a><a class="bx-next" href="">Next</a></div></div></div>
        </div>
    </div>
</section>

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
            $('.reiting_otziv label').on('click', function() {
                $(this).parent().find('[type=radio]').removeClass('checked');
                $(this).prev('[type=radio]').addClass('checked');
            });
            $('#button-review').on('click', function() {
                $.ajax({
                        url: 'index.php?route=product/product/write&product_id=<?php echo $product_id; ?>',
                        type: 'post',
                        dataType: 'json',
                        data: 'name=' + encodeURIComponent($('input[name=\'name\']').val()) + '&text=' + encodeURIComponent($('textarea[name=\'text\']').val()) + '&rating=' + encodeURIComponent($('input[name=\'rating\']:checked').val() ? $('input[name=\'rating\']:checked').val() : '') + '&captcha=' + encodeURIComponent($('input[name=\'captcha\']').val()),
                        /*beforeSend: function() {
                        $('#button-review').button('loading');
                        },*/
                        complete: function() {
                        /*$('#button-review').button('reset');*/
                        $('#captcha').attr('src', 'index.php?route=tool/captcha#' + new Date().getTime());
                        $('input[name=\'captcha\']').val('');
                        return false;
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
                return false;
            });
            $('.button_corzina_click .add_to_basket').on('click', function(){
            if ($(window).width() >= 1170) {
                //$(this).parent().find('.input-size-div').show();
                cart.addToCartOptionsProduct('<?php echo $product_id; ?>', 1, $(this).closest('.inform_kart'), '.input-size-div');
            }
            else {
                cart.addToCartOptionsProduct('<?php echo $product_id; ?>', 1, $(this).closest('.inform_kart'), '.modalOptions');
            }
            });
            $(document).ready(function() {
                $('.thumbnails').magnificPopup({
                        type:'image',
                        delegate: 'a',
                        gallery: {
                        enabled:true
                        }
                });
                
                // 1. Initialize fotorama manually.
                var $fotoramaDiv = $('#fotorama').fotorama();

                // 2. Get the API object.
                var fotorama = $fotoramaDiv.data('fotorama');
                $('.imgLeft a ').hover(function(eventObject){
                 fotorama.show($(this).attr('order') - 1);
                 eventObject.preventDefault();
             });
            });
//--></script>
<style type="text/css">
    .myyyyyy {
        display: inline-block;
        width: 500px;
        height: 765px;
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

<?php echo $footer; ?>
