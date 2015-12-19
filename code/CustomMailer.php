<?php

require_once 'SendGrid/Unirest/Unirest.php';
require_once 'SendGrid/Unirest/HttpMethod.php';
require_once 'SendGrid/Unirest/HttpResponse.php';
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'SendGrid.php');

SendGrid::register_autoloader();

class CustomMailer extends Mailer
{
    var $mailer = null;


    function __construct($mailer = null)
    {
        parent::__construct();
        $this->mailer = $mailer;
    }


    protected function instantiate()
    {
        $sendgrid = new SendGrid(SENDGRIDMAILER_USERNAME, SENDGRIDMAILER_PASSWORD);   // put your sendgrid credetials in mysite/_config
        return $sendgrid;
    }


    /* Overwriting SilverStripe's Mailer's function */
    function sendHTML($to, $from, $subject, $htmlContent, $attachedFiles = false, $customheaders = false, $plainContent = false, $inlineImages = false)
    {
        $mail = new SendGrid\Mail(SENDGRIDMAILER_USERNAME, SENDGRIDMAILER_PASSWORD);
        $sendgrid = $this->instantiate();
        if (!$from) $from = SENDGRIDMAILER_MAIL;
        $from_name = preg_replace('/"*(.*)"*\<(.*)\>/i', '$1', $from);
        if($from_name) $from = preg_replace('/"*(.*)"*\<(.*)\>/i', '$2', $from);
        $mail->addTo($to)->setFromName($from_name)->setFrom($from)->setSubject($subject)->setHtml($htmlContent);
        $response = $sendgrid->web->send($mail);                        // send mail via sendgrid web API
        if ($response->message == "error") return false;
        if ($response->message == "success") return true;
        return false;
    }


    /* Overwriting SilverStripe's Mailer function */
    function sendPlain($to, $from, $subject, $plainContent, $attachedFiles = false, $customheaders = false)
    {
        $mail = new SendGrid\Mail(SENDGRIDMAILER_USERNAME, SENDGRIDMAILER_PASSWORD);
        $sendgrid = $this->instantiate();
        if (!$from) $from = SENDGRIDMAILER_MAIL;
        $from_name = preg_replace('/"*(.*)"*\<(.*)\>/i', '$1', $from);
        if($from_name) $from = preg_replace('/"*(.*)"*\<(.*)\>/i', '$2', $from);
        $mail->addTo($to)->setFromName($from_name)->setFrom($from)->setSubject($subject)->setText($plainContent);
        $response = $sendgrid->web->send($mail);
        if ($response->message == "error") return false;
        if ($response->message == "success") return true;
        return false;
    }
}
