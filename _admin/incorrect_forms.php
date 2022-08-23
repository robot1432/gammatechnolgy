<?php
include('../sulata/includes/config.php');
include('../sulata/includes/language.php');
include('../sulata/includes/functions.php');
include('../sulata/includes/get-settings.php');

$sessionUserId = $_SESSION[SESSION_PREFIX . 'user_id'];
$sql = "SELECT id,data FROM form_data WHERE " . suJsonExtract('data', 'user_id', FALSE) . " = '".$sessionUserId."' AND " . suJsonExtract('data', 'status', FALSE) . " = 'Incorrect'";
$result = suQuery($sql);

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
                                        <th style="width:15%">Address</th>
                                        <th style="width:15%">Pincode</th>
                                        <th style="width:15%">Job Function</th>
                                        <th style="width:15%">Phone</th>
                                        <th style="width:15%">Annual Revenue</th>
                                        <th style="width:15%">Date</th>
                                        <th style="width:15%">Client Code</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    for ($i=0; $i < $result['num_rows']; $i++) { 
                                        $data = suUnstrip(json_decode($result['result'][$i]['data'],1));
                                        $form_id = $data['form_id'];
                                        $sql_form = "SELECT id,data FROM forms WHERE live = 'Yes' AND id = '".$form_id."'";
                                        $result_form = suQuery($sql_form);
                                        $data_form = suUnstrip(json_decode($result_form['result'][0]['data'],1));
                                        ?>
                                        <tr>
                                            <td><span class="badge"><?php echo ($i+1) ?></span></td>

                                            <td>
                                                <p><?php echo $data['name'] ?></p>
                                                <p><strong><?php echo $data_form['name'] ?></strong></p>
                                            </td>
                                            <td>
                                                <p><?php echo $data['address'] ?></p>
                                                <p><strong><?php echo $data_form['address'] ?></strong></p>
                                            </td>
                                            <td>
                                                <p><?php echo $data['pincode'] ?></p>
                                                <p><strong><?php echo $data_form['pincode'] ?></strong></p>
                                            </td>
                                            <td>
                                                <p><?php echo $data['job_function'] ?></p>
                                                <p><strong><?php echo $data_form['job_function'] ?></strong></p>
                                            </td>
                                            <td>
                                                <p><?php echo $data['phone'] ?></p>
                                                <p><strong><?php echo $data_form['phone'] ?></strong></p>
                                            </td>
                                            <td>
                                                <p><?php echo $data['annual_revenue'] ?></p>
                                                <p><strong><?php echo $data_form['annual_revenue'] ?></strong></p>
                                            </td>
                                            <td>
                                                <p><?php echo $data['date'] ?></p>
                                                <p><strong><?php echo $data_form['date'] ?></strong></p>
                                            </td>
                                            <td>
                                                <p><?php echo $data['client_code'] ?></p>
                                                <p><strong><?php echo $data_form['client_code'] ?></strong></p>
                                            </td>
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