<?php
    //uwvrhpespojnuoyb
    //pdbkhrosfapdlqfi
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\OAuth;
    require 'vendor/autoload.php';
    function sendemailforAccount($email, $subject, $body){
    global $username;
    global $password;
    $mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 2;
    $mail->isSMTP();
    $mail->Host       = 'sandbox.smtp.mailtrap.io';
    $mail->SMTPAuth   = true;
    $mail->Username   = '886064d94b8ae8';
    $mail->Password   = '5accadd00e4ade';
    $mail->Port       = 2525;
    $mail->CharSet = "UTF-8";

    //Recipients
    $mail->setFrom('dandd.bhsoft@gmail.com', 'Dao Duy Dan');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body    = $body;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    if($mail->send()){
        return true;
    }
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
return false;
}

?>

