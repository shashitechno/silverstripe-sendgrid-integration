<?php
/*
 * Uncomment lines below to configure username, password and/or "From" mail
 */
// define('SENDGRIDMAILER_USERNAME', '<username>');
// define('SENDGRIDMAILER_PASSWORD', '<password>');
// define('SENDGRIDMAILER_MAIL', 'Info Test <info@testmail.com>'); //
Email::set_mailer(new CustomMailer());

SS_Log::add_writer(new SS_LogFileWriter(BASE_PATH . '/info.log'), SS_Log::INFO);
