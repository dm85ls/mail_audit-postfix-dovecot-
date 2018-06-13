$(function() { //Функция очистки поля email
    var input = $('#emailfrom'); //Задаем переменную со значениме, полученным из формы "emailfrom"
	var input1 = $('#emailto'); //Задаем переменную со значениме, полученным из формы "emailto"
	var input2 = $('#email'); //Задаем переменную со значениме, полученным из формы "email"
    var value = input.val(); //Присваиваем переменной значение "emailfrom"
	var value1 = input1.val(); //Присваиваем переменной значение "emailto"
	var value1 = input2.val(); //Присваиваем переменной значение "email"
    $('#cb1').change(function() { //Функция очистки поля
        if (this.checked) { //Если изменилось состояние ЧБ, то значения обнуляются
			input.data('value', input.val());
            input.val('');
			input1.data('value1', input1.val());
            input1.val('');
			input2.data('value1', input2.val());
            input2.val('');
        } else { //Иначе не меняем значения
			input.val(input.data('value'));
			input1.val(input1.data('value1'));
			input2.val(input2.data('value1'));
        }
        
    });
});