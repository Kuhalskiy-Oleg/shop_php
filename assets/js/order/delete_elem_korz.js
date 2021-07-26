$(document).ready(function() {

	

	//берем все элементы из DOM дерева с id submit
    
    const Btn_submit = $("input[data='submit_items_products_id_name']"); 
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

			            	console.log(data)

			            	if (data['succes'] == 'succes') {
			            		
			            		//для удаления той карточки , номер которой вернул массив отправленный с сервера
			            		let attr_number = `[number = "${data['id']}"]`;
			            		console.log(attr_number)
			            		$(attr_number).remove();

			            		//для того чтобы скоректировать позиционирование кнопок удаления после того как один элемент корзины удалится со страницы
			            		let form_perelet = document.querySelectorAll('.count_order');								
								for (let value of form_perelet) {
									console.log($(value).attr('number'));
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
	}


});