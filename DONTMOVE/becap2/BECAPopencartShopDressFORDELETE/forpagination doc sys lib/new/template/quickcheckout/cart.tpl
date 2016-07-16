    <div class="title_number">
            <p>№</p>
            <p>Название</p>
            <p>Количество</p>
            <p>Цена</p>
            <p>Сумма</p>
    </div>
        
    <?php if ($products || $vouchers) { $i=0; ?>
	<?php foreach ($products as $product) { $i++; ?>
            <div class="Tovar_Number_1">
                    <p class="Nomer"><?=$i?></p>
                    <?php if ($product['thumb']) { ?>
                    <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="image_girl_corzina" /></a>
                    <?php } ?>
                    <p class="name"><a href="<?php echo $product['href']; ?>" class="titleProductBasket"><?php echo $product['name']; ?></a><br>
                        <?php foreach ($product['option'] as $option) { ?>
                        <?php echo $option['name']; ?>: <?php echo $option['value']; ?><br />
                        <?php } ?>
                      <?php if ($product['reward']) { ?>
                      <br />
                      <small><?php echo $product['reward']; ?></small>
                      <?php } ?>
                      <?php if ($product['recurring']) { ?>
                      <br />
                      <span class="label label-info"><?php echo $text_recurring_item; ?></span> <small><?php echo $product['recurring']; ?></small>
                      <?php } ?>
                    </p>
                    <div class="countProdBasket">
                      <img class="controlCount button-update" id="removeCountBasket" src="catalog/view/theme/tdekor/img/removeCountBasket.png" alt="controlCount">

                        <?php if ($edit_cart) { ?>
                              <input type="hidden" name="quantity[<?php echo $product['key']; ?>]" size="1" value="<?php echo $product['quantity']; ?>" class="form-control hidden-quantity" />
                                <span id="countProdBasket"><?php echo $product['quantity']; ?></span>
                        <?php } else { ?>
                        x&nbsp;<?php echo $product['quantity']; ?>
                        <?php } ?>
                      <img class="controlCount button-update" id="addCountBasket" src="catalog/view/theme/tdekor/img/addCountBasket.png" alt="controlCount">
                    </div>
                    <p class="price"><span><del></del></span><br><?php echo $product['price']; ?></p>
                    <p class="summa"><?php echo $product['total']; ?></p>
                    <button class="close_corzina deleteFromBasket button-remove" data-remove="<?php echo $product['key']; ?>"></button>
            </div>

        <?php } ?>
    <?php } ?>
        
        <?php foreach ($totals as $total) { ?>
        <div id="<?if($total['title'] == 'Сумма') echo 'totalPriceSumm'; elseif($total['title'] == 'Итого') echo 'totalPrice';?>" class="zakazati">
            <p><?php echo $total['title']; ?>: <span><?php echo $total['text']; ?></span></p>
        </div>
        <?}?>
        <div style="padding-top: 5px;text-align:right;width: 50%; float: right;">
            <div><b style="font-size: 17px">Стоимость доставки рассчитывается по тарифам почты России.</b></div>
            * Наш оператор позвонит Вам и сообщит общую стоимость заказа вместе с доставкой. Стоимость доставки зависит от отдаленности региона и габарита груза.
        </div>
        <div class="clear"></div>
       
        <script type="text/javascript">
	$(".controlCount").on("click", function () {
		var thisId = $(this).attr("id");
		if(thisId == "addCountBasket") {
			var countProdBasket = $(this).parent();
			var thisCount = parseInt(countProdBasket.children("#countProdBasket").html());
			countProdBasket.children("#countProdBasket").html(thisCount+1);
                        countProdBasket.children(".hidden-quantity").html(thisCount+1);
                        countProdBasket.children(".hidden-quantity").val(thisCount+1);
			var thisPrice = parseInt(countProdBasket.parent().children(".finalPriceProductBasket").html());
			var priceUnit = parseInt(countProdBasket.parent().children(".priceProductBasket").children("span").html());
			countProdBasket.parent().children(".finalPriceProductBasket").html(thisPrice+priceUnit+" руб.");
			var totalPrice = parseInt($("#totalPrice span").html());
			$("#totalPrice span").html(totalPrice+priceUnit+" руб.");
			var totalPriceSumm = parseInt($("#totalPriceSumm span").html());
			$("#totalPriceSumm span").html(totalPriceSumm+priceUnit+" руб.");
		}else if(thisId == "removeCountBasket") {
			var countProdBasket = $(this).parent();
			var thisCount = parseInt(countProdBasket.children("#countProdBasket").html());
			if(thisCount >= 2) {
				countProdBasket.children("#countProdBasket").html(thisCount-1);
                                countProdBasket.children(".hidden-quantity").html(thisCount-1);
                                countProdBasket.children(".hidden-quantity").val(thisCount-1);
				var thisPrice = parseInt(countProdBasket.parent().children(".finalPriceProductBasket").html());
				var priceUnit = parseInt(countProdBasket.parent().children(".priceProductBasket").children("span").html());
				countProdBasket.parent().children(".finalPriceProductBasket").html(thisPrice-priceUnit+" руб.");
				var totalPrice = parseInt($("#totalPrice span").html());
				$("#totalPrice span").html(totalPrice-priceUnit+" руб.");
				var totalPriceSumm = parseInt($("#totalPriceSumm span").html());
				$("#totalPriceSumm span").html(totalPriceSumm-priceUnit+" руб.");
			}
		}
	});
        </script>