<?php

define('SENDGRIDMAILER_MAIL', 'info@testmail.com');
Email::set_mailer( new CustomMailer() );

?>
