$(document).ready(function() {




	//берем все элементы из DOM дерева с id submit
    
    const Btn_submit = document.querySelectorAll('#submit_order_edit_pos'); 
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

                            //console.log(data);

                            if (data['rezult'] == 'succes') {

                                window.location.href = "index.php?page=order&elem=open_order"; 

                            }else if(data['rezult'] == 'error'){

                                alert( 'при изменении кол-ва штук товара возникла ошибка ' + '\n' + data['error_my_sql']  );
                            }

                            if(data['rezult_valid'] == 'error'){

                                alert( data['rezult_count_Err']  );
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