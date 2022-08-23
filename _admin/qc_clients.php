<?php
include('../sulata/includes/config.php');
include('../sulata/includes/language.php');
include('../sulata/includes/functions.php');
include('../sulata/includes/get-settings.php');

$sessionUserId = $_SESSION[SESSION_PREFIX . 'user_id'];

$sql = "SELECT " . suJsonExtract('data', 'user_id') . " FROM form_data WHERE " . suJsonExtract('data', 'status', FALSE) . " = 'Incorrect'";
$result = suQuery($sql);
$users = array();
for ($i=0; $i < $result['num_rows']; $i++) { 

    array_push($users,$result['result'][$i]['user_id']);
}
$occurences = array_count_values($users);
$qc_users = array();
foreach ($occurences as $key => $value) {
    if ($value > 80) {
        array_push($qc_users, $key);
    }
}
$result = array();
for ($j=0; $j < sizeof($qc_users); $j++) { 
    $sql_user = "SELECT id,data FROM users WHERE id = '".$qc_users[$j]."'";
    $result_user = suQuery($sql_user);
    $data = suUnstrip(json_decode($result_user['result'][0]['data'],1));
    array_push($result, $data);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $getSettings['site_name'] . ' - ' . $h1; ?></title>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <?php include('includes/head.php'); ?>
    <script type="text/javascript">

        $(document).ready(function () {
                //Keep session alive
                $(function () {
                    window.setInterval("suStayAlive('<?php echo PING_URL; ?>')", 300000);
                });
                //Disable submit button
                suToggleButton(1);

            });
            //Set variable TRUE to save on CTRL + S
            var saveOnCtrlS = true;

        </script> 



    </head>
    <body>
        <p id="loading-area"></p>
        <?php
        include('includes/header.php');
        ?>
        <div class="container-fluid" id="container-area">
            <div class="row">
                <?php include('includes/sidebar.php'); ?>
                <main>
                    <div class="col-sm-10 content-area" id="working-area">
                        <div class="table-responsive">

                            <table class="table table-striped table-hover tablex" id="myTable">
                                <thead>
                                    <tr>
                                        <th style="width:5%">&nbsp;</th>
                                        <th style="width:15%">Name</th>
                                        <th style="width:15%">Email</th>
                                        <th style="width:15%">Phone</th>
                                        <th style="width:15%">Registration Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    for ($i=0; $i < sizeof($result); $i++) { 
                                        $data = $result[$i];
                                        ?>
                                        <tr>
                                            <td><span class="badge"><?php echo ($i+1) ?></span></td>

                                            <td><?php echo $data['name'] ?></td>
                                            <td>
                                                <a href="mailto:<?php echo $data['email'] ?>"><?php echo $data['name'] ?></a>
                                            </td>
                                            <td><?php echo $data['phone'] ?></td>
                                            <td><?php echo $data['registration_date'] ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>


                        </div>
                    </div>

                </main>

            </div>
            <?php include('includes/footer.php'); ?>
        </div>
        <?php include('includes/footer-js.php'); ?>
        <script src="//cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
        <script>
            $(document).ready( function () {
                $('#myTable').DataTable();
            } );
        </script>
        <?php suIframe(); ?>
    </body>
    </html>