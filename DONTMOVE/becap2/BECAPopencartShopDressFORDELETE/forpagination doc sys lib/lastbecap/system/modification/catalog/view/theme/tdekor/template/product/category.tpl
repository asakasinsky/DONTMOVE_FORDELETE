<?php echo $header; ?><?php if( ! empty( $mfilter_json ) ) { echo '<div id="mfilter-json" style="display:none">' . base64_encode( $mfilter_json ) . '</div>'; } ?><?php if( ! empty( $mfilter_json ) ) { echo '<div id="mfilter-json" style="display:none">' . base64_encode( $mfilter_json ) . '</div>'; } ?>
<div class="wrapper wrappFilters">
    <section>
      <div class="breadСrumbs">
        <a href="<?php echo HTTP_SERVER; ?>">Главная</a>
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
            <a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
            <? if (end($breadcrumbs) !== $breadcrumb) echo "<span> > </span>"; ?>
        <?php } ?>
      </div><!-- .breadСrumbs -->
      <?php echo $column_left; ?>
      <?php echo $content_top; ?>
      <h1><?=$heading_title?></h1>
      <div><?=$description?></div>
    </section>
</div><!-- .wrappFilters -->

<div id="mfilter-content-container">
 <div class="wrapper wrappContent">

    <section class="content" id="content">
    <?php
    if (!empty($this->request->get['path'])) {
        $parts = explode('_', $this->request->get['path']);
        $category_id = end($parts);
    }
    if (isset($category_id)) {
    ?>
    <script type="text/javascript">
        rrApiOnReady.push(function() {
            try { rrApi.categoryView(<?php echo $category_id;?>); } catch(e) {}
        })
    </script>
    <? } ?>

      <?php if($products): ?>
      <?php foreach ($products as $product) { ?>
      
      <div class="product product-list" order-product="<?php echo $product['product_id']; ?>">
        <div class="slideProduct">
          <div class="headerProduct">
            <? if($product['new_product']) {?><span class="newProduct">НОВИНКА</span><?}?>
            <?php if ($product['special']) { ?><span class="saleProduct"><? echo floor(100 - 100*$product['special']/$product['price']); ?>%</span><?}?>
            <span class="likeProduct" onclick="wishlist.add(<?php echo $product['product_id']; ?>);"></span>
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
               <?php $class = 'class="="'; ?>
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
          <?php if ($product['tax']) { ?>
          <span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
          <?php } ?>
        </p>
        <?php } ?>
        
        
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
      <?php endif; ?>
      <div class="clear"></div>
      <?php echo $pagination; ?>
       <div><?=$bottom_description;?></div>
    </section>
  </div><!-- .wrappContent -->
</div>
<?php echo $content_bottom; ?>
<?php echo $footer; ?>
