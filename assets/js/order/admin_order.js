$(document).ready(function() {




	

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
            	
            }

        });

        
        // останавливаем сабмит, чтоб не перезагружалась страница
   		return false;
    });
		



});