$(function(){ //Функция настройки дат
		$('#from_date').datetimepicker({ //Дата начала
						language:  'ru', //Язык русский
						weekStart: 1, //Начало недели с понедельника
						todayHighlight: true, //Подсвечивать текущую дату
						autoclose: true //Закрытие формы после выбора данных
					});
		$('#to_date').datetimepicker({ //Дата конца
						language:  'ru',
						weekStart: 1,
						todayHighlight: true,
						autoclose: true
					});
		}); 