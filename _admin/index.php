<?php
include('../sulata/includes/config.php');
include('../sulata/includes/language.php');
include('../sulata/includes/functions.php');
include('../sulata/includes/get-settings.php');
function isJson($string)
{
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}
$showManageIcon = FALSE;
//Check admin login.
//If user is not logged in, send to login page.
checkAdminLogin();
$sessionUserId = $_SESSION[SESSION_PREFIX . 'user_id'];
$title = 'Welcome';
$h1 = $title;

//Check IP restriction
if (!in_array(ADMIN_GROUP_NAME, $_SESSION[SESSION_PREFIX . 'user_group'])) {
    suCheckIpAccess();
}
$sessionUserId = $_SESSION[SESSION_PREFIX . 'user_id'];

$sql = "SELECT id,data FROM forms WHERE live = 'Yes'";
$result = suQuery($sql);
$users = array();
for ($i = 0; $i < $result['num_rows']; $i++) {
    $data = suUnstrip(json_decode($result['result'][$i]['data'],1));
    if (in_array($sessionUserId, $data['user_id'])) {
        array_push($users, $data['user_id']);
    }
}
$filled_forms = sizeof($users);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo $getSettings['site_name'] . ' - ' . $h1; ?></title>
    <?php include('includes/head.php'); ?>
    <script type="text/javascript">
        $(document).ready(function() {
            //Keep session alive
            $(function() {
                window.setInterval("suStayAlive('<?php echo PING_URL; ?>')", 300000);
            });
            //Disable submit button
            suToggleButton(1);

        });
        //Set variable TRUE to save on CTRL + S
        var saveOnCtrlS = false;
    </script>
    <style>
        .stats
        {
            flex-wrap: wrap;
        }
        @media (max-width: 576px) {
            .w-32
            {
                width: 100% !important;
                margin-top: 10px;
                margin-bottom: 20px;
            }
        }
        /*#working-area*/
        /*{*/
        /*    margin-right: auto;*/
        /*}*/
    </style>
</head>

<body>
    <p id="loading-area"></p>
    <?php
    include('includes/header.php');
    ?>
    <div class="container-fluid" id="container-area">
        <div class="row">
            <?php include('includes/sidebar.php'); ?>
                <div class="col-sm-10 content-area" id="working-area">
                    <?php if($_SESSION[SESSION_PREFIX . 'admin_login'] == 1 && ($_SESSION[SESSION_PREFIX . 'user_group'][0] == 'Client' || $_SESSION[SESSION_PREFIX . 'user_group'][0] == 'Admin')) { ?>
                    <div class="d-flex justify-content-between stats">
                        <div class="w-32 text-center" style="background-color: #1eb5ae; color:white;">
                            <?php
                            $sql = "SELECT id FROM forms WHERE live = 'Yes'";
                            $result = suQuery($sql);
                            $total_forms = $result['num_rows'];
                            ?>
                            <h1>600</h1>
                            <p>Total Forms</p>
                        </div>
                        <div class="w-32 text-center" style="background-color: #1eb5ae; color:white;">
                            <?php

                            ?>
                            <h1><?php 
                            if($filled_forms <= 600)
                            {
                                echo $filled_forms; 
                            }
                            else
                            {
                                echo '600';
                            }
                            ?></h1>
                            <p>Fill Forms</p>
                        </div>
                        <div class="w-32 text-center" style="background-color: #1eb5ae; color:white;">
                            <?php
                            $sql = "SELECT id FROM forms WHERE live = 'Yes'";
                            $result = suQuery($sql);
                            ?>
                            <h1><?php 
                            $pending_forms = 600-$filled_forms;
                            if($pending_forms >= 0)
                            {
                                echo $pending_forms; 
                            }
                            else
                            {
                                echo '0';
                            }
                            ?></h1>
                            <p>Pending Forms</p>
                        </div>
                    </div>
                    <?php } else { ?>
                    <!-- Add new -->
                    <?php if ($showManageIcon == TRUE) { ?>
                        <a href="<?php echo ADMIN_URL; ?>manage<?php echo PHP_EXTENSION; ?>/<?php echo $table; ?>/" class="btn btn-circle"><i class="fa fa-table"></i></a>
                    <?php } ?>

                    <div id="error-area">
                        <ul></ul>
                    </div>
                    <div id="message-area">
                        <p></p>
                    </div>
                    <div>
                        <div>
                            <div class="row">
                                <!-- Line Chart -->
                                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                                    <h4 class="mb-0 py-2 px-3 btn-theme">Line Chart</h4>
                                    <?php
                                    $labelsArray = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
                                    $dataArray = array("10", "60", "20", "40", "30", "50", "70", "90", "100", "80", "10", "30");
                                    $title = urlencode("Sales in Millions");
                                    $sizeArray = array('90%', '90%');
                                    $labelsArray = urlencode(json_encode($labelsArray));
                                    $dataArray = urlencode(json_encode($dataArray));
                                    $clickUrl = '';
                                    $type = 'line';
                                    ?>
                                    <iframe class="alpha-border" width="100%" height="350" frameborder="0" src="<?php echo BASE_URL; ?>chartjs/index.php?title=<?php echo $title; ?>&labels=<?php echo $labelsArray; ?>&data=<?php echo $dataArray; ?>&click_url=<?php echo $clickUrl; ?>&type=<?php echo $type; ?>"></iframe>
                                </div>
                                <!-- Pie Chart -->
                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                    <h4 class="mb-0 py-2 px-3 btn-theme">Pie Chart</h4>
                                    <?php
                                    $labelsArray = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
                                    $dataArray = array("10", "60", "20", "40", "30", "50", "70", "90", "100", "80", "10", "30");
                                    $title = urlencode("Sales in Millions");
                                    $sizeArray = array('90%', '90%');
                                    $labelsArray = urlencode(json_encode($labelsArray));
                                    $dataArray = urlencode(json_encode($dataArray));
                                    $clickUrl = '';
                                    $type = 'pie';
                                    ?>
                                    <iframe class="alpha-border" width="100%" height="350" frameborder="0" src="<?php echo BASE_URL; ?>chartjs/index.php?title=<?php echo $title; ?>&labels=<?php echo $labelsArray; ?>&data=<?php echo $dataArray; ?>&click_url=<?php echo $clickUrl; ?>&type=<?php echo $type; ?>"></iframe>
                                </div>
                                <!-- Bar Chart -->
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <h4 class="mb-0 py-2 px-3 btn-theme">Bar Chart</h4>
                                    <?php
                                    $labelsArray = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
                                    $dataArray = array("10", "60", "20", "40", "30", "50", "70", "90", "100", "80", "10", "30");
                                    $title = urlencode("Sales in Millions");
                                    $sizeArray = array('90%', '90%');
                                    $labelsArray = urlencode(json_encode($labelsArray));
                                    $dataArray = urlencode(json_encode($dataArray));
                                    $clickUrl = '';
                                    $type = 'bar';
                                    ?>
                                    <iframe class="alpha-border" width="100%" height="300" frameborder="0" src="<?php echo BASE_URL; ?>chartjs/index.php?title=<?php echo $title; ?>&labels=<?php echo $labelsArray; ?>&data=<?php echo $dataArray; ?>&click_url=<?php echo $clickUrl; ?>&type=<?php echo $type; ?>"></iframe>
                                </div>
                                <!-- Pie Chart -->
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <h4 class="mb-0 py-2 px-3 btn-theme">Horizontal Bar Chart</h4>
                                    <?php
                                    $labelsArray = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
                                    $dataArray = array("10", "60", "20", "40", "30", "50", "70", "90", "100", "80", "10", "30");
                                    $title = urlencode("Sales in Millions");
                                    $sizeArray = array('90%', '90%');
                                    $labelsArray = urlencode(json_encode($labelsArray));
                                    $dataArray = urlencode(json_encode($dataArray));
                                    $clickUrl = '';
                                    $type = 'horizontalBar';
                                    ?>
                                    <iframe class="alpha-border" width="100%" height="300" frameborder="0" src="<?php echo BASE_URL; ?>chartjs/index.php?title=<?php echo $title; ?>&labels=<?php echo $labelsArray; ?>&data=<?php echo $dataArray; ?>&click_url=<?php echo $clickUrl; ?>&type=<?php echo $type; ?>"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>

        </div>
        <?php include('includes/footer.php'); ?>
    </div>
    <?php include('includes/footer-js.php'); ?>
    <?php suIframe(); ?>
</body>

</html>