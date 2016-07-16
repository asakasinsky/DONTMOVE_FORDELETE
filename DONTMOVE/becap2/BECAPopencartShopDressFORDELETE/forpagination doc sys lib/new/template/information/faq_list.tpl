<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
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
      <table class="table table-bordered table-striped table-hover">
	    <thead>
		  <tr>
		
			<th><?php echo $text_question; ?></th>
			<th><?php echo $text_answer; ?></th>
		
			
		  </tr>
		</thead>
		<tbody>
		<?php foreach ($all_faq as $faq) { ?>
		  <tr>
		     <td style="vertical-align:middle"><?php echo $faq['question']; ?></td>
		   <td style="vertical-align:middle"><?php echo $faq['answer']; ?></td>
		  
		   </tr>
		<?php } ?>
		</tbody>
	  </table>
	  <div class="row">
        <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
        <div class="col-sm-6 text-right"><?php echo $results; ?></div>
      </div>
	  <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?> 