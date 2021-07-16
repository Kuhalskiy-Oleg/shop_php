$(document).ready(function() {



	$('.form_registration').submit(function(){

	    
	        // получение данных из полей функцией serialize
	        var form = $(this);
	        var data = form.serialize();


	        let name_user       = $(this).find("input[name='form_registration_name']");
            let name_user_error        = $(this).find("span[class='name_user_error']");

            let family_user       = $(this).find("input[name='form_registration_family']");
            let family_user_error    = $(this).find("span[class='family_user_error']");

            let login_user        = $(this).find("input[name='form_registration_login']");
            let login_user_error = $(this).find("span[class='login_user_error']");

            let email_user      = $(this).find("input[name='form_registration_email']");
            let email_user_error       = $(this).find("span[class='email_user_error']");

            let password_1_user       = $(this).find("input[name='form_registration_password']");
            let password_1_user_error       = $(this).find("span[class='password_1_user_error']");

            let password_2_user       = $(this).find("input[name='form_registration_password_two']");
            let password_2_user_error       = $(this).find("span[class='password_2_user_error']");



	        
	        $.ajax({

	            url: $(this).attr('action'),
                type: $(this).attr('method'),
	            data: data,
	            dataType: "json",


	            // действие, при ответе с сервера
	            success: function(data){



	            	console.log(data);

	            	if (data['succes'] == 'succes_add_user') {

                        name_user.css({'border':'1px dashed green','box-shadow':'0 0 5px green'});
                        name_user_error.html('');  
                        family_user.css({'border':'1px dashed green','box-shadow':'0 0 5px green'});
                        family_user_error.html(''); 
                        login_user.css({'border':'1px dashed green','box-shadow':'0 0 5px green'});
                        login_user_error.html('');  
                        email_user.css({'border':'1px dashed green','box-shadow':'0 0 5px green'}); 
                        email_user_error.html(''); 
                        password_1_user.css({'border':'1px dashed green','box-shadow':'0 0 5px green'});
                        password_1_user_error.html('');
                        password_2_user.css({'border':'1px dashed green','box-shadow':'0 0 5px green'});
                        password_2_user_error.html(''); 

	            		setTimeout(function () {
                            alert(  'вы успешно зарегистрировались' + '\n' + 
                            		'добавлена запись в базу данных № ' + data['rezult_add_data_db'] )                           
                        }, 100);
                        
                        setTimeout(function () {
                           window.location.href = "index.php?page=registration"; 
                        }, 150);

	            	}else if(data['succes'] == 'error_add_user') {

                        name_user.css({'border':'1px dashed green','box-shadow':'0 0 5px green'});
                        name_user_error.html('');  
                        family_user.css({'border':'1px dashed green','box-shadow':'0 0 5px green'});
                        family_user_error.html(''); 
                        login_user.css({'border':'1px dashed green','box-shadow':'0 0 5px green'});
                        login_user_error.html('');  
                        email_user.css({'border':'1px dashed green','box-shadow':'0 0 5px green'}); 
                        email_user_error.html(''); 
                        password_1_user.css({'border':'1px dashed green','box-shadow':'0 0 5px green'});
                        password_1_user_error.html('');
                        password_2_user.css({'border':'1px dashed green','box-shadow':'0 0 5px green'});
                        password_2_user_error.html(''); 

	            		setTimeout(function () {
                            alert(  'ошибка при регистрации: ' + data['rezult_add_data_db'] )                           
                        }, 100);
                        
                        // setTimeout(function () {
                        //    window.location.href = "index.php?page=registration"; 
                        // }, 150);


	            	}else if(data['error'] == 'error') {





	            		//_______________________________NAME
                        if (data['nameErr'] != '') {
                            name_user.css({'border':'1px dashed red','box-shadow':'0 0 5px red'}); 
                            name_user_error.html(data['nameErr']); 
                        }else{
                            name_user.css({'border':'1px dashed green','box-shadow':'0 0 5px green'});
                            name_user_error.html('');  
                        }


                        //_______________________________FAMILY
                        if (data['familyErr'] != '') {
                            family_user.css({'border':'1px dashed red','box-shadow':'0 0 5px red'}); 
                            family_user_error.html(data['familyErr']); 
                        }else{
                            family_user.css({'border':'1px dashed green','box-shadow':'0 0 5px green'});
                            family_user_error.html('');  
                        }


                        //_______________________________LOGIN
                        if (data['loginErr'] != '') {
                            login_user.css({'border':'1px dashed red','box-shadow':'0 0 5px red'}); 
                            login_user_error.html(data['loginErr']); 
                        }else{
                            login_user.css({'border':'1px dashed green','box-shadow':'0 0 5px green'});
                            login_user_error.html('');  
                        }


                        //_______________________________EMAIL
                        if (data['emailErr'] != '') {
                            email_user.css({'border':'1px dashed red','box-shadow':'0 0 5px red'}); 
                            email_user_error.html(data['emailErr']); 
                        }else{
                            email_user.css({'border':'1px dashed green','box-shadow':'0 0 5px green'}); 
                            email_user_error.html(''); 
                        }


                        //_______________________________PASSWORD_1
                        if (data['passwordErr'] != '') {
                            password_1_user.css({'border':'1px dashed red','box-shadow':'0 0 5px red'}); 
                            password_1_user_error.html(data['passwordErr']); 
                        }else{
                            password_1_user.css({'border':'1px dashed green','box-shadow':'0 0 5px green'}); 
                            password_1_user_error.html('');
                        }


                        //_______________________________PASSWORD_2
                        if (data['password_two_Err'] != '') {
                            password_2_user.css({'border':'1px dashed red','box-shadow':'0 0 5px red'}); 
                            password_2_user_error.html(data['password_two_Err']); 
                        }else{
                            password_2_user.css({'border':'1px dashed green','box-shadow':'0 0 5px green'});
                            password_2_user_error.html(''); 
                        } 


                        //_______________________________PASSWORD_1---PASSWORD_2
                        if ((data['passwordErr'] == '') && (data['password_two_Err'] == '')){
	                        if (data['error_pasword_no_sovpadenie'] == 'Пароли_не_совпадают') {
	                            password_1_user.css({'border':'1px dashed red','box-shadow':'0 0 5px red'});
	                            password_2_user.css({'border':'1px dashed red','box-shadow':'0 0 5px red'}); 
	                            password_2_user_error.html('Пароли не совпадают'); 
	                        }else{
	                            password_1_user.css({'border':'1px dashed green','box-shadow':'0 0 5px green'});
	                            password_2_user.css({'border':'1px dashed green','box-shadow':'0 0 5px green'});
	                            password_2_user_error.html(''); 
	                        } 
	                    }
	            	}
	            }

	        });

	        
	        // останавливаем сабмит, чтоб не перезагружалась страница
       		return false;
    });






	$('.form_avtorization').submit(function(){

	    
	        // получение данных из полей функцией serialize
	        var form = $(this);
	        var data = form.serialize();

            let login_user        = $(this).find("input[name='form_avtorization_login']");
            let login_user_error = $(this).find("span[class='login_user_error']");

            let password_user       = $(this).find("input[name='form_avtorization_password']");
            let password_user_error       = $(this).find("span[class='password_user_error']");



	        
	        $.ajax({

	            url: $(this).attr('action'),
                type: $(this).attr('method'),
	            data: data,
	            dataType: "json",


	            // действие, при ответе с сервера
	            success: function(data){



	            	console.log(data);

	            	if (data['succes'] == 'succes') {
	            		//console.log(data);
	            		login_user.css({'border':'1px dashed green','box-shadow':'0 0 5px green'});
                        login_user_error.html(''); 
                        password_user.css({'border':'1px dashed green','box-shadow':'0 0 5px green'}); 
                        password_user_error.html('');


	            		setTimeout(function () {
                            alert(  'здравствуйте ' + data['user_name'] + ' ' + data['user_family'] + ' !' );
                            		                          
                        }, 100);
                        
                        setTimeout(function () {
                           window.location.href = "index.php?page=admin"; 
                        }, 150);



	            	}else if(data['error'] == 'error_password') {
	            		//console.log(data);
                        login_user.css({'border':'1px dashed green','box-shadow':'0 0 5px green'});
                        login_user_error.html(''); 
                        password_user.css({'border':'1px dashed red','box-shadow':'0 0 5px red'}); 
                        password_user_error.html('');
	            		setTimeout(function () {
                            alert(  data['rezult'] )                           
                        }, 100);

                    }else if(data['error'] == 'error_login') {
                        login_user.css({'border':'1px dashed red','box-shadow':'0 0 5px red'});
                        login_user_error.html(''); 
                        password_user.css({'border':'1px dashed green','box-shadow':'0 0 5px green'}); 
                        password_user_error.html('');
                        setTimeout(function () {
                            alert(  data['rezult'] )                           
                        }, 100);


	            	}else if(data['error'] == 'error') {

	            		//console.log(data);

                        //_______________________________LOGIN
                        if (data['loginErr'] != '') {
                            login_user.css({'border':'1px dashed red','box-shadow':'0 0 5px red'}); 
                            login_user_error.html(data['loginErr']); 
                        }else{
                            login_user.css({'border':'1px dashed green','box-shadow':'0 0 5px green'});
                            login_user_error.html('');  
                        }


                        


                        //_______________________________PASSWORD
                        if (data['passwordErr'] != '') {
                            password_user.css({'border':'1px dashed red','box-shadow':'0 0 5px red'}); 
                            password_user_error.html(data['passwordErr']); 
                        }else{
                            password_user.css({'border':'1px dashed green','box-shadow':'0 0 5px green'}); 
                            password_user_error.html('');
                        }


                        


                        
	            	}
	            }

	        });

	        
	        // останавливаем сабмит, чтоб не перезагружалась страница
       		return false;
    });



});