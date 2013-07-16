<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

/*
|--------------------------------------------------------------------------
| Application Constants
|--------------------------------------------------------------------------
|
| These Constants are used by the site for various needs
|
*/


define('PHONE_ONLY_USER',1125);

//define('CURRENT_DATE_IN_TZ',date('Y-m-d 00:00:00'));
define('TODAY_CURRENT_DATE_IN_TZ',date('Y-m-d 00:00:00'));
define('CURRENT_DATE_IN_TZ',date('2013-02-01 00:00:00'));
define('LISTINGS_PER_PAGE',50);
define('LISTINGUPLOADEDDOCS','http://www.zoomtanzania.com/ListingUploadedDocs/');
define('LISTINGIMAGES','http://www.zoomtanzania.com/ListingImages/');
define('CATEGORY_THUMB_NAILS','http://www.zoomtanzania.com/ListingImages/CategoryThumbnails/');
define('DEFENSIOAPIKEY','8571efd19f1a1f6b973cec6ef17c02b6');
// define('DEFENSIOAPIKEY','F2FE8BC3756A30F7D666BFEDE09046E9'); this is the live key

/* End of file constants.php */
/* Location: ./application/config/constants.php */