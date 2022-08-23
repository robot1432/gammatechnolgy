<?php 

if ($tableSegment == 'clients') {
	extract($_POST);
	$email = suStrip($email);
	$sql_update_form = "UPDATE users SET data = JSON_REPLACE(data,'$.name','$name'),data = JSON_REPLACE(data,'$.email','$email'),data = JSON_REPLACE(data,'$.phone','$phone'),data = JSON_REPLACE(data,'$.employee_name','$employee_name'),data = JSON_REPLACE(data,'$.address','$address'),data = JSON_REPLACE(data,'$.registration_date','$registration_date'),data = JSON_REPLACE(data,'$.joining_date','$joining_date') WHERE " . suJsonExtract('data', 'email', FALSE) . " = '".suStrip($email)."'";
	suQuery($sql_update_form);
}