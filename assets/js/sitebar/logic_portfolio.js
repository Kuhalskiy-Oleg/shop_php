$(function(){

	

	var intro = $('.intro'),                                 //intro блок 
		sidebar = $('.sidebar'),
		intro_visota = intro.innerHeight(),                  //для подсчета высоты intro
		scrollpos = $(window).scrollTop(),                   //для подсчета высоты всего сайта
		window_width = $(window).innerWidth(),               //для подсчета ширины всего сайта
		head_intro_mini_fixed = $('.head_intro_mini_fixed'), //щапка блока интро мини фиксированная
		burger = $('.burger');                               //бургер

	



	
	$(window).on('scroll load resize' , function() {
		
		scrollpos = $(window).scrollTop();
		intro_visota = intro.innerHeight();
		window_width = $(window).innerWidth();



		//ПРИ АКАРДИОНЕ И ЖЕСТКОМ ВКЛ-ВЫКЛ
		// при ширине экрана большей ... когда исчезает мини_меню мы удаляем класс актив(если мы не используем аккардион) или удаляем атрибут style(если мы не используем жесткое вкл-выкл менюшки) у менюшки чтобы потом при ширине экрана меньшей чем 769 нам появилось бургер меню без открытой менюшки
		if (window_width > 883){ //ГЛЮЧИТ НА -17PX нужно было 900

			
			
			sidebar.removeClass('activ');
			

			//удаляем класс актив у бургера что бы он небыл крестиком
			burger.removeClass('activ_burger');

			$('body').removeClass('no_scroll'); 
			$('.maska_sidebar').removeClass('activ');

			
		}

		
	
	});

	



	
	//при клике на бУРГЕР исполню:
	burger.on('click' , function(event) { 

		event.preventDefault();                          

		sidebar.toggleClass('activ');              //ВЫДАЕМ КЛАСС АКТИВ САЙТБАРУ что бы он вылез благодаря свойству transform translateX прописанному в css
		burger.toggleClass('activ_burger');        //ВЫДАЕМ БУРГЕРУ КЛАСС АКТИВНОСТИ
		$('body').toggleClass('no_scroll');        //выдаем класс тегу body который убирет скролл &.no_scroll{overflow: hidden;}
		$('.maska_sidebar').toggleClass('activ');  //выдаем класс актив родителю сайтбара чтобы он затемнил все окно кроме самого сайтбара
		


		//для закрытия cайтбара  при клике по родителю-маске
		$('.maska_sidebar').on("click", function(){

			

			$('.maska_sidebar').removeClass('activ');
			burger.removeClass('activ_burger');
			sidebar.removeClass('activ');				//удаляем класс show у окна по которому мы нажали
			$('body').removeClass('no_scroll');     //убираем класс у body который отвечает за стопорку скрола
			
			
		});


		//что бы cайтбар не закрывался при клике по его телу
		sidebar.on('click',function(event){
			event.stopPropagation();
			

		});
	});


	


	//при клике по кнопкам и ссылкам с таким атрибутом мы удаляем классы у сайтбара и фона тега маин и только после этого совершается переход на другую страницу
	$('[data-close_sitebar]').on('click',  function(event) {

		event.preventDefault();
		burger.removeClass('activ_burger');
		sidebar.removeClass('activ');
		$('body').removeClass('no_scroll'); 
		$('.maska_sidebar').removeClass('activ');

		

	});





	






});	