$(document).ready(function() {




	//берем все элементы из DOM дерева с id submit
    
    const Btn_submit = document.querySelectorAll('#submit_order'); 
    //console.log(Btn_submit);

    //если колв-во элементов больше нуля то будем выполнять дальнейший код
    if (Btn_submit.length > 0) {

        //перебираем массив с кнопками
        for (let index = 0; Btn_submit.length > index; index++ ){

            //записываем каждый элемент массива в переменную btn_submit_element
            let btn_submit_element = Btn_submit[index];
            //console.log(btn_submit_element);



            //вешаем событие клика ONE на ту кнопку из списка на которую мы нажали
            $(btn_submit_element).one("click", function(){
                
                //забираем родителя той кнопки по которой мы нажали
                let Filter_form_id = $(this).closest('form');
                //console.log(Filter_form_id);

                //отправляем данные с формы  на сервер
                $(Filter_form_id).submit(function(e){
                    e.preventDefault();

                    let value_count = $(this).find("input[data='input']");
                    let error_count = $(this).find("span[data='span']");
                    //console.log(error_count)

	    
			        // получение данных из полей функцией serialize
			        var form = $(this);
			        var data = form.serialize();




			        
			        $.ajax({

			            url: $(this).attr('action'),
			            type: $(this).attr('method'),
			            data: data,
			            dataType: "json",


			            // действие, при ответе с сервера
			            success: function(data){



			            	console.log(data);
			            	//выводим при удалении карточки
                            if (data['succes'] == 'succes_add') {

                            	

                            	value_count.css({'border':'1px dashed green','box-shadow':'0 0 5px green'});
                            	error_count.html('');


                                setTimeout(function () {
                                    alert( data['login'] + ' , ваш заказ успешно сформирован'  )                           
                                }, 100);
                                
                                setTimeout(function () {
                                   window.location.href = "index.php?page=order&elem=open_order"; 
                                }, 150);
                                
                            }else if(data['succes'] == 'succes_err'){


                            	value_count.css({'border':'1px dashed green','box-shadow':'0 0 5px green'});
                            	error_count.html('');

                                if (data['login'] == null) {
                                    setTimeout(function () {
                                        alert( 'для оформления заказа вам необходимо зарегистрироваться на сайте' )                      
                                    }, 100);
                                }else{
                                    setTimeout(function () {
                                        alert( data['login'] + ' , при формировании вашего заказа возникла ошибка' + '\n' + data['rezult_error'] )                      
                                    }, 100);
                                }
                                
                                 
                            }else if(data['count_Err'] != '') {

 							
                            	data['id'].forEach(element => {
                            		let value_count_val = $('.value'+element['id']).val();
                            		let count_value = $('.value'+element['id']);
                            		let count_error = $('.error'+element['id']);

                            		if (value_count_val != '') {

                            			if(!(/^[0-9]+$/.test(value_count_val))){

			                                count_value.css({'border':'1px dashed red','box-shadow':'0 0 5px red'});
                            				count_error.html('введите только цифры без пробелов и символов');
			                            
			                            }else if(value_count_val >= 1000 ){
			                                count_value.css({'border':'1px dashed red','box-shadow':'0 0 5px red'});
                            				count_error.html('Недопусимое число - введите не больше 1000');
			                            

			                            }else if(value_count_val <= 0 ){
			                                count_value.css({'border':'1px dashed red','box-shadow':'0 0 5px red'});
                            				count_error.html('Недопусимое число - введите больше 0');
                            			}else{
                            				count_value.css({'border':'1px dashed green','box-shadow':'0 0 5px green'});
                            				count_error.html('');
                            			}

                            			
                            		}else{
                            			count_value.css({'border':'1px dashed red','box-shadow':'0 0 5px red'});
                            			count_error.html('Это поле обязательно к заполнению');
                            		}
                            		
                            	});
                            	

                            }

			            }

			        });

			        
			        // останавливаем сабмит, чтоб не перезагружалась страница
			   		return false;
			    });
			});
		};
	}


});