<?php echo $header; ?><?php if( ! empty( $mfilter_json ) ) { echo '<div id="mfilter-json" style="display:none">' . base64_encode( $mfilter_json ) . '</div>'; } ?>
<?php if( ! empty( $mfilter_json ) ) { echo '<div id="mfilter-json" style="display:none">' . base64_encode( $mfilter_json ) . '</div>'; } ?>

<section class="wrapperCatalog width">
    <div class="middleSlide_catalog">
        <div class="linkKorzina">
            <a href="<?php echo HTTP_SERVER; ?>">Главная</a>
            <?php foreach ($breadcrumbs as $breadcrumb) { ?>
            <a href="<?php echo $breadcrumb['href']; ?>" <? if (end($breadcrumbs) === $breadcrumb) echo 'class="boldKorzina"'; ?>><?php echo $breadcrumb['text']; ?></a>
            <? if (end($breadcrumbs) !== $breadcrumb) echo "<span>&nbsp;-&nbsp;</span>"; ?>
            <?php } ?>
        </div>
        
        <h1><?=$heading_title?></h1>
        <?php echo $column_left; ?>
        <?php echo $content_top; ?>
        <div><?=$description?></div>

        <div class="tovarLine1" id="mfilter-content-container">
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
                        try { rrApi.categoryView( < ?php echo $category_id; ? > ); } catch (e) {}
                        })
                    </script>
                    <? } ?>
                    <? include_once(DIR_TEMPLATE . "new/template/product/product_list.tpl"); ?>
                    <div><?=$bottom_description;?></div>
                </section>
            </div><!-- .wrappContent -->
        </div>

</section>
<script type="text/javascript">
    $(document).ready(function(){
        $(".tovar_number_1").hover(function () {
          $(this).addClass("openProdus");
         }, function () {
          $(this).removeClass("openProdus");
         });
     });
</script>
<?php echo $content_bottom; ?>
<?php echo $footer; ?>
