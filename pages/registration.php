






<div class="home_avtorizac">

	<form class="form_registration" action="assets/php/personal_account/registration.php" method="post">
		<label>Регистрация</label>

		<span  class="name_user_error" id="span"></span>
		<input type="text"     name="form_registration_name"         value="<?=$form_registration_name_valid??null?>"   placeholder="введите ваше имя" >
		

		<span  class="family_user_error" id="span"></span>
		<input type="text"     name="form_registration_family"       value="<?=$form_registration_family_valid??null?>"   placeholder="введите вашу фамилию">
		

		<span  class="login_user_error" id="span"></span>
		<input type="text"     name="form_registration_login"        value="<?=$form_registration_login_valid??null?>"   placeholder="введите логин">
		

		<span  class="email_user_error" id="span"></span>
		<input type=""         name="form_registration_email"        value="<?=$form_registration_email_valid??null?>"   placeholder="введите ваш email">
		

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