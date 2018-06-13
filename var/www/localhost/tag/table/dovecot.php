<!DOCTYPE html>
<html>
<head>
	<title>Таблица паролей</title>
	<!-- Подключение стилей -->
	<link href="../js/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
	<link href="../js/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen"> 
	<!-- Подключение скриптов -->
	<script type="text/javascript" src="../js/ajax.js"></script>
	<script type="text/javascript" src="../js/pagination.js"></script>
	<script type="text/javascript" src="../js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
	<script type="text/javascript" src="../js/bootstrap-datetimepicker.ru.js" charset="UTF-8"></script>
	<script type="text/javascript" src="../js/hide.js" charset="UTF-8"></script>
	<script type="text/javascript" src="../js/radio.js" charset="UTF-8"></script>
	<script type="text/javascript" src="../js/clear.js" charset="UTF-8"> </script> 
	<script type="text/javascript" src="../js/data.js" charset="UTF-8"></script>	
</head>
<body>
	<div class="container" style="width:900px;">  
		<h3 align="center">Выборка подключений</h3>  
		<h4 align="center">Выберите дату</h4>
		<center>
		<!-- Выбор даты -->
		<div class="date">  
			 <input type="text" name="from_date" id="from_date" class="form-control" placeholder="Начиная с" />  
		</div>  
		<!-- Выбор даты -->
		<div class="date">  
			 <input type="text" name="to_date" id="to_date" class="form-control" placeholder="Заканчивая" />  
		</div>
		<br/>		
		<!-- Кнопка фильтра -->
		<div class="knop">  
			 <input type="button" name="filter" id="filter" value="Применить" class="btn btn-info" />  
		</div> 
		<br/>				
		<!-- Кнопка авторизации -->
		<div class="vibor">  
			<input id="id1" type="checkbox" name ="vybor" value ="1" onclick="chbx(this)"> Только авторизованных 
			<input id="id2" type="checkbox" name ="vybor" value ="2" onclick="chbx(this)"> unknown_user 
			<input id="id3" type="checkbox" name ="vybor" value ="3" onclick="chbx(this)"> Неверный пароль
			<input type="checkbox" name="pov" value="2" class="btn btn-info" /> Убрать повторения 
		</div>
		<!-- Окно email -->
		<div>
			<input type="checkbox" name="hid" id="cb1" onchange='showOrHide("cb1", "cat1");'/> Поиск по email
					 Показывать по
					<!-- Выбор кол-ва отображаемой информации -->
					<select>
						<option type="number" name="pag" id="p1" value="5">5</option>
						<option type="number" name="pag" id="p2" value="15" selected>15</option>
						<option type="number" name="pag" id="p3" value="25">25</option>
						<option type="number" name="pag" id="p4" value="50">50</option>
						<option type="number" name="pag" id="p5" value="100">100</option>
					</select>
			<br/>
			<!-- Скрытое поле -->
			<div id ="cat1" class="vibor" style="display: none;">
			<div class="date"><input type="text" name="email" id="email" class="form-control" placeholder="Email" /></div>
			</div>
		</div>
		<div style="clear:both"></div>                 
		<br/>  
		</center>
		<!-- Таблица -->
		<div id="order_table">  
			 <ul class="pagination pager" id="myPager"></ul>			 
		</div>  
	</div> 
</body>
</html>
<script type="text/javascript" src="../js/dovtab.js" charset="UTF-8"></script>