<?php
//obrrej.php
include ('../config.php'); //Подключаю данные из конфига
$connect = mysqli_connect($db_host, $db_username, $db_password, $db_name) //Коннект к базе данных
			or die("Ошибка " . mysqli_error($link));  
$output = '';  
if($_POST['emailfrom'] != '' OR $_POST['emailto'] != '')
{
	if($_POST['emailfrom'] != '' && $_POST['emailto'] != '')	
	{
			$query = "  
				SELECT * FROM reject  
				WHERE logdate BETWEEN '".$_POST["from_date"]."' AND '".$_POST["to_date"]."' 
				AND frommail LIKE '".$_POST["emailfrom"]."' AND tomail LIKE '".$_POST["emailto"]."'";  
	}
	elseif ($_POST['emailfrom'] != '' && $_POST['emailto'] == '')
	{  
			$query = "  
				SELECT * FROM reject  
				WHERE logdate BETWEEN '".$_POST["from_date"]."' AND '".$_POST["to_date"]."' 
				AND frommail LIKE '".$_POST["emailfrom"]."'";  
	}
	else
	{
			$query = "  
				SELECT * FROM reject  
				WHERE logdate BETWEEN '".$_POST["from_date"]."' AND '".$_POST["to_date"]."' 
				AND tomail LIKE '".$_POST["emailto"]."'";  
	}
}
else
{
			$query = "  
				SELECT * FROM reject  
				WHERE logdate BETWEEN '".$_POST["from_date"]."' AND '".$_POST["to_date"]."'";  
}
$result = mysqli_query($connect, $query);  
			$output .= '  
				<table class="table table-bordered">  
					<thead><tr>  
                               <th width="17%">Logdate</th>  
                               <th width="25%">From</th>  
                               <th width="10%">To</th>  
                               <th width="5%">Ip</th>  
                               <th width="43%">Event</th>  
                          </tr></thead> 
			';  
			if(mysqli_num_rows($result) > 0)  
				{  
					while($row = mysqli_fetch_array($result))  
						{  
							if($row["ip"]!='none')
							{
								$output .= '  
									<tbody><tr>  
										<td>'. $row["logdate"] .'</td>  
										<td>'. $row["frommail"] .'</td>  
										<td>'. $row["tomail"] .'</td> 
										<td><a href="https://www.reg.ru/whois/?check=&dname='. $row["ip"] .'&_csrf=847b34f47227732637e2e311702dcc9c" target="_blank">'. $row["ip"] .'</a></td>  
										<td>'. $row["event"] .'</td> 
									</tr></tbody> 
									';  
							}
							else
							{
								$output .= '  
									<tbody><tr>  
										<td>'. $row["logdate"] .'</td>  
										<td>'. $row["frommail"] .'</td>  
										<td>'. $row["tomail"] .'</td> 
										<td>'. $row["ip"] .'</td>  
										<td>'. $row["event"] .'</td> 
									</tr></tbody>  
									'; 
							}
						}  
				}  
			else  
				{  
					$output .= '  
								<tr>  
									<td colspan="5">Ничего не найдено</td>  
								</tr>  
								';  
				}  
					$output .= '</table><center><ul class="pagination pager" id="myPager"></ul></center>';  
					echo $output;
?>