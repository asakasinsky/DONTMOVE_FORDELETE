<?php if ($reviews) { ?>
<?php foreach ($reviews as $review) { ?>
            <div class="comentsForm">
                <p><?php echo $review['author']; ?>     <?php echo $review['date_added']; ?></p>
                <span>
                    <?php echo $review['text']; ?>
                </span>
                <?php for ($i = 1; $i <= 5; $i++) { ?>
                <?php if ($review['rating'] < $i) { ?>
                <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
                <?php } else { ?>
                <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                <?php } ?>
                <?php } ?>
            </div>
<?php } ?>
<div class="text-right"><?php echo $pagination; ?></div>
<?php } else { ?>
<div class="comentsForm"><p><?php echo $text_no_reviews; ?></p></div>
<?php } ?>
