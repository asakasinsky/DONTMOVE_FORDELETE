<div class="wrapper wrappFooter">
    <footer>
    <?php if ($informations) { ?>
    <div class="leftFooter">
    <?php foreach ($informations as $information) { ?>
        <a href="<?php echo $information['href']; ?>" title="<?php echo $information['title']; ?>"><?php echo $information['title']; ?></a>
    <?php } ?>
	<a href="<?=HTTP_SERVER?>faq" title="Вопрос/Ответ">Вопрос/Ответ</a>
    </div><!-- .leftFooter -->
    <?php } ?>
    <?php if ($logo) { ?>
      <a class="logoFooter" href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>"  />
        <span class="nameSite">TDEKOR.RU</span>
        <span class="descSite"><?php echo $name; ?></span>
      </a>
      <?php } else { ?>
      <h1><a class="logoHeader" href="<?php echo $home; ?>"><?php echo $name; ?></a></h1>
      <?php } ?>

      <div class="rightFooter">
          <div class="left-block-info">
              <span class="phoneNav"><?php //echo $telephone; ?></span>
              <span><?php echo $email; ?></span>
              <span><?php echo $address; ?></span>

          </div>
        <a href="<?=$account?>" title="Личный кабинет">Личный кабинет</a>
      </div><!-- .rightFooter -->
    </footer>

	<script>

    //$("#input-telephone").inputmask("7(999)999-99-99");

    $(document).ready(function () {

        $('#button-oneclick').on('click', function () {
            $('.alert, .text-danger').remove();

            var tel_number = $("#input-telephone").val();
            var product_id = $('input[name="product_id"]').val();

            var pattern = /^\+[1-9]{1}[0-9]{3,14}$/;

            if (pattern.test($("#input-telephone").val())) {
                $.ajax({
                    url: 'index.php?route=product/buyoneclick/oneclickadd',
                    type: 'post',
                    data: 'product_id=' + product_id + '&tel_number=' + tel_number,
                    dataType: 'json',
                    complete: function () {
                        $('#cart > button').button('reset');
                    },
                    success: function (json) {
                        if (json['redirect']) {
                            location = json['redirect'];
                        }

                        if (json['success']) {
                           $('.form-one-click-call').html('<label class="control-label" for="input-telephone">' + json['text_order_success'] + ' ' + json['code'] + '</label>');
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        //console.log(xhr.status);
                        //console.log(thrownError);
                        $('#content').parent().before('<div class="alert alert-danger"><i class="fa fa-minus-circle"></i>'+ xhr.responseText +' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
					}
                });
            }
            else {
                $('#content').parent().before('<div class="alert alert-danger"><i class="fa fa-minus-circle"></i> Телефонный номер неверен. Он должен состаять из цифр.<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
            }
        });

    });

</script>

  </div><!-- .wrappFooter -->
  <div class="backgroundModal hide" onclick="closeModal();"></div>
  <div class="modalWindow hide">
    <p class="titleModal">ТОВАР ДОБАВЛЕН В КОРЗИНУ</p>
    <img class="imageBuyModal" src="#" alt="productImage" width="245">
    <p class="infoPModal titleProdModal"><span></span></p>
    <p class="infoPModal descProductModal"></p>
    <br>
    <p class="infoPModal"></p>
    <p class="infoPModal sizeProd"></p>
    <div class="priceModal">
      <p></p>
      <span class="closeModalButton" onclick="closeModal();">Продолжить покупки</span>
      <a href="<?=HTTP_SERVER?>qcheckout" class="openBasketModal">Перейти в корзину</a>
    </div><!-- .priceModal -->
    <div class="clear"></div>
    <div style="padding-top: 5px;">
    </div>
    <div class="alsobought-container"></div>
  </div><!-- .modalWindow -->
<div id='up-btn'>&uarr; Вверх</div>
<script type="text/javascript">
  $('#up-btn').click(function(){
    $('html, body').animate({ scrollTop: 0 }, 'slow');
  });
</script>
</body></html>
<?php 
  if(!isset($_COOKIE['visitorKey'])){
    SetCookie("visitorKey",rand()); 
  }
?>