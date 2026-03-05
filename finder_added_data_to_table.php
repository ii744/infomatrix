<?php
include('blocks/connecttodb.php');//у зовнішньому файлі прописано підключення до хоста і до бази даних
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DOBERMAN</title>
</head>
<body>
<?php
//Блок автозаміни символів з української розкладки клавіатури, що сприймаються програмою, як службові символи, і це викликає помилку
foreach ($_POST as &$value) {           //Функція перебору всіх ячейок масиву. $value при кожній ітерації набуває значення чергової ячейки масиву. Символ "&" (посилання) прив'язує значення ячейки до значення, що змінилось в результаті виконання команди у цій ітерації.
	$value=str_replace("'","`",$value); //Функція пошуку і заміни символу. Перший аргумент - те, що шукаємо, другий - те, чим замінюємо, третій - де шукаємо (або пряме значення рядку, або перемінна, або конкретно вказана ячейка масиву)
      };
foreach ($_POST as &$value) {
    $value=str_replace('"',"``",$value);
      };
foreach ($_POST as &$value) {
        $value=str_replace('\\',"/",$value);
      };

//Блок явної передачі локальним перемінним значень глобальної перемінної S_POST (оскільки не всякий хост надає можливість працювати з $_POST['index']) напряму).
$region=$_POST["region"];
$area=$_POST["area"];
$settlement=$_POST["settlement"];
$lost_date=$_POST["lost_date"];
$plot=$_POST["plot"];
$surname=$_POST["surname"];
$name=$_POST["name"];
$patronymic=$_POST["patronymic"];
$alias=$_POST["alias"];
$birthday=$_POST["birthday"];
$age=$_POST['age'];
$sex=$_POST['sex'];
$address=$_POST['address'];
$phone=$_POST['phone'];
$email=$_POST['email'];
$car=$_POST['car'];
$height=$_POST['height'];
$eye_color=$_POST['eye_color'];
$complection=$_POST['complection'];
$hair=$_POST['hair'];
$eye=$_POST['eye_color'];
$special_signs=$_POST['special_signs'];
$direction=$_POST['direction'];
$additional=$_POST['additional'];
$finders_id=$_POST['id'];

//Блок внесення значень форми, отриманих з глобальної перемінної $_POST у локальні перемінні, у відповідні ячейки таблиці
$result = mysqli_query($db, "INSERT INTO lost_people (region,area,settlement,lost_date,plot,surname,first_name,patronymic,alias,date_of_birth,estimated_age,sex,place_of_residence,phone_numbers,email,has_a_car,signs_height,signs_complection,signs_hair,signs_eye_color,special_signs,direction,additional_information,finders_id) 
                                            VALUES ('$region','$area','$settlement','$lost_date','$plot','$surname','$name','$patronymic','$alias','$birthday','$age','$sex','$address','$phone','$email','$car','$height','$complection','$hair','$eye','$special_signs','$direction','$additional','$finders_id')");

//Блок отримання номеру конкретно цієї заявки (значення поля id)
$id=mysqli_insert_id($db); 
                    
//Службовий блок. Перевірка, чи не було помилки при внесенні даних у таблицю. Інформування файндера про номер його заявки
if ($result==true){
    echo "Надану Вами інформацію внесено до бази пошуку.";
    echo "<br>Вашу заявку зареєстровано під номером: ", $id;
    echo "<br>Будь-ласка, збережіть цей номер для подальшої співпраці.";
}else{
    echo "<br>Упс. Щось пішло не так. Інформацію не додано. Будь-ласка, поверніться на попередню сторінку і перевірте правильність внесення інформації.";
};

echo "<p><a href='index.php'>ПОВЕРНУТИСЬ НА ГОЛОВНУ СТОРІНКУ</a></p>";
?>
</body>
</html>