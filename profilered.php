<?php
include 'header.php';
include 'models' . DIRECTORY_SEPARATOR . 'Sys' . DIRECTORY_SEPARATOR . 'SysUsers.php';
include 'models' . DIRECTORY_SEPARATOR . 'Sys' . DIRECTORY_SEPARATOR . 'SysRoles.php';
$errors = array();
$userRoles = array();
if (isset($_POST) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_SESSION['user_id'];
    $input_user = new SysUsers();
    $input_user->setPassword($_POST['password']);
    $input_user->setAddress($_POST['address']);
    $input_user->setTelefonNumber($_POST['telefonnumber']);
    $input_user->setEmail($_POST['e-mail']);
    $sysStmt = $conn->prepare("UPDATE Sys_Users SET password=:password,adress=:address,telefon_number=:tel, email=:email WHERE username='$username'");
    if (strlen($input_user->getPassword()) <= 80 && strlen($input_user->getPassword()) >= 6) {
        $sysStmt -> bindValue(':password', sha1($input_user->getPassword()));
    } else {
        $errors['$input_user->getPassword()'] = "<div class='error'>" . 'Паролата е задължително поле с максимална дължина 80 символа и минимална дължина 6 символа.<br>' . "</div>";
     
    }
    echo $input_user->getAddress();
    if (strlen($input_user->getAddress()) <= 350) {
        $sysStmt -> bindValue(':address', $input_user->getAddress());
    } else {
        $errors['$input_user->getAddress()'] = "<div class='error'>" . 'Адрес е задължително поле с максимална дължина 350 символа.' . "</div>";
     
    }
    if (strlen($input_user->getTelefonNumber()) <= 50) {
        $sysStmt -> bindValue(':tel', $input_user->getTelefonNumber());
    } else {
        $errors['$input_user->getTelefonNumber()'] = "<div class='error'>" . 'Номер е задължително поле с максимална дължина 50 символа.<br>' . "</div>";
     
    }
    if (strlen($input_user->getEmail()) <= 150) {
        $sysStmt -> bindValue(':email', $input_user->getEmail());
    } else {
        $errors['$input_user->getEmail()'] = "<div class='error'>" . 'E-mail е задължително поле с максимална дължина 150 символа.<br>' . "</div>";
        
    }
    if (!isset($errors) || count($errors) == 0) {
        if ($sysStmt->execute()) {
            echo '<div class="succ">Записа беше усешно запазен!</div>';
        } else {
            echo "<div class='errorPage'>";
            print_r($sysStmt->errorInfo());
            echo "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="style/main.css" type="text/css"/>
        <link type="text/css" href="scripts/jquery-ui-themes-1.12.1/themes/base/jquery-ui.css" rel="stylesheet"/>
        <script type="text/JavaScript" src="scripts/jquery-3.2.1.js"></script>
        <script type="text/JavaScript" src="scripts/UserJQueryMessageStyles.js"></script>
        <script type="text/JavaScript" src="scripts/DatePicker.js"></script>
        <script type="text/javascript" src="scripts/jquery-ui-1.12.1/jquery-ui.js"></script>
        <title>Students Calendar</title>
        <meta charset ="utf-8">
        <meta name = "Description" content = "This web page is for students calendar. They can see their calendars, their lecturers and so on.">
        <meta name = "keywords" content = "Students, Calendar, Lecturers">
        <meta name = "author" content = "Elica Venchova, Natalia Ignatova">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div class="edit" id="userInfo">
            <div class="edit_form">
                <h2>Редактиране на профил</h2>
                <form action="profilered.php" method="POST">
                    <label>Парола<span class="required">*</span> <input type="password" name="password"></label>
					<label>Адрес<span class="required">*</span><input type="text" name="address"></label>
                    <label>Телефонен номер<span class="required">*</span><input type="text" name="telefonnumber"></label>
                    <label>E-mail<span class="required">*</span><input type="email" name="e-mail"></label>
                    <div class="buttons"> <input type="submit"> </div>
                </form>
            </div>
        </div>

    </body>

</html>
