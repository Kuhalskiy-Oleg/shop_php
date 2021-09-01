$(document).ready(function() {

    //отправляем данные с формы  на сервер
    $('.select_card_views').submit(function(e){
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
            	if(data['result'] == 'succes'){
                    window.location.href = "index.php?page=shop"; 
            	}
            }

        });

        
        // останавливаем сабмит, чтоб не перезагружалась страница
   		return false;
    });




});