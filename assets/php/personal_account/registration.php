<?php  

	//форма регистрации
	$form_registration_name         = $_POST['form_registration_name']; 
	$form_registration_family       = $_POST['form_registration_family']; 
	$form_registration_login        = $_POST['form_registration_login'];
	$form_registration_email        = $_POST['form_registration_email'];  
	$form_registration_password     = $_POST['form_registration_password']; 
	$form_registration_password_two = $_POST['form_registration_password_two']; 

	$nameErr = $familyErr = $loginErr = $emailErr = $passwordErr = $password_two_Err = $error_pasword_no_sovpadenie = '';




	//_____________ПОДКЛЮЧАЕМ ФУНКЦИИ ВАЛИДАЦИИ ДАННЫХ___________
	require('function_valid.php');





	//____________________________________________форма регистрации_____________________________
    //проверяем имя
    if (isset($form_registration_name)) {
    	
    	if (empty($form_registration_name)) {
		$nameErr = "Введите имя";

		}else if(mb_strlen($form_registration_name) < 3 || mb_strlen($form_registration_name) > 50 ){
			$nameErr = "Недопусимая длина имя(от 3 до 50 символов)";

		}else if(!preg_match("/^(([a-zA-Z]{1,50})|([а-яА-ЯЁёІіЇїҐґЄє]{1,50}))$/u",$form_registration_name))  {

			$nameErr = "Имя должно содержать только буквы";

		}else{
			$form_registration_name = filter_var($form_registration_name , FILTER_SANITIZE_STRING); 
			$form_registration_name_valid = valid_name_family($form_registration_name);
		}
    }



    //проверяем фамилию
    if (isset($form_registration_family)) {
    	
    	if (empty($form_registration_family)) {
		$familyErr = "Введите фамилию";

		}elseif(mb_strlen($form_registration_family) < 3 || mb_strlen($form_registration_family) > 50 ){
			$familyErr = "Недопусимая длина фамилии(от 3 до 50 символов)";

		//u - По символам юникода разбивает
		// проверяем, содержит ли имя только буквы и пробелы
		}elseif(!preg_match("/^(([a-zA-Z]{1,50})|([а-яА-ЯЁёІіЇїҐґЄє]{1,50}))$/u",$form_registration_family)) {
			
			$familyErr = "Фамилия должна содержать только буквы";
			
		}else{
			$form_registration_family = filter_var($form_registration_family , FILTER_SANITIZE_STRING ); 
			$form_registration_family_valid = valid_name_family($form_registration_family);
		}
    }




    //проверяем логин
    if (isset($form_registration_login)) {
    	
    	if (empty($form_registration_login)) {
		$loginErr = "Введите логин";

		}elseif(mb_strlen($form_registration_login) < 3 || mb_strlen($form_registration_login) > 30 ){
			$loginErr = "Недопусимая длина логина (от 3 до 30 символов)";

		// проверяем, содержит ли имя только буквы и пробелы
		}elseif(preg_match("/[ }{\]\[№;:#$?<+=>!%^&*\/\\\`\"\']/",$form_registration_login)) {
			
			$loginErr = "логин должен содержать буквы , числа и некоторые символы ( ~@()-_| )";
						
		}else {
			$form_registration_login_valid = valid_login_password($form_registration_login);
		}
    }








    //filter_var - проверка правильности email встроенной функцией PHP  
    //preg_match — Выполняет проверку на соответствие регулярному выражению 
	//проверяем емаил

    if (isset($form_registration_email)) {

		if (empty($form_registration_email)) {
			$emailErr = "Введите email";

		}elseif(mb_strlen($form_registration_email) < 3 || mb_strlen($form_registration_email) > 100 ){
			$emailErr = "Недопусимая длина email (от 3 до 100 символов)";
		

		// проверьте, правильно ли сформирован адрес электронной почты
		}elseif (!filter_var($form_registration_email, FILTER_VALIDATE_EMAIL)) {
	    	$emailErr = "Неверный формат электронной почты";
	    
	    }elseif(!preg_match("/^[A-Z0-9._%+-]+@[A-Z0-9-]+.+.[A-Z]{2,4}$/i",$form_registration_email)) {
	    	$emailErr = "Неверный формат электронной почты";

		}else{
			$form_registration_email_valid = valid_email($form_registration_email);
		}
	}





	
	//проверяем пароль
    if (isset($form_registration_password)) {
    	
    	if (empty($form_registration_password)) {
		$passwordErr = "Введите пароль";

		}elseif(mb_strlen($form_registration_password) < 5 || mb_strlen($form_registration_password) > 15 ){
			$passwordErr = "Недопусимая длина пароля (от 5 до 15 символов)";

		}elseif(preg_match("/[ }{\]\[№;:#$?<+=>!%^&*\/\\\`\"\']/",$form_registration_password)) {
			
			$passwordErr = "пароль должен содержать буквы , числа и некоторые символы ( ~@()-_| )";
		}else{

			$form_registration_password_valid = valid_login_password($form_registration_password);
		
		}
			

    }



    //preg_match — Выполняет проверку на соответствие регулярному выражению
	//проверяем пароль
    if (isset($form_registration_password_two)) {
    	
    	if (empty($form_registration_password_two)) {
		$password_two_Err = "Введите пароль еще раз";

		}elseif(mb_strlen($form_registration_password_two) < 5 || mb_strlen($form_registration_password_two) > 15 ){
			$password_two_Err = "Недопусимая длина пароля (от 5 до 15 символов)";

		}elseif(preg_match("/[ }{\]\[№;:#$?<+=>!%^&*\/\\\`\"\']/",$form_registration_password_two)) {
			
			$password_two_Err = "пароль должен содержать буквы , числа и некоторые символы ( ~@()-_| )";
		}else{

				$form_registration_password_two_valid = valid_login_password($form_registration_password_two);

			
		}
    }






	if (isset($form_registration_password_valid) && isset($form_registration_password_two_valid)) {
		
		if ($form_registration_password_valid != $form_registration_password_two_valid) {
			$error_pasword_no_sovpadenie = "Пароли_не_совпадают";
		}else{
			$error_pasword_no_sovpadenie = "Пароли_совпадают";
			$form_registration_password_valid_hesh_SOVPAD = password_hash($form_registration_password_two_valid, PASSWORD_BCRYPT);
		}

		//password_verify($form_registration_password_two_valid, $form_registration_password_valid_hesh_SOVPAD);

	}








	if ((!empty($nameErr))          ||
		(!empty($familyErr))        ||
		(!empty($loginErr))         ||
		(!empty($emailErr))         ||
		(!empty($passwordErr))      ||
		(!empty($password_two_Err)) ||
		($error_pasword_no_sovpadenie == "Пароли_не_совпадают")) {





	 
		echo json_encode([ 
	 					'error'                        => 'error'                      , 
	 					'nameErr'                      => $nameErr                     ,
	 					'familyErr'                    => $familyErr                   ,
	 					'loginErr'                     => $loginErr                    ,
	 					'emailErr'                     => $emailErr                    ,
	 					'passwordErr'                  => $passwordErr                 ,
	 					'password_two_Err'             => $password_two_Err            ,
	 					'error_pasword_no_sovpadenie'  => $error_pasword_no_sovpadenie ,
	 					'name'                         => $form_registration_name_valid  ,
	 					'family'                       => $form_registration_family_valid,
	 					'login'                        => $form_registration_login_valid ,
	 					'email'                        => $form_registration_email_valid ,        

					]);



	}elseif((empty($nameErr))          &&
			(empty($familyErr))        &&
			(empty($loginErr))         &&
			(empty($emailErr))         &&
			(empty($passwordErr))      &&
			(empty($password_two_Err)) &&
			($error_pasword_no_sovpadenie == "Пароли_совпадают")) {


			//подключаемся к бд
			require('../db/link_db.php');

				
			//защищаем бд от иньекций
			$value_name_valid_db = mysqli_real_escape_string($products_lesson_6, (string)htmlspecialchars(strip_tags($form_registration_name_valid)));
			$value_family_valid_db = mysqli_real_escape_string($products_lesson_6, (string)htmlspecialchars(strip_tags($form_registration_family_valid)));
			$value_login_valid_db = mysqli_real_escape_string($products_lesson_6, (string)htmlspecialchars(strip_tags($form_registration_login_valid)));
			$value_email_valid_db = mysqli_real_escape_string($products_lesson_6, (string)htmlspecialchars(strip_tags($form_registration_email_valid)));
			$value_password_hesh_SOVPAD_valid_db = mysqli_real_escape_string($products_lesson_6, (string)htmlspecialchars(strip_tags($form_registration_password_valid_hesh_SOVPAD)));




			//записываем в бд данные
			if (mysqli_query($products_lesson_6, " INSERT INTO `users`  (   `name`    ,
												 						  `family`  ,
												 						  `login`   ,
												 						  `email`   ,
												 						  `password`)       
												 						     
												 						   

					                             VALUES ( '{$value_name_valid_db}'  ,
					                            		  '{$value_family_valid_db}',
					                            		  '{$value_login_valid_db}' ,
					                              		  '{$value_email_valid_db}' ,
					                            		  '{$value_password_hesh_SOVPAD_valid_db}' ) ")  ){        
					                            		                  
					                            		 
					//если запись в дб возратила true то
					$rezult_add_data_db =  mysqli_insert_id($products_lesson_6);
						                                                           
					
					echo json_encode([ 
						
		 					'succes'                       => 'succes_add_user'              , 
		 					'rezult_add_data_db'           =>  $rezult_add_data_db           , 
		 					'name'                         => $form_registration_name_valid  ,
		 					'family'                       => $form_registration_family_valid,
		 					'login'                        => $form_registration_login_valid ,
		 					'email'                        => $form_registration_email_valid ,        
		 					'error_pasword_no_sovpadenie'  => $error_pasword_no_sovpadenie   ,

							
						]);

					
			//если запись в дб возратила false то		
			}else{


				$rezult_add_data_db =  mysqli_error($products_lesson_6);
				echo json_encode([ 

		 					'succes'                       => 'error_add_user'               ,             
		 					'rezult_add_data_db'           =>  $rezult_add_data_db           , 
		 					'name'                         => $form_registration_name_valid  ,
		 					'family'                       => $form_registration_family_valid,
		 					'login'                        => $form_registration_login_valid ,
		 					'email'                        => $form_registration_email_valid ,        
		 					'error_pasword_no_sovpadenie'  => $error_pasword_no_sovpadenie   ,
	

						]);



			}

			mysqli_close($products_lesson_6);
		
	}
	




?>