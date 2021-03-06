//Применение фильтра по нажатию на кнопку "Применить"
	$('#filter').click(function(){
				var num = parseInt($('option[name=pag]:selected').val(), 10); //Выбираем кол-во результатов на странице
				var vybor = $('input[name=vybor]:checked').val(); //Присваиваем значение состояния чекбокса авторизации
				var pov = $('input[name=pov]:checked').val(); //Присваиваем значение состояения чекбокса повторов
				var emailtr = $('#email').val(); //Присваиваем значение емайла
				var email = emailtr.trim(); //Убираем пробелы
                var from_date = $('#from_date').val(); //Присваиваем значения дате "от" 
                var to_date = $('#to_date').val(); //Присваиваем значения дате "до" 
                if(from_date != '' && to_date != '') //Если поля дат не пусты
                {  
						$.ajax({  
                          url:"obrabotka.php", //Файл обрабокти 
                          method:"POST",  //Метод
                          data:{from_date:from_date, to_date:to_date, vybor:vybor, pov:pov, email:email},  //Отправляем массив данных
                          success:function(data)  
                          {  
                               $('#order_table').html(data); //Выводим новые данные в указанный див
							   $(document).ready(function (){ //Функция пагинации
								  $('#order_table').pageMe({ //Выбираем таблицу для пагинации
									pagerSelector:'#myPager', //ID переключателя страниц
									activeColor: 'blue', //Цвет кнопки текущей страницы
									prevText:'Предыдущая', //Подпись левой стрелки
									nextText:'Следющая', //Подпись правой стрелки
									showPrevNext:true, //Отображать ссылки на предыдущую и следующую страницы
									hidePageNumbers:false, //Скрывать номера страниц
									perPage:num //Число результатов на странице
								  });
								});							   
                          }  
						});	
                }			
                else //Если не выбрали дату(ы)
                {  
                     alert("Пожалуйста, выберите даты"); //Окно ошибки 
                }  
	});  