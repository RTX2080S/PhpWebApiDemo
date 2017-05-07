<?php

require '../Libraries/PHPMailer/PHPMailerAutoload.php';

class NoteMailer {

    public $note;

    public function __construct($content) {
        $this->note = $content;
    }

    private function getBodyHTML() {
        $note = $this->note;

        $htmlContent = "<html><head>";
        $htmlContent .= "</head><body>";

        $htmlContent .= '<h2>A contact information received</h2><br />';
        $htmlContent .= '<p>Contact Name: <b>' . $note->name . '</b></p>';
        $htmlContent .= '<p>Email: <b>' . $note->email . '</b></p>';
        $htmlContent .= '<p>Phone: <b>' . $note->phone . '</b></p>';
        $htmlContent .= '<p>Comment: <b>' . $note->comment . '</b></p>';        
        $htmlContent .= '<p>TimeStamp: <b>' . $this->getAklDateTimeStr() . '</b></p>';

        $htmlContent .= '<br />';
        $htmlContent .= '<br />';
        $htmlContent .= '<br />';

        $htmlContent .= '</body></html>';

        return $htmlContent;
    }

    private function getAklDateTimeStr() {        
        date_default_timezone_set("Pacific/Auckland");
        return date("Y-m-d h:i:sa");
    }
    
    public function Send() {
        $mail = new PHPMailer;

        //$mail->SMTPDebug = 3;                               // Enable verbose debug output
        $mail->isSMTP();
        $mail->Host = 'dummy.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication

        $mail->Username = 'user@dummy.com'; 
        $mail->Password = 'dummypassword';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 25;                            // TCP port to connect to

        $mail->setFrom('from@dummy.com', 'New Contact');
        $mail->addAddress('to@dummy.com');     // Add a recipient

        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = 'A new contact received';
        $mail->Body = $this->getBodyHTML();

        $sent = $mail->send();

        return $sent;
    }

}
