$(document).ready(function(){ //Функция скрытия столбцов
        var checkBoxes = $("#select input[name='column']"); //Задаем переменную, со значением, соответсвующему выбранному ЧБ
        for (var i = 0; i < checkBoxes.length; i++){ 
           if(checkBoxes[i].checked){ //Скрываем столбец, равный значению ЧБ
               $('#table td:nth-child('+$(checkBoxes[i]).val()+')').toggleClass("hide");
			   $('#table th:nth-child('+$(checkBoxes[i]).val()+')').toggleClass("hide");
           }
       }
       $("#select input[name='column']").change(function(){                        
           $('#table td:nth-child('+$(this).val()+')').toggleClass("hide");
		   $('#table th:nth-child('+$(this).val()+')').toggleClass("hide");
       });    
   });