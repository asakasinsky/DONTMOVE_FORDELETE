<?php echo $header; ?>
<div class="container">
        <div class="linkKorzina">
            <a href="<?php echo HTTP_SERVER; ?>">Главная</a>
            <?php foreach ($breadcrumbs as $breadcrumb) { ?>
            <a href="<?php echo $breadcrumb['href']; ?>" <? if (end($breadcrumbs) === $breadcrumb) echo 'class="boldKorzina"'; ?>><?php echo $breadcrumb['text']; ?></a>
            <? if (end($breadcrumbs) !== $breadcrumb) echo "<span>&nbsp;-&nbsp;</span>"; ?>
            <?php } ?>
        </div>
  <?php if ($success) { ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div>
  <?php } ?>
  <?php if ($error_warning) { ?>
  <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php }$class = 'col-sm-12'; ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <div class="row">
          <div class="col-sm-6" style="width: 45%; margin-right: 5%;text-align: center;">
          <div class="well" style="min-height: 300px;">
            <h2><?php echo $text_new_customer; ?></h2>
            <p><strong><?php echo $text_register; ?></strong></p>
            <br>
            <div style="text-align: left;padding-left: 85px;">
            <p><strong>- Контролировать состояние заказа;</strong></p>
            <p><strong>- Просматривать сделанные ранее заказы</strong></p>
            </div>
            <input type="submit" class="btn-primary" value="Зарегистрироваться" onclick="window.location.href='<?php echo $register; ?>';" style="margin-top: 28px;">
            <br/>
            <br/>
          </div>            
        </div>
        <div class="col-sm-6" style="width: 45%; margin-left: 5%;text-align: center;">
          <div class="well" style="min-height: 300px;">
            <h2><?php echo $text_returning_customer; ?></h2>
            <p><strong><?php echo $text_i_am_returning_customer; ?></strong></p>
            <br>
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
              <div class="form-group">
                  <label class="control-label" for="input-email" style="margin-right: 11px;"><?php echo $entry_email; ?></label>
                <input type="text" name="email" value="<?php echo $email; ?>" placeholder="<?php echo $entry_email; ?>" id="input-email" required onblur="var regex = /^([a-zA-Z0-9_.+-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/;if(regex.test(this.value)) { try {rrApi.setEmail(this.value);}catch(e){}}"/>
              </div>
              <div class="form-group">
                <label class="control-label" for="input-password"><?php echo $entry_password; ?></label>
                <input type="password" name="password" value="<?php echo $password; ?>" placeholder="<?php echo $entry_password; ?>" id="input-password" required />
                <br/>
                </div>
                <input type="submit" class="btn-primary" value="<?php echo $button_login; ?>" style="width: 110px;" />
                <a href="<?php echo $forgotten; ?>" style="text-decoration:underline;"><?php echo $text_forgotten; ?></a>
              <?php if ($redirect) { ?>
              <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
              <?php } ?>
            </form>
          </div>
        </div>
      </div>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>