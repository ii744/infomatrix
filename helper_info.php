<?php
include('blocks/connecttodb.php');//у зовнішньому файлі прописано підключення до хоста і до бази даних
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DOBERMAN</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php
//Блок формування пошукового запиту (по місцю подій) в залежності від того, які поля заповнені
$q="";
$region=$_POST['region'];
$area=$_POST['area'];
$settlement=$_POST['settlement'];
$lost_date=$_POST['lost_date'];

If ($region!='--'){
	$q="region='$region'";
};

If ($area!='--'){
			If($q!=''){
				$q=$q." AND area='$area'";	
					  }else{
						$q="area='$area'";
					  };
};

If ($settlement!='--'){
			If($q!=''){
				$q=$q." AND settlement='$settlement'";	
			  		  }else{
						$q="settlement='$settlement'";
			  		  };
};

If ($lost_date!=''){
            If($q!=''){
                $q=$q." AND lost_date>='$lost_date'";	
                    }else{
                    $q="lost_date>='$lost_date'";
                    };
};

If ($q!=''){
	$q="SELECT*FROM lost_people WHERE ".$q;
    //echo $q;
}else{
	echo
        "<table align='center'; width='650px'; border='1px';>
            <tr>
                <td>
                    <p align='center'>Ви не ввели жодного параметра для пошуку</a></p>
                    <p align='center'><a href='helper_search_form.php'>СФОРМУВАТИ ПОШУКОВИЙ ЗАПИТ</a></p>
                    <p align='center'><a href='index.php'>ПОВЕРНУТИСЬ НА ГОЛОВНУ</a></p>
                </td>    
            </tr> 
        </table>";
    die();
};

//Проміжне інформування про обрані параметри пошуку
/*
echo "<table align='center'; width='650px';>
    <tr>
        <td>
            
            <h3>Ви прийняли рішення здійснювати пошук за наступними параметрами:</h3>
            <h4>ЛОКАЦІЯ</h4>
            <p>Область: $region</p>
            <p>Район: $area</p>
            <p>Населений пункт: $settlement</p> 
            <h4>ЧАСОВІ ПАРАМЕТРИ</h4>
            <p>Пошук подій, починаючи з дати: $lost_date</p> 
           
        </td>
    </tr>   
</table>";
*/

//Блок виведення рядків таблиці втрачених людей (lost_people), що відповідають сформованому запиту
    $result=mysqli_query($db, $q); 
    $myrow = mysqli_fetch_array($result);
    //Блок перевірки, чи містить таблиця якусь інформацію по запиту
    if ($myrow==false){
        echo "База даних не містить інформації по даному запиту";
        die();
    };

    do {printf("<table align='center'; width='650px'; border='1px';>
                    <tr>
                        <td width='200px'>
                            <p>Втрачена особа: %s %s</p>
                            <p>Дата втрати: %s</p>
                            <p>Локація:</p> 
                            <p>Область: %s</p> 
                            <p>Район: %s</p> 
                            <p>Населений пункт: %s</p> 
                            <p>Опис подій: %s</p>
                            <p align='center'><a href='#'>МАЮ ІНФОРМАЦІЮ АБО МОЖУ ДОПОМОГТИ. ПЕРЕЙТИ В СЛУЖБОВИЙ ЧАТ</a></p>
                        </td>
                    </tr>
                </table>", $myrow["surname"],$myrow["first_name"],$myrow["lost_date"],$myrow["region"],$myrow["area"],$myrow["settlement"],$myrow["plot"]);
            }
    while($myrow = mysqli_fetch_array($result));

    echo "<table align='center'; width='650px'; border='1px';>
            <tr>
                <td>
                    <p align='center'><a href='helper_search_form.php'>СФОРМУВАТИ ІНШИЙ ЗАПИТ</a></p>
                    <p align='center'><a href='index.php'>ПОВЕРНУТИСЬ НА ГОЛОВНУ</a></p>
                </td>    
            </tr> 
        </table>"
?>
</script>
</body>
</html>