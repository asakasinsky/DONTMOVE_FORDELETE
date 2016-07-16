<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<div>
  <div>
    <p><?php echo $mail_text_question_added; ?></p>
    <?php if (isset($product_id)) { ?>
		<p><b><?php echo $mail_text_product; ?></b> <a href="<?php echo $store_url; ?>index.php?route=product/product&product_id=<?php echo $product_id; ?>"><?php echo $product_name; ?></a></p>
	<?php } ?>
    <p><b><?php echo $mail_text_name; ?></b> <?php echo $name; ?></p>
    <p><b><?php echo $mail_text_email; ?></b> <?php echo $email; ?></p>
    <p><b><?php echo $mail_text_question; ?></b> <?php echo $question_text; ?></p>
    <p><?php echo $mail_text_answer; ?></p>
    <p style="margin-top: 25px;"><a href="<?php echo $store_url; ?>" title="<?php echo $store_name; ?>"><?php echo $store_name; ?></a></p>
  </div>
</div>
</body>
</html>
