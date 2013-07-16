<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Email
| -------------------------------------------------------------------------
| This file lets you define parameters for sending emails.
| Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/libraries/email.html
|
*/



$config['protocol'] = 'smtp';
$config['smtp_host'] = 'box800.bluehost.com';
$config['smtp_user'] = 'info@zoomtanzaniahost.com';
$config['smtp_pass'] = '123456';
$config['smtp_port'] = '26';
$config['mailtype'] = 'html';
$config['wordwrap'] = TRUE;
$config['charset']='utf-8';  
$config['newline']="\r\n";  

/* End of file email.php */
/* Location: ./application/config/email.php */