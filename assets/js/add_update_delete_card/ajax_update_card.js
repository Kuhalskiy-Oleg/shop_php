$(document).ready(function() {



    


    

    









    // Валидация файлов на клиентской стороне для того чтобы небыло багов при загрузке аяксом слишком больших файлов
    function validateFiles(options) {
        var result = [], //в этой переменной будем хранить массив с ошибками
            file;        //в эту переменную загрузим информацию о загружаемом файле
     
        // Перебираем файлы из input file
        //Метод .each() специально спроектирован, чтобы сделать циклические операции над DOM-элементами более краткими и менее подверженными ошибкам. При вызове функции перебираются все DOM-элементы включенные в выборку объекта jQuery.
        options.option_file_img.each(function(index,file_img) {

            // Выбран ли файл
            if (!file_img.files.length) {
                //не выводим ошибку если файл не выбран т.к пользователь может и не обновлять картинку в карточке
                //result.push({errorCode: 'файл не выбран'});
                return;
            }
            
            file = file_img.files[0];
            console.log(file);

            // Проверяем размер / если размер файла больше чем размер указанный в параметрах вызываемой функции то
            if (file.size > options.option_maxSize) {
                result.push({ 
                              errorCode: 'файл '+file.name+' слишком велик = ' + file.size + ' максимальный размер файла = ' + options.option_maxSize  });
                              
            }


            // Проверяем размер / если размер файла меньше чем размер указанный в параметрах вызываемой функции то
            if (file.size < options.option_minSize) {
                result.push({ 
                              errorCode: 'файл '+file.name+' слишком мал = ' + file.size + ' минимальный размер файла = ' + options.option_minSize });
                                
            }


            // Проверяем тип файла
            if (options.option_types.indexOf(file.type) === -1) {
                result.push({  errorCode: 'Неподдерживаемый формат изображения ' + file.name});
            }
        });
     
        return result;
    }




















    
    //блок для взятия значения из input[name="delete_2] у определенной карточки что бы отключить подсветку зеленым при удалении карточки
    let btn_input_delete_val;
    const Btn_delete = document.querySelectorAll('.delete_label'); 
    //если колв-во элементов больше нуля то будем выполнять дальнейший код
    if (Btn_delete.length > 0) {

        //перебираем массив с кнопками
        for (let index = 0; Btn_delete.length > index; index++ ){

            //записываем каждый элемент массива в переменную btn_submit_element
            let btn_deletet_element = Btn_delete[index];
            //console.log(btn_deletet_element);


            //вешаем событие клика ONE на ту кнопку из списка на которую мы нажали
            $(btn_deletet_element).on("click", function(){
                

                //забираем родителя той кнопки по которой мы нажали
                let Filter_form_id_1 = $(this).closest('form');
                //console.log(Filter_form_id_1);

                let home_input_radio_delete = Filter_form_id_1.find(".home_input_radio_delete");
                let delete_label = Filter_form_id_1.find(".delete_label");
                home_input_radio_delete.css({'display':'flex'});
                delete_label.css({'opacity':'0'});

                btn_input_delete_val = Filter_form_id_1.find('input[name="delete_2"]').val(); 
                //console.log(btn_input_delete_val);

            });
        }
    }


    //блок для того чтобы скрыть кнопку удалить и показать блок с выбором -да-нет-
    const Btn_radio_2 = document.querySelectorAll('.radio_2'); 
    //если колв-во элементов больше нуля то будем выполнять дальнейший код
    if (Btn_radio_2.length > 0) {

        //перебираем массив с кнопками
        for (let index = 0; Btn_radio_2.length > index; index++ ){

            //записываем каждый элемент массива в переменную btn_submit_element
            let btn_Btn_radio_2_element = Btn_radio_2[index];
            //console.log(btn_Btn_radio_2_element);


            //вешаем событие клика ONE на ту кнопку из списка на которую мы нажали
            $(btn_Btn_radio_2_element).on("click", function(){

                //забираем родителя той кнопки по которой мы нажали
                let Filter_form_id_2 = $(this).closest('form');
                //console.log(Filter_form_id_2);

                let home_input_radio_delete_2 = Filter_form_id_2.find(".home_input_radio_delete");
                let delete_label_2 = Filter_form_id_2.find(".delete_label");
                home_input_radio_delete_2.css({'display':'none'});
                delete_label_2.css({'opacity':'1'});

            });
        }
    }


    //блок для того чтобы изменить значение атрибута с no на yes для удаления карточки в файле php
    const Btn_radio_3 = $('input[name="radio_yes"]'); 
    //если колв-во элементов больше нуля то будем выполнять дальнейший код
    if (Btn_radio_3.length > 0) {

        //перебираем массив с кнопками
        for (let index = 0; Btn_radio_3.length > index; index++ ){

            //записываем каждый элемент массива в переменную btn_submit_element
            let btn_Btn_radio_3_element = Btn_radio_3[index];
            //console.log(btn_Btn_radio_3_element);


            //вешаем событие клика ONE на ту кнопку из списка на которую мы нажали
            $(btn_Btn_radio_3_element).on("click", function(){

                //забираем родителя той кнопки по которой мы нажали
                let Filter_form_id_3 = $(this).closest('form');
                //console.log(Filter_form_id_3);
                Filter_form_id_3.find('input[name="radio_no"]').attr('value','yes');

            });
        }
    }


    



  




















    //берем все элементы из DOM дерева с id submit
    
    const Btn_submit = document.querySelectorAll('#submit'); 
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

                    let value_brand       = $(this).find("input[name='value_brand']");
                    let text_error        = $(this).find("span[class='text_error update']");

                    let input_zamena_file = $(this).find("input[name='input_zamena_img']");
                    let img_upload        = $(this).find("img[id='img_upload']");
                    let home_img_error    = $(this).find("span[class='home_img_error update']");

                    let value_discription = $(this).find("textarea[name='value_discription']");
                    let description_error = $(this).find("span[class='description_error update']");

                    let value_model       = $(this).find("input[name='value_model']");
                    let model_error       = $(this).find("span[class='Model_error update']");

                    let value_color       = $(this).find("input[name='value_color']");
                    let color_error       = $(this).find("span[class='color_error update']");

                    let value_price       = $(this).find("input[name='value_price']");
                    let price_error       = $(this).find("span[class='price_error update']");




                    
                    let value_brand_val       = value_brand.val();
                    let value_discription_val = value_discription.val();
                    let value_model_val       = value_model.val();
                    let value_color_val       = value_color.val();
                    let value_price_val       = value_price.val();

                    
                    



                    //console.log(btn_input_delete_val);


                    //проверка будет производится если мы не удаляем карточку а обновляем
                    if (btn_input_delete_val != 'delete') {



                        //____________________________ПОВЕРЯЕМ ДАННЫЕ С ПОЛЕЙ ВВОДА ТЕКСТА НА КЛИЕНТСКОЙ СТОРОНЕ

                        //эта проверка актуальна если данные не ушли на сервер

                        //_______________________________BRAND
                        if (value_brand_val == '') {
                            value_brand.css({'border':'1px dashed red','box-shadow':'0 0 5px red'}); 
                            text_error.html('Это поле обязательно к заполнению'); 

                        }else if(value_brand_val.length >= 30 ){
                            value_brand.css({'border':'1px dashed red','box-shadow':'0 0 5px red'}); 
                            text_error.html("Недопусимая длина строки (до 30 символов)");

                        }else{
                            value_brand.css({'border':'1px dashed green','box-shadow':'0 0 5px green'});
                            text_error.html('');  
                        }


                        //_______________________________DESCRIPTION
                        if (value_discription_val == '') {
                            value_discription.css({'border':'1px dashed red','box-shadow':'0 0 5px red'}); 
                            description_error.html('Это поле обязательно к заполнению');  

                        }else if(value_discription_val.length >= 100000 ){
                            value_discription.css({'border':'1px dashed red','box-shadow':'0 0 5px red'}); 
                            description_error.html("Недопусимая длина строки (до 10000 символов)");

                        }else{
                            value_discription.css({'border':'1px dashed green','box-shadow':'0 0 5px green'});
                            description_error.html('');  
                        }


                        //_______________________________MODEL
                        if (value_model_val == '') {
                            value_model.css({'border':'1px dashed red','box-shadow':'0 0 5px red'}); 
                            model_error.html('Это поле обязательно к заполнению');  

                        }else if(value_model_val.length >= 100 ){
                            value_model.css({'border':'1px dashed red','box-shadow':'0 0 5px red'}); 
                            model_error.html("Недопусимая длина строки (до 100 символов)");

                        }else{
                            value_model.css({'border':'1px dashed green','box-shadow':'0 0 5px green'}); 
                            model_error.html(''); 
                        }


                        //_______________________________COLOR
                        if (value_color_val == '') {
                            value_color.css({'border':'1px dashed red','box-shadow':'0 0 5px red'}); 
                            color_error.html('Это поле обязательно к заполнению');  

                        }else if(value_color_val.length >= 100 ){
                            value_color.css({'border':'1px dashed red','box-shadow':'0 0 5px red'}); 
                            color_error.html("Недопусимая длина строки (до 100 символов)");

                        }else{
                            value_color.css({'border':'1px dashed green','box-shadow':'0 0 5px green'}); 
                            color_error.html('');
                        }




                        //_______________________________PRICE
                        if (value_price_val == '') {
                            value_price.css({'border':'1px dashed red','box-shadow':'0 0 5px red'}); 
                            price_error.html('Это поле обязательно к заполнению'); 
                        
                        }else{

                            //заменяем запятую на точку
                            value_price_val = value_price_val.replaceAll(',', '.');

                            if(!(/^[0-9]*[.]?[0-9]+$/.test(value_price_val))){

                                value_price.css({'border':'1px dashed red','box-shadow':'0 0 5px red'}); 
                                price_error.html('введите только цифры без пробелов и символов кроме . и ,');
                            

                            }else if(value_price_val >= 100000 ){
                                value_price.css({'border':'1px dashed red','box-shadow':'0 0 5px red'}); 
                                price_error.html("Недопусимая сумма - введите не больше 100 000.00");
                            

                            }else if(value_price_val <= 0 ){
                                value_price.css({'border':'1px dashed red','box-shadow':'0 0 5px red'}); 
                                price_error.html("Недопусимая сумма - введите больше 0");
                            

                            }else if(!(/^\d{0,10}(\d{1,10}[.]\d{0,2})?$/.test(value_price_val))){
                                value_price.css({'border':'1px dashed red','box-shadow':'0 0 5px red'}); 
                                price_error.html('введите корректное число');
                                                 
                            }else{
                                value_price.css({'border':'1px dashed green','box-shadow':'0 0 5px green'});
                                price_error.html(''); 
                            } 
                        }





                        //передаем в параметр функции (для проверки размера файла) массив
                        var validationErrors = validateFiles({
                                                                option_file_img: input_zamena_file,
                                                                option_maxSize: 7 * 1024 * 1024,  //Максимальный размер файла 7 Мб
                                                                option_minSize: 1000,             //Минимальный размер файла 
                                                                option_types: ['image/jpeg', 'image/jpg', 'image/png']
                                                            });
                           
                        
                        
                        //console.log(validationErrors);


                        // если функция возратила не пустой массив то
                        if (validationErrors.length != 0) {
                            console.log('client validation errors: ', validationErrors);
                            input_zamena_file.css({'border':'1px dashed red','box-shadow':'0 0 5px red'}); 
                            img_upload.css({'border':'1px dashed red','box-shadow':'0 0 5px red'}); 
                            home_img_error.html('ошибка при загрузке файла');

                            if (validationErrors.length == 1){
                                alert('при загрузке файла фозникли следующие ошибки:' + '\n' + 
                                       validationErrors[0]['errorCode']                            
                                );
                            }else if (validationErrors.length == 2){
                                alert('при загрузке файла фозникли следующие ошибки:' + '\n' + 
                                       validationErrors[0]['errorCode']               + '\n' + 
                                       validationErrors[1]['errorCode']                                                       
                                );
                            }

                            return false;

                        // Добавление файлов в formdata
                        }else{
                            input_zamena_file.css({'border':'1px dashed green','box-shadow':'0 0 5px green'});
                            img_upload.css(       {'border':'1px dashed green','box-shadow':'0 0 5px green'});
                            home_img_error.html('');

                            var formData = new FormData($(this).get(0));

                        }


                    }else{

                        var formData = new FormData($(this).get(0));
                    }

                    


                    $.ajax({
                        url: $(this).attr('action'),
                        type: $(this).attr('method'),
                        contentType: false, //  убираем форматирование данных по умолчанию
                        processData: false, //  убираем преобразование строк по умолчанию
                        data: formData,
                        dataType: 'json',
                        success: function(data){

                            console.log(data);


                            //выводим при удалении карточки
                            if (data['delete'] == 'succes') {

                                setTimeout(function () {
                                    alert(  data['mysql_rezult'] )                           
                                }, 100);
                                
                                setTimeout(function () {
                                   window.location.href = "index.php?page=admin"; 
                                }, 150);
                                
                            }else if(data['delete'] == 'error'){

                                setTimeout(function () {
                                    alert(  data['mysql_rezult'] )                      
                                }, 100);
                                 
                            }
                            

                            //выводим при успешном обновлении всех полей в карточке
                            if (data['succes'] == 'succes_update_img') {

                                //убираем все сообщения говорящие об ошибках
                                text_error.html(       '');
                                home_img_error.html(   '');  
                                description_error.html('');
                                model_error.html(      '');  
                                color_error.html(      '');
                                price_error.html(      '');
                                value_brand.css(      {'border':'1px dashed green','box-shadow':'0 0 5px green'});
                                input_zamena_file.css({'border':'1px dashed green','box-shadow':'0 0 5px green'});
                                img_upload.css(       {'border':'1px dashed green','box-shadow':'0 0 5px green'});
                                value_discription.css({'border':'1px dashed green','box-shadow':'0 0 5px green'});
                                value_model.css(      {'border':'1px dashed green','box-shadow':'0 0 5px green'}); 
                                value_color.css(      {'border':'1px dashed green','box-shadow':'0 0 5px green'}); 
                                value_price.css(      {'border':'1px dashed green','box-shadow':'0 0 5px green'});


                                //console.log(data);

                                //выводим алеот
                                setTimeout(function () {

                                            alert(  data['mysql_rezult'][0]['update_brand']          + '\n' + 
                                                    data['mysql_rezult'][0]['name_img']              + '\n' +
                                                    data['mysql_rezult'][0]['update_img']            + '\n' +
                                                    data['mysql_rezult'][0]['update_discription']    + '\n' +  
                                                    data['mysql_rezult'][0]['update_model']          + '\n' + 
                                                    data['mysql_rezult'][0]['update_color']          + '\n' +
                                                    data['mysql_rezult'][0]['update_price']          
            
                                                    
                                                );
                                      
                                }, 100);

                                
                                setTimeout(function () {
                                   window.location.href = "index.php?page=admin"; 
                                }, 150);
                                









                            //выводим при НЕуспешном обновлении всех полей в карточке
                            }else if (data['succes'] == 'error_update_img') {

                                //убираем все сообщения говорящие об ошибках
                                text_error.html(       '');
                                home_img_error.html(   '');  
                                description_error.html('');
                                model_error.html(      '');  
                                color_error.html(      '');
                                price_error.html(      '');
                                value_brand.css(      {'border':'1px dashed green','box-shadow':'0 0 5px green'});
                                input_zamena_file.css({'border':'1px dashed green','box-shadow':'0 0 5px green'});
                                img_upload.css(       {'border':'1px dashed green','box-shadow':'0 0 5px green'});
                                value_discription.css({'border':'1px dashed green','box-shadow':'0 0 5px green'});
                                value_model.css(      {'border':'1px dashed green','box-shadow':'0 0 5px green'}); 
                                value_color.css(      {'border':'1px dashed green','box-shadow':'0 0 5px green'}); 
                                value_price.css(      {'border':'1px dashed green','box-shadow':'0 0 5px green'});


                                //console.log(data);

                                //выводим алеот
                                setTimeout(function () {

                                            alert(  data['mysql_rezult'][0]['mysqli_error']  );        
               
                                }, 100);

                                
                                setTimeout(function () {
                                   window.location.href = "index.php?page=admin"; 
                                }, 150);










                            //выводим при успешном обновлении всех полей в карточке кроме обновления картинки
                            }else if (data['succes'] == 'succes_no_update_img') {


                                //убираем все сообщения говорящие об ошибках
                                text_error.html(       '');
                                home_img_error.html(   '');  
                                description_error.html('');
                                model_error.html(      '');  
                                color_error.html(      '');
                                price_error.html(      '');
                                value_brand.css(      {'border':'1px dashed green','box-shadow':'0 0 5px green'});
                                input_zamena_file.css({'border':'1px dashed green','box-shadow':'0 0 5px green'});
                                img_upload.css(       {'border':'1px dashed green','box-shadow':'0 0 5px green'});
                                value_discription.css({'border':'1px dashed green','box-shadow':'0 0 5px green'});
                                value_model.css(      {'border':'1px dashed green','box-shadow':'0 0 5px green'}); 
                                value_color.css(      {'border':'1px dashed green','box-shadow':'0 0 5px green'}); 
                                value_price.css(      {'border':'1px dashed green','box-shadow':'0 0 5px green'});


                               // console.log(data);

                                //выводим алеот
                                setTimeout(function () {

                                            alert(  data['mysql_rezult'][0]['update_brand']          + '\n' + 
                                                    data['mysql_rezult'][0]['update_img']            + '\n' +
                                                    data['mysql_rezult'][0]['update_discription']    + '\n' +  
                                                    data['mysql_rezult'][0]['update_model']          + '\n' + 
                                                    data['mysql_rezult'][0]['update_color']          + '\n' +
                                                    data['mysql_rezult'][0]['update_price']          
                                                              

                                                );
                                      
                                }, 100);

                                
                                setTimeout(function () {
                                   window.location.href = "index.php?page=admin"; 
                                }, 150);








                            //выводим при НЕуспешном обновлении всех полей в карточке кроме обновления картинки
                            }else if (data['succes'] == 'error_no_update_img') {

                                //убираем все сообщения говорящие об ошибках
                                text_error.html(       '');
                                home_img_error.html(   '');  
                                description_error.html('');
                                model_error.html(      '');  
                                color_error.html(      '');
                                price_error.html(      '');
                                value_brand.css(      {'border':'1px dashed green','box-shadow':'0 0 5px green'});
                                input_zamena_file.css({'border':'1px dashed green','box-shadow':'0 0 5px green'});
                                img_upload.css(       {'border':'1px dashed green','box-shadow':'0 0 5px green'});
                                value_discription.css({'border':'1px dashed green','box-shadow':'0 0 5px green'});
                                value_model.css(      {'border':'1px dashed green','box-shadow':'0 0 5px green'}); 
                                value_color.css(      {'border':'1px dashed green','box-shadow':'0 0 5px green'}); 
                                value_price.css(      {'border':'1px dashed green','box-shadow':'0 0 5px green'});


                               // console.log(data);

                                //выводим алеот
                                setTimeout(function () {

                                            alert(  data['mysql_rezult'][0]['mysqli_error']  );        
               
                                }, 100);

                                
                                setTimeout(function () {
                                   window.location.href = "index.php?page=admin"; 
                                }, 150);











                            }else if(data['error'] == 'error'){
                                //console.log(data);

                                //_______________________________BRAND
                                if (data['brand_Err'] != '') {
                                    value_brand.css({'border':'1px dashed red','box-shadow':'0 0 5px red'}); 
                                    text_error.html(data['brand_Err']); 
                                }else{
                                    value_brand.css({'border':'1px dashed green','box-shadow':'0 0 5px green'});
                                    text_error.html('');  
                                }


                                //_______________________________FILES
                                if (isNaN(data['result_add_img']['error'])) {
                                    input_zamena_file.css({'border':'1px dashed red','box-shadow':'0 0 5px red'}); 
                                    img_upload.css({'border':'1px dashed red','box-shadow':'0 0 5px red'}); 
                                    home_img_error.html(data['result_add_img']['error']); 
                                }else{
                                    input_zamena_file.css({'border':'1px dashed green','box-shadow':'0 0 5px green'});
                                    img_upload.css({'border':'1px dashed green','box-shadow':'0 0 5px green'});
                                    home_img_error.html('');  
                                }


                                //_______________________________DESCRIPTION
                                if (data['discription_Err'] != '') {
                                    value_discription.css({'border':'1px dashed red','box-shadow':'0 0 5px red'}); 
                                    description_error.html(data['discription_Err']); 
                                }else{
                                    value_discription.css({'border':'1px dashed green','box-shadow':'0 0 5px green'});
                                    description_error.html('');  
                                }


                                //_______________________________MODEL
                                if (data['model_Err'] != '') {
                                    value_model.css({'border':'1px dashed red','box-shadow':'0 0 5px red'}); 
                                    model_error.html(data['model_Err']); 
                                }else{
                                    value_model.css({'border':'1px dashed green','box-shadow':'0 0 5px green'}); 
                                    model_error.html(''); 
                                }


                                //_______________________________COLOR
                                if (data['color_Err'] != '') {
                                    value_color.css({'border':'1px dashed red','box-shadow':'0 0 5px red'}); 
                                    color_error.html(data['color_Err']); 
                                }else{
                                    value_color.css({'border':'1px dashed green','box-shadow':'0 0 5px green'}); 
                                    color_error.html('');
                                }


                                //_______________________________PRICE
                                if (data['price_Err'] != '') {
                                    value_price.css({'border':'1px dashed red','box-shadow':'0 0 5px red'}); 
                                    price_error.html(data['price_Err']); 
                                }else{
                                    value_price.css({'border':'1px dashed green','box-shadow':'0 0 5px green'});
                                    price_error.html(''); 
                                } 


                                
                                
                            }
                        }
                    });
                });


                
            });

        }

       
    }
    

    
});



