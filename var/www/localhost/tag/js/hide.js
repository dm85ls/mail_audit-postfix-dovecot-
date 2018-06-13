function showOrHide(cb, cat) //Функция скрытого влока
		{
		cb = document.getElementById(cb); //Получаем значение cb  
		cat = document.getElementById(cat); //Получаем значение cat 
		if (cb.checked) cat.style.display = "block"; //Если выбран ЧБ, то показывать строку
		else cat.style.display = "none"; //Иначе скрыть
		}