






<div class="home_avtorizac">

	<form class="form_registration" action="assets/php/personal_account/registration.php" method="post">
		<label>Регистрация</label>

		<span  class="name_user_error" id="span"></span>
		<input type="text"     name="form_registration_name"         value="<?php echo $form_registration_name_valid;   ?>"   placeholder="введите ваше имя" >
		

		<span  class="family_user_error" id="span"></span>
		<input type="text"     name="form_registration_family"       value="<?php echo $form_registration_family_valid; ?>"   placeholder="введите вашу фамилию">
		

		<span  class="login_user_error" id="span"></span>
		<input type="text"     name="form_registration_login"        value="<?php echo $form_registration_login_valid;  ?>"   placeholder="введите логин">
		

		<span  class="email_user_error" id="span"></span>
		<input type=""         name="form_registration_email"        value="<?php echo $form_registration_email_valid;  ?>"   placeholder="введите ваш email">
		

		<span  class="password_1_user_error" id="span"></span>
		<input type="password" name="form_registration_password"     placeholder="введите пароль">
		

		<span  class="password_2_user_error" id="span"></span>
		<input type="password" name="form_registration_password_two" placeholder="введите пароль еще раз">
		

		<input class="submit_form_registration" type="submit"   name="form_registration_submit"       value="отправить">
	</form>

</div>



<!-- СКРИПТ ДЛЯ ОТМЕНЫ АВТОМАТИЧЕСКОГО ПОВТОРНОГО ЗАПОЛНЕНИЯ ФОРМЫ ПОСЛЕ ПЕРЕЗАГРУЗКИ СТРАНИЦЫ-->
<script>
	
	if ( window.history.replaceState ) {
	window.history.replaceState( null, null, window.location.href );
	}
</script>