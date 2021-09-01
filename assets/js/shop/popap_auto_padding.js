$(function(){

	const PopupLinks = document.querySelectorAll('.PopupLinks');   //записываем в переменную все обьекты с классом PopupLinks . при клике на этот класс откроется модальное окно
	const Body = document.querySelector('body');                   //записываем в переменную один обьект тег боди
	const LockPadding = document.querySelectorAll('.LockPadding'); //записываем в переменную все обьекты с классом LockPadding . для фиксированных обьектов на сайте

	const time = 800; //задержка срабатывания функции. Время указывается такое же как и в css в transition

	let onelock = true; //для того чтобы небыло двойных быстрых нажатий на обьекты с классом PopupLinks чтобы небыло глюков при открытии модальных окон / при true переменная считается открытой

	//console.log(PopupLinks)


	// Переменная «e» как способ получения елемента на котором произошло событие
	// е - функция в которой мы передаем id нужного попапа в функцию открытия попапа
	// length -Длина массива: число, на единицу превосходящее максимальный индекс массива
	// если количество элементов в массиве больше нуля то запускаем цикл.
	// в цикле будет столько итераций сколько будет элементов в массиве PopupLinks.length и переменная index будет увеличиваться на 1 с каждой итерацией
	// PopupLink в ней будет хранится каждый обьект по отдельности из массива PopupLinks
	// addEventListener - назначения обработчиков (вешаем на обьект PopupLink событие клика)
	// getAttribute - получаем от обьекта атрибут href и удаляем из него решетку и пробелы чтобы получить чистое имя
	// PopupName - в эту переменную записываем значение атрибута href
	// CurentPopup - в эту переменную записываем значение атрибута href из PopupName и это значение должно соответствовать id того попапа котрое следует открыть при нажатии на кнопку
	// popupOpen(CurentPopup); - отправляем id попапа который нужно открыть в функцию
	if (PopupLinks.length > 0) {
		for (let index = 0; PopupLinks.length > index; index++ ){
			const PopupLink = PopupLinks[index];
			//console.log(PopupLink);
			PopupLink.addEventListener("click", function(e){
				const PopupName = PopupLink.getAttribute('popup');
				const CurentPopup = document.getElementById(PopupName);
				PopupOpen(CurentPopup);
			});

		}
	}

	// Переменная «e» как способ получения елемента на котором произошло событие
	// е - функция в которой мы передаем id нужного попапа в функцию открытия попапа
	// код для закрытия попапа
	// Метод Element.closest() возвращает ближайший родительский элемент (или сам элемент), который соответствует заданному CSS-селектору
	// т.е мы можем в теле попапа разместить обьект с классом close_popup и при нажатии на него мы обратимся к родителю т.е к самому модальному окну с классом popup 
	// и этого родителя (само модальное окно) мы передаем в  функцию PopupClose
	const PopupCloseObject = document.querySelectorAll('.close_popup');//обьект с классом close_popup
	if (PopupCloseObject.length > 0){
		for ( let index = 0; PopupCloseObject.length > index; index++){
			const el = PopupCloseObject[index];
			el.addEventListener('click', function(e){
				PopupClose(el.closest('.popup'));
				e.preventDefault();
			});
		}
	}


	
	//функция открытия попапа
	//в нее мы передаем обьект попапа по id полученного из атрибута href у обьекта с классом PopupLinks
	//далее проверяем есть ли такой обект и открыта ли переменная onelock . если будет onelock = false то она будет закрытая
	//создаем переменную в котрую записываем открытый попап и если он существует то мы его отпраляем в функцию закрытия чтобы открылся новый попап который будет в первом попапе
	//если не то мы еще блочим наш скролл
	//свойство classList объекта Element является свойством только для чтения, которое возвращает живую коллекцию DOMTokenList, содержащую значение глобального атрибута class (классы элемента).
	//далее если нет открытых попапов мы добавляем класс open к выбранному попапу чтобы его показать
	//и вешаем события клика на открывшийся попап и создаем условие которое отсекает все кроме темной области
	//если у попапа нету в родителях обьекта с классом Popup_content тогда мы попаз закрываем т.е передаем в функцию закрытия ближайший обьект с классом попап
	//т.е при клике внутри блока popup_content у нас ничего не произойдет но если мы кликнем за пределами этого блока то попап закроетсся
	//target — триггер, позволяющий получить доступ к элементу, над которым произошло событие.
	function PopupOpen(CurentPopup){
		if (CurentPopup && onelock){
			const PopuapActive = document.querySelector('.popup.open');
			if (PopuapActive){
				
				PopupClose(PopuapActive,  false);
			}else{
				BodyLock();
			}
			CurentPopup.classList.add('open');
			CurentPopup.addEventListener('click',function(e){
				if (!e.target.closest('.popup_content')){
					PopupClose(e.target.closest('.popup'));
				}
			});
		}
	}


	//функция закрытия попапа
	function PopupClose(PopuapActive, onelock = true){
		if(onelock == true){
			//console.log('s')
			PopuapActive.classList.remove('open');
			if(onelock){
				BodyUnLock();
			}
		}else{
			PopuapActive.classList.remove('open');
		}
	}



	//функция для автоматического добавления  поддинга при открытии попаппа
	//LockPaddingValue в нее записываем разницу между шириной окна и шириной боди . эта разница и будет padding
	//у шапки уже есть паддинг с права 15 и значит нам нужно прибавить к 15 разницу между шириной окна и контейнером
	function BodyLock(){
		const LockPaddingValue = window.innerWidth - document.querySelector('body').offsetWidth ;

		if (LockPadding.length > 0 ) {
			for (let index = 0; LockPadding.length > index; index++){
				const el = LockPadding[index];
				let = rezult_padding_plus_padding = LockPaddingValue + 15;
				el.style.paddingRight =  rezult_padding_plus_padding + 'px';
				
			}
		}
		Body.style.paddingRight = LockPaddingValue + 'px' ;
		Body.classList.add('lock');

		onelock = false;
		setTimeout(function(){
			onelock = true;

		}, time);
	}


	//функция для автоматического удаления поддинга при открытии попаппа
	function BodyUnLock(){
		setTimeout(function(){
			if(LockPadding.length > 0){
				for(let index = 0; LockPadding.length > index; index++ ){
					const el = LockPadding[index];
					el.style.paddingRight = '15px';
				}
			}
			Body.style.paddingRight = '0px';
			Body.classList.remove('lock');

		},time);

		onelock = false;
		setTimeout(function(){
			onelock = true;
		},time);
	}



	//функция для закрывания попапа через нажатие на клавиатуре клавиши эскейп
	document.addEventListener('keydown', function(e){
		if (e.which === 27 ) {
			const PopuapActive = document.querySelector('.popup.open');
			PopupClose(PopuapActive);
		}
	})



















})