function chbx(obj) //Функция чб как radio
		{
		var that = obj; //Задаем переменную со значением obj
		if(document.getElementById(that.id).checked == true) { //Если выбран ЧБ, то запрещаем выбрать дополнительный ЧБ и переключается на него
			document.getElementById('id1').checked = false;
			document.getElementById('id2').checked = false;
			document.getElementById('id3').checked = false;
			document.getElementById(that.id).checked = true;
			}
		}