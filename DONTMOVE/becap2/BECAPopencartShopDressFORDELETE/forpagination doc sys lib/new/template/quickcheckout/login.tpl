<div id="login">
    <form class="right_form">
        <div class="inp_block">
        <span class="forms"><?php echo $entry_email; ?></span>
        <input type="text" name="email" value="" id="input-login-email" class="cart_inp">
        </div>

        <div class="inp_block">
        <span class="forms"><?php echo $entry_password; ?></span>
        <input type="password" name="password" class="cart_inp">
        </div>

        <input type="submit" id="button-login" value="Войти" class="vt">
    </form>
</div>

<script type="text/javascript"><!--
$('#login input').keydown(function(e) {
	if (e.keyCode == 13) {
		$('#button-login').click();
	}
});
//--></script>   