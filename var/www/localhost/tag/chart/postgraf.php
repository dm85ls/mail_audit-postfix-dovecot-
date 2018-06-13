<!DOCTYPE html>
<html>
<head>
	<title>График писем</title>
	<link href="../js/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
	<link href="../js/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen"> 
	<script type="text/javascript" src="../js/Chart.js" charset="UTF-8"></script>
	<script type="text/javascript" src="../js/chartjs-plugin-zoom.js" charset="UTF-8"></script>
	<script type="text/javascript" src="../js/ajax.js"></script>
	<script type="text/javascript" src="../js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
	<script type="text/javascript" src="../js/bootstrap-datetimepicker.ru.js" charset="UTF-8"></script>
	<script type="text/javascript" src="../js/data.js" charset="UTF-8"></script>
</head>
<body>
	<div class="container" style="width:900px;">  
		<h3 align="center">График писем</h3>  
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
			 <input type="button" name="filter" id="filter" value="Применить" class="btn btn-info" onclick="disp(document.getElementById('form1'))" />  
		</div>                
	</div>
	</center>	
	<div id="chart_div"></div>
</body>
</html>
<script type="text/javascript" src="../js/posgr.js" charset="UTF-8"></script>