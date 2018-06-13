<?php
//rejectgrafob.php
include ('../config.php'); //Подключаю данные из конфига
$connect = mysqli_connect($db_host, $db_username, $db_password, $db_name) //Коннект к базе данных
    or die("Ошибка " . mysqli_error($link));
$query = "SELECT 
	SUM(IF(event LIKE '%450 4.7.1%', 1, 0)) AS hcount,
    SUM(IF(event LIKE '%550 5.1.1%', 1, 0)) AS uucount,
	SUM(IF(event LIKE '%550 5.7.23%', 1, 0)) AS spfcount,
	SUM(IF(event LIKE '%454 4.7.1%', 1, 0)) AS account,
	logdate AS newdate
	FROM reject WHERE logdate BETWEEN '".$_POST["from_date"]."' AND '".$_POST["to_date"]."'
	GROUP BY day(logdate)
	ORDER BY logdate
";//Параметры поиска
$result = mysqli_query($connect, $query); //Получаем результаты по запросу
while($row = mysqli_fetch_array($result))
{
	$sub_array1[] =  array(
	"x" => substr($row["newdate"], 0, 10),
	"y1" => $row["hcount"],
	"y2" => $row["uucount"],
	"y3" => $row["spfcount"],
	"y4" => $row["account"],
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
var y4 = jsonfile.jsonarray.map(function(e) {
   return e.y4;
});
var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Неизвестный хост',
            data: y1,
            borderColor: "red",
			fill: false,
			lineTension: 0,
			pointRadius: 5,
			pointHoverRadius: 10,
			pointBackgroundColor: "red",
			pointfill: false,
        },{ 
			label: 'Неизвестный получатель',
            data: y2,
            borderColor: "blue",
			fill: false,
			lineTension: 0,
			pointRadius: 5,
			pointHoverRadius: 10,
			pointBackgroundColor: "blue",
			pointfill: false,
		}, {
			label: 'Сбой SPF',
            data: y3,
            borderColor: "green",
			fill: false,
			lineTension: 0,
			pointRadius: 5,
			pointHoverRadius: 10,
			pointBackgroundColor: "green",
			pointfill: false,
		},{
			label: 'Доступ закрыт',
            data: y4,
            borderColor: "orange",
			fill: false,
			lineTension: 0,
			pointRadius: 5,
			pointHoverRadius: 10,
			pointBackgroundColor: "orange",
			pointfill: false,
		}
		],
	},
	options: {
		hover: {
			mode: 'point',
		},
		tooltips: {
			mode: 'point',
            titleFontSize: 14,
			bodyFontSize: 14,
        },
		scales: {
		  xAxes: [{
			type: 'time',
			time: {
			  unit: 'day',
				displayFormats: {
				'day': 'Do MMM',
			  }
			}
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
				max: 5,
				min: 1
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