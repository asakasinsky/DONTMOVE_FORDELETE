      			<p class="populatTovar"><?php echo $heading_title; ?></p>
      			<div class="forSlide">
      				<div class="slide">
      					<ul class="bxslider">
  <?php foreach ($products as $product) { ?>
      					   <li>
      					  	<a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>"></a>
      					  	<p class="textOnPhotoSlide"><?php echo $product['name']; ?><br>
                                                    
                                                    <del><? if ($product['special']) echo $product['price'];?></del><span><? if ($product['special']) echo $product['special']; else echo $product['price'];?></span>
                                                </p>
      					  </li>
  <?php } ?>
      					</ul>
      				</div>
      			</div>
