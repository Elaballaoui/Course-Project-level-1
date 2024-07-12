<?php
$title='Contact Us';
$nameErr = $emailErr = $messageErr = $documentFileErr = "";
$name = $email = $message = $documentFile = "";
require_once 'template/header.php';
function stringValidate($field)
{
    $field=filter_var(trim($field), FILTER_SANITIZE_STRING);
    if(!empty($field)) {return $field;}else{return false;}
}
function emailValidate($field)
{
    $field=filter_var(trim($field), FILTER_SANITIZE_EMAIL);
    if (filter_var($field, FILTER_VALIDATE_EMAIL)) {return $field;}else{return false;}
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//    echo '<pre>'; print_r($_POST); echo '</pre>';
//    echo '<pre>'; print_r($_FILES['document']); echo '</pre>';
//    echo $_FILES['document']['tmp_name'];
//    echo '<br>';
//    if (!stringValidate($_POST['name'])) {return die('Your name is invalid');}
//    if (!stringValidate($_POST['message'])) {return die('Your message is invalid');}
//    if (!emailValidate($_POST['email'])) {return die('Your email is invalid');}
//    ************************************************************************************
    $name=$_POST['name'];$email=$_POST['email'];$message=$_POST['message'];
    if (!stringValidate($_POST['name'])) $nameErr='Name is required';
    if (!stringValidate($_POST['message'])) $nameErr='Message is required';
    if (!emailValidate($_POST['email'])) $nameErr='Email is required';
//    ************************************************************************************
    if (isset($_FILES['document']) && $_FILES['document']['error'] == 0) {
        $allowed=[
            'jpg'=>'image/jpeg',
            'png'=>'image/png',
            'gif'=>'image/gif'
        ];
        $maxFileSize= 12 * 1024;
        $mimeFileType=mime_content_type($_FILES['document']['tmp_name']);
//        if (!in_array($_FILES['document']['type'], $allowed)) die('Your uploaded file is not an image.');
//        if ($_FILES['document']['size']>$maxFileSize) die('Your uploaded file is too large.');
//        if (!in_array($mimeFileType,$allowed)) die('Your uploaded file is not a valid image.');
//    ************************************************************************************
        $documentFile=$_FILES['document']['name'];
        if ($_FILES['document']['size']>$maxFileSize) $documentFileErr='Your file is too large.';
        if (!in_array($mimeFileType,$allowed)) $documentFileErr='Invalid file type.';
        if (($_FILES['document']['size']>$maxFileSize) && !in_array($mimeFileType,$allowed)) $documentFileErr='Invalid type and too large file.';
    }
}
?>
<a href="index.php" class="btn btn-primary"><i class="bi bi-backspace"></i> Back</a>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="name">Your name</label>
        <input type="text" name="name" value="<?php echo $name ?>" class="form-control" placeholder="Your name">
        <span class="text-danger"><?php echo  $nameErr ?></span>
    </div>
    <div class="form-group">
        <label for="email">Your email</label>
        <input type="email" name="email" value="<?php echo $email ?>" class="form-control" placeholder="Your email">
        <span class="text-danger"><?php echo $emailErr ?></span>
    </div>
    <div class="form-group">
        <label for="document">Your document</label>
        <input type="file" name="document" class="form-control">
        <span class="text-danger"><?php echo $documentFileErr ?></span>
    </div>
    <div class="form-group">
        <label for="message">Your message</label>
        <textarea name="message" class="form-control"><?php echo $message ?></textarea>
        <span class="text-danger"><?php echo $messageErr ?></span>
    </div>
    <button class="btn btn-primary">Send</button>
</form>
<?php require_once 'template/footer.php'?>