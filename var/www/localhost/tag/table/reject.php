<!DOCTYPE html>
<html>
<head>
	<title>Таблица событий</title>
	<!-- Подключение стилей -->
	<link href="../js/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
	<link href="../js/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen"> 
	<!-- Подключение скриптов -->	
	<script type="text/javascript" src="../js/ajax.js"></script>
	<script type="text/javascript" src="../js/pagination.js"></script>
	<script type="text/javascript" src="../js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
	<script type="text/javascript" src="../js/bootstrap-datetimepicker.ru.js" charset="UTF-8"></script>
	<script type="text/javascript" src="../js/hide.js" charset="UTF-8"></script>
	<script type="text/javascript" src="../js/clear.js" charset="UTF-8"></script>  
	<script type="text/javascript" src="../js/data.js" charset="UTF-8"></script>
</head>
<body>
	<div class="container" style="width:100%;">  
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
		<div class="vibor">
			<input type="checkbox" name="hid" id="cb1" onchange='showOrHide("cb1", "cat1");'/> Поиск по email (Для поиска укажите 1 или 2 адреса)
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
			<div id="cat1" class="vibor" style="display: none;">
			<div class="date"><input type="text" name="emailfrom" id="emailfrom" class="form-control" placeholder="From" /></div>
			<div class="date"><input type="text" name="emailto" id="emailto" class="form-control" placeholder="To" /></div>
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
<script type="text/javascript" src="../js/rejtab.js" charset="UTF-8"></script>