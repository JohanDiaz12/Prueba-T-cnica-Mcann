<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json');

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'] ?? 'Participante';
    $correo = $_POST['email'] ?? '';

    if(empty($correo)) {
        $response['message'] = 'No proporcionaste un correo válido';
        echo json_encode($response);
        exit;
    }

$htmlBody = "
<!DOCTYPE html>
<html lang='es'>
<head>
<meta charset='UTF-8'>
<title>Informacion del Taller</title>
</head>
<body style='margin:0; padding:0; background-color:#f4f4f4;'>
    <table width='100%' cellpadding='0' cellspacing='0' border='0' style='background-color:#f4f4f4; padding:20px 0;'>
        <tr>
            <td align='center'>
                <table width='600' cellpadding='0' cellspacing='0' border='0' style='background-color:#ffffff; border-radius:10px; overflow:hidden;'>
                    <tr>
                        <td align='center' style='padding:20px 0; background-color:#8A2036;'>
                            <img src='cid:logo_img' alt='Logo McCann' width='150' style='display:block;'>
                        </td>
                    </tr>
                    <tr>
                        <td style='padding:20px; font-family:Arial, sans-serif; text-align:center;'>
                            <h1 style='color:#8A2036; font-size:24px; margin-bottom:15px;'>¡Hola, $nombre!</h1>
                            <p style='font-size:16px; line-height:1.5; color:#333;'>Nos alegra que formes parte de nuestro taller de desarrollo web. Prepárate para aprender, crear y disfrutar de esta experiencia única con nosotros.</p>
                        </td>
                    </tr>
                    <tr>
                        <td style='padding:0 20px 20px 20px;'>
                            <img src='cid:info_img' alt='Taller McCann' width='100%' style='display:block; border-radius:10px;'>
                        </td>
                    </tr>
                    <tr>
                        <td align='center' style='padding:20px;'>
                            <a href='https://mccann.com.mx/contactos/' style='display:inline-block; padding:12px 25px; background-color:#8A2036; color:#ffffff; text-decoration:none; border-radius:5px; font-family:Arial, sans-serif; font-weight:bold;'>Visita nuestra pagina para saber mas de nosotros</a>
                        </td>
                    </tr>
                    <tr>
                        <td style='padding:20px; text-align:center; font-family:Arial, sans-serif; font-size:12px; color:#999;'>
                            <p>McCann Worldgroup México | Agustin.Cardenas@mrm.com | +52 55 1234 5678</p>
                            <p>Síguenos en:</p>
                            <p>
                                <a href='https://www.facebook.com/McCannWorldgroupMexico' style='margin:0 5px; display:inline-block;'>
                                    <img src='cid:facebook_icon' alt='Facebook' width='32' height='32' style='display:block;'>
                                </a>
                                <a href='https://x.com/McCannMexico' style='margin:0 5px; display:inline-block;'>
                                    <img src='cid:twitter_icon' alt='Twitter' width='32' height='32' style='display:block;'>
                                </a>
                                <a href='https://www.linkedin.com/company/mccannworldgroupmexico/posts/?feedView=all' style='margin:0 5px; display:inline-block;'>
                                    <img src='cid:linkedin_icon' alt='LinkedIn' width='32' height='32' style='display:block;'>
                                </a>
                            </p>
                            <p>Este correo se envió automáticamente, por favor no respondas a esta dirección.</p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
";


    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'chrisco4865@gmail.com';
        $mail->Password = 'ffdm yvtf naac raab';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('chrisco4865@gmail.com', 'McCann');
        $mail->addAddress($correo);

        $mail->isHTML(true);
        $mail->Subject = 'Informacion del taller de desarrollo web';
        $mail->Body = $htmlBody;
        $mail->AddEmbeddedImage('img/logo.png', 'logo_img');
        $mail->AddEmbeddedImage('img/info.png', 'info_img');
        $mail->AddEmbeddedImage('img/logo.png', 'logo_img');
        $mail->AddEmbeddedImage('img/facebook.png', 'facebook_icon');
        $mail->AddEmbeddedImage('img/twitter.png', 'twitter_icon');
        $mail->AddEmbeddedImage('img/linkedln.png', 'linkedin_icon');

        $mail->send();

        $response['success'] = true;
        $response['message'] = "Se envió correctamente a $correo";
    } catch(Exception $e) {
        $response['message'] = "No se pudo enviar el correo. Error: {$mail->ErrorInfo}";
    }

    echo json_encode($response);

} else {
    $response['message'] = 'Método no permitido';
    echo json_encode($response);
}
?>
