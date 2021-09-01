$(document).ready(function() {
    //КОД ДЛЯ ДОБАВЛЕНИЯ В БД тб=paid_orders ОПЛАЧЕННОГО ЗАКАЗА И УДАЛЕНИЯ ИЗ БД тб=order_products ТЕХ ПОЗИЦИЙ ТОВАРОВ КОТОРЫЕ БЫЛИ В ЗАКАЗЕ

    let error_telephone = $('.error.error_telephone');
    let error_adress = $('.error.error_adress');
    let error_sum = $('.error.error_sum');

    //отправляем данные с формы  на сервер
    $('.form_oplata').submit(function(e){
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

                if(data['result'] == 'error_valid'){

                    if (data['oplata_err'] != '') {
                        error_sum.html(data['oplata_err']);
                    }else{
                        error_sum.html('');
                    }

                    if (data['adress_err'] != '') {
                        error_adress.html(data['adress_err']);
                    }else{
                        error_adress.html('');
                    }

                    if (data['telephone_err'] != '') {
                        error_telephone.html(data['telephone_err']);
                    }else{
                        error_telephone.html('');
                    }   
                }else{
                    error_telephone.html('');
                    error_adress.html('');
                    error_sum.html(''); 
                }

                if(data['result'] == 'sum_no_sovpad'){
                    error_sum.html(data['oplata_err']);
                }

                if (data['result'] == 'succes') {

                    error_telephone.html('');
                    error_adress.html('');
                    error_sum.html('');

                    setTimeout(function () {
                        alert(data['oplata_succes']);                                  
                    }, 100);
                    
                    setTimeout(function () {
                       window.location.href = "index.php?page=basket&elem=open_order"; 
                    }, 150);
                }

                if (data['result'] == 'error_add_item_in_order') {
                    alert(data['oplata_error']);  
                }
            	

            }

        });

        
        // останавливаем сабмит, чтоб не перезагружалась страница
   		return false;
    });




});