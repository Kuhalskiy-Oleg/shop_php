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
                result.push({errorCode: 'файл не выбран'});
                return;
            }
            
            file = file_img.files[0];
            $('span.span_absolut').html(file.name);
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


    $('#form_add_card').on('submit', function(e){
        e.preventDefault();
        

        let value_brand       = $(this).find("input[name='value_brand']");
        let text_error        = $(this).find("span[class='text_error add']");

        let img_add           = $(this).find("img[id='img_add']");
        let file_input_id     = $(this).find("input[name='add_file']");
        let home_img_error    = $(this).find("span[class='home_img_error add']");

        let value_discription = $(this).find("textarea[name='value_discription']");
        let description_error = $(this).find("span[class='description_error add']");

        let value_model       = $(this).find("input[name='value_model']");
        let model_error       = $(this).find("span[class='Model_error add']");

        let value_color       = $(this).find("input[name='value_color']");
        let color_error       = $(this).find("span[class='color_error add']");

        let value_price       = $(this).find("input[name='value_price']");
        let price_error       = $(this).find("span[class='price_error add']");



        //____________________________ПОВЕРЯЕМ ДАННЫЕ С ПОЛЕЙ ВВОДА ТЕКСТА НА КЛИЕНТСКОЙ СТОРОНЕ
        let value_brand_val       = value_brand.val();
        let value_discription_val = value_discription.val();
        let value_model_val       = value_model.val();
        let value_color_val       = value_color.val();
        let value_price_val       = value_price.val();
        let array_errors_client_valid = [];

        //эта проверка актуальна если данные не ушли на сервер

        //_______________________________BRAND
        if (value_brand_val == '') {
            value_brand.css({'border':'1px dashed red','box-shadow':'0 0 5px red'}); 
            text_error.html('Это поле обязательно к заполнению'); 
            array_errors_client_valid = 'error';

        }else if(value_brand_val.length >= 30 ){
            value_brand.css({'border':'1px dashed red','box-shadow':'0 0 5px red'}); 
            text_error.html("Недопусимая длина строки (до 30 символов)");
            array_errors_client_valid = 'error';

        }else{
            value_brand.css({'border':'1px dashed green','box-shadow':'0 0 5px green'});
            text_error.html('');  
        }


        //_______________________________DESCRIPTION
        if (value_discription_val == '') {
            value_discription.css({'border':'1px dashed red','box-shadow':'0 0 5px red'}); 
            description_error.html('Это поле обязательно к заполнению');  
            array_errors_client_valid = 'error';

        }else if(value_discription_val.length >= 100000 ){
            value_discription.css({'border':'1px dashed red','box-shadow':'0 0 5px red'}); 
            description_error.html("Недопусимая длина строки (до 10000 символов)");
            array_errors_client_valid = 'error';

        }else{
            value_discription.css({'border':'1px dashed green','box-shadow':'0 0 5px green'});
            description_error.html('');  
        }


        //_______________________________MODEL
        if (value_model_val == '') {
            value_model.css({'border':'1px dashed red','box-shadow':'0 0 5px red'}); 
            model_error.html('Это поле обязательно к заполнению');  
            array_errors_client_valid = 'error';

        }else if(value_model_val.length >= 100 ){
            value_model.css({'border':'1px dashed red','box-shadow':'0 0 5px red'}); 
            model_error.html("Недопусимая длина строки (до 100 символов)");
            array_errors_client_valid = 'error';

        }else{
            value_model.css({'border':'1px dashed green','box-shadow':'0 0 5px green'}); 
            model_error.html(''); 
        }


        //_______________________________COLOR
        if (value_color_val == '') {
            value_color.css({'border':'1px dashed red','box-shadow':'0 0 5px red'}); 
            color_error.html('Это поле обязательно к заполнению');  
            array_errors_client_valid = 'error';

        }else if(value_color_val.length >= 100 ){
            value_color.css({'border':'1px dashed red','box-shadow':'0 0 5px red'}); 
            color_error.html("Недопусимая длина строки (до 100 символов)");
            array_errors_client_valid = 'error';

        }else{
            value_color.css({'border':'1px dashed green','box-shadow':'0 0 5px green'}); 
            color_error.html('');
        }


        
        //_______________________________PRICE
        if (value_price_val == '') {
            value_price.css({'border':'1px dashed red','box-shadow':'0 0 5px red'}); 
            price_error.html('Это поле обязательно к заполнению'); 
            array_errors_client_valid = 'error';

        }else{

            //заменяем запятую на точку
            value_price_val = value_price_val.replaceAll(',', '.');

            if(!(/^[0-9]*[.]?[0-9]+$/.test(value_price_val))){

                value_price.css({'border':'1px dashed red','box-shadow':'0 0 5px red'}); 
                price_error.html('введите только цифры без пробелов и символов кроме . и ,');
                array_errors_client_valid = 'error';

            }else if(value_price_val >= 100000 ){
                value_price.css({'border':'1px dashed red','box-shadow':'0 0 5px red'}); 
                price_error.html("Недопусимая сумма - введите не больше 100 000.00");
                array_errors_client_valid = 'error';

            }else if(value_price_val <= 0 ){
                value_price.css({'border':'1px dashed red','box-shadow':'0 0 5px red'}); 
                price_error.html("Недопусимая сумма - введите больше 0");
                array_errors_client_valid = 'error';

            }else if(!(/^\d{0,10}(\d{1,10}[.]\d{0,2})?$/.test(value_price_val))){
                value_price.css({'border':'1px dashed red','box-shadow':'0 0 5px red'}); 
                price_error.html('введите корректное число');
                array_errors_client_valid = 'error';

            
            }else{
                value_price.css({'border':'1px dashed green','box-shadow':'0 0 5px green'});
                price_error.html(''); 
            } 
        }








        var formData = new FormData($(this).get(0)); // создаем новый экземпляр объекта и передаем ему нашу форму 

        //передаем в параметр функции (для проверки размера файла) массив
        var validationErrors = validateFiles({
                                                option_file_img: file_input_id,
                                                option_maxSize: 7 * 1024 * 1024,  //Максимальный размер файла 7 Мб
                                                option_minSize: 1000,             //Минимальный размер файла 
                                                option_types: ['image/jpeg', 'image/jpg', 'image/png']
                                            });
           
        //var formData = new FormData; 
        
        //console.log(validationErrors);


        // если функция возратила не пустой массив то
        if (validationErrors.length != 0) {
            console.log('client validation errors: ', validationErrors);
            img_add.css({'border':'1px dashed red','box-shadow':'0 0 5px red'}); 
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

        }else{
            img_add.css({'border':'1px dashed green','box-shadow':'0 0 5px green'});
            home_img_error.html('');
        }



        // Добавление файлов в formdata если ошибок нет на стороне клиента то данные передаются на сервер
        if((validationErrors.length == 0) && (array_errors_client_valid.length == 0)){

            formData = new FormData($(this).get(0));

            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                contentType: false, //  убираем форматирование данных по умолчанию
                processData: false, //  убираем преобразование строк по умолчанию
                data: formData,
                dataType: 'json',
                success: function(data){
                   
                    console.log(data);
                    if (data['succes'] == 'succes') {

                        //убираем все сообщения говорящие об ошибках
                        text_error.html(       '');
                        home_img_error.html(   '');  
                        description_error.html('');
                        model_error.html(      '');  
                        color_error.html(      '');
                        price_error.html(      '');
                        value_brand.css(      {'border':'1px dashed green','box-shadow':'0 0 5px green'});
                        img_add.css(       {'border':'1px dashed green','box-shadow':'0 0 5px green'});
                        value_discription.css({'border':'1px dashed green','box-shadow':'0 0 5px green'});
                        value_model.css(      {'border':'1px dashed green','box-shadow':'0 0 5px green'}); 
                        value_color.css(      {'border':'1px dashed green','box-shadow':'0 0 5px green'}); 
                        value_price.css(      {'border':'1px dashed green','box-shadow':'0 0 5px green'});


                        //console.log(data);

                        setTimeout(function () {
                           alert( (data['result_add_img']['succes']) + '\n' + ('добавлена запись в базу данных №-' + data['rezult_add_data_db'])); 
                        }, 100);

                        
                        setTimeout(function () {
                           window.location.href = "index.php?page=admin&select=product_edid"; 
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
                        if (data['result_add_img']['error']) {
                            img_add.css({'border':'1px dashed red','box-shadow':'0 0 5px red'}); 
                            home_img_error.html(data['result_add_img']['error']); 
                        }else if(data['result_add_img']['succes']) {
                            img_add.css({'border':'1px dashed green','box-shadow':'0 0 5px green'});
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

        }
        
    });
});



