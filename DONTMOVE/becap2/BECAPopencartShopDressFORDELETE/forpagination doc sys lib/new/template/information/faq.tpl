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
      <?php echo $content_bottom; ?>

    </div>
    <?php echo $column_right; ?></div>

</div>
<style type="text/css">
.wrapper-otziv {
    width: 553px;
    float: left;
    border: 1px solid #333333;
    position: relative;
    margin-bottom: 30px;
    margin-right: 30px;
    margin-left: 15px;

}
.title {
    margin-left: -1px;
    padding: 4px 0;
    display: block;
    width: 555px;
    color: #fefefe;
    overflow: hidden;
    background-color: #993333;
    text-indent: 9px;
}
.text{
    color: #3a3a3a;
    font-size: 14px;
    line-height: 14px;
    padding: 5px;
    background-color: #EAEAEA;
    border-left: 5px solid #330000;
    display: block;
}
.zagolovok1{
      color: #3c1115;
    font: 24px "UbuntuBold";
    padding-left: 20px;
}
</style>
<?php echo $footer; ?>
