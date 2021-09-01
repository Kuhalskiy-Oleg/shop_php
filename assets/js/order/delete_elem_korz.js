$(document).ready(function() {

    
    const Input_data = $("input[data='submit_items_products_id_name']"); 
    //console.log(Input_data);

    //если колв-во элементов больше нуля то будем выполнять дальнейший код
    if (Input_data.length > 0) {

        //перебираем массив с кнопками
        for (let index = 0; Input_data.length > index; index++ ){

            //записываем каждый элемент массива в переменную btn_submit_element
            let btn_submit_element = Input_data[index];
            //console.log(btn_submit_element);

            


            //вешаем событие клика ONE на ту кнопку из списка на которую мы нажали
            $(btn_submit_element).one("click", function(){

            	//при клике на кнопку удалить записываем в переменную сколько всего кнопок осталось
            	const Input_data_after_click = $("input[data='submit_items_products_id_name']"); 
            	//console.log(Input_data_after_click);

            	//удаляем кноппку оформит заказ когда товаров в корзине нету
            	if (Input_data_after_click.length <= 1) {
            		$('input#submit_order').remove();
            		//console.log('sss')
            	}
                
                //забираем родителя той кнопки по которой мы нажали
                let Filter_form_id = $(this).closest('.form_delete_elem_korz');
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

			            	//console.log(data)

			            	if (data['succes'] == 'succes') {
			            		
			            		//для удаления той карточки , номер которой вернул массив отправленный с сервера
			            		let attr_number = `[number = "${data['id']}"]`;
			            		//console.log(attr_number)
			            		$(attr_number).remove();

			            		//для того чтобы скоректировать позиционирование кнопок удаления после того как один элемент корзины удалится со страницы
			            		let form_perelet = document.querySelectorAll('.count_order');								
								for (let value of form_perelet) {
									//console.log($(value).attr('number'));
									let top = $(value).position().top;
								    let left = $(value).position().left;
								    $(`.vvvv${$(value).attr('number')}`).offset({top: top + 28, left: left });
								}

						        

			            		
			            	}
			            }

			        });

			        
			        // останавливаем сабмит, чтоб не перезагружалась страница
			   		return false;
			    });
			});
		};

	//если кнопок delete нет на странице то мы удаляем кнопку оформить заказ	
	}
		
	


});