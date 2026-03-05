<?php
include('blocks/connecttodb.php');//у зовнішньому файлі прописано підключення до хоста і до бази даних
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DOBERMAN</title>
    <link rel="stylesheet" href="css/style_executors.css">
 </head>
<body>
<!-- php-блок, що виводить перелік екзекюторів з таблиці 'executors'-->
<?php
    $result=mysqli_query($db, "SELECT id,photo,name,description FROM executors");
    $myrow = mysqli_fetch_array($result);
    do {printf("<table align='center'; width='650px'; border='1px';>
                            <tr>
                                <td width='40px'><img src=%s></td>
                                <td>
                                    <table>
                                        <tr>
                                            <td><p class='executors_name'>%s</p></td>
                                        </tr>
                                        <tr>
                                            <td>%s</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>", $myrow["photo"], $myrow["name"], $myrow["description"]);}
    while($myrow = mysqli_fetch_array($result));
?>
</script>
</body>
</html>