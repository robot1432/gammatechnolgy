<?php

//Set session to empty so that new settings can be fetched
if ($tableSegment == SETTINGS_TABLE_NAME) {
    $_SESSION[SESSION_PREFIX . 'getSettings'] = '';
}
//Send mail to user on creation
if ($tableSegment == USERS_TABLE_NAME) {

    if (file_exists('includes/send-mail-on-user-creation.php')) {
        include('includes/send-mail-on-user-creation.php');
    }
}
if ($tableSegment == 'clients') {
	$otp = rand(1000,9999);
	$sql_otp = "UPDATE clients SET data= JSON_INSERT(data,'$.otp','" . $otp . "') WHERE id='$maxId'";
	suQuery($sql_otp);
	$email = file_get_contents('../sulata/mails/new-user.html');
	$email = str_replace('#NAME#', $_POST['name'], $email);
	$email = str_replace('#SITE_NAME#', $getSettings['site_name'], $email);
	$email = str_replace('#MOBILE#', $_POST['phone'], $email);
	$email = str_replace('#USER#', $_POST['name'], $email);
	$email = str_replace('#PASSWORD#', $otp, $email);
	$email = str_replace('#URL#', BASE_URL, $email);
	$subject = sprintf(USER_WELCOME_EMAIL, $getSettings['site_name']);
	//Send mails
	suMail($_POST['email'], $subject, $email, $getSettings['site_name'], 'ascenttech001@gmail.com', TRUE);
    
	
}