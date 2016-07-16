<?php echo $header; ?>
<div class="container">
      <div class="breadСrumbs">
        <a href="<?php echo HTTP_SERVER; ?>">Главная</a>
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
            <a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
            <? if (end($breadcrumbs) !== $breadcrumb) echo "<span> > </span>"; ?>
        <?php } ?>
      </div><!-- .breadСrumbs -->
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h1><?php echo $heading_title; ?></h1>
      <?php echo $text_message; ?>
      <div class="buttons">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
      </div>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; 
if (isset($order_id)) {
?>
<script type="text/javascript">
rrApiOnReady.push(function() {
    try{ 
        rrApi.order({
            transaction: <?php echo $order_id; ?>,
            items: [
                <?php foreach ($items as $item) { ?>
                    { 
                        id: <?php echo $item['product_id']; ?>, 
                        qnt: <?php echo $item['quantity'];?>,
                        price: <?php echo $item['price']; ?>
                    }
                <?php if (!($item == $last_item)) { ?>,<?php } ?>
                <?php } ?>
            ]
        });
    } catch(e) {}
})
</script>
<? } ?>