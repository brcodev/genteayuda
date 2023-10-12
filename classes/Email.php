<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Model\Visita;
use URLify;


class Email
{

    public $email;
    public $nombre;
    public $token;


    public function __construct($email)
    {
        $this->email = $email;
    }


    public function recoverPassMail($nombre, $apellido, $token)
    {


        $mail = new PHPMailer(true);


        try {

            $mail->SMTPDebug = '';
            $mail->isSMTP();
            $mail->Host       = $_ENV["MHOST"];
            $mail->SMTPAuth   = true;
            $mail->Username   = $_ENV["GAD_USER"];
            $mail->Password   = $_ENV["GAD_PASS"];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('users-noreply@genteayuda.site', 'Gadmin Genteayuda');
            $mail->addAddress($this->email);

            $template = file_get_contents('../views/admin/templates/recover.php');
            $template = str_replace("{{name}}", $nombre . " " . $apellido, $template);
            $template = str_replace("{{action_url_2}}", '<b>' . 'https://genteayuda.site/resetaccsysclient/reset?token=' . $token . '</b>', $template);
            $template = str_replace("{{action_url_1}}", 'https://genteayuda.site/resetaccsysclient/reset?token=' . $token, $template);
            $template = str_replace("{{year}}", date('Y'), $template);
            $template = str_replace("{{operating_system}}", Utils::getOS(), $template);
            $template = str_replace("{{browser_name}}", Utils::getBrowser(), $template);

            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = 'Restablecer contraseña de tu cuenta Gadmin';
            $mail->Body    = $template;


            $mail->send();
            return true;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            return false;
        }
    }

    public function attemptsWarning($user, $attemps)
    {


        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = '';
            $mail->isSMTP();
            $mail->Host       = $_ENV["MHOST"];
            $mail->SMTPAuth   = true;
            $mail->Username   = $_ENV["GAD_USER"];
            $mail->Password   = $_ENV["GAD_PASS"];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('users-noreply@genteayuda.site', 'Gadmin Genteayuda');
            $mail->addAddress($this->email);

            $template = file_get_contents('../views/admin/templates/warning.php');
            $template = str_replace("{{name}}", $user, $template);
            $template = str_replace("{{number}}", $attemps, $template);
            $template = str_replace("{{action_url_1}}", 'https://genteayuda.site/recaccsysclient/recover', $template);
            $template = str_replace("{{year}}", date('Y'), $template);
            $template = str_replace("{{operating_system}}", Utils::getOS(), $template);
            $template = str_replace("{{browser_name}}", Utils::getBrowser(), $template);

            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = 'Cuenta bloqueada por intentos fallidos de acceso';
            $mail->Body    = $template;


            $mail->send();
            return true;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            return false;
        }
    }


    public function sentInfo($data, $idRegion, array $helps)
    {


        $mail = new PHPMailer(true);

        $reg = Utils::regionesPre($idRegion);


        if ($helps[1] == 0) {
            array_pop($helps);
        }

        if ($helps[2] == 0) {
            array_pop($helps);
        }

        $intHelp = $helps;

        for ($i = 0; $i <= 3; $i++) {
            switch ($helps[$i]) {
                case 1:
                    $helps[$i] = "Alimentaria";
                    break;
                case 2:
                    $helps[$i] = "Psicológica";
                    break;
                case 3:
                    $helps[$i] = "Vestuario";
                    break;
            }
        }

        try {

            $mail->SMTPDebug = '';
            $mail->isSMTP();
            $mail->Host       = $_ENV["MHOST"];
            $mail->SMTPAuth   = true;
            $mail->Username   = $_ENV["USER_TEST2"];
            $mail->Password   = $_ENV["USER_PASS"];;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('no-reply@genteayuda.site', 'Genteayuda');
            $mail->addAddress($this->email);


            $template = file_get_contents('../views/visita/mailinfo.php');
            $template = str_replace("{{help_one}}", $helps[0], $template);
            if (count($helps) == 2) {
                $template = str_replace("{{help_two}}", " o " . $helps[1], $template);
                $template = str_replace("{{help_three}}", " ", $template);
            } elseif (count($helps) > 2) {
                $template = str_replace("{{help_two}}", ", " . $helps[1], $template);
                $template = str_replace("{{help_three}}", " o de " . $helps[2], $template);
            } else {
                $template = str_replace("{{help_two}}", " ", $template);
                $template = str_replace("{{help_three}}", " ", $template);
            }
            $template = str_replace("{{region}}", $reg, $template);


            require_once __DIR__ . '/../views/visita/orgmailtemp.php';

            $orgAdd = $output;

            $template = str_replace("{{org}}", $orgAdd, $template);

            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = 'Información de ayudas';
            $mail->Body    = $template;


            $mail->send();
            ob_end_clean();
            return true;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            return false;
        }
    }

    public function orgRequest(array $data)
    {

        $mail = new PHPMailer(true);

        try {

            $mail->SMTPDebug = '';
            $mail->isSMTP();
            $mail->Host       = $_ENV["MHOST"];
            $mail->SMTPAuth   = true;
            $mail->Username   = $_ENV["USER_TEST2"];
            $mail->Password   = $_ENV["USER_PASS"];;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('no-reply@genteayuda.site', 'Genteayuda');
            $mail->addAddress($this->email);

            //Content
            $template = file_get_contents('../views/visita/mailrequest.php');
            $template = str_replace("{{nombre}}", $data["nombres"], $template);
            $template = str_replace("{{nombre_org}}", $data["nombre_org"], $template);
            $template = str_replace("{{help}}", Utils::typeToStringPre($data["ayuda"]), $template);
            $template = str_replace("{{region}}", Utils::regionesPre($data["region"]), $template);


            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = 'Recibimos la solicitud de inscripción de tu organización';
            $mail->Body    = $template;


            $mail->send();
            return true;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            return false;
        }
    }
}
