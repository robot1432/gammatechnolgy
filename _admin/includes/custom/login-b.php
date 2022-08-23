<?php 
if($_SESSION[SESSION_PREFIX . 'user_group'][0] == 'Client'){
	$MAC = exec('getmac');
	$MAC = explode(' ', $MAC);
	$mac = $MAC[0];
	$sql_mac = "SELECT id,data FROM users WHERE id = '".$result['result'][0]['id']."'";
	$result_mac = suQuery($sql_mac);
	$data_mac = json_decode($result_mac['result'][0]['data'],1);
	$data_mac = $data_mac['mac'];
	if (isset($data_mac) && $mac != '') {
// 		if ($data_mac != $mac) {
// 			$sql_update_mac = "UPDATE users SET data = JSON_INSERT(data,'$.blocked','yes') WHERE id = '".$result['result'][0]['id']."'";
// 			$result_update_mac = suQuery($sql_update_mac);

// 			$sql_update_mac = "UPDATE clients SET data = JSON_INSERT(data,'$.blocked','yes') WHERE " . suJsonExtract('data', 'email',FALSE) . " = '".suStrip($result['result'][0]['email'])."'";
// 			suQuery($sql_update_mac);

// 			if ($result_update_mac['affected_rows'] == 0) {
// 				$sql_update_mac = "UPDATE users SET data = JSON_REPLACE(data,'$.blocked','yes') WHERE id = '".$result['result'][0]['id']."'";
// 				$result_update_mac = suQuery($sql_update_mac);

// 				$sql_update_mac = "UPDATE clients SET data = JSON_REPLACE(data,'$.blocked','yes') WHERE " . suJsonExtract('data', 'email',FALSE) . " = '".suStrip($result['result'][0]['email'])."'";
// 				suQuery($sql_update_mac);
// 			}

// 			$error = INVALID_LOGIN;

// 			suPrintJs('
// 			    parent.suToggleButton(0);
// 			    parent.$("#message-area").hide();
// 			    parent.$("#error-area").show();
// 			    parent.$("#error-area").html("<ul><li>' . $error . '</li></ul>");
// 			    parent.$("html, body").animate({ scrollTop: parent.$("html").offset().top }, "slow");
// 			');
// 			exit;
// 		}
	}
	else
	{
		$sql_update_mac = "UPDATE users SET data = JSON_INSERT(data,'$.mac','".$mac."') WHERE id = '".$result['result'][0]['id']."'";
		suQuery($sql_update_mac);

		$sql_update_mac = "UPDATE clients SET data = JSON_INSERT(data,'$.mac','".$mac."') WHERE " . suJsonExtract('data', 'email',FALSE) . " = '".suStrip($result['result'][0]['email'])."'";
		suQuery($sql_update_mac);
	}
	$sql_client_login = "SELECT " . suJsonExtract('data', 'joining_date') . " FROM clients WHERE " . suJsonExtract('data', 'email', FALSE) . "='" . suPost('email') . "' AND " . suJsonExtract('data', 'status', FALSE) . "='" . suStrip('Active') . "' AND Live='Yes' LIMIT 0,1";
	$result_client_login = suQuery($sql_client_login);
	if (strtotime($result_client_login['result'][0]['joining_date']) > strtotime(date('Y-m-d'))) {
		$error = INVALID_LOGIN;
		suPrintJs('
		    parent.suToggleButton(0);
		    parent.$("#message-area").hide();
		    parent.$("#error-area").show();
		    parent.$("#error-area").html("<ul><li>' . $error . '</li></ul>");
		    parent.$("html, body").animate({ scrollTop: parent.$("html").offset().top }, "slow");
		');
		exit;
	}
}