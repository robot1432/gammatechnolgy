<?php

if ($tableSegment == 'groups') {
    //Check if at least one group is entered
    if (file_exists('includes/group-required-check.php')) {
        include('includes/group-required-check.php');
    }
}
if ($tableSegment == 'form_data') {
	$_POST['user_id'] = $_POST['d-user_id'];
	$_POST['form_id'] = $_POST['d-form_id'];
	$sql_nform = "SELECT id, " . suJsonExtract('data', 'user_id') . " FROM forms WHERE " . suJsonExtract('data', 'name', FALSE) . " = '".suStrip($_POST['name'])."' AND " . suJsonExtract('data', 'address', FALSE) . " = '".suStrip($_POST['address'])."' AND " . suJsonExtract('data', 'pincode', FALSE) . " = '".suStrip($_POST['pincode'])."' AND " . suJsonExtract('data', 'job_function', FALSE) . " = '".suStrip($_POST['job_function'])."' AND " . suJsonExtract('data', 'phone', FALSE) . " = '".suStrip($_POST['phone'])."' AND " . suJsonExtract('data', 'annual_revenue', FALSE) . " = '".suStrip($_POST['annual_revenue'])."' AND " . suJsonExtract('data', 'date', FALSE) . " = '".suStrip($_POST['date'])."' AND " . suJsonExtract('data', 'client_code', FALSE) . " = '".suStrip($_POST['client_code'])."' AND id = '".$_POST['form_id']."'";
	$result_nform = suQuery($sql_nform);
	$user_id = $result_nform['result'][0]['user_id'];
	$sql_get_forms = "SELECT id,data FROM forms WHERE live = 'Yes' AND id = '".$_POST['form_id']."'";
	$result_get_form = suQuery($sql_get_forms);
	$data_get_form = suUnstrip(json_decode($result_get_form['result'][0]['data'],1));
	$user_id = $data_get_form['user_id'];
	if (is_array($user_id)) {
		array_push($user_id, $_SESSION[SESSION_PREFIX . 'user_id']);
	}
	else
	{
		$user_id = array($_SESSION[SESSION_PREFIX . 'user_id']);
	}
	
	if ($result_nform['num_rows'] == 0) {
		$_POST['status'] = 'Incorrect';
	}
	else
	{
		$_POST['status'] = 'Correct';
	}
	$user_id = json_encode($user_id);
	$sql_update_form = "UPDATE forms SET data = JSON_REPLACE(data,'$.user_id','$user_id') WHERE id = '".$_POST['form_id']."'";
	suQuery($sql_update_form);
}