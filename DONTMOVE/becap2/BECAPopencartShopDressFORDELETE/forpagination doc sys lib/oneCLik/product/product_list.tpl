                    <?php if($products): ?>
                    <?php foreach ($products as $product) { ?>
                    <div class="tovar_number_1" order-product="<?php echo $product['product_id']; ?>">
                        <div class="positionNormale">
                            <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="bigImg"></a>
                        </div>
                        <div class="nume_price_catalog">
                            <p><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a><span><?php echo $product['special']; ?></span></p>
                        </div>
                        <div class="Otenka_catalog">
                            <div class="stars_catalog">
                                <input class="star star-5<? if ($product['rating'] == 5) echo ' checked'; ?>" id="star-5" type="radio" name="star">
                                <label class="star star-5" for="star-5"></label>
                                <input class="star star-4<? if ($product['rating'] == 4) echo ' checked'; ?>" id="star-4" type="radio" name="star">
                                <label class="star star-4" for="star-4"></label>
                                <input class="star star-3<? if ($product['rating'] == 3) echo ' checked'; ?>" id="star-3" type="radio" name="star" checked="checked">
                                <label class="star star-3" for="star-3"></label>
                                <input class="star star-2<? if ($product['rating'] == 2) echo ' checked'; ?>" id="star-2" type="radio" name="star">
                                <label class="star star-2" for="star-2"></label>
                                <input class="star star-1<? if ($product['rating'] == 1) echo ' checked'; ?>" id="star-1" type="radio" name="star">
                                <label class="star star-1" for="star-1"></label>
                            </div>
                            <p><span><?php echo $product['price']; ?></span></p>	
                        </div>
                        <div class="navMobileProduct">
                            <?php if(isset($product['images'][$product['product_id']])){?>
                                          <?php $i=1; ?>
                                          <?php foreach($product['images'][$product['product_id']] as $photo){?>
                                              <?php if($i == 1):?>
                                              <?php $class = 'class="active"'; ?>
                                              <?php else:  ?>
                                              <?php $class = 'class=""'; ?>
                                              <?php endif; ?>
                                              <a href="<?php echo $product['href']; ?>" <?php echo $class; ?> big-image="<?php echo $photo['big']; ?>" title="<?php echo $product['name']; ?>"></a>
                                          <?php $i++; ?>
                                          <?php }?>

                            <?php } else { ?>
                                        <a href="<?php echo $product['href']; ?>" class="active" big-image="<?php echo $product['thumb']; ?>" title="<?php echo $product['name']; ?>" /></a>
                            <?php } ?>
                        </div>
                        <div class="rightGallery">
                            <?php if(isset($product['images'][$product['product_id']])){?>
                                          <?php $i=1; ?>
                                          <?php foreach($product['images'][$product['product_id']] as $photo){?>
                                              <?php if($i == 1):?>
                                              <?php $class = 'class="active"'; ?>
                                              <?php else:  ?>
                                              <?php $class = 'class=""'; ?>
                                              <?php endif; ?>
                                              <img order-image="<?php echo $i; ?>" <?php echo $class; ?> src="<?php echo $photo["small"]; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" big-image="<?php echo $photo["big"]; ?>" />
                                          <?php $i++; ?>
                                          <?php }?>

                            <?php } else { ?>
                                <img width="43" order-image="1" class="activeImageProduct" src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="" />
                            <?php } ?>
                        </div>
                        <div class="bottomProduct">
                            <div>
                                <button class="button_block button4click" order-product="<?php echo $product['product_id']; ?>" onclick="cart.addToCartOptions('<?php echo $product['product_id']; ?>', 1, this);">в корзину</button>
                            </div>
                            <div class="option">
                                <?php 
                                $options = $product['options'];
                                if ($options) 
                                foreach ($options as $option) { 
                                ?>
                                <?php if ($option['type'] == 'radio' && $option['required']) { $i=0; ?>
                                <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
                                    <p class="titleSize"><?php echo $option['name']; ?>:</p>
                                    <?php if (isset($option['product_option_value'])) foreach ($option['product_option_value'] as $option_value) { ?>
                                    <input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" style="display:none;" />
                                    <span class="sizeProduct option-popup" for="option-value-<?php echo $option_value['product_option_value_id']; ?>" data-addprice="<?php if ($option_value['price']) echo $option_value['price'];else echo 0; ?>" onclick="calc_price_catalog(this)"><?php echo $option_value['name']; ?></span>
                                    <?php 
                                    } ?>
                                </div>
                                <br />
                                <?php } ?>
                                <?php }//foreach ?>
                            </div>
                            <div class="clear"></div>
                            <div class="otlojitiActiveProd" onclick="wishlist.add( <?php echo $product['product_id']; ?> );">ОТЛОЖИТЬ</div>
                        </div>
                        <button class="bistriiSee" data-id="<?php echo $product['product_id']; ?>" onclick="quickSee(this)">БЫСТРЫЙ ПРОСМОТР</button>
                    </div>

                    <?php } ?>
                    <?php endif; ?>
                    <div class="clear"></div>
                    <?php echo $pagination; ?>