<?php
include('../sulata/includes/config.php');
include('../sulata/includes/language.php');
include('../sulata/includes/functions.php');
include('../sulata/includes/get-settings.php');

$sessionUserId = $_SESSION[SESSION_PREFIX . 'user_id'];
$sql = "SELECT id,data FROM clients WHERE " . suJsonExtract('data', 'blocked', FALSE) . " = 'yes'";
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
                                        <th style="width:15%">Email</th>
                                        <th style="width:15%">Phone</th>
                                        <th style="width:15%">Registration Date</th>
                                        <th style="width:15%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    for ($i=0; $i < $result['num_rows']; $i++) { 
                                        $data = suUnstrip(json_decode($result['result'][$i]['data'],1));
                                        ?>
                                        <tr>
                                            <td><span class="badge"><?php echo ($i+1) ?></span></td>

                                            <td><?php echo $data['name'] ?></td>
                                            <td>
                                                <a href="mailto:<?php echo $data['email'] ?>"><?php echo $data['email'] ?></a>
                                            </td>
                                            <td><?php echo $data['phone'] ?></td>
                                            <td><?php echo $data['registration_date'] ?></td>
                                            <td><a href="<?php echo ADMIN_URL ?>unblock.php?id=<?php echo $result['result'][$i]['id'] ?>" class="btn btn-xs btn-theme">Unblock</a></td>
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