<?php
include('../sulata/includes/config.php');
include('../sulata/includes/language.php');
include('../sulata/includes/functions.php');
include('../sulata/includes/get-settings.php');

$sql_update_mac = "UPDATE users SET data = JSON_REPLACE(data,'$.blocked','no') WHERE id = '".$_GET['id']."'";
suQuery($sql_update_mac);

$sql_client = "SELECT " . suJsonExtract('data', 'email') . " FROM users WHERE id = '".$_GET['id']."'";
$result_client = suQuery($sql_client);
$email = $result_client['result'][0]['email'];

$sql_update_mac = "UPDATE users SET data = JSON_REPLACE(data,'$.blocked','no') WHERE " . suJsonExtract('data', 'email',FALSE) . " = '".$email."'";
suQuery($sql_update_mac);


header("Location:".ADMIN_URL.'blocked_clients.php');