<?php
include 'amo-crm-client.php';

session_start();

$number = "";
$errors = [];
$message_title = 'Заявка Шаган ';
$recepient = 'face9100@gmail.com';

if(empty($_POST['form_token']) || $_POST['form_token'] !== $_SESSION['form_token']) {
    $errors[] = "Невалидный токен";
}

if(!empty($_POST['number'])) {
    $number = $_POST['number'];
} else {
    $errors[] = "Введите номер";
}

if ($errors) {
    $_SESSION['status'] = 'error';
    $_SESSION['errors'] = $errors;
    header('Location:index.php?result=validation_error');
} else {
    try {
        mail($recepient, $message_title, $number);
        AmoCrmClient::createLead([[
            "name" => $message_title . $number
        ]]);
        $_SESSION['status'] = 'success';
        header('Location:index.php?result=success');
    } catch(\Exception $e) {
        $_SESSION['status'] = 'error';
        header('Location:index.php?result=unexpected_error');
    }
}

die();
