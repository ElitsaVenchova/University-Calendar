<?php
require_once('..' . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'Noms' . DIRECTORY_SEPARATOR . 'NomCathedrals.php');
include '..' . DIRECTORY_SEPARATOR . 'header.php';

function save($conn, $post) {
    if ($post['id'] != null && !empty($post['id'])) {
        $stmt = $conn->prepare("UPDATE nom_Cathedrals SET short_name = ?, name = ?, description = ?, is_active = ? WHERE ID = ?");
        $stmt->execute(array($post['shortName'], $post['name'], $post['description'], $post['isActive'], $post['id']));
    } else {
        $stmt = $conn->prepare("INSERT INTO nom_Cathedrals (short_name, name, description, is_active) VALUES (?,?,?,?)");
        $stmt->execute(array($post['shortName'], $post['name'], $post['description'], $post['isActive']));
    }
    return "Записа беше редактиран успешно!";
}

if (isset($_POST) && isset($_POST['update']) && !empty($_POST['update'])) {
    $msg = save($conn, $_POST);
    $cathedralId = $_POST['id'];
} else if (isset($_GET) && isset($_GET['cathedralId']) && !empty($_GET['cathedralId'])) {
    $cathedralId = $_GET['cathedralId'];
}

$currCathedral = new NomCathedrals();
if (isset($cathedralId)) {
    $sql = "SELECT id, short_name, nc.name, nc.description, nc.is_active FROM nom_Cathedrals nc where nc.id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt->execute(array($cathedralId))) {
        while ($row = $stmt->fetch()) {
            $currCathedral = new NomCathedrals();
            $currCathedral->setId($row['id']);
            $currCathedral->setShortName($row['short_name']);
            $currCathedral->setName($row['name']);
            $currCathedral->setDescription($row['description']);
            $currCathedral->setIsActive($row['is_active']);
        }
    }
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../style/main.css" type="text/css"/>
        <link type="text/css" href="../scripts/jquery-ui-themes-1.12.1/themes/base/jquery-ui.css" rel="stylesheet"/>
        <script type="text/JavaScript" src="../scripts/jquery-3.2.1.js"></script>
        <script type="text/JavaScript" src="../scripts/UserJQueryMessageStyles.js"></script>
        <script type="text/JavaScript" src="../scripts/DatePicker.js"></script>
        <script type="text/javascript" src="../scripts/jquery-ui-1.12.1/jquery-ui.js"></script>
        <title>Редакция - Катедра</title>
    </head>
    <body onKeyPress="return checkSubmit(event)">
        <?php if (isset($msg)): ?>
            <div class="succ">
                <?= $msg ?>
            </div>
            <?php $msg = null; ?>
        <?php endif; ?> 
        <form name="nom_cathedral_edit_form" method="post">
            <input type="hidden" name="update"/>
            <script>
                function checkSubmit(e)
                {
                    var v = document.forms['nom_cathedral_edit_form'];
                    if (e.which === 13 && !e.altKey && !e.ctrlKey && !e.shiftKey)
                    {
                        updateRow();
                    }
                }

                function updateRow() {
                    var ok = vallidateForm(document.forms[0]);
                    if (ok)
                    {
                        document.forms[0].elements['update'].value = true;
                        document.forms[0].submit();
                    }
                }

                function clearFields() {
                    $('#shortName').val("");
                    $('#name').val("");
                    $('#description').val("");
                    $('#isActive').val("");
                }
            </script>
            <div class="edit" id="userInfo">
                <div class="edit_form">
                    <label>№<span class="required">*</span> <input readonly type="text" name="id" required="Y" id="id" readonly value="<?= $currCathedral->getId() ?>"/> </label>
                    <label>Код<span class="required">*</span> <input type="text" required="Y" name="shortName" id="shortName" value="<?= $currCathedral->getShortName() ?>"/> </label>
                    <label>Име <input type="text" name="name" id="name" value="<?= $currCathedral->getName() ?>"/> </label>
                    <label>Описание <input type="text" name="description" id="description" value="<?= $currCathedral->getDescription() ?>"/> </label>
                    <label>Активност<span class="required">*</span> <select name="isActive" id="isActive" required="Y">
                            <option></option>
                            <option value='Y' <?= $currCathedral->getIsActive() != null && strcmp($currCathedral->getIsActive(), "Y") == 0 ? "selected" : "" ?>>Да</option>
                            <option value='N' <?= $currCathedral->getIsActive() != null && strcmp($currCathedral->getIsActive(), "N") == 0 ? "selected" : "" ?>>Не</option>
                        </select> </label>
                </div>
                <div class="buttons">
                    <button type="button" name="Update" value="Промени" onclick="updateRow();">Промени</button>
                    <button type="button" name="Clean" value="Изчисти" onclick="clearFields();">Изчисти</button> 
                </div>
            </div>
        </form>
    </body>
</html>
