<?php
header('Content-Type: application/json');
require_once 'vendor/autoload.php';
// creates object
$mail = new PHPMailer(true);

if(!isset($_POST['email'],$_POST['subject'],$_POST['link'],$_POST['type']))
{
    $response['success']= false;
    $response['message']= "Try again with appropriate parameters";
    echo json_encode($response);
    die();
}

try {
    if ($_POST['type'] == 1)
    {
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $link = $_POST['link'];
        $message = $link;
    }
    else
    {
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $link = $_POST['link'];
        $message = $link;
    }

    $mail->IsSMTP();
    $mail->isHTML(true);
    $mail->SMTPDebug = 0;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "ssl";
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 465;
    $mail->AddAddress($email);
    $mail->Username = 'schooloforthodoxbible@gmail.com';
    $mail->Password = 'orthodoxbible89';
    $mail->SetFrom('orthodoxbibleschool@gmail.com', 'Orthodox Bible School');
    if (empty($_POST['replyto'])){
        $mail->AddReplyTo("orthodoxbibleschool@gmail.com", "Orthodox Bible School");

    }else{
        $mail->AddReplyTo($_POST['replyto']);
    }
    $mail->Subject = $subject;
    $mail->Body = $message;
    $mail->AltBody = $message;


    if ($mail->Send()) {

        $response['success']= true;
        $response['message']= "Your mail was send successfully";
        echo json_encode($response);

    }
    else
    {
        $response['success']= false;
        $response['message']= "Mail sending failed";
        echo json_encode($response);
    }
} catch (phpmailerException $ex) {
    $msg = "<div class='alert alert-warning'>" . $ex->errorMessage() . "</div>";
    $response['success']= false;
    $response['message']= $ex->errorMessage();
    echo json_encode($response);
}


?>

