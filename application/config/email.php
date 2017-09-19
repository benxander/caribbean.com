<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Email Preferences

 * The following is a list of all the preferences that can be set when sending email.
Preference 	Default Value 	Options 	Description
useragent	CodeIgniter	None	The "user agent".
protocol	mail	mail, sendmail, or smtp	The mail sending protocol.
mailpath	/usr/sbin/sendmail	None	The server path to Sendmail.
smtp_host	No Default	None	SMTP Server Address.
smtp_user	No Default	None	SMTP Username.
smtp_pass	No Default	None	SMTP Password.
smtp_port	25	None	SMTP Port.
smtp_timeout	5	None	SMTP Timeout (in seconds).
wordwrap	TRUE	TRUE or FALSE (boolean)	Enable word-wrap.
wrapchars	76		Character count to wrap at.
mailtype	text	text or html	Type of mail. If you send HTML email you must send it as a complete web page. Make sure you don't have any relative links or relative image paths otherwise they will not work.
charset	utf-8		Character set (utf-8, iso-8859-1, etc.).
validate	FALSE	TRUE or FALSE (boolean)	Whether to validate the email address.
priority	3	1, 2, 3, 4, 5	Email Priority. 1 = highest. 5 = lowest. 3 = normal.
crlf 	\n 	"\r\n" or "\n" or "\r" 	Newline character. (Use "\r\n" to comply with RFC 822).
newline	\n 	"\r\n" or "\n" or "\r"	Newline character. (Use "\r\n" to comply with RFC 822).
bcc_batch_mode	FALSE	TRUE or FALSE (boolean)	Enable BCC Batch Mode.
bcc_batch_size	200	None	Number of emails in each BCC batch.

 */

$config['protocol'] = 'smtp'; // mail, sendmail, or smtp    The mail sending protocol.
$config['smtp_host'] = 'unaisangamer.com';
$config['smtp_user'] = 'soporte@unaisangamer.com'L; // SMTP Username.
$config['smtp_pass'] = 's0p0rte_Caribbean'; // SMTP Password.
$config['smtp_port'] = '25'; // SMTP Port.
$config['smtp_timeout'] = '5'; // SMTP Timeout (in seconds).
$config['wordwrap'] = TRUE; // TRUE or FALSE (boolean)    Enable word-wrap.
$config['wrapchars'] = 76; // Character count to wrap at.
$config['mailtype'] = 'html'; // text or html Type of mail. If you send HTML email you must send it as a complete web page. Make sure you don't have any relative links or relative image paths otherwise they will not work.
$config['charset'] = 'utf-8'; // Character set (utf-8, iso-8859-1, etc.).
$config['validate'] = FALSE; // TRUE or FALSE (boolean)    Whether to validate the email address.
$config['priority'] = 3; // 1, 2, 3, 4, 5    Email Priority. 1 = highest. 5 = lowest. 3 = normal.
$config['crlf'] = "\r\n"; // "\r\n" or "\n" or "\r" Newline character. (Use "\r\n" to comply with RFC 822).
$config['newline'] = "\r\n"; // "\r\n" or "\n" or "\r"    Newline character. (Use "\r\n" to comply with RFC 822).
$config['bcc_batch_mode'] = FALSE; // TRUE or FALSE (boolean)    Enable BCC Batch Mode.
$config['bcc_batch_size'] = 200; // Number of emails in each BCC batch.

?>
