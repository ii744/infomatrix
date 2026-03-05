<?php
include('blocks/connecttodb.php');//у зовнішньому файлі прописано підключення до хоста і до бази даних
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ФОРМА</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <table align='center'; width='650px'; border='1px';>
    <tr>
        <td align="right" >
            <h2>Вітаємо. Давайте знайомитись!</h2>
            <form name="finder_form" action="finder_adds_data_form.php" target="_parent" method="post" >
                <p>Ваше ім'я: <input name="name" size="50" type="text"></p>
                <p>Ваше прізвище: <input name="surname" size="50" type="text"></p>
                <p>Ваша e-mail: <input name="email" size="50" type="text"  ></p>
                <p>Номер Вашого телефону: <input name="phone" size="50" type="text"  ></p>
                <input type="submit" size="50" name="submit">
            </form>

        </td>
    </tr>
</table>
</body>
</html>