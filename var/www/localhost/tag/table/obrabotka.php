<?php
//obrabotka.php
include ('../config.php'); //Подключаю данные из конфига
$connect = mysqli_connect($db_host, $db_username, $db_password, $db_name) //Коннект к базе данных
			or die("Ошибка " . mysqli_error($link));  
$output = '';  
if($_POST['email'] != '') //Проверяем наличие данных в поле емайл
{
	if(isset($_POST['pov']) && $_POST['pov'] == '2') //Проверяем состояние чекбокса "Убрать повторы"
   {
	   if(isset($_POST['vybor']) && $_POST['vybor'] != '') //Проверяем состояние чекбокса "Только авторизованных" 
		   {
			if(isset($_POST['vybor']) && $_POST['vybor'] == '1')
			{
			$query = "  
				SELECT * FROM dovecot 
				WHERE (logdate BETWEEN '".$_POST["from_date"]."' AND '".$_POST["to_date"]."') 
				AND auth = 1 AND email LIKE '".$_POST["email"]."'  GROUP BY email, ip ORDER BY logdate";  
			}
			elseif(isset($_POST['vybor']) && $_POST['vybor'] == '2')
			{
			$query = "  
				SELECT * FROM dovecot 
				WHERE (logdate BETWEEN '".$_POST["from_date"]."' AND '".$_POST["to_date"]."') 
				AND pass LIKE 'unknown_user' AND email LIKE '".$_POST["email"]."'  GROUP BY email, ip ORDER BY logdate";  
			}
			else
			{
			$query = "  
				SELECT * FROM dovecot 
				WHERE (logdate BETWEEN '".$_POST["from_date"]."' AND '".$_POST["to_date"]."') 
				AND pass NOT LIKE 'unknown_user' AND pass NOT LIKE 'none' AND email LIKE '".$_POST["email"]."'  GROUP BY email, ip, pass ORDER BY logdate";  
			}
		   }
		else
			{  
			$query = "  
				SELECT * FROM dovecot  
				WHERE (logdate BETWEEN '".$_POST["from_date"]."' AND '".$_POST["to_date"]."') 
				AND email LIKE '".$_POST["email"]."' GROUP BY email, ip, pass ORDER BY logdate ";  
			}
   }
   else
   {
	  if(isset($_POST['vybor']) && $_POST['vybor'] != '')
		{  
			if(isset($_POST['vybor']) && $_POST['vybor'] == '1')
			{
			$query = "  
				SELECT * FROM dovecot 
				WHERE (logdate BETWEEN '".$_POST["from_date"]."' AND '".$_POST["to_date"]."') 
				AND auth = 1 AND email LIKE '".$_POST["email"]."'";  
			}
			elseif(isset($_POST['vybor']) && $_POST['vybor'] == '2')
			{
			$query = "  
				SELECT * FROM dovecot 
				WHERE (logdate BETWEEN '".$_POST["from_date"]."' AND '".$_POST["to_date"]."') 
				AND pass LIKE 'unknown_user' AND email LIKE '".$_POST["email"]."'";  
			}
			else
			{
			$query = "  
				SELECT * FROM dovecot 
				WHERE (logdate BETWEEN '".$_POST["from_date"]."' AND '".$_POST["to_date"]."') 
				AND pass NOT LIKE 'unknown_user' AND pass NOT LIKE 'none' AND email LIKE '".$_POST["email"]."'";  
			}
		}
		else 
			{  
			$query = "  
				SELECT * FROM dovecot  
				WHERE logdate BETWEEN '".$_POST["from_date"]."' AND '".$_POST["to_date"]."' 
				AND email LIKE '".$_POST["email"]."'";  
			}
   }
}
else
{
	if(isset($_POST['pov']) && $_POST['pov'] == '2')
   {
	   if(isset($_POST['vybor']) && $_POST['vybor'] != '')
		{ 
			if(isset($_POST['vybor']) && $_POST['vybor'] == '1')
			{
			$query = "  
				SELECT * FROM dovecot 
				WHERE (logdate BETWEEN '".$_POST["from_date"]."' AND '".$_POST["to_date"]."') 
				AND auth = 1 GROUP BY email, ip ORDER BY logdate";  
			}
			elseif(isset($_POST['vybor']) && $_POST['vybor'] == '2')
			{
			$query = "  
				SELECT * FROM dovecot 
				WHERE (logdate BETWEEN '".$_POST["from_date"]."' AND '".$_POST["to_date"]."') 
				AND pass LIKE 'unknown_user' GROUP BY email, ip ORDER BY logdate";  
			}
			else
			{
			$query = "  
				SELECT * FROM dovecot 
				WHERE (logdate BETWEEN '".$_POST["from_date"]."' AND '".$_POST["to_date"]."') 
				AND pass NOT LIKE 'unknown_user' AND pass NOT LIKE 'none' GROUP BY email, ip, pass ORDER BY logdate";  
			}
		}
		else
			{  
			$query = "  
				SELECT * FROM dovecot  
				WHERE (logdate BETWEEN '".$_POST["from_date"]."' AND '".$_POST["to_date"]."') 
				GROUP BY email, ip ORDER BY logdate";  
			}
   }
   else
   {
	  if(isset($_POST['vybor']) && $_POST['vybor'] != '')
		{  
			if(isset($_POST['vybor']) && $_POST['vybor'] == '1')
			{
			$query = "  
				SELECT * FROM dovecot 
				WHERE (logdate BETWEEN '".$_POST["from_date"]."' AND '".$_POST["to_date"]."') AND auth = 1";  
			}
			elseif(isset($_POST['vybor']) && $_POST['vybor'] == '2')
			{
			$query = "  
				SELECT * FROM dovecot 
				WHERE (logdate BETWEEN '".$_POST["from_date"]."' AND '".$_POST["to_date"]."') 
				AND pass LIKE 'unknown_user'";  
			}
			else
			{
			$query = "  
				SELECT * FROM dovecot 
				WHERE (logdate BETWEEN '".$_POST["from_date"]."' AND '".$_POST["to_date"]."') 
				AND pass NOT LIKE 'unknown_user' AND pass NOT LIKE 'none'";  
			}
		}
		else
			{  
			$query = "  
				SELECT * FROM dovecot  
				WHERE (logdate BETWEEN '".$_POST["from_date"]."' AND '".$_POST["to_date"]."')";  
			}
   }
}
$result = mysqli_query($connect, $query);  
			$output .= '  
				<table class="table table-bordered">  
					<thead><tr>  
							   <th width="35%">Logdate</th>  
                               <th width="25%">Email</th>  
                               <th width="25%">Ip</th>  
                               <th width="10%">Pass</th>  
                               <th width="5%">Auth</th> 
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
											<td>'. $row["email"] .'</td>
											<td><a href="https://www.reg.ru/whois/?check=&dname='. $row["ip"] .'&_csrf=847b34f47227732637e2e311702dcc9c" target="_blank">'. $row["ip"] .'</a></td> 
											<td>'. $row["pass"] .'</td>  
											<td>'. $row["auth"] .'</td>  
										</tr></tbody>  
										';
							}
							else
							{
									$output .= '  
										<tbody><tr>   
											<td>'. $row["logdate"] .'</td>  
											<td>'. $row["email"] .'</td>
											<td>'. $row["ip"] .'</td> 
											<td>'. $row["pass"] .'</td>  
											<td>'. $row["auth"] .'</td>  
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