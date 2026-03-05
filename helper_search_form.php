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

    <div align="center" >
        <p class="helper_form">
    <p>Оберіть критерії відбору інформації:</p>
    <form name="helper_form_search" action="helper_info.php" target="_parent" method="post">
        <p>Локація, де було втрачено зв'язок:</p>
        <p>Область:
            <select name="region">
                <?php
                    $result=mysqli_query($db, "SELECT * FROM region");
                    $myrow = mysqli_fetch_array($result);
                        do {printf ("<option>%s</option>",$myrow['region']);
                        }while($myrow = mysqli_fetch_array($result));
                ?>
            </select>
        </p>            
        <p>Район:
            <select name="area">
                <?php
                    $result=mysqli_query($db, "SELECT area FROM area");
                    $myrow = mysqli_fetch_array($result);
                        do {printf ("<option>%s</option>",$myrow['area']);
                        }while($myrow = mysqli_fetch_array($result));
                ?>
            </select>
        </p>
        <p>Населений пункт: <input name="settlement" size="50" type="text" value="--"></p>
        <p>Дата, з якої зв'язок вважається втраченим: <input name="lost_date" size="10" type="date"></p>
        <input type="submit" size="50" name="submit">
        </p>
    </form>                
    </div>
</body>
</html>