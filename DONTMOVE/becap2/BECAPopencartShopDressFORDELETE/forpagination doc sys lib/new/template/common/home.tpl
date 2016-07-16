<?php echo $header; ?>
<div class="container">
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <section class="wrapper4 width">
      		<div class="middleImg">
      		</div>
      	</section>
      	<section class="wrapper5 width">
      		<div class="middleSlide">
				<?php echo $content_bottom; ?>
                </div>


      		</div>
      	</section>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>