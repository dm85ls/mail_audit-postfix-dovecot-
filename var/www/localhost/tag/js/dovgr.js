	//Применение фильтра по нажатию на кнопку "Применить"
	$('#filter').click(function(){  
				$('input[class=series-chk]:not(checked)').prop('checked', true);	//Обнуляем значение column
                var from_date = $('#from_date').val(); //Присваиваем значения дате "от" 
                var to_date = $('#to_date').val(); //Присваиваем значения дате "до" 
                if(from_date != '' && to_date != '') //Если поля дат не пусты
                {  
						$.ajax({  
                          url:"dovecotgrob.php", //Файл обработки запроса 
                          method:"POST",  //Выбираем метод 
                          data:{from_date:from_date, to_date:to_date,},  //Отправляем массив данных
                          success:function(data)  
                          {  
                                $('#chart_div').html(data); //Выводим новые данные в указанный див
                          }  
						});	
                }			
                else //Если не выбрали дату(ы)
                {  
                     alert("Пожалуйста, выберите даты");  //Окно ошибки
                }  
	});  