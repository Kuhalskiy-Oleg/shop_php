$(document).ready(function() {
    //КОД ДЛЯ УДАЛЕНИЯ ПОЗИЦИИ В ЗАКАЗЕ В БД тб=order_products 




    const Btn_submit = $(".submit_del_element_order_products"); 
    //console.log(Btn_submit);

    //если колв-во элементов больше нуля то будем выполнять дальнейший код
    if (Btn_submit.length > 0) {

        //перебираем массив с кнопками
        for (let index = 0; Btn_submit.length > index; index++ ){

            //записываем каждый элемент массива в переменную btn_submit_element
            let btn_submit_element = Btn_submit[index];
            console.log(btn_submit_element);

            


            //вешаем событие клика ONE на ту кнопку из списка на которую мы нажали
            $(btn_submit_element).one("click", function(){

                console.log('ss'); 
                
                //забираем родителя той кнопки по которой мы нажали
                let Filter_form_id = $(this).closest('.del_element_order_products');
                console.log(Filter_form_id);

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

                        	console.log(data);
                            if (data['result'] == 'succes') {

                                //удаляем строку в таблице
                                $(`#table tbody tr[id_tr_tabl_sborka=${data['id']}]`).remove();

                            }

                            if (data['result'] == 'error') {
                                alert("при удалении позиции из заказа возникла ошибка" + '\n' + data['mysql_error'])
                            }

                        }

                    });

                    
                    // останавливаем сабмит, чтоб не перезагружалась страница
               		return false;
                });

            });
        };

    };



});