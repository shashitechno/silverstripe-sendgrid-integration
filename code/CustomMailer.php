<?php

require_once 'SendGrid/Unirest/Unirest.php';
require_once 'SendGrid/Unirest/HttpMethod.php';
require_once 'SendGrid/Unirest/HttpResponse.php';
require_once(dirname( __FILE__ ).DIRECTORY_SEPARATOR.'SendGrid.php');

SendGrid::register_autoloader();

class CustomMailer extends Mailer {
        var $mailer = null;
        

        function __construct($mailer = null){
                parent::__construct();
                $this->mailer = $mailer;
        }


        protected function instanciate() {
                $sendgrid = new SendGrid(SENDGRIDMAILER_USERNAME, SENDGRIDMAILER_PASSWORD);   // put your sendgrid credetials in mysite/_config
                return $sendgrid;
        }


        /* Overwriting SilverStripe's Mailer's function */
        function sendHTML($to, $from, $subject, $htmlContent, $attachedFiles = false, $customheaders = false, $plainContent = false, $inlineImages = false){
              $mail = new SendGrid\Mail(SENDGRIDMAILER_USERNAME, SENDGRIDMAILER_PASSWORD);
              $sendgrid = $this->instanciate();
              $mail->addTo($to)->setBcc('shashikant@clickheremedia.co.uk')->setFrom($from)->setSubject($subject)->setHtml($htmlContent);
              $sendgrid->web->send($mail);                        // send mail via sendgrid web API
        }


        /* Overwriting SilverStripe's Mailer function */
        function sendPlain($to, $from, $subject, $plainContent, $attachedFiles = false, $customheaders = false){
              $mail = new SendGrid\Mail(SENDGRIDMAILER_USERNAME, SENDGRIDMAILER_PASSWORD);
              $sendgrid = $this->instanciate();
              $mail->addTo($to)->setBcc('shashikant@clickheremedia.co.uk')->setFrom($from)->setSubject($subject)->setText($plainContent);
              $sendgrid->web->send($mail);
        }


}
