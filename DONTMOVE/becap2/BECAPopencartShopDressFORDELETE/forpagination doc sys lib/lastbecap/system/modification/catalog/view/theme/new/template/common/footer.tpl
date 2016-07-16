        <div class="backgroundModal2" onclick="closeModal()" ></div>
        <div class="modalOptions">
            <div class="navModalSee">
                <img class="closeModalSee" src="<?php echo HTTP_THEME; ?>images/exitModal.png" alt="" onclick="closeModal()">
            </div>
            <div class="options">
                    <p>Выберите размер:</p>
                    <div class="sizeProduct">
                            <input type="radio" name="option" value="3258">
                            <label data-addprice="0" class="option-popup">42</label>
                    </div>
            </div>
        </div>
        <div class="modalBistrSee">
            Информация о товаре загружается...
        </div>
        
<section class="forFooter width">
          <footer>
              <div class="cols1">
                  <h3>Каталог</h3>
                  <a href="#">Новинки</a><br>
                  <a href="#">Платья</a><br>
                  <a href="#">Блузы.топы</a><br>
                  <a href="#">Брюки,колготки</a><br>
                  <a href="#">Юбки</a><br>
                  <a href="#">Верхняя одежда</a><br>
                  <a href="#">Костюмы</a><br>
                  <a href="#">Купальники</a><br>
                  <a href="#">Аксессуары</a><br>
                  <a href="#">Большие размеры</a><br>
              </div>
              <div class="cols1">
                  <h3>СЕРВИС</h3>
                  <a href="<?=HTTP_SERVER?>/reviews">Ваши отзывы</a><br>
                  <a href="<?=HTTP_SERVER?>/faq">Ваши вопросы</a><br>
                  <a href="<?=HTTP_SERVER?>">Как заказать</a><br>
                  <a href="<?=HTTP_SERVER?>/delivery">Доставка</a><br>
                  <a href="<?=HTTP_SERVER?>/payment">Оплата</a><br>
                  <a href="<?=HTTP_SERVER?>/about_us">Контакты</a>
              </div>
              <div class="logo">
                  <p><img src="<?php echo HTTP_THEME; ?>images/logotype.png"></p>
                  <div class="social">
                      <a href="#"><img src="<?php echo HTTP_THEME; ?>images/vk.png" alt="ВКонтакте" ></a>
                      <a href="#"><img src="<?php echo HTTP_THEME; ?>images/facebook.png" alt="Facebook"></a>
                      <a href="#"><img src="<?php echo HTTP_THEME; ?>images/ok.png" alt="Odnoklassniki"></a>
                      <a href="#"><img src="<?php echo HTTP_THEME; ?>images/instagram.png" alt="Instagram"></a>
                  </div>
                  <div class="LogAut">
                      <?php if($is_logged) { ?>
                      					<a href="<?php echo $account; ?>"><?php echo $username; ?></a>
                      <?php } else { ?>
                      					<a href="<?php echo $login; ?>">ВХОД</a>
                      					<span>/</span>
                      					<a href="<?php echo $register; ?>">РЕГИСТРАЦИЯ</a>
                      <?php } ?>
                  </div>
              </div>
              <div class="contactFooter">
                  <p><?php echo $telephone; ?></p>
                  <button>ЗАКАЖИ ОБРАТНЫЙ ЗВОНОК</button>
              </div>
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

      </section>
</div>


</body></html>