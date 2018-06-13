<?php
//obrpost.php
//postfix
include ('../config.php'); //Подключаю данные из конфига
$connect = mysqli_connect($db_host, $db_username, $db_password, $db_name) //Коннект к базе данных
			or die("Ошибка " . mysqli_error($link));  
$output = '';  
if($_POST['emailfrom'] != '' OR $_POST['emailto'] != '')
{
	if($_POST['emailfrom'] != '' && $_POST['emailto'] != '')	
	{
			$query = "  
				SELECT * FROM postfix  
				WHERE logdate BETWEEN '".$_POST["from_date"]."' AND '".$_POST["to_date"]."' 
				AND frommail LIKE '".$_POST["emailfrom"]."' AND tomail LIKE '%".$_POST["emailto"]."%'";    
	}
	elseif ($_POST['emailfrom'] != '' && $_POST['emailto'] == '')
	{
			$query = "  
				SELECT * FROM postfix  
				WHERE logdate BETWEEN '".$_POST["from_date"]."' AND '".$_POST["to_date"]."' 
				AND frommail LIKE '".$_POST["emailfrom"]."'";  
	}
	else
	{ 
			$query = "  
				SELECT * FROM postfix  
				WHERE logdate BETWEEN '".$_POST["from_date"]."' AND '".$_POST["to_date"]."' 
				AND tomail LIKE '%".$_POST["emailto"]."%'";  
	}
}
else
{ 
			$query = "  
				SELECT * FROM postfix  
				WHERE logdate BETWEEN '".$_POST["from_date"]."' AND '".$_POST["to_date"]."'";  
}
$result = mysqli_query($connect, $query);  
			$output .= '  
				<table class="table table-bordered" id="table">  
					<thead><tr>  
                               <th width="5%">Logdate</th>  
                               <th width="5%">Stopdate</th>  
                               <th width="5%">Id</th>  
                               <th width="5%">Id2</th>  
                               <th width="5%">Msgid</th>
							   <th width="5%">From</th>  
                               <th width="5%">To</th> 
                               <th width="5%">Orig_to</th>  
                               <th width="5%">Ip</th>  
                               <th width="5%">Ip2</th>
							   <th width="5%">User</th>  
                               <th width="5%">Status</th>   
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
									   <td>'. $row["stopdate"] .'</td>  
									   <td>'. $row["id"] .'</td>  
									   <td>'. $row["id2"] .'</td>  
									   <td>'. $row["msgid"] .'</td>  
									   <td>'. $row["frommail"] .'</td> 
									   <td>'. $row["tomail"] .'</td>  
									   <td>'. $row["orig_to"] .'</td>  
									   <td><a href="https://www.reg.ru/whois/?check=&dname='. $row["ip"] .'&_csrf=847b34f47227732637e2e311702dcc9c" target="_blank">'. $row["ip"] .'</a></td> 
									   <td>'. $row["ip2"] .'</td> 
									   <td>'. $row["user"] .'</td>  
									   <td>'. $row["status"] .'</td>							
									</tr></tbody>  
									';  
							}
							else
							{
								$output .= '  
									<tbody><tr>
									   <td>'. $row["logdate"] .'</td> 
									   <td>'. $row["stopdate"] .'</td>  
									   <td>'. $row["id"] .'</td>  
									   <td>'. $row["id2"] .'</td>  
									   <td>'. $row["msgid"] .'</td>  
									   <td>'. $row["frommail"] .'</td> 
									   <td>'. $row["tomail"] .'</td>  
									   <td>'. $row["orig_to"] .'</td>  
									   <td>'. $row["ip"] .'</td> 
									   <td>'. $row["ip2"] .'</td> 
									   <td>'. $row["user"] .'</td>  
									   <td>'. $row["status"] .'</td>							
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