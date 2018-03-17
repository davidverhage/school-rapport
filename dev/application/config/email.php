<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['protocol'] = 'smtp';
$config['smtp_host'] = 'ssl://smtp.gmail.com'; //change this
$config['smtp_port'] = '465';
$config['smtp_user'] = 'elapsus.enms@gmail.com'; //change this
$config['smtp_pass'] = 'Dv11020909'; //change this
$config['mailtype'] = 'html';
$config['charset'] = 'iso-8859-1';
$config['wordwrap'] = TRUE;
$config['newline'] = "\r\n"; //use double quotes to comply with RFC 8


/*
$config = array(
	'protocol' => 'smtp',
	'smtp_host' => 'ssl://smtp.gmail.com', //change this
	'smtp_port' => '587',
	'smtp_user' => 'spreekuur.online@gmail.com', //change this
	'smtp_pass' => 'Dv11020909', //change this
	'mailtype' => 'html',
	'charset' => 'iso-8859-1',
	'wordwrap' => TRUE,
	'newline' => "\r\n" //use double quotes to comply with RFC 8
);

*/

if (ENVIRONMENT == 'production') {
    $config['protocol'] = 'smtp';
    $config['smtp_host'] = 'ssl://smtp.gmail.com'; //change this
    $config['smtp_port'] = '465';
    $config['smtp_user'] = 'elapsus.enms@gmail.com'; //change this
    $config['smtp_pass'] = 'Dv11020909'; //change this
    $config['mailtype'] = 'html';
    $config['charset'] = 'iso-8859-1';
    $config['wordwrap'] = TRUE;
    $config['newline'] = "\r\n"; //use double quotes to comply with RFC 822 standard
}