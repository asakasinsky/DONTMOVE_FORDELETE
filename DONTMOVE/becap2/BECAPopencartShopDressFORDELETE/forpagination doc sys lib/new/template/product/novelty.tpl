<?php echo $header; ?>

<section class="wrapperCatalog width">
    <div class="middleSlide_catalog">
        <div class="linkKorzina">
            <a href="<?php echo HTTP_SERVER; ?>">Главная</a>
            <?php foreach ($breadcrumbs as $breadcrumb) { ?>
            <a href="<?php echo $breadcrumb['href']; ?>" <? if (end($breadcrumbs) === $breadcrumb) echo 'class="boldKorzina"'; ?>><?php echo $breadcrumb['text']; ?></a>
            <? if (end($breadcrumbs) !== $breadcrumb) echo "<span>&nbsp;-&nbsp;</span>"; ?>
            <?php } ?>
        </div>
        
        <?php echo $column_left; ?>
        <?php echo $content_top; ?>
        <h1><?=$heading_title?></h1>

        <div class="tovarLine1" id="mfilter-content-container">
            <div class="wrapper wrappContent">
                <section class="content" id="content">
                    <?php
                    echo $content_bottom; ?>
                </section>
            </div><!-- .wrappContent -->
        </div>

</section>
<?php echo $footer; ?>
