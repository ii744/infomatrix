<?php
include('blocks/connecttodb.php');//у зовнішньому файлі прописано підключення до хоста і до бази даних
$name=$_POST['name'];
$surname=$_POST['surname'];
$email=$_POST['email'];
$phone=$_POST['phone'];

//Блок перевірки, чи були внесені дані у форму
If($name==''||$surname==''||$phone==''){
    echo 
   "<h2 align='center'>Ви не ввели ім'я, або прізвище, або номер телефону (або взагалі нічого не ввели)</h2>
    <p align='center'><a href='finder_introduce_form.php'>ПОВЕРНУТИСЬ НА ФОРМУ ВВЕДЕННЯ ВАШИХ ДАНИХ</a></p>
    <p align='center'><a href='index.php'>ПОВЕРНУТИСЬ НА ГОЛОВНУ</a></p>";
    die();
};

/*
//Блок перевірки на унікальність запису про заявника. Перш, ніж вносити дані користувача в таблицю, їх потрібно перевірити на унікальність ---------------> ПОКИ ЩО ВИРІШИЛА ВІДМОВИТИСЬ ВІД ЦЬОГО, ОСКІЛЬКИ ТАКА УМОВА ОЗНАЧАЄ, ЩО ОДНА ЛЮДИНА МОЖЕ РОЗМІСТИТИ ТІЛЬКИ ОДНУ ЗАЯВКУ. ЦЕ НЕПРАВИЛЬНО
$result=mysqli_query($db, "SELECT * FROM finders WHERE name='$name' AND surname='$surname' AND email='$email' AND phone='$phone'");
$myrow = mysqli_fetch_array($result);
If ($myrow['id']==true){
    // header("Location: uniqueness_error.php");
    echo 
   "<h2 align='center'>Користувач з такими даними вже існує. Перевірте правильність внесеної інформації</h2>
    <p align='center'><a href='finder_introduce_form.php'>ПОВЕРНУТИСЬ НА ФОРМУ ВВЕДЕННЯ ВАШИХ ДАНИХ</a></p>
    <p align='center'><a href='index.php'>ПОВЕРНУТИСЬ НА ГОЛОВНУ</a></p>";
    die();
   };
*/

$result = mysqli_query($db, "INSERT INTO finders (name,surname,email,phone) VALUES ('$name','$surname','$email','$phone')");
echo "<br>";
$result1=mysqli_query($db, "SELECT * FROM finders WHERE name='$name' AND surname='$surname' AND email='$email' AND phone='$phone'"); 
$myrow = mysqli_fetch_array($result1);
$_FINDERS_ID=$myrow['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DOBERMAN</title>
    <link rel="stylesheet" href="css/style_finder_form_in_db.css">
</head>
<body>

    <h4>ПОПЕРЕДЖЕННЯ!</h4>
    <p class='danger'>Зміст полів, виділених червоним кольором, буде доступний іншим громадянам.</p>
    <p>Вносячи дані людини, яку Ви шукаєте, не нашкодьте їй.</p>
    <br>
    <h3>Інформація про місце події:</h3>

    <form name="finder_added_data_to_table.php" action="finder_added_data_to_table.php" target="_parent" method="post">
        <p>Область:
            <select name="region" class='danger'>
                <?php
                    $result=mysqli_query($db, "SELECT * FROM region");
                    $myrow = mysqli_fetch_array($result);
                        do {printf ("<option>%s</option>",$myrow['region']);
                        }while($myrow = mysqli_fetch_array($result));
                ?>
            </select>
        </p>            
        <p>Район:
            <select name="area" class='danger'>
                <?php
                    $result=mysqli_query($db, "SELECT area FROM area");
                    $myrow = mysqli_fetch_array($result);
                        do {printf ("<option>%s</option>",$myrow['area']);
                        }while($myrow = mysqli_fetch_array($result));
                ?>
            </select>
        </p>
        <p>Населений пункт: <input name="settlement" size="50" type="text" value="--" class='danger'></p>
        <p>Дата, коли було виявлено втрату зв'язку: <input name="lost_date" size="10" type="date" class='danger'></p>
        <p>Опис обставин, за яких сталась втрата людини:<textarea name="plot" type="text" class='danger'></textarea></p>
        <p>Прізвище втраченої особи: <input name="surname" size="50" type="text" class='danger'></p>
        <p>Ім'я втраченої особи: <input name="name" size="50" type="text" class='danger'></p>
        <p>По-батькові втраченої особи: <input name="patronymic" size="50" type="text"></p>
        <p>Прізвисько: <input name="alias" size="50" type="text"></p>
        <p>Дата народження: <input name="birthday" size="10" type="date"></p>
        <p>Вік: <input name="age" size="3" type="text"></p>
        <p>Стать:
            <select name="sex">
                <?php
                    $result=mysqli_query($db, "SELECT * FROM sex");
                    $myrow = mysqli_fetch_array($result);
                        do {printf ("<option>%s</option>",$myrow['sex']);
                        }while($myrow = mysqli_fetch_array($result));
                ?>
            </select>
        <p>Адреса постійного проживання до зникнення: <input name="address" size="150" type="text"></p>
        <p>Номери телефонів: <input name="phone" size="100" type="text"></p>
        <p>E-mail: <input name="email" size="100" type="text"></p>
        <p>Опис автомобіля, якщо такий був у користуванні особи:<textarea name="car" value="--" class='danger'></textarea></p>
        <p>Прикмети. Зріст (см.): <input name="height" size="3" type="text"></p>
        <p>Прикмети. Статура: <input name="complection" size="20" type="text"></p>
        <p>Прикмети. Колір очей: <input name="eye_color" size="20" type="text"></p>
        <p>Прикмети. Волосся: <input name="hair" size="20" type="text"></p>
        <p>Особливі прикмети:<textarea name="special_signs"></textarea></p>
        <p>Сфера діяльності:
            <select name="direction">
                <?php
                    $result=mysqli_query($db, "SELECT direction_of_activity FROM direction_of_activity");
                    $myrow = mysqli_fetch_array($result);
                        do {printf ("<option>%s</option>",$myrow['direction_of_activity']);
                        }while($myrow = mysqli_fetch_array($result));
                ?>
            </select>
        </p>            
        <p>Додаткова інформація:<textarea name="additional"></textarea></p>
        <p>ID користуача:<textarea name="id" readonly="on" ><?php echo $_FINDERS_ID ?></textarea></p>
        <input type="submit" size="50" name="submit">
    </form>                

</body>
</html>