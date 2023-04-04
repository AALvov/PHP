<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Отправка текстов</title>
    <style>
        form {
            width: 1200px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
        }

        label {
            width: 50%;
            margin-right: 20px;
            font-size: 30px;
            margin-bottom: 40px;
        }

        div {
            display: flex;
            justify-content: space-around;
        }

        input {
            width: 50%;
            padding: 5px;
            height: 50px;
        }

        .good {
            border: 5px solid green;
            margin-bottom: 15px;
        }

        .bad {
            border: 5px solid red;
            font-weight: bold;
            background: pink;

        }


    </style>
</head>
<body>
<?php
include_once 'autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


$isSuccess = false;
$isError = false;
$successMassage = '';
$errorMassage = '';
if (!empty($_POST['author'])) {

    try {
        $storage = new FileStorage();
        $newObj = new TelegraphText($_POST['author'], 'newText', $storage);

        $newObj->text = $_POST['text'];


        if (!empty($_POST['email'])) {
            try {
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->SMTPAuth = true;
                $mail->Host = "smtp.mailsnag.com";
                $mail->Port = 2525;
                $mail->Username = "Q8CeHTjRDiTF";
                $mail->Password = "kRVSPxcwBf8M";
                $mail->SMTPSecure = "tls";

                $mail->setFrom("Telegrapher@example.com");
                $mail->addAddress($_POST['email']);

                $mail->Subject = "Test";
                $mail->Body = $_POST['text'];

                $mail->send();

                $isSuccess = true;
                $successMassage = 'Сообщение отправлено';

            } catch (Exception $e) {
                $isError = true;

                $errorMassage = "Сообщение не было отправлено. Причина: " . $e->getMessage();
            }


        }
        $isSuccess = true;
        $successMassage = 'Текст записан';
    } catch (TelegraphTextException $e) {

        $isError = true;
        $errorMassage = "Текст не был записан. Причина: " . $e->getMessage();
    }
}


function errorHandler($level, $msg, $line, $file)
{
    if ($file == 'TelegraphText.php') {
        echo '<div class="bad">' . $msg . '</div>';
    }
}

set_exception_handler("errorHandler");


if ($isSuccess) {

    echo '<div class="good">' . $successMassage . '</div>';

}
if ($isError) {

    echo '<div class="bad">' . $errorMassage . '</div>';

}

?>
<form method="post" action="input_text.php">
    <div>
        <label for="author">Автор произведения</label>
        <input type="text" name="author" id="author">
    </div>
    <div>

        <label for="text">Текст произведения</label>
        <input type="textarea" name="text" id="text">
    </div>
    <div>

        <label for="email">E-mail</label>
        <input type="text" name="email" id="email">
    </div>
    <div>
        <input type="submit" value="Отправить">
    </div>
</form>
</body>
</html>


