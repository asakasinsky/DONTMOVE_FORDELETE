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
      </section>
</div>


</body></html>