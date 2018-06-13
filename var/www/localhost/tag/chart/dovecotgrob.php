<?php
//dovecotgrob.php
include ('../config.php'); //Подключаю данные из конфига
$connect = mysqli_connect($db_host, $db_username, $db_password, $db_name) //Коннект к базе данных
    or die("Ошибка " . mysqli_error($link));
$query = "SELECT 
	SUM(IF(auth = '1', 1, 0)) AS authcount,
    SUM(IF(pass LIKE '%unknown_user%', 1, 0)) AS unkuscount,
	SUM(IF(pass NOT LIKE '%unknown_user%' AND auth != '1', 1, 0)) AS unkpacount,
	logdate AS newdate
	FROM dovecot WHERE logdate BETWEEN '".$_POST["from_date"]."' AND '".$_POST["to_date"]."'
	GROUP BY day(logdate)
	ORDER BY logdate
";//Параметры поиска
$result = mysqli_query($connect, $query); //Получаем результаты по запросу
while($row = mysqli_fetch_array($result))
{
	$sub_array1[] =  array(
	"x" => substr($row["newdate"], 0, 10),
	"y1" => $row["authcount"],
	"y2" => $row["unkuscount"],
	"y3" => $row["unkpacount"]
     );
}
?>
<!DOCTYPE HTML>
<html>
<head>
<script>
var jsonfile = {
   "jsonarray": <?php echo json_encode($sub_array1, JSON_NUMERIC_CHECK); ?>
};
var labels = jsonfile.jsonarray.map(function(e) {
   return e.x;
});
var y1 = jsonfile.jsonarray.map(function(e) {
   return e.y1;
});
var y2 = jsonfile.jsonarray.map(function(e) {
   return e.y2;
});
var y3 = jsonfile.jsonarray.map(function(e) {
   return e.y3;
});
var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Авторизованные пользователи',
            data: y1,
            borderColor: "red",
			fill: false,
			lineTension: 0,
			pointRadius: 5,
			pointHoverRadius: 10,
			pointBackgroundColor: "red",
			pointfill: false,
        },{ 
			label: 'Неизвестные пользователи',
            data: y2,
            borderColor: "blue",
			fill: false,
			lineTension: 0,
			pointRadius: 5,
			pointHoverRadius: 10,
			pointBackgroundColor: "blue",
			pointfill: false,
		}, {
			label: 'Неверный пароль',
            data: y3,
            borderColor: "green",
			fill: false,
			lineTension: 0,
			pointRadius: 5,
			pointHoverRadius: 10,
			pointBackgroundColor: "green",
			pointfill: false,
		}],
	},
	options: {
		hover: {
			mode: 'point',
		},
		tooltips: {
			mode: 'point',
            titleFontSize: 14,
			bodyFontSize: 14
        },
		scales: {
		  xAxes: [{
			type: 'time',
			time: {
				unit: 'day',
				displayFormats: {
				'day': 'Do MMM',
			  }
			},
		  }],
		  yAxes: [{
		}],
		},
		pan: {
			enabled: true,
			mode: 'xy'
		},
		zoom: {
			enabled: true,
			mode: 'xy',
			limits: {
				max: 10,
				min: 0.5
				}	
			},
		},
});
</script>
</head>
<body>
<canvas id="myChart" style="height: window.innerHeight, width: window.innerWidth"></canvas>
</body>
</html> 