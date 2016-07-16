<?php if($products): ?>
<div class="wrapper wrappContent">
    <section class="content">
     <?php foreach ($products as $product) { ?>
      
      <div class="product" order-product="<?php echo $product['product_id']; ?>">
        <div class="slideProduct">
          <div class="headerProduct">
            <? if($product['new_product']) {?><span class="newProduct">НОВИНКА</span><?}?>
            <?php if ($product['special']) { ?><span class="saleProduct"><? echo floor(100 - 100*$product['special']/$product['price']); ?>%</span><?}?>
            <span class="likeProduct<? if($product['is_liked']) echo ' likes_active' ?>" onclick="wishlist.add(<?php echo $product['product_id']; ?>);"></span>
          </div><!-- .headerProduct -->
          <?php if(isset($product['images'][$product['product_id']]) && count($product['images'][$product['product_id']]) > 1): ?>
          <div class="navSlideProduct">
            <span class="prevProduct" id="prevProduct"></span>
            <span class="nextProduct" id="nextProduct"></span>
          </div><!-- .navSlideProduct -->
          <?php endif; ?>
        <div class="imagesProduct">
         <?php if(isset($product['images'][$product['product_id']])){?>
           <?php $i=1; ?>
           <?php foreach($product['images'][$product['product_id']] as $photo){?>
               <?php if($i == 1):?>
               <?php $class = 'class="activeImageProduct"'; ?>
               <?php else:  ?>
               <?php $class = 'class=""'; ?>
               <?php endif; ?>
               <a href="<?php echo $product['href']; ?>"><img order-image="<?php echo $i; ?>" <?php echo $class; ?> src="<?php echo $photo; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="" /></a>
           <?php $i++; ?>
           <?php }?>
         
         <?php } else { ?>
         <a href="<?php echo $product['href']; ?>"><img order-image="1" class="activeImageProduct" src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="" /></a>
         <?php } ?>
         </div><!-- .imagesProduct -->
        </div><!-- .slideProduct -->
        <a href="<?php echo $product['href']; ?>" class="showMoreProduct">ПОДРОБНЕЕ</a>
        <button class="addToCartProduct" data-name='<?php echo $product['name']; ?>' onclick="cart.addToCartOptions('<?php echo $product['product_id']; ?>', 1, this);">В КОРЗИНУ</button>
        <div class="clear"></div>
        <a href="<?php echo $product['href']; ?>" class="titleProduct"><?php echo $product['name']; ?></a>
        <?php if ($product['price']) { ?>
        <p class="priceProduct">
          <?php if (!$product['special']) { ?>
           <span class="price"><price><?php echo $product['price']; ?></price></span>
           <input type="hidden" class="price0" value="<?php echo $product['price']; ?>"/>
          <?php } else { ?>
            <span class="priceOld"><?php echo $product['price']; ?></span>
           <span class="price"><price><?php echo $product['special']; ?></price></span>
           <input type="hidden" class="price0" value="<?php echo $product['special']; ?>"/>
           <input type="hidden" class="priceold0" value="<?php echo $product['price']; ?>"/>
          <?php } ?>
        </p>
        <?php } ?>
        <!-- .priceProduct -->
        <div class="sizesProduct">
			<?php 
			$options = $product['options'];
			if ($options) 
			foreach ($options as $option) { 
			?>
				<?php if ($option['type'] == 'radio' && $option['required']) { $i=0; ?>
				<div id="option-<?php echo $option['product_option_id']; ?>" class="option">
				  <p class="titleSizes"><?php echo $option['name']; ?>:</p>
				  <?php if (isset($option['product_option_value'])) foreach ($option['product_option_value'] as $option_value) { ?>
					  <input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" style="display:none;" />
					  <label for="option-value-<?php echo $option_value['product_option_value_id']; ?>" style="width:100px;" data-addprice="<?php if ($option_value['price']) echo $option_value['price'];else echo 0; ?>" onclick="calc_price_catalog(this)"><?php echo $option_value['name']; ?>

					  </label>
				  <?php 
				  //if($i%2 != 0) echo "<br>"; $i++;
				  } ?>
				</div>
				<br />
				<?php } ?>
			<?php }//foreach ?>
        </div><!-- .sizesProduct -->
      </div><!-- .product -->
      
      <?php } ?>
	  <div class="clear"></div>
	  <?php echo $pagination; ?>
	  <!-- .pstrNav -->
    </section>
</div>
<?php endif; ?>

<div class="fancybox-overlay fancybox-overlay-fixed" id="fancybox-options" style="width: auto; height: auto; display: none;">
    <div id="alert" style="width: 357px;height: 134px; background-color: #fb2b75; margin: 0 auto 0 -177px;position: absolute;top: 50%;left: 50%; padding: 5px; color: white;">
        <div id="alert-close" style="background:url(catalog/view/theme/<?php /*echo $this->config->get('config_template')*/ ?>/image/alert-close.png); width: 13px;cursor: pointer;float: right;height: 13px;"></div>
        <div style="padding: 34px 15px;">Пожалуйста, сделайте выбор параметра товара</div>
        <div id="alert-prod" style="font-weight: bold;padding: 0 15px;"></div>                        
    </div>
</div>