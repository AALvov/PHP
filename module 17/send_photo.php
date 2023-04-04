<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        form {
            display: flex;
            width: 500px;
            margin: 0 auto;
            flex-direction: column;
        }

        input {
            margin-bottom: 10px;
            padding: 10px;
        }
    </style>
</head>
<body>
<form method="post" action="send_photo.php" enctype="multipart/form-data">
    <input type="hidden" value="1" name="form-checker">
    <input type="file" name="photo">
    <input type="submit" value="Отправить">
</form>
<?php
session_start();
if (!isset($_SESSION['sent'])) {
    $_SESSION['sent'] = 0;
} else {
    if (isset($_POST['form-checker'])) {
        if ($_FILES['photo']['size'] < 2 * 1048576 && ($_FILES['photo']['type'] == 'image/jpeg' || $_FILES['photo']['type'] == 'image/png')) {
            if ($_SESSION['sent'] !== 0) {
                echo '<p> Ошибка! Файл уже был отправлен!</p>';
            }
            $_SESSION['sent']++;
            try {
                move_uploaded_file($_FILES['photo']['tmp_name'], './images/' . $_FILES['photo']['name']);
            } catch (Exception $e) {
                echo $e->getMessage();
            }
            header('Location:' . './images/' . $_FILES['photo']['name']);
        } else {
            echo '<p> Ошибка! Некорректный файл!</p>';

        }
    }
}


?>

</body>
</html>