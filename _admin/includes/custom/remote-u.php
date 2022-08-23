<?php 
if ($table == 'clients' && suSegment(1) == 'delete') {
	$sql_nform = "SELECT " . suJsonExtract('data', 'email') . " FROM clients WHERE id = '".$id."'";
	$result_nform = suQuery($sql_nform);
	$email = $result_nform['result'][0]['email'];

	$sql = "UPDATE users SET live='No' WHERE " . suJsonExtract('data', 'email', FALSE) . " = '" . $email . "'";
	suQuery($sql);
}