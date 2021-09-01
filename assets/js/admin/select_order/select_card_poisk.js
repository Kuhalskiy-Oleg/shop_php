$(document).ready(function() {

    //отправляем данные с формы  на сервер
    $('.select_card_poisk_admin_order').submit(function(e){
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

                if (data['result'] == 'succes') {
                    $('.error_select_card_poisk').html('');
                    window.location.href = "index.php?page=admin&select=order_edid";

                }else if(data['result'] == 'error'){
                    $('.error_select_card_poisk').html(data['count_Err']);
                }else if(data['result'] == 'not_product'){
                    $('.error_select_card_poisk').html('');
                    setTimeout(function(){
                        alert(data['count_Err']);
                    },50)
                    
                }

            }

        });

        
        // останавливаем сабмит, чтоб не перезагружалась страница
   		return false;
    });




});