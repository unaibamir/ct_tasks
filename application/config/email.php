<?php

// Unaib's local machine
if( isset($_SERVER["HTTP_HOST"]) && $_SERVER["HTTP_HOST"] == "ct-tasks.local") {

	$config = array(
	  'protocol' => 'smtp',
	  'smtp_host' => '127.0.0.1',
	  'smtp_port' => 1025,
	  'crlf' => "\r\n",
	  'newline' => "\r\n",
	  'mailtype'	=>	'html'
	);
	
} else {
	$config = array(
	  'protocol' => 'smtp',
	  'smtp_host' => 'ssl://mail.gewportal.com',
	  'smtp_port' => 465,
	  'smtp_user' => 'portal@gewportal.com',
	  'smtp_pass' => 'ak47UN@@22',
	  'crlf' => "\r\n",
	  'newline' => "\r\n",
	  'mailtype'	=>	'html',
	  'charset'   => 'iso-8859-1',
	);
}



$config["from_email"]	=	"portal@gewportal.com";
$config["from_name"]	=	"GULF ENVIRONMENT & CO";
