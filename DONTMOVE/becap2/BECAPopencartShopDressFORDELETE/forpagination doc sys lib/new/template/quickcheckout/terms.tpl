<label><?php if ($text_agree) { ?>
  <?php echo $text_agree; ?>
  <?php if ($agree) { ?>
  <input type="checkbox" name="agree" value="1" checked="checked" />
  <?php } else { ?>
  <input type="checkbox" name="agree" value="1" />
  <?php } ?>
<?php } ?></label>
<div class="zakazati">
        <button id="button-payment-method" class="orange_button ">ЗАКАЗАТЬ</button>
</div>