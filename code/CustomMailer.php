<?php


require_once(dirname( __FILE__ ).DIRECTORY_SEPARATOR.'SendGrid.php');


class CustomMailer extends Mailer {
        var $mailer = null;
        

        function __construct($mailer = null){
                parent::__construct();
                $this->mailer = $mailer;
        }


        protected function instanciate() {
                $sendgrid = new SendGrid($_ENV['SENDGRID_USERNAME'], $_ENV['SENDGRID_PASSWORD']);   // put your sendgrid credetials in mysite/_config
                return $sendgrid;
        }


        /* Overwriting SilverStripe's Mailer's function */
        function sendHTML($to, $from, $subject, $htmlContent, $attachedFiles = false, $customheaders = false, $plainContent = false, $inlineImages = false){
              $mail = new SendGrid\Mail($_ENV['SENDGRID_USERNAME'], $_ENV['SENDGRID_PASSWORD']);
              $sendgrid = $this->instanciate();
              $mail->addTo($to)->setBcc('shahshikant@clickheremedia.co.uk')->setFrom($from)->setSubject($subject)->setHtml($htmlContent);
              $sendgrid->web->send($mail);                        // send mail via sendgrid web API
        }


        /* Overwriting SilverStripe's Mailer function */
        function sendPlain($to, $from, $subject, $plainContent, $attachedFiles = false, $customheaders = false){
              $mail = new SendGrid\Mail($_ENV['SENDGRID_USERNAME'], $_ENV['SENDGRID_PASSWORD']);
              $sendgrid = $this->instanciate();
              $mail->addTo($to)->setBcc('shashikant@clickheremedia.co.uk')->setFrom($from)->setSubject($subject)->setText($plainContent);
              $sendgrid->web->send($mail);
        }


}
