<?php
//Password note
if ($tableSegment == 'users') {
    if ($getSettings['autogenerate_user_password'] == '1') {
        echo "<p><i class='fa fa-info-circle color-dodgerBlue'></i> " . AUTO_PASSWORD_MESSAGE . "</p>";
    }
}

if ($tableSegment == 'form-data') {
	$sql_joining = "SELECT " . suJsonExtract('data', 'joining_date') . " FROM clients WHERE " . suJsonExtract('data', 'email', FALSE) . " = '".suStrip($_SESSION[SESSION_PREFIX . 'user_email'])."' AND live = 'Yes'";
	$result_joining = suQuery($sql_joining);
	$joining_date = $result_joining['result'][0]['joining_date'];
	if (strtotime($joining_date. ' + 5 days') <= strtotime(date('Y-m-d'))) {
		$sql_update_form = "UPDATE clients SET data = JSON_REPLACE(data,'$.working_status','Completed') WHERE " . suJsonExtract('data', 'email', FALSE) . " = '".suStrip($_SESSION[SESSION_PREFIX . 'user_email'])."' AND live = 'Yes'";
		suQuery($sql_update_form);

		$sql_update_form = "UPDATE users SET data = JSON_INSERT(data,'$.working_status','Completed') WHERE " . suJsonExtract('data', 'email', FALSE) . " = '".suStrip($_SESSION[SESSION_PREFIX . 'user_email'])."' AND live = 'Yes'";
		suQuery($sql_update_form);
	}
	$sql_form = "SELECT id,data FROM forms WHERE live = 'Yes'";
	$result_form = suQuery($sql_form);

	$user_forms = array();
	for ($i=0; $i < $result_form['num_rows']; $i++) { 
		$data = suUnstrip(json_decode($result_form['result'][$i]['data'],1));
		if (is_array($data['user_id'])) {
			if (!in_array($_SESSION[SESSION_PREFIX . 'user_id'], $data['user_id'])) {
				$id = array('form_id' => $result_form['result'][$i]['id']);
				$data1 = array_merge($id,$data);
				array_push($user_forms, $data1);
			}
		}
		else
		{
			$id = array('form_id' => $result_form['result'][$i]['id']);
			$data1 = array_merge($id,$data);
			array_push($user_forms, $data1);
		}
		
	}
	echo "<div class='form_pic'><img src='".BASE_URL."files/".$user_forms[0]['picture']."'></div>";
	echo "<input type='hidden' name='d-form_id' value='".$user_forms[0]['form_id']."'>";
	echo "<input type='hidden' name='d-user_id' value='".$_SESSION[SESSION_PREFIX . 'user_id']."'>";
	if (empty($user_forms)) {
		$sql_update_form = "UPDATE clients SET data = JSON_REPLACE(data,'$.working_status','Completed') WHERE " . suJsonExtract('data', 'email', FALSE) . " = '".suStrip($_SESSION[SESSION_PREFIX . 'user_email'])."' AND live = 'Yes'";
		suQuery($sql_update_form);

		$sql_update_form = "UPDATE users SET data = JSON_INSERT(data,'$.working_status','Completed') WHERE " . suJsonExtract('data', 'email', FALSE) . " = '".suStrip($_SESSION[SESSION_PREFIX . 'user_email'])."' AND live = 'Yes'";
		suQuery($sql_update_form);
		?>
		<script>
			$("#error-area").html('No forms available right now.');
			$("#error-area").show();
			$("#error-area").addClass("py-4 pl-3");
			$('form').hide();
		</script>
		<?php
	}
}