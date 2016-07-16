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
                    <label class="control-label" for="input-search"><?php echo $entry_search; ?></label>
                    <div class="row">
                        <input type="text" name="search" value="<?php echo $search; ?>" placeholder="<?php echo $text_keyword; ?>" id="input-search" class="" />
                        <select name="category_id" class="form-control" style="width: 50%;">
                          <option value="0"><?php echo $text_category; ?></option>
                          <?php foreach ($categories as $category_1) { ?>
                          <?php if ($category_1['category_id'] == $category_id) { ?>
                          <option value="<?php echo $category_1['category_id']; ?>" selected="selected"><?php echo $category_1['name']; ?></option>
                          <?php } else { ?>
                          <option value="<?php echo $category_1['category_id']; ?>"><?php echo $category_1['name']; ?></option>
                          <?php } ?>
                          <?php foreach ($category_1['children'] as $category_2) { ?>
                          <?php if ($category_2['category_id'] == $category_id) { ?>
                          <option value="<?php echo $category_2['category_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
                          <?php } else { ?>
                          <option value="<?php echo $category_2['category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
                          <?php } ?>
                          <?php foreach ($category_2['children'] as $category_3) { ?>
                          <?php if ($category_3['category_id'] == $category_id) { ?>
                          <option value="<?php echo $category_3['category_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
                          <?php } else { ?>
                          <option value="<?php echo $category_3['category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
                          <?php } ?>
                          <?php } ?>
                          <?php } ?>
                          <?php } ?>
                        </select>
                        <label class="checkbox-inline">
                          <?php if ($sub_category) { ?>
                          <input type="checkbox" name="sub_category" value="1" checked="checked" />
                          <?php } else { ?>
                          <input type="checkbox" name="sub_category" value="1" />
                          <?php } ?>
                          <?php echo $text_sub_category; ?></label>
                    </div>
                    <p>
                      <label class="checkbox-inline">
                        <?php if ($description) { ?>
                        <input type="checkbox" name="description" value="1" id="description" checked="checked" />
                        <?php } else { ?>
                        <input type="checkbox" name="description" value="1" id="description" />
                        <?php } ?>
                        <?php echo $entry_description; ?></label>
                    </p>
                    <input type="button" value="<?php echo $button_search; ?>" id="button-search" class="btn-primary" />
                    <h2><?php echo $text_search; ?></h2>
                    <?php
                    if (!empty($this->request->get['path'])) {
                    $parts = explode('_', $this->request->get['path']);
                    $category_id = end($parts);
                    }
                    
                    include_once(DIR_TEMPLATE . "new/template/product/product_list.tpl"); ?>
                </section>
            </div><!-- .wrappContent -->
        </div>

</section>
<?php echo $content_bottom; ?>
<script type="text/javascript"><!--
$('#button-search').bind('click', function() {
	url = 'search';
	
	var search = $('#content input[name=\'search\']').prop('value');
	
	if (search) {
		//url += '&search=' + encodeURIComponent(search);
		url += '/' + encodeURIComponent(search);
	}

	var category_id = $('#content select[name=\'category_id\']').prop('value');
	
	if (category_id > 0) {
		url += '&category_id=' + encodeURIComponent(category_id);
	}
	
	var sub_category = $('#content input[name=\'sub_category\']:checked').prop('value');
	
	if (sub_category) {
		url += '&sub_category=true';
	}
		
	var filter_description = $('#content input[name=\'description\']:checked').prop('value');
	
	if (filter_description) {
		url += '&description=true';
	}

	location = url;
});

$('#content input[name=\'search\']').bind('keydown', function(e) {
	if (e.keyCode == 13) {
		$('#button-search').trigger('click');
	}
});

$('select[name=\'category_id\']').on('change', function() {
	if (this.value == '0') {
		$('input[name=\'sub_category\']').prop('disabled', true);
	} else {
		$('input[name=\'sub_category\']').prop('disabled', false);
	}
});

$('select[name=\'category_id\']').trigger('change');
--></script>
<?php echo $footer; ?>
